<?php

/**

 * Created by PhpStorm.

 * User: kshit

 * Date: 2019-04-02

 * Time: 18:35:40

 */



class Login extends CI_Controller

{

    function __construct () {

        parent::__construct();

        $this->load->model("login_m");

    }



    // public function index()

    // {

    //     if ($_POST)

    //     {

    //         $mobile = $this->input->post('user_mobile');

    //         $check = $this->login_m->user_login($mobile);

    //         //echo $check;

    //         if ($check === false){
    //             echo 'failure';
    //         }else{
    //             echo 'success';
    //         }

    //         //echo "success";

    //     }else{

    //         echo 'failure';

    //     }

    // }

    // public function index()

    // {

    //     if ($_POST)

    //     {
    //         $mobile = $this->input->post('user_mobile');
    //         $check = $this->login_m->user_login($mobile);
    //         echo "success";
    //     }

    // }

    public function index()

    {

        if ($_POST)

        {

            $mobile = $this->input->post('user_mobile');

            $check = $this->login_m->user_login($mobile);
            //print_r($check); exit;
            echo $check;

        }else{

            echo 'failure';

        }

    }

    public function validate_otp()

    {
        if ($_POST)
        {
            $otp = $this->input->post('otp');
            if ($_SESSION['user_login_otp'] == $otp){
                $data = array(
                    "user_login" => TRUE
                );
                $this->session->set_userdata($data);
                unset($_SESSION['user_login_otp']);
                echo 'success';
            }else{
                echo 'failure';
            }

        }else{
            echo 'failure';
        }

    }

    // public function register_user()

    // {

    //     if ($_POST){

    //         $data = $_POST;

    //         $mobile = '+91'.$data['mobile'];

    //         $name = $data['name'];

    //         $email = $data['email'];

    //         $referral_code = $data['referral_code'];

    //         $check = $this->db->get_where('users', array('mobile' => $mobile))->row();

    //         if (isset($check)) {

    //             $response = array('result' => 'failure', 'msg' => 'Mobile Number Already Exist');

    //         } else {

    //             $array = array(

    //                 'name' => $name,

    //                 'mobile' => $mobile,

    //                 'email' => $email

    //             );

    //             if (!empty($referral_code) && $referral_code != '')

    //             {

    //                 $check_referral = $this->db->get_where('users', array('referral_code' => $referral_code))->row();

    //                 if (!empty($check_referral))

    //                 {

    //                     $array['referral_userID'] = $check_referral->ID;

    //                 }else{

    //                     $array['referral_userID'] = 0;

    //                 }

    //             }else{

    //                 $array['referral_userID'] = 0;

    //             }

    //             $_SESSION['register_info'] = $array;

    //             $this->login_m->otp($mobile);

    //             $response = array('result' => 'success', 'msg' => 'SMS Sent');

    //         }

    //         echo json_encode($response);

    //     }

    // }

    public function register_user()
    {
        if ($_POST){
            $data = $_POST;
            $mobile = $data['mobile'];
            $name = $data['name'];
            $user_city = $data['user_city'];
            $referral_code = $data['referral_code'];
            $check = $this->db->get_where('users', array('mobile' => '+91'.$mobile))->row();
            $check_referral = $this->db->get_where('users', array('referral_code' =>$referral_code))->row();
            if($referral_code!=''){
              if(empty($check_referral)){
             $response = array('result' => 'failure', 'msg' => 'Invalid Referral Code');
            }  
            }
            
            elseif (isset($check)) {
                $response = array('result' => 'failure', 'msg' => 'Mobile Number Already Exist');
            } else {
                $referral_userID ='';
                if(!empty($referral_code)){
                    $get_user_r = $this->db->get_where('users', array('referral_code' =>$referral_code))->row();
                    $referral_userID = $get_user_r->ID;
                }else{
                    $referral_userID ='0'; 
                }

                $array = array(
                    'name' => $name,
                    'mobile' => '+91'.$mobile,
                    'cityID' =>$user_city,
                    'referral_userID' => $referral_userID,
                );
                
                $_SESSION['register_info'] = $array;
                $this->login_m->otp($mobile);
                $response = array('result' => 'success', 'msg' => 'SMS Sent');
            }
            echo json_encode($response);
        }
    }



    public function validate_register_otp()

    {

        if ($_POST)

        {

            $otp = $this->input->post('otp');

            if ($otp == $_SESSION['user_register_otp'])

            {

                unset($_SESSION['user_register_otp']);

                $register = $this->login_m->register_user();

                if ($register == TRUE){

                   //$this->signup_email($subject,$to,$message,$referral_code );

                   $response = array('result'=>'success','msg'=>'Registered Successfully');

                }else{

                    $response = array('result'=>'failure','msg'=>'Something Went Wrong');

                }

            }else{

                $response = array('result'=>'failure','msg'=>'OTP Incorrect');

            }

        }else{

            $response = array('result'=>'failure','msg'=>'Direct Access Not Allowed');

        }

        echo json_encode($response);

    }

   public function signup_email($subject = 'Test Email', $message='Test', $to = 'anisha@teknikoglobal.com',$referral_code ='THY85U')

    {

        $this->load->library('email');

        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>

            <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />

            <title>' . html_escape($subject) . '</title>

            <style type="text/css">

                body {

                    font-family: Arial, Verdana, Helvetica, sans-serif;

                    font-size: 16px;

                }

            </style>

        </head>

        <body>

        ' . $message . '

        </body>

        </html>';

        $result = $this->email

            ->from('anisha@teknikoglobal.com')

            ->reply_to('anisha@teknikoglobal.com')    // Optional, an account where a human being reads.

            ->to($to)

            ->subject($subject)

            ->message($body)

            ->send();



        return $result;

    }

    public function logout()

    {

        session_destroy();

        redirect("home");

    }

}