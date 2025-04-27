<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');


class Notification extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("home_m");
    }


    public function index()
    {
        if ($_POST) {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            $user_tokens = $this->db->query("SELECT * FROM `user_login` WHERE device_token !=''")->result();
            foreach ($user_tokens as $u) {
                $deviceToken = $u->device_token;
                if ($u->device_type == 'ios') {
                    $this->send_ios_notification($deviceToken, $message);
                } else {
                    $sendData = array(
                        'body' => $message,
                        'title' => $title,
                        'sound' => 'Default'
                    );
                    $this->fcmNotification($deviceToken, $sendData);
                }
            }
            $this->session->set_flashdata('msg', 'Notification Sent Successfully');
        }

        $this->data['sub_view'] = 'notification/index';
        $this->data['title'] = 'Notification';
        $this->load->view("_layout", $this->data);
    }

    public function specific()
    {
        if ($_POST) {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            $users = $this->input->post('userID');
            //print_r($users); exit;
            $user_array = implode(',', $this->input->post('userID'));

            $user_tokens = $this->home_m->get_all_table_query("SELECT * FROM `user_login` WHERE device_token !='' AND userID IN ($user_array)");

            foreach ($user_tokens as $u) {
                $deviceToken = $u->device_token;
                if ($u->device_type == 'ios') {
                    $this->send_ios_notification($deviceToken, $message);
                } else {
                    $sendData = array(
                        'body' => $message,
                        'title' => $title,
                        'sound' => 'Default'
                    );
                    $a = $this->fcmNotification($deviceToken, $sendData);
                    //insert notification
                    foreach ($users as $user) {
                        $insert_array = array(
                            'title' => $title,
                            'text' => $message,
                            'userID' => $user,
                            'status' => 'sent',
                            'added_on' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('notifications', $insert_array);
                    }

                    // var_dump($a);
                    // exit();
                }
            }
            $this->session->set_flashdata('msg', 'Notification Sent Successfully');
        }
        $this->data['user'] = $this->home_m->get_all_row_where('users', array('status' => 'Y'));

        $this->data['sub_view'] = 'notification/specific';
        $this->data['title'] = 'User Wise Notification';
        $this->load->view("_layout", $this->data);
    }


    public function all_user_sms()
    {
        if ($_POST) {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            if (!empty($message)) {
                $users = $this->db->query("SELECT * FROM `users` WHERE mobile !='' AND status = 'Y'")->result();
                foreach ($users as $u) {
                    $a = $this->send_sms($u->mobile, $message);
                    $this->db->insert('test_sms', array('mobile' => $u->mobile, 'message' => $message, 'response' => $a, 'added_on' => date('Y-m-d H:i:S')));
                }
                $this->session->set_flashdata('msg', 'SMS Sent Successfully');
            }
        }

        $this->data['sub_view'] = 'notification/send_all_sms';
        $this->data['title'] = 'Notification';
        $this->load->view("_layout", $this->data);
    }

    public function specific_user_sms()
    {
        if ($_POST) {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            $user_array = implode(',', $this->input->post('userID'));
            if (!empty($message)) {
                $users = $this->db->query("SELECT * FROM `users` WHERE mobile !='' AND status = 'Y' AND ID IN ($user_array)")->result();
                foreach ($users as $u) {
                    $a = $this->send_sms($u->mobile, $message);
                    $this->db->insert('test_sms', array('mobile' => $u->mobile, 'message' => $message, 'response' => $a, 'added_on' => date('Y-m-d H:i:S')));
                }
                $this->session->set_flashdata('msg', 'SMS Sent Successfully');
            }
        }
        $this->data['user'] = $this->home_m->get_all_row_where('users', array('status' => 'Y'));
        $this->data['sub_view'] = 'notification/send_specific_sms';
        $this->data['title'] = 'Notification';
        $this->load->view("_layout", $this->data);
    }

    public function send_sms($mobile, $message)
    {
        $sender = "GROCST";
        $message = urlencode($message);

        $msg = "sender=" . $sender . "&route=4&country=91&message=" . $message . "&mobiles=" . $mobile . "&authkey=284738AIuEZXRVCDfj5d26feae";

        $ch = curl_init('http://api.msg91.com/api/sendhttp.php?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        $result = curl_close($ch);
        return $res;
    }

    public function send_ios_notification($device_token, $message_text)
    {
        $payload = '{"aps":{"alert":"' . $message_text . '","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory"}}';
        //include_once("Cow.pem");
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/larde9bv/public_html/app/LarderProd.pem');
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        //$fp=stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        if ($fp) {
            echo "Connected" . $err;
        }
        $msg = chr(0) . pack("n", 32) . pack("H*", str_replace(' ', '', $device_token)) . pack("n", strlen($payload)) . $payload;
        $res = fwrite($fp, $msg);
        if ($res) {
            echo "hello";
            echo $res;
        }
        fclose($fp);
        return true;
    }

    public function test_ios_notification()
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        echo getcwd();
        $device_token = "ebcf8d730a853ad74fe0dca399e321058de05e4b71e89a2d15620e45a0a6bc38";
        $message_text = "Congratulation !!! Your order is placed Successfully and you have won a new scratch card.";
        $image = "http://www.love.quotesms.com/images/love-images/Funny-love-images-SMS.jpg";
        $payload = '{"aps":{"alert":"' . $message_text . '","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory"},"otherCustomURL" : "' . $image . '"}';
        //include_once("Cow.pem");
        //echo $file = getcwd().'/'.'LarderProd.pem';
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'home/larde9bv/public_html/app/LarderProd.pem');
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        //$fp=stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        if ($fp) {
            echo "Connected" . $err;
        }
        $msg = chr(0) . pack("n", 32) . pack("H*", str_replace(' ', '', $device_token)) . pack("n", strlen($payload)) . $payload;
        $res = fwrite($fp, $msg);
        if ($res) {
            echo $res;
        }
        fclose($fp);
        echo "<br>Hello<br>";
        echo $err;
        echo "<br>";
        echo $payload;
    }

    public function fcmNotification($device_id, $sendData)
    {
        #API access key from Google API's Console
        if (!defined('API_ACCESS_KEY')) {
            define('API_ACCESS_KEY', 'AAAA1HKDgQE:APA91bFGcpAMnemBJlCBYXP8Yo3aRz5f3iZaWsg4AHZR6uesM-I1MSIiVzyzbmiUZAWxbrkerqeOKvqY0daZZhLiHyWEJwXuSH8SqDdo_sUH33BXRzYeOfd9Z108OwOzKOcQmH5Ks4hL');
            // define('API_ACCESS_KEY', 'AAAArjidZIg:APA91bFFDV3c0Kh7ccb-j7mlFvAjPgbJIUqQK91JPyjMWv_1QVNg3Rjzm3NmxFuZJMrW6n0i0JYEyNjLtrIy3pdVuEmocmOSVNwR0IClIYNiWuM392JQEs-Sik1XC46WjviPHUc1c2SH');
        }

        $fields = array(
            'to'    => $device_id,
            'data'  => $sendData,
            'notification'  => $sendData
        );


        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        //$data = json_decode($result);
        if ($result === false)
            die('Curl failed ' . curl_error());

        curl_close($ch);
        return $result;
    }
}
