<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-04-02
 * Time: 18:37:40
 */

class Login_m extends MY_Model
{
    function __construct() {
        parent::__construct();
    }

    function hash($string) {
        return parent::hash($string);
    }

    public function generate_random_password($length = 4) {
        $numbers = range('1','9');
        $final_array = array_merge($numbers);
        //$final_array = array_merge($numbers);
        $password = '';

        while($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }

        return $password;
    }

    public function generate_random_password2($length = 6) {
        $numbers = range('0','9');
        $alphabets = range('A','Z');
        $final_array = array_merge($alphabets,$numbers);
        $password = '';
        while($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }
        return $password;
    }

    // public function user_login($mobile)
    // {
    //     $validate = $this->db->get_where('users',array('mobile'=>'+91'.$mobile))->row();
    //     if(!empty($validate)){
    //         $otp = $this->generate_random_password();
    //         $message = $otp." is your authentication code.";
    //         $this->send_sms($mobile,$message);
    //         $data = array(
    //             "loginUserID" => $validate->ID,
    //             "name" => $validate->name,
    //             "email" => $validate->email,
    //             "mobile" => $validate->mobile,
    //             "cityID" => $validate->cityID,//new
    //             "user_login" => FALSE
    //         );

    //         $this->session->unset_userdata('panel');
    //         $this->session->set_userdata($data);
    //         $_SESSION['user_login_otp'] = $otp;
    //         //return TRUE;
    //         return $otp;
    //     }else{
    //         return false;
    //     }
    // }

    // public function user_login($mobile)
    // {
    //     $validate = $this->db->get_where('users',array('mobile'=>'+91'.$mobile))->row();
    //     if(!empty($validate)){
    //         $otp = $this->generate_random_password();
    //         $message = $otp." is your authentication code.";
    //         $this->send_sms($mobile,$message);
    //         $data = array(
    //             "loginUserID" => $validate->ID,
    //             "user_login" => FALSE
    //         );

    //         $this->session->unset_userdata('panel');
    //         $this->session->set_userdata($data);
    //         $_SESSION['user_login_otp'] = $otp;
    //         return TRUE;
    //         //return $otp;
    //     }
    //     else{
    //         $array = array();
    //         $array['referral_code'] = $this->generate_referral_code($mobile);
    //         $array['mobile'] = '+91'.$mobile;
    //         $array['image'] = 'default.jpg';
    //         $array['wallet'] = 0;
    //         $array['status'] = 'Y';
    //         $array['added_on'] = date("Y-m-d H:i:s");
    //         $array['updated_on'] = date("Y-m-d H:i:s");
    //         $this->db->insert('users',$array);
    //         $userID = $this->db->insert_id();

    //         $otp = $this->generate_random_password();
    //         $message = $otp." is your authentication code.";
    //         $this->send_sms($mobile,$message);
    //         $data = array(
    //             "loginUserID" =>$userID,
    //             "user_login" => TRUE
    //         );
    //         $this->session->set_userdata($data);
    //         $_SESSION['user_login_otp'] = $otp;
    //         return TRUE;
    //     }
    // }

    
    public function user_login($mobile)

    {

        $validate = $this->db->get_where('users',array('mobile'=>'+91'.$mobile))->row();

        if(!empty($validate)){

            $otp = $this->generate_random_password();

            $message = $otp." is your authentication code to register at Gowisekart";


            //$success = $this->send_sms($mobile,$message);



            $success = $this->send_sms($mobile,$otp);
           //print_r($success);
           //die;
            $data = array(

                "loginUserID" => $validate->ID,

                "name" => $validate->name,

                "mobile" => $validate->mobile,

                "user_login" => FALSE

            );



            $this->session->unset_userdata('panel');

            $this->session->set_userdata($data);

            $_SESSION['user_login_otp'] = $otp;

            //return TRUE;

            /*return 'success';*/

            return $otp;

          //echo $otp;

        }else{

            return false;

        }

    }


    public function send_sms($mobile,$otp){
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"61e3c66e773dad7cce5ff533\",\n  \"sender\": \"GOWKRT\",\n  \"mobiles\": \"91".$mobile."\",\n  \"otp\": \"".$otp."\"\n}",
          CURLOPT_HTTPHEADER => [
            "authkey: 371792AiSdLSzp61dd714fP1",
            "content-type: application/JSON"
        ],
    ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
      } else {
          echo $response;
      }


  }

  public function send_sms_old($mobile,$message){
    $sender = "GOWKRT";

    $message = urlencode($message);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.msg91.com/api/sendhttp.php?sender=GOWKRT&route=4&country=91&message='.$message.'&mobiles='.$mobile.'&authkey=371792AiSdLSzp61dd714fP1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=2984i98tdm4rd3bg0v84iqvah4'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

}

public function otp($mobile)
{
    $otp = $this->generate_random_password();
    $message = $otp." is your authentication code.";
    $this->send_sms($mobile,$message);
    $_SESSION['user_register_otp'] = $otp;
    return TRUE;
}
private function check_unique_referral($referral_code,$user_name)
{
    $check = $this->db->get_where('users',array('referral_code'=>$referral_code))->row();
    if (empty($check)){
        return TRUE;
    }else{
        $this->generate_referral_code($user_name);
    }
}
private function generate_referral_code($user_name)
{
    $code = strtoupper(substr($user_name,0,2)).$this->generate_random_password2(6);
    if ($this->check_unique_referral($code,$user_name)){
        return $code;
    }
}
public function register_user()
{
    if (isset($_SESSION['register_info'])){
        $array = $_SESSION['register_info'];
        $user_name = $array['name'];
        $array['referral_code'] = $this->generate_referral_code($user_name);
        $array['image'] = 'default.jpg';
        $array['wallet'] = 0;
        $array['status'] = 'Y';
        $array['added_on'] = date("Y-m-d H:i:s");
        $array['updated_on'] = date("Y-m-d H:i:s");
        $this->db->insert('users',$array);
        $userID = $this->db->insert_id();
        unset($_SESSION['register_info']);
        $validate = $this->db->get_where('users',array('ID'=>$userID))->row();
        if(!empty($validate)) {
            $data = array(
                "loginUserID" => $validate->ID,
                "name" => $validate->name,
                "email" => $validate->email,
                "mobile" => $validate->mobile,
                "referral_code" =>$validate->referral_code,
                "user_login" => TRUE
            );
            $this->session->set_userdata($data);
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }
}
}