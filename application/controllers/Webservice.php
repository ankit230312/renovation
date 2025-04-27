<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -----------------------------------------------------

| PRODUCT NAME:     gowisekart

| -----------------------------------------------------

| AUTHOR:           SUNIL THAKUR (http://sunilthakur.in)

| -----------------------------------------------------

| EMAIL:            sunil.thakur@teknikoglobal.in

| -----------------------------------------------------

| COPYRIGHT:        RESERVED BY TEKNIKOGLOBAL

| -----------------------------------------------------

| WEBSITE:          http://teknikoglobal.com

| -----------------------------------------------------

*/



class Webservice extends CI_Controller{



    function __construct () {

        parent::__construct();

        $this->load->model("webservice_m");

    }



    public function index()

    {

        echo "<h4>RESTRICTED ACCESS!</h4>";

    }



    public function check_version()

    {

        $version = $this->db->get('app_version')->row();

        $response[] = array('result'=>'success','message'=>'', 'version'=>$version);

        echo json_encode($response);

    }



    private function get_stock_count($product_name,$unit,$unit_value)

    {

        $stock_count = 0;

        $stock = $this->db->query("SELECT * FROM `stock` WHERE `product` = '$product_name'")->row();

        if (!empty($stock))

        {

            $multiplier = 1;

            if ($unit != $stock->unit)

            {

                if (strtoupper($unit) == 'KG' && strtoupper($stock->unit) == 'GM')

                {

                    $multiplier = $multiplier * 1000;

                }elseif (strtoupper($unit) == 'GM' && strtoupper($stock->unit) == 'KG')

                {

                    $multiplier = $multiplier / 1000;

                }

            }

            $stock_count = $stock->value/($unit_value * $multiplier);

        }

        return $stock_count;

    }



    public function generate_random_password($length = 10) {

        $numbers = range('0','9');

        $alphabets = range('A','Z');

        

        //$additional_characters = array('_','.');

        $final_array = array_merge($alphabets,$numbers);

        //$final_array = array_merge($numbers);

        $password = '';      

        while($length--) {

          $key = array_rand($final_array);

          $password .= $final_array[$key];

      }

      return $password;

  }



  public function send_otp()

  {

    $data = json_decode(file_get_contents('php://input'), true);


    //$this->db->insert('data',array('data'=>json_encode($data)));


    $mobile = $data['mobile'];



    $otp = $data['otp'];

    // if($mobile == '6370371406'){
    //     $otp = '1234';
    // }



//    $message = $otp." is your authentication code to register.";
    $message = $otp." is your authentication code to register at Rapto";



    $message = urlencode($message);

    //$this->send_sms($mobile,$message);
    $this->send_sms($mobile,$otp);



    $check_mobile = $this->webservice_m->get_single_table("users",array('mobile'=>'+91'.$mobile));

    if(!empty($check_mobile))

    {

        $response[] = array('result'=>'success','message'=>'SMS Send Successfully', 'otp'=>$otp);

    } else {

        $response[] = array('result'=>'new','message'=>'SMS Send Successfully', 'otp'=>$otp);

    }

        //send sms for otp



    echo json_encode($response);

}



//  public function send_sms($mobile, $message){

//     $sender = "GOWISE";

//     $message = urlencode($message);

//     // echo $mobile;
//     // echo $message;


//     $msg = "sender=".$sender."&route=4&country=91&message=".$message."&mobiles=".$mobile."&authkey=284738AIuEZXRVCDfj5d26feae";



//      $ch = curl_init('http://api.msg91.com/api/sendhttp.php?');

//      curl_setopt($ch, CURLOPT_POST, true);

//     curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);

//       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//      $res = curl_exec($ch);

//      $result = curl_close($ch);
//      // print_r($res);
//      // die;
//     return $res;
// }

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

      //   if ($err) {
      //     //echo "cURL Error #:" . $err;
      // } else {
      //     return $response;
      // }
    return $response;


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



public function login()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $mobile = $data['mobile'];



    $deviceID = $data['deviceID'];

    $deviceToken = $data['deviceToken'];

    $deviceType = $data['deviceType'];

    $ip_address = $_SERVER['REMOTE_ADDR'];

    $path = base_url('uploads/');
    $response = [];


    $user = $this->webservice_m->get_single_table('users',array('mobile'=>'+91'.$mobile));

    if(!empty($user))

        {   $userID = $user->ID;

            $img = $path.$user->image;   



            if($user->status == 'Y')

            {

                $this->webservice_m->update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType);

                $response[] = array(

                    'result'=>'success',

                    'message'=>'Successful Login',

                    'userID'=>(string)$userID, 

                    "name"=>$user->name, 

                    "mobile"=>$user->mobile, 

                    "email"=>$user->email, 

                    "image"=>$img,

                    "wallet" => $user->wallet,

                    "referral_code"=>$user->referral_code

                    

                );

            } else {

                $response[] = array(

                    "result" => 'verify',

                    "message" => "Your Account is disabled. Please Contact Administrator."

                );

            }



            

        } else {

            $response[] = array('result'=>'failure', 'message'=>'Invalid Login Credential..');

        }

        echo json_encode($response); 

    }



    public function login_with_truecaller()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $mobile = $data['mobile'];

        $name = $data['name'];

        $email = $data['email'];

        

        $deviceID = $data['deviceID'];

        $deviceToken = $data['deviceToken'];

        $deviceType = $data['deviceType'];

        $ip_address = $_SERVER['REMOTE_ADDR'];

        $path = base_url('uploads/');

        

        $user = $this->webservice_m->get_single_table('users',array('mobile'=>$mobile));



        $this->send_otp($mobile,$otp);

        if(!empty($user))

            {   $userID = $user->ID;

                $img = $path.$user->image;   



                $user_data =  array(

                    'userID'=>(string)$userID, 

                    "name"=>$user->name, 

                    "mobile"=>$user->mobile, 

                    "email"=>$user->email, 

                    "image"=>$img,

                    "wallet" => $user->wallet,

                    "referral_code"=>$user->referral_code

                );



                if($user->status == 'Y')

                {

                    $this->webservice_m->update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType);

                    $response = array(

                        'result'=>'success',

                        'message'=>'Successful Login',

                        'user_data'=>$user_data



                    );

                } else {

                    $response = array(

                        "result" => 'verify',

                        "message" => "Your Account is disabled. Please Contact Administrator.",

                        "user_data" => (object)array()

                    );

                }





            } else {

                $created_on = date('Y-m-d H:i:s');

                $referral_code = strtoupper(substr($name, 0,2)).$this->generate_random_password(6);

                $referral_userID = 0;



                $array = array(

                    'name' => $name,

                    'email' => $email,

                    'auth_type' => 'truecaller',

                    'mobile' => $mobile,

                    'image' => 'default_user.png',

                    'referral_code' => $referral_code,

                    'referral_userID' => $referral_userID,

                    'wallet' => 0,

                    'status' => 'Y',

                    'added_on' => $created_on

                );

                $userID = $this->webservice_m->table_insert('users',$array);



                $this->webservice_m->update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType);

                $path = base_url('uploads/');

                $user = $this->webservice_m->get_single_table('users',array('userID'=>$userID));

                $img = $path.$user->image; 





                $user_data =  array(

                    'userID'=>(string)$userID, 

                    "name"=>$user->name, 

                    "mobile"=>$user->mobile, 

                    "email"=>$user->email, 

                    "image"=>$img,

                    "wallet" => $user->wallet,

                    "referral_code"=>$user->referral_code

                );



                $response = array('result'=>'success','first_time' => 'Y','message'=>'Successful Signup','user_data'=>$user_data);



            }

            echo json_encode($response); 

        }

        public function signup()

        {

            $data = json_decode(file_get_contents('php://input'), true);

            $name = $data['name'];

            $email = $data['email'];

            $mobile = $data['mobile'];



            $deviceID = $data['deviceID'];

            $deviceToken = $data['deviceToken'];

            $deviceType = $data['deviceType'];

            $ip_address = $_SERVER['REMOTE_ADDR'];

            $img = base_url('uploads/user.png');

            $created_on = date('Y-m-d H:i:s');

            $referral_code = strtoupper(substr($name, 0,2)).$this->generate_random_password(6);



        // $check_email = $this->webservice_m->get_single_table("users",array('email'=>$email));

        // if(count($check_email)>0)

        // {

        //     $response[] = array('result'=>'failure','message'=>'Email ID Already Exist');



        // } else {

            $referral_userID ='0';
            $userID = 0; 
            $array = array(

                'name' => $name,

                'email' => $email,

                'mobile' => '+91'.$mobile,

                'image' => 'user.png',

                'referral_code' => $referral_code,

                'referral_userID' => $referral_userID,

                'wallet' => '0',

                'status' => 'Y',

                'added_on' => $created_on

            );

            if(!empty($mobile)){
                $user = $this->webservice_m->get_single_row_where('users',array('mobile'=>'+91'.$mobile));
                if(empty($user)){
                    $userID = $this->webservice_m->table_insert('users',$array);
                    $this->webservice_m->update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType);
                    $this->signup_email($email,$name,$referral_code);
                    $response[] = array('result'=>'success','message'=>'Successful Signup','userID'=>(string)$userID, "name"=>$name, "mobile"=>$mobile, "email"=>$email, "image"=>$img, "referral_code"=>$referral_code);


                }else{
                    $response[] = array('result'=>'failure','message'=>'User Already Registered');

                }

            }else{
                $response[] = array('result'=>'failure','message'=>'Mobile No Required');

            }





        // }

            



            echo json_encode($response);

        }



        public function test_email1()

        {

            $this->signup_email('cruel.skt@gmail.com','Sunil','SFDG757H');

        }



        public function signup_email($email,$name,$referral_code)

        {

            $data = json_decode(file_get_contents('php://input'), true);

            

            //SMTP & mail configuration

            $config = array(

                'protocol'  => 'mail',

                'smtp_host' => 'smtp.gmail.com',

                'smtp_port' => 587,

                'smtp_user' => 'gowisekart@gmail.com',

                'smtp_pass' => 'gowisekart@123',

                'mailtype'  => 'html',

                'charset'   => 'utf-8'

            );

            $this->email->initialize($config);

            $this->email->set_mailtype("html");

            $this->email->set_newline("\r\n");



            //Email content

            $htmlContent = '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile currentTable" data-thumb="http://gowisekart.com/admin/uploads/logo1575713051.png" data-module="SignUp">

            <tbody><tr>

            <td width="100%" height="100" align="center">



            <!-- Space -->

            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">

            <tbody><tr>

            <td width="100%" height="50"></td>

            </tr>

            </tbody></table>

            <!-- End Space -->



            <!-- Logo -->

            <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullCenter" object="drag-module-small">

            <tbody><tr>

            <td width="100%">

            <a href="#" style="text-decoration: none;">

            <img src="http://gowisekart.com/admin/uploads/logo1575713051.png" width="200px" alt="" border="0" class="hover">

            </a>

            </td>

            </tr>

            </tbody></table>

            <!-- End Logo -->



            <!-- Space -->

            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">

            <tbody><tr>

            <td width="100%" height="50"></td>

            </tr>

            </tbody></table>

            <!-- End Space -->



            <!-- Shadow -->

            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="full" style="-webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px;">

            <tbody><tr>

            <td width="100%" style="-webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; -webkit-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75); -moz-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75); box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.10); border: 1px solid #d7d7d7;" bgcolor="#ffffff">



            <!-- SORTABLE -->

            <div class="sortable_inner ui-sortable">

            <!-- Start Top -->

            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" style="-webkit-border-top-right-radius: 6px; -moz-border-top-right-radius: 6px; border-top-right-radius: 6px; -webkit-border-top-left-radius: 6px; -moz-border-top-left-radius: 6px; border-top-left-radius: 6px;" id="not1ChangeBG" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center" class="fullCenter">



            <!-- Header Text -->

            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" height="50"></td>

            </tr>



            <tr>

            <td width="100%" height="20" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            <tr>

            <td width="100%" style="width:329px; height:auto;" class="fullCenter">

            <img src="http://gowisekart.com/admin/uploads/image1575713075.png" width="329" alt="illustration" border="0" class="hover">

            </td>

            </tr>

            <tr>

            <td width="100%" height="50" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>



            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td valign="middle" width="100%" style="text-align: center; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 20px; color: #353535; line-height: 40px; font-weight: 400;" class="fullCenter">

            Hi

            <span style="color:#e41b41;">'.$name.'</span>!</br> Welcome to gowisekart.

            </td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>



            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" height="25" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>



            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="">

            <tbody><tr>

            <td valign="middle" width="100%" style="text-align: center; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 16px; color: #868585; line-height: 24px; font-weight: 400;" class="">

            Your account has been created successfully and is ready to use.

            </td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>



            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" height="15" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>







            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" height="30" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>







            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" align="center">

            <table border="0" cellpadding="0" cellspacing="0" align="center" class="buttonScale">

            <tbody><tr>

            <td align="center" height="40">



            <a href="#" style="text-align: center; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 16px; color: #868585; line-height: 24px; font-weight: 400;">Your Referral Code!</a>



            </td> 

            </tr>

            </tbody></table>

            </td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>

            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" align="center">

            <table border="0" cellpadding="0" cellspacing="0" align="center" class="buttonScale">

            <tbody><tr>

            <td align="center" height="40" bgcolor="#94da43" style="border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; padding-left: 30px; padding-right: 30px; font-family: \'Lato\', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); font-size: 16px; font-weight: 400; line-height: 1px; background-color: #e41b41;">



            <a href="#" style="color: rgb(255, 255, 255); text-decoration: none; width: 100%;">'.$referral_code.'</a>



            </td>

            </tr>

            </tbody></table>

            </td>

            </tr>

            </tbody></table>



            </td>

            </tr>

            </tbody></table>



            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="-webkit-border-bottom-right-radius: 6px; -moz-border-bottom-right-radius: 6px; border-bottom-right-radius: 6px; -webkit-border-bottom-left-radius: 6px; -moz-border-bottom-left-radius: 6px; border-bottom-left-radius: 6px;">

            <tbody><tr>

            <td width="100%" valign="middle" align="center">



            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter">

            <tbody><tr>

            <td width="100%" height="50" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            </tbody></table>





            </td>

            </tr>

            </tbody></table>



            </div>

            </td>

            </tr>

            </tbody></table>

            <!-- End Shadow -->





            <!-- CopyRight -->

            <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">

            <tbody><tr>

            <td width="100%" height="25" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            <tr>

            <td valign="middle" width="100%" style="text-align: center; font-family: \'Lato\', Helvetica, Arial, sans-serif; color: rgb(165, 168, 174); font-size: 12px; font-weight: 400; line-height: 18px;" class="fullCenter">



            <br> Copyright gowisekart 2019

            </td>

            </tr>

            </tbody></table>



            <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">

            <tbody><tr>

            <td width="100%" height="20" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>

            <tr>

            <td valign="middle" width="100%" style="text-align: center; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color: rgb(148, 218, 67); font-size: 12px; font-weight: 400; line-height: 18px;" class="fullCenter">

            <!--subscribe-->

            <a href="#" style="text-decoration: none; color: #e41b41;">Unsubscribe</a>

            <!--unsub-->

            </td>

            </tr>

            </tbody></table>



            <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">

            <tbody><tr>

            <td width="100%" height="60" style="font-size: 1px; line-height: 1px;">&nbsp;</td>

            </tr>



            </tbody></table>

            <!-- End CopyRight -->





            </td>

            </tr>

            </tbody></table>';



            $list = array('thakur5sunil@gmail.com');

            $this->email->to($email);

            $this->email->bcc($list);

            $this->email->from('gowisekart@gmail.com','gowisekart');

            $this->email->subject('Welcome To gowisekart');

            $this->email->message($htmlContent);



            //Send email

            $this->email->send();

             //echo $this->email->print_debugger();

            return true;

        }



        public function apply_referral_code()

        {

            $data = json_decode(file_get_contents('php://input'), true);

            $userID = $data['userID'];

            $code = $data['code'];

           // $get_user = $this->webservice_m->get_single_table("users",array('referral_code'=>$code));

            $get_user =$this->db->get_where('users',array('referral_code'=>$code))->row();


            if(!empty($get_user))

            {

                $get_user_r = $this->webservice_m->get_single_table("users",array('referral_code'=>$code));

                $referral_userID = $get_user_r->ID;

                $settings =  $this->webservice_m->get_single_table("settings",array('id'=>1));
                if(!empty($settings->refer_earn)){
                    $wallet = $settings->refer_earn;
                }


                


                $this->db->query("UPDATE `users` SET `referral_userID`='$referral_userID',`wallet`='$wallet' WHERE `ID`='$userID'");



                $txn_array = array(
                    'userID'=>$userID,
                    'txn_no' => 'RFR'.time().rand(99,999),
                    'amount' => $wallet,
                    'type'=>'CREDIT',
                    'note'=>'',
                    'against_for' => 'referal_bonus',
                    'paid_by'=>'admin',
                    'orderID'=>0,
                    'transaction_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('transactions', $txn_array);

                $today =  date("Y-m-d H:i:s");
                $txn_array1 = array(
                    'user_id'=>$userID,
                    'previous_wallet' => 0,
                    'added_amount' => $wallet,
                    'created_at' =>$today,
                    'expired_on' => date('Y-m-d H:i:s', strtotime($today. ' + 2 days')) ,
                );
                $this->db->insert('refer_earn_new', $txn_array1);

                $message = 'Gowisekart is delivering handpicked farm fresh fruits, vegetables, grocery & household items.Use My referal code '.$code.'Instant Cash Amount Rs'.$settings->refer_earn.' will be added in your Gowisekart Wallet on Signup that will expire in 2 days.';

                $notification_insert = array(

                    "title"=>'Refer & Earn',

                    "image"=>'',

                    "text"=>$message,

                    "userID"=>$userID,

                    "status"=>'sent',

                    "added_on"=>date("Y-m-d H:i:s"),

                    "updated_on"=>date("Y-m-d H:i:s"),

                );

                $this->db->insert('notifications',$notification_insert);



                $user_login = $this->db->get_where('user_login',array('userID'=>$userID))->result();

                foreach ($user_login as $login)

                {

                    if (strtolower($login->device_type) == 'android'){

                        $this->send_notification('Refer & Earn', $message , $login->device_token,'');

                    }

                }


                
                $response[] = array('result'=>'success', 'message'=>'Valid Referral Code');

            } else {

                $response[] = array('result'=>'failure','message'=>'Invalid Referral Code');

            }

            echo json_encode($response);

        }



    // public function home()

    // {

    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $userID = $data['userID'];

    //     $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    //     $deviceID = (!empty($data['deviceID']))?$data['deviceID']:'';

    //     $deviceToken = (!empty($data['deviceToken']))?$data['deviceToken']:'';

    //     $deviceType = (!empty($data['deviceType']))?$data['deviceType']:'ANDROID';

    //     $ip_address = $_SERVER['REMOTE_ADDR'];



    //     $path = base_url('admin/uploads/banners/');

    //     $this->db->select('sum(qty) as count');

    //     //$cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID))->row();

    //     $user = $this->webservice_m->get_user(array('ID'=>$userID));

    //     $banners = $this->webservice_m->get_all_data_where('app_banners',array('status'=>'Y'),'priority','desc');

    //     $city = $this->db->get_where('city',array('status'=>'Y'))->result();

    //     foreach($banners as $b)

    //     {

    //         $b->banner = $path.$b->banner;

    //     }



    //     $delivery_charges = 0;

    //     $min_order_amount = 0;

    //     $max_order_amount = 0;

    //     $free_delivery_amount = 0;

    //     $settings = $this->webservice_m->get_single_table('settings',array('ID'=>1),$select='*');



    //     if (!empty($settings)){

    //         $delivery_charges = $settings->delivery_charge;

    //         $min_order_amount = $settings->min_order_amount;

    //         $max_order_amount = $settings->max_order_amount;

    //         $free_delivery_amount = $settings->free_delivery_amount;

    //     }



    //     if(!empty($deviceID) && !empty($deviceToken))

    //     {

    //     	$this->webservice_m->update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType);

    //     }

        

    //     $response[] = array('result'=>'success', 'banners'=>$banners, 'cart_count'=>$cart_item_count->count, 'delivery_charges'=>$delivery_charges,'min_order_amount'=>$min_order_amount,'max_order_amount'=>$max_order_amount,'free_delivery_amount'=>$free_delivery_amount,'gst'=>0,'city'=>$city);

    //     echo json_encode($response);

    // }



        public function home()

        {

            $data = json_decode(file_get_contents('php://input'), true);

            $userID = $data['userID'];
            $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

            $cityID = (!empty($data['cityID'])?$data['cityID']:0);

            $deviceID = (!empty($data['deviceID']))?$data['deviceID']:'';

            $deviceToken = (!empty($data['deviceToken']))?$data['deviceToken']:'';

            $deviceType = (!empty($data['deviceType']))?$data['deviceType']:'ANDROID';

            $ip_address = $_SERVER['REMOTE_ADDR'];



            $path = base_url('admin/uploads/banners/');

            $this->db->select('sum(qty) as count');
            if (isset($cityID) && !empty($cityID)) {
                $this->db->where(array('cityID'=>$cityID));
            }
            $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID))->row();
           //  echo $this->db->last_query(); exit;

            $user = $this->webservice_m->get_user(array('ID'=>$userID));

            $banners = $this->webservice_m->get_all_data_where('app_banners',array('status'=>'Y'),'priority','desc');
            if(!empty($banners)){
                foreach($banners as $b){
                    if($b->type=='subcategory'){
                      $parentCategory =  $this->db->query("select * from category where categoryID='$b->categoryID'")->row();
                      if(!empty($parentCategory)){
                        $b->parent = $parentCategory->parent;
                    }else{
                     $b->parent = '0';
                 }
             }else{
               $b->parent = '0'; 
           }
       }
   }

   $city = $this->db->get_where('city',array('status'=>'Y'))->result();

        //count of notification
   $total_notifications = '';
   $notifications =$this->db->query("select count(*) as count from notifications where status='sent' AND userID='$userID'")->row();
   if(!empty($notifications)){
       $total_notifications = $notifications->count;
   }
   else{
       $total_notifications = '0';
   }

   foreach($banners as $b)

   {

    $b->banner = $path.$b->banner;

}

$this->expired_refer_earn_wallet($userID);

$delivery_charges = 0;

$min_order_amount = 0;

$max_order_amount = 0;

$free_delivery_amount = 0;
$cashback_discount = 0;

$settings = $this->webservice_m->get_single_table('settings',array('ID'=>1),$select='*');



if (!empty($settings)){

    $delivery_charges = $settings->delivery_charge;

    $min_order_amount = $settings->min_order_amount;

    $max_order_amount = $settings->max_order_amount;

    $free_delivery_amount = $settings->free_delivery_amount;
    $cashback_discount = $settings->cashback_discount;
    $min_amount_cashback = $settings->min_amount_cashback;

}



if(!empty($deviceID) && !empty($deviceToken))

{

    $this->webservice_m->update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType);

}
        //  if(is_null($cart_item_count->count)){
        //         $cart_item_count->count = '';
        // }


$response[] = array('result'=>'success', 'banners'=>$banners, 'cart_count'=>$cart_item_count->count, 'delivery_charges'=>$delivery_charges,'min_order_amount'=>$min_order_amount,'max_order_amount'=>$max_order_amount,'free_delivery_amount'=>$free_delivery_amount,'gst'=>0,'cashback_wallet'=>$user_info->cashback_wallet,'cashback_discount'=>$cashback_discount,'min_amount_cashback'=>$min_amount_cashback,'notification'=> $total_notifications,'city'=>$city);

echo json_encode($response);

}

public function expired_refer_earn_wallet($userID){

    $this->db->order_by("id", "desc");
    $refer_wallets  = $this->db->get_where('refer_earn_new',array('user_id'=>$userID,'status'=>0))->result();
    if(!empty($refer_wallets)){
        foreach($refer_wallets as $refer){
            $previous_wallet = isset($refer->previous_wallet) ? $refer->previous_wallet : 0;//50
            $user = $this->db->get_where('users',array('ID'=>$userID))->row();
            $new_wallet = $user->wallet - $refer->added_amount;
            if($user->wallet > $refer->previous_wallet){
                $today = date("Y-m-d H:i:s");
                $expire = $refer->expired_on;
//            $today_time = strtotime($today);
//            $expire_time = strtotime($expire);
                if($expire < $today && $user->wallet > 0){
                    $txn_array = array(
                        'userID'=>$userID,
                        'txn_no' => 'REF'.rand(1111,9999),
                        'amount' => $user->wallet-$refer->previous_wallet,
                        'type'=>'DEBIT',
                        'note'=>'',
                        'against_for' => 'refer_expired1',
                        'paid_by'=>'Gowisekart',
                        'orderID'=>0,
                        'transaction_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions', $txn_array);

                    $this->db->where(array('ID'=>$userID));
                    $this->db->update('users',array('wallet'=>$previous_wallet));
                }else{

                }
            }
            if($new_wallet < $user->wallet){
            	$today = date("Y-m-d H:i:s");
            	$expire = $refer->expired_on;
            	$today_time = strtotime($today);
            	$expire_time = strtotime($expire);
            	if($expire < $today && $user->wallet > 0){
                    $txn_array = array(
                        'userID'=>$userID,
                        'txn_no' => 'REF'.rand(1111,9999),
                        'amount' => $user->wallet-$refer->previous_wallet,
                        'type'=>'DEBIT',
                        'note'=>'',
                        'against_for' => 'refer_expired2',
                        'paid_by'=>'Gowisekart',
                        'orderID'=>0,
                        'transaction_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions', $txn_array);
                    $this->db->where(array('ID'=>$userID));
                    $this->db->update('users',array('wallet'=>$previous_wallet));


                    $this->db->where(array('id'=>$refer->id));
                    $this->db->update('refer_earn_new',array('status'=>1));
                }
            }

        }
    }



}



public function get_product($productID,$cityID)

{

        // $product = $this->webservice_m->get_single_table('products',array('productID'=>$productID));

    $product = $this->db->query("SELECT products_variant.retail_price as rp,products_variant.cost_price as cp, products_variant.stock_count as sc,products.* FROM `products` LEFT JOIN products_variant ON products_variant.product_id = products.productID WHERE products.productID ='$productID' AND products_variant.status = 'Y' AND products_variant.city_id = '$cityID'")->row();



    return $product;

}



public function get_brand($brandID)

{

    $brand = $this->webservice_m->get_single_table('brand',array('brandID'=>$brandID));

    return $brand;

}

public function product_price($productID,$cityID)

{

    $products_price = $this->webservice_m->get_single_table('products_variant',array('product_id'=>$productID, 'city_id'=>$cityID));

    if(!empty($products_price)){

        return $products_price;

    }else{

        return '';

    }

}



public function get_categories()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $path1 = base_url('admin/uploads/category/');
    $this->db->order_by('priority','asc');
    $category = $this->webservice_m->get_all_data_where('category',array('parent'=>'0', 'status'=>'Y'));

    foreach($category as $c)

    {

        $c->icon = $path1.$c->icon;

        $c->image = $path1.$c->image;

        $c->subcategories = $this->subcategory($c->categoryID);

    }

    $response[] = array('result'=>'success', 'category'=>$category);

    echo json_encode($response);

}



public function subcategory($categoryID)

{

    $path1 = base_url('admin/uploads/category/');

    $subcategory = $this->webservice_m->get_all_table_query("SELECT `categoryID`, `title`,`icon`,`image` FROM `category` WHERE `parent`='$categoryID' AND `status`='Y'");

    foreach ($subcategory as $s)

    {

        $s->icon = $path1.$s->icon;

        $s->image = $path1.$s->image;

        $s->parent_cat = $categoryID;

        $s->parent_cat_name = $this->get_name($categoryID);

    }

    return $subcategory;

}



public function get_name($categoryID)

{

    $q = $this->db->query("SELECT  `title` FROM `category` WHERE `categoryID`='$categoryID'")->row();

    if(!empty($q))

    {

        return $q->title;

    }

    return 'Gowisekart Products';

}

public function get_subcategories()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $categoryID = $data['categoryID'];

    $path1 = base_url('admin/uploads/category/');

    $subcategory = $this->webservice_m->get_all_data_where('category',array('parent'=>$categoryID, 'status'=>'Y'));

    foreach($subcategory as $c)

    {

        $c->icon = $path1.$c->icon;

        $c->image = $path1.$c->image;

    }

    $response[] = array('result'=>'success', 'subcategory'=>$subcategory);

    echo json_encode($response);

}



public function feature_banners()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $path = base_url('admin/uploads/banners/');

    $feature_banners = $this->webservice_m->get_all_data_where('featured_banner',array('status'=>'Y'),'priority','desc');

    foreach($feature_banners as $fb)

    {

        $fb->banner = $path.$fb->banner;

    }

    $response[] = array('result'=>'success', 'feature_banners'=>$feature_banners);

    echo json_encode($response);

}





public function deals()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $d = date('Y-m-d');

    $products = array();

    $path2 = base_url('admin/uploads/products/');

    $variant_default_id = '';



        //user upadte

    $this->db->where(array('ID'=>$userID));

    $this->db->update('users',array('cityID'=>$cityID));



    $deal_banner = $this->webservice_m->get_single_table("deal_banner",array("status"=>"Y"));

    if(!empty($deal_banner))

    {

        $deal_banner->banner = base_url('admin/uploads/banners/').$deal_banner->banner;

    }

    $deal_query = "SELECT * FROM `deals` WHERE (`start_date` <= '$d' AND `end_date`>='$d') AND `status`='Y'";

    if($cityID > 0)

    {



        $deal_query .= "AND `cityID`='$cityID'";

    }

    $deal_query .= "  ORDER BY RAND() LIMIT 5";



    $deals = $this->db->query($deal_query)->result();

    foreach($deals as $d)

    {

        $product = $this->get_product($d->productID,$cityID);

        if(!empty($product)){

            $brand = $this->get_brand($product->brand_id);

            if($product->rp ==NULL){

                $product->rp = $product->retail_price;

            }

            if($product->sc ==NULL){

                $product->sc = $product->stock_count;

            }





            $all_variants_default = $this->get_variants_default($product->productID,$is_default=1,$cityID);

            foreach($all_variants_default as $allv){

               $cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

               $variant_default_id = $allv->id;

                   //}



               $products[] = array(

                'productID' => $product->productID,

                'product_name' => $product->product_name,

                'product_image' => $path2.$product->product_image,

                'brand' => $brand->brand,

                'category_id' => $product->category_id,

                'retail_price' => $product->rp,

                'price' => $d->deal_price,

                'unit_value' => $product->unit_value,

                'unit' => $product->unit,

                'stock_count'=> $product->sc,

                'in_stock' => $product->in_stock,

                'max_quantity' => $this->deal_maxQty($product->productID,$product->max_quantity,$cityID),

                'featured' => $product->featured,

                'vegtype' => $product->vegtype,

                'cart_count' => $cart_count,

                'variant_default_id' => $variant_default_id,

                'all_variants' => $this->get_variants_with_maxQty($userID,$product->productID,$product->max_quantity,$cityID),

            );



           }



       }



   }

   $response[] = array('result'=>'success', 'products'=>$products, "deal_banner"=>$deal_banner);

   echo json_encode($response);



}



public function deals_all_product()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $d = date('Y-m-d');

    $products = array();

    $path2 = base_url('admin/uploads/products/');

    $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$d' AND `end_date`>='$d') AND `status`='Y' AND `cityID`='$cityID'")->result();

    $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));

    foreach($deals as $d)

    {

        $product = $this->get_product($d->productID,$cityID);

        if(!empty($product)){

            $brand = $this->get_brand($product->brand_id);

            if($product->rp ==NULL){

                $product->rp = $product->retail_price;

            }

            if($product->sc ==NULL){

                $product->sc = $product->stock_count;

            }

            

            $all_variants_default = $this->get_variants_default($product->productID,$is_default=1,$cityID);

            foreach($all_variants_default as $allv){

               $cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

               $variant_default_id = $allv->id;





               $products[] = array(

                'productID' => $product->productID,

                'product_name' => $product->product_name,

                'product_image' => $path2.$product->product_image,

                'brand' => $brand->brand,

                'category_id' => $product->category_id,

                'retail_price' => $product->rp,

                'price' => $d->deal_price,

                'unit_value' => $product->unit_value,

                'unit' => $product->unit,

                'stock_count'=> $product->sc,

                'in_stock' => $product->in_stock,

                'max_quantity' => $this->deal_maxQty($product->productID,$product->max_quantity,$cityID),

                'featured' => $product->featured,

                'vegtype' => $product->vegtype,

                'cart_count' => $cart_count,

                'variant_default_id' => $variant_default_id,

                'all_variants' => $this->get_variants_with_maxQty($userID,$product->productID,$product->max_quantity,$cityID),

            );



           }

       }

   }

   $response[] = array('result'=>'success', 'products'=>$products);

   echo json_encode($response);



}





public function gift_banner()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

    $gift_banner = $this->webservice_m->get_single_table("gift_banner",array("status"=>"Y"));

    if(!empty($gift_banner))

    {

        $gift_banner->banner = base_url('admin/uploads/banners/').$gift_banner->banner;

    }

    $new_banner = $this->webservice_m->get_single_table("new_banner",array("status"=>"Y"));

    if(!empty($new_banner))

    {

        $new_banner->banner = base_url('admin/uploads/banners/').$new_banner->banner;

    }



    $new_banner1 = $this->webservice_m->get_all_data_where("new_banner",array("status"=>"Y"));

    if(!empty($new_banner1))

    {

        foreach($new_banner1 as $nb)

        {

            $nb->banner = base_url('admin/uploads/banners/').$nb->banner;

        }



    }

    $response[] = array('result'=>'success','share_earn'=>'Hey user, Please use my referral code to register to gowisekart and get cashback on first order. Use My Code is '.$user_info->referral_code.'. and to Download latest gowisekart App from play store using https://bit.ly/3EtEsEe .', 'gift_banner'=>$gift_banner, 'new_banner'=>$new_banner, 'new_banner1'=>$new_banner1);

    echo json_encode($response);

}







public function products()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $categoryID = $data['categoryID'];



    $p = "SELECT * FROM `products` WHERE FIND_IN_SET($categoryID,category_id) AND in_stock = 'Y'";

        // if($cityID > 0)

        // {

        //     $p .= " AND productID IN (SELECT product_id FROM products_detail WHERE city_id = '$cityID' AND `status` = 'Y')";

        // }



        // $p .= "ORDER BY TRIM(`products`.`product_name`) ASC";
    $p .= "ORDER BY priority ASC";



    $products = $this->db->query($p)->result();

    if(!empty($products))

    {

        foreach($products as $key=> $p)

        {

            $brand = $this->get_brand($p->brand_id);

            $p->product_image = base_url('admin/uploads/products/').$p->product_image;

                //$p->brand = $brand->brand;

            $p->brand = '';

            $all_variants_default = $this->get_variants_default($p->productID,$is_default=1,$cityID);

            foreach($all_variants_default as $allv){

               $p->cart_count = $this->product_cart_count($userID,$p->productID,$allv->id);

               $p->variant_default_id = $allv->id;

           }

           $p->all_variants = $this->get_variants($p->productID,$cityID);

           foreach($p->all_variants as $allv){

            $allv->max_quantity = $this->deal_maxQty($p->productID,$p->max_quantity,$cityID);

            $allv->cart_count = $this->product_cart_count($userID,$p->productID,$allv->id);

        }





        $city_price = $this->product_price($p->productID,$cityID);



        if(!empty($city_price))

        {

            $p->price = $city_price->price;

            $p->cost_price = $city_price->cost_price;

            $p->retail_price = $city_price->retail_price;

            $p->stock_count = $city_price->stock_count;

            $p->unit_value = $city_price->unit_value;

            $p->unit = $city_price->unit;

            $p->weight = $city_price->weight;

        }



        $p->price = $this->check_deal($p->productID,$p->price,$cityID);

        $p->max_quantity = $this->deal_maxQty($p->productID,$p->max_quantity,$cityID);



    }

}

$response[] = array('result'=>'success', 'products'=>$products);

echo json_encode($response);

}



    //

public function recommended_products()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $categoryID = $data['categoryID'];

    $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));



        //$subcategory = $this->webservice_m->get_all_data('category',array('parent'=>$categoryID));

    $subcategory = $this->db->query("SELECT * FROM `category` WHERE parent = '$categoryID'")->result();

    $sub_array = array();

    foreach($subcategory as $sc)

    {

        array_push($sub_array,$sc->categoryID);

    }

    $subcat = implode(',',$sub_array);



        //$p = "SELECT * FROM `products` WHERE FIND_IN_SET($categoryID,category_id) AND in_stock = 'Y' AND featured='Y'";

    $p = "SELECT * FROM `products` WHERE category_id IN ($subcat) AND in_stock = 'Y' AND featured='Y'";

        // if($cityID > 0)

        // {

        //     $p .= " AND productID IN (SELECT product_id FROM products_detail WHERE city_id = '$cityID' AND `status` = 'Y')";

        // }



        //$p .= "ORDER BY TRIM(`products`.`product_name`) ASC";
    $p .= "ORDER BY priority ASC";

        //echo $p; exit;

    $products = $this->db->query($p)->result();

    if(!empty($products))

    {

        foreach($products as $key=> $p)

        {

            $brand = $this->get_brand($p->brand_id);

            $p->product_image = base_url('admin/uploads/products/').$p->product_image;

                //$p->brand = $brand->brand;

            $p->brand = '';

            $all_variants_default = $this->get_variants_default($p->productID,$is_default=1,$cityID);

            foreach($all_variants_default as $allv){

               $p->cart_count = $this->product_cart_count($userID,$p->productID,$allv->id);

               $p->variant_default_id = $allv->id;

           }

           $p->all_variants = $this->get_variants($p->productID,$cityID);

           foreach($p->all_variants as $allv){

            $allv->max_quantity = $this->deal_maxQty($p->productID,$p->max_quantity,$cityID);

            $allv->cart_count = $this->product_cart_count($userID,$p->productID,$allv->id);

        }





        $city_price = $this->product_price($p->productID,$cityID);



        if(!empty($city_price))

        {

            $p->price = $city_price->price;

            $p->cost_price = $city_price->cost_price;

            $p->retail_price = $city_price->retail_price;

            $p->stock_count = $city_price->stock_count;

            $p->unit_value = $city_price->unit_value;

            $p->unit = $city_price->unit;

            $p->weight = $city_price->weight;

        }



        $p->price = $this->check_deal($p->productID,$p->price,$cityID);

        $p->max_quantity = $this->deal_maxQty($p->productID,$p->max_quantity,$cityID);



    }

}

$response[] = array('result'=>'success', 'products'=>$products);

echo json_encode($response);

}



     //get all variants

public function get_variants($product_id,$cityID){

    $path1 = base_url('admin/uploads/variants/');

    $variants = $this->webservice_m->get_all_table_query("SELECT * FROM `products_variant` WHERE `city_id`='$cityID' AND `product_id`='$product_id'");

    foreach($variants as $value){

        $value->variant_image = $path1.$value->variant_image;

    }

    return $variants;

}



public function get_variants_with_maxQty($userID,$product_id,$max_quantity,$cityID){

    $path1 = base_url('admin/uploads/variants/');

    $variants = $this->webservice_m->get_all_table_query("SELECT * FROM `products_variant` WHERE `city_id`='$cityID' AND `product_id`='$product_id'");

    foreach($variants as $value){

        $value->variant_image = $path1.$value->variant_image;

        $value->max_quantity = $this->deal_maxQty($product_id,$max_quantity,$cityID);

        $value->cart_count =$this->product_cart_count($userID,$product_id,$value->id);

    }



    return $variants;

}



    //get all default variants

public function get_variants_default($product_id,$is_default,$cityID){

    $path1 = base_url('admin/uploads/products/');

    $variants = $this->webservice_m->get_all_table_query("SELECT * FROM `products_variant` WHERE `city_id`='$cityID' AND `product_id`='$product_id' AND `is_default`='$is_default' AND in_stock='Y'");

    foreach($variants as $value){

        $value->variant_image = $path1.$value->variant_image;

    }

    return $variants;

}





private function check_deal($productID,$price,$cityID)

{

    $check = $this->webservice_m->get_single_table('deals',array('productID'=>$productID,'cityID'=>$cityID),$select='*');

        // $check = $this->webservice_m->get_single_table('deals',array('productID'=>$productID),$select='*');

    if(!empty($check) && strtotime($check->end_date) > time() && strtotime($check->start_date) < time())

    {

        $price = $check->deal_price;

    }

    return $price;

}



private function deal_maxQty($productID,$max_qty,$cityID=0)

{

    $check = $this->webservice_m->get_single_table('deals',array('productID'=>$productID,'cityID'=>$cityID),$select='*');

        // $check = $this->webservice_m->get_single_table('deals',array('productID'=>$productID),$select='*');

    if(!empty($check))

    {

        $max_qty = $check->max_quantity;

    }

    return $max_qty;

} 







private function product_cart_count($userID,$productID,$variant_id='')

{

    if($variant_id !=''){

        $this->db->select('COALESCE(sum(qty),0) as count');

        $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID,'productID'=>$productID,'variantID'=>$variant_id))->row();

        return $cart_item_count->count;

    }else{

        $this->db->select('COALESCE(sum(qty),0) as count');

        $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID,'productID'=>$productID))->row();

        return $cart_item_count->count;

    }



}





public function coupons()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $d = date('Y-m-d');

    $offers = $this->webservice_m->get_all_table_query("SELECT * FROM `offers` WHERE `start_date` <='$d' AND `end_date` >='$d' AND is_active='Y'");



    $response[] = array('result'=>'success', 'products'=>$offers);

    echo json_encode($response);

}





public function search_product()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $key = $data['key'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:1);

    $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));

    // $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE productID IN (SELECT product_id FROM products_variant WHERE city_id = '$cityID' AND `in_stock` = 'Y' AND `status`='Y') AND `in_stock` = 'Y' AND `product_name` LIKE '%$key%' OR `tags` LIKE '%$key%'");
    $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE `in_stock` = 'Y' AND `product_name` LIKE '%$key%' OR `tags` LIKE '%$key%'");

    $productARr = [];


    if(!empty($products))

    {

        foreach($products as $p)

        {

            $brand = $this->get_brand($p->brand_id);

            $p->product_image = base_url('admin/uploads/products/').$p->product_image;

                //$p->brand = $brand->brand;

            $p->brand = '';



            $city_price = $this->product_price($p->productID,$cityID);

            if(!empty($city_price))

            {

                $p->price = $city_price->price;

                $p->cost_price = $city_price->cost_price;

                $p->retail_price = $city_price->retail_price;

                $p->stock_count = $city_price->stock_count;

                $p->unit_value = $city_price->unit_value;

                $p->unit = $city_price->unit;

                $p->weight = $city_price->weight;

            }





                //$p->cart_count = $this->product_cart_count($userID,$p->productID);

            $all_variants_default = $this->get_variants_default($p->productID,$is_default=1,$cityID);

            foreach($all_variants_default as $allv){

               $p->cart_count = $this->product_cart_count($userID,$p->productID,$allv->id);

               $p->variant_default_id = $allv->id;

           }

           $p->all_variants = $this->get_variants($p->productID,$cityID);
           $p->price = $this->check_deal($p->productID,$p->price,$cityID );

           $p->max_quantity = $this->deal_maxQty($p->productID,$p->max_quantity,$cityID);

           foreach($p->all_variants as $allv){

               $allv->max_quantity = $this->deal_maxQty($p->productID,$p->max_quantity,$cityID);

               $allv->cart_count = $this->product_cart_count($userID,$p->productID,$allv->id);

           }

           

       }

   }

   $response[] = array('result'=>'success', 'products'=>$products);

   echo json_encode($response);

}



public function search()

{

    $data = json_decode(file_get_contents('php://input'), true);
    $this->db->insert('new',['data'=>json_encode($data)]);
    $userID = $data['userID'];
    $cityID = $data['cityID'];

    $key = $data['key'];

    $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));

    $products = '';

    if(!empty($user)){
        if(!empty($key) && $key!=''){
            // $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE productID IN (SELECT product_id FROM products_variant WHERE city_id = '$cityID' AND `status` = 'Y') AND `in_stock` = 'Y' AND `product_name` LIKE '%$key%' OR `tags` LIKE '%$key%'");
            $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE  `in_stock` = 'Y' AND `in_stock` != 'D' AND `product_name` LIKE '%$key%' OR `tags` LIKE '%$key%'");
             // echo $this->db->last_query();

            $list = array();
            if(!empty($products)){
                foreach($products as $pro){

                    $where = [];
                    $where['city_id'] = $cityID;
                    // $where['status'] = 'Y';
                    $where['product_id'] = $pro->productID;
                    $product_verients = $this->db->get_where('products_variant',$where)->row();


            // $product_verients = $this->webservice_m->get_all_table_query("SELECT product_id FROM products_variant WHERE city_id = '$cityID' AND `status` = 'Y' AND `product_id`='$pro->productID'");


                    if($product_verients->status == 'Y' && $pro->in_stock == 'Y'){


                    $pro->product_image = base_url('admin/uploads/products/').$pro->product_image;

                    $variant_data = $this->db->get_where('products_variant',array('product_id'=>$pro->productID,'city_id'=>$cityID))->result();
                    $products_variant = array();
                    $i = 0;
                    foreach ($variant_data as $key) {
                        $check_cart = $this->db->get_where('product_cart',array('productID'=>$pro->productID,'variantID'=>$key->id,'userID'=>$userID))->result();
                        if (!empty($check_cart)) {
                            $qty = $this->db->get_where('product_cart',array('productID'=>$pro->productID,'variantID'=>$key->id,'userID'=>$userID))->row()->qty;
                        }else{
                            $qty = '0';
                        }
                        if ($i == 0) {
                            $is_default = "1";
                        }else{
                           $is_default = "0";
                       }
                       $data_1_products_variant =array(
                        'id'                                  => $key->id,
                        'is_default'                          => $is_default,
                        'product_id'                          => $key->product_id,
                        'city_id'                             => $key->city_id,
                        'unit_value'                          => $key->unit_value,
                        'unit'                                => $key->unit,
                        'weight'                              => $key->weight,
                        'cost_price'                          => $key->cost_price,
                        'stock_count'                         => $key->stock_count,
                        'in_stock'                            => $key->in_stock,
                        'retail_price'                        => $key->retail_price,
                        'price'                               => $key->price,
                        'created_at'                          => $key->created_at,
                        'updated_at'                          => $key->updated_at,
                        'vegtype'                             => $key->vegtype,
                        'status'                              => $key->status,
                        'variant_image'                       => base_url('admin/uploads/variants/').$key->variant_image,
                        'cart_count'                          => $qty,
                        'max_quantity'                        => $pro->max_quantity,

                    );
                       $i++;
                       array_push($products_variant, $data_1_products_variant);
                   }
                   $variant_data1 = $this->db->get_where('products_variant',array('product_id'=>$pro->productID,'city_id'=>$cityID))->row();
                   if (isset($pro->brand_id) && !empty($pro->brand_id)) {
                       $brand = $this->db->get_where('brand',array('brandID'=>$pro->brand_id))->row()->brand;
                   }else{
                    $brand = "";
                }
                $data = array(
                    'productID'           =>$pro->productID,
                    'product_name'        =>$pro->product_name,
                    'product_description' =>$pro->product_description,
                    'use'                 =>$pro->use,
                    'benefit'             =>$pro->benefit,
                    'storage'             =>$pro->storage,
                    'product_image'       =>$pro->product_image,

                    'category_id'         =>$pro->category_id,
                    'brand_id'            =>$pro->brand_id,
                    'in_stock'            =>$pro->in_stock,
                    'cost_price'          =>$pro->cost_price,
                    'stock_count'         =>$pro->stock_count,
                    'price'               =>$pro->price,
                    'retail_price'        =>$pro->retail_price,
                    'unit_value'          =>$pro->unit_value,
                    'unit'                =>$pro->unit,

                    'weight'              =>$pro->weight,
                    'featured'            =>$pro->featured,
                    'vegtype'             =>$pro->vegtype,
                    'max_quantity'        =>$pro->max_quantity,
                    'priority'            =>$pro->priority,
                    'tags'                =>$pro->tags,
                    'added_on'            =>$pro->added_on,
                    'updated_on'          =>$pro->updated_on,
                    'brand'                       =>$brand,
                    'cart_count'                  =>0,
                    'variant_default_id'          =>$variant_data1->id,
                    'all_variants'    =>$products_variant,
                );
                array_push($list, $data);
            }
        }
    }
    }

}

$response[] = array('result'=>'success', 'products'=>$list);

echo json_encode($response);

}


public function transaction_history(){

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = isset($data['userID']) ? $data['userID'] :'';
    $response =[];
    if(!empty($userID)){

        $users = $this->db->get_where('users',array('ID'=>$userID))->row();
        $wallet = $users->wallet;
        $cashback_wallet = $users->cashback_wallet;

        $this->db->order_by("transactionID desc");

        $transactions = $this->db->get_where('transactions',array('userID'=>$userID))->result();

        $response[] = array('result'=>'success', 'transactions'=>$transactions,'wallet'=>$wallet,'cashback_wallet'=>$cashback_wallet);


    }else{
        $response[] = array('result'=>'failure', 'message'=>"User ID Required");

    }

    echo json_encode($response);
}


public function check_delivery_charge(){
  $data = json_decode(file_get_contents('php://input'), true);
  $amount = isset($data['amount']) ? $data['amount'] :0;

  if(!empty($amount)){
    $settings = $this->db->get_where('settings',array('ID'=>1))->row();

    if($amount >= $settings->free_delivery_amount){
        $delivery_charges = 0;
    }else{
       $delivery_charges = $settings->delivery_charge;
   }


   $response[] = array('result'=>'success', 'delivery_charges'=>$delivery_charges);


}else{
    $response[] = array('result'=>'failure', 'message'=>"amount Required");

}





echo json_encode($response);
}









public function search_new()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = isset($data['userID']) ? $data['userID'] :'';

    $key = isset($data['key'])? $data['key']:'';

    $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));
    $cityID =  isset($data['cityID']) ? $data['cityID'] :'1';
    $products = '';
    if(!empty($key)){
        if(!empty($user)){
            if(!empty($key) && $key!=''){
                $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE productID IN (SELECT product_id FROM products_variant WHERE city_id = '$user->cityID' AND `status` = 'Y') AND `in_stock` = 'Y' AND `product_name` LIKE '%$key%' OR `tags` LIKE '%$key%'");

                if(!empty($products))

                {

                    foreach($products as $product)

                    {

                        $brand = $this->get_brand($product->brand_id);

                        $product->product_image = base_url('admin/uploads/products/').$product->product_image;

                        $product->brand = $brand->brand;

            //$product->brand = '';

                        $city_price = $this->product_price($product->productID,$cityID);

                        if(!empty($city_price))

                        {

                            $product->price = $city_price->price;

                            $product->cost_price = $city_price->cost_price;

                            $product->retail_price = $city_price->retail_price;

                            $product->stock_count = $city_price->stock_count;

                            $product->unit_value = $city_price->unit_value;

                            $product->unit = $city_price->unit;

                            $product->weight = $city_price->weight;

                        }

                //$product->cart_count = $this->product_cart_count($userID,$product->productID);

                        $all_variants_default = $this->get_variants_default($product->productID,$is_default=1,$cityID);

                        foreach($all_variants_default as $allv){

                           $product->cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

                           $product->variant_default_id = $allv->id;

                       }

                       $product->all_variants = $this->get_variants($product->productID,$cityID);

                       foreach($product->all_variants as $allv){

                        $allv->max_quantity = $this->deal_maxQty($product->productID,$product->max_quantity,$cityID);

                        $allv->cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

                    }

                    $product->price = $this->check_deal($product->productID,$product->price,$cityID);

                    $product->max_quantity = $this->deal_maxQty($product->productID,$product->max_quantity,$cityID);



                }

            }
            $response[] = array('result'=>'success', 'products'=>$products,'product_image '=>'');

        }

    }else{
        $response[] = array('result'=>'failure', 'products'=>null,'message'=>'User ID Required');

    }
}else{
    $response[] = array('result'=>'failure', 'products'=>null,'message'=>'key Required');

}






echo json_encode($response);

}






public function product_detail()

{

    $data = json_decode(file_get_contents('php://input'), true);




$this->db->insert('new',['data'=>json_encode($data)]);

    $userID = $data['userID'];

    $productID = $data['productID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $product = $this->webservice_m->get_single_table("products",array("productID"=>$productID));

        //$product = $this->db->query("SELECT products_detail.retail_price as retail_price,products_detail.cost_price as cost_price, products_detail.stock_count as stock_count,products.* FROM `products` LEFT JOIN products_detail ON products_detail.product_id = products.productID WHERE productID ='$productID'")->row();

    if(!empty($product))

    {

        $brand = $this->get_brand($product->brand_id);

        $product->product_image = base_url('admin/uploads/products/').$product->product_image;

        $product->brand = "";

        if (!empty($brand)) {

            $product->brand = $brand->brand;

        }



        $city_price = $this->product_price($product->productID,$cityID);

        if(!empty($city_price))

        {

            $product->price = $city_price->price;

            $product->cost_price = $city_price->cost_price;

            $product->retail_price = $city_price->retail_price;

            $product->stock_count = $city_price->stock_count;

            $product->unit_value = $city_price->unit_value;

            $product->unit = $city_price->unit;

            $product->weight = $city_price->weight;

        }

        $product->max_quantity = $this->deal_maxQty($product->productID,$product->max_quantity,$cityID);

        $all_variants_default = $this->get_variants_default($product->productID,$is_default=1,$cityID);

        foreach($all_variants_default as $allv){

           $product->cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

           $product->variant_default_id = $allv->id;

       }

       $product->all_variants = $this->get_variants($product->productID,$cityID);

       foreach($product->all_variants as $allv){

        $allv->max_quantity = $this->deal_maxQty($product->productID,$product->max_quantity,$cityID);

        $allv->cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

        if($allv->is_default == 1)

        {

            $allv->price = $this->check_deal($allv->product_id,$allv->price,$cityID);

        }



    }

    $product->price = $this->check_deal($product->productID,$product->price,$cityID);



}

$response[] = array('result'=>'success', 'product'=>$product);

echo json_encode($response);

}





public function similar_products()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $productID = $data['productID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $product = $this->db->get_where('products',array('productID'=>$productID))->row();

    $sql = "SELECT * FROM `products` WHERE `productID`!='$productID'AND `in_stock` = 'Y' AND (";

        $cat = explode(',', $product->category_id);

        if(!empty($cat))

        {

            foreach($cat as $c)

            {

                $sql .= " FIND_IN_SET($c,`category_id`) OR ";

            }

            $sql = substr($sql, 0, -3);





        } else{

            $sql .= " 1";

        }

        $sql .= " ) ORDER BY priority ASC";

        $products = $this->db->query($sql)->result();



        // $products = $this->webservice_m->get_all_data_where("products",array("productID !="=>$productID, "in_stock" => 'Y'));

        if(!empty($products))

        {

            foreach($products as $product)

            {

                $brand = $this->get_brand($product->brand_id);

                $product->product_image = base_url('admin/uploads/products/').$product->product_image;

                //$product->brand = $brand->brand;

                $product->brand = '';

                $city_price = $this->product_price($product->productID,$cityID);

                if(!empty($city_price))

                {

                    $product->price = $city_price->price;

                    $product->cost_price = $city_price->cost_price;

                    $product->retail_price = $city_price->retail_price;

                    $product->stock_count = $city_price->stock_count;

                    $product->unit_value = $city_price->unit_value;

                    $product->unit = $city_price->unit;

                    $product->weight = $city_price->weight;

                }

                //$product->cart_count = $this->product_cart_count($userID,$product->productID);

                $all_variants_default = $this->get_variants_default($product->productID,$is_default=1,$cityID);

                foreach($all_variants_default as $allv){

                   $product->cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

                   $product->variant_default_id = $allv->id;

               }

               $product->all_variants = $this->get_variants($product->productID,$cityID);

               foreach($product->all_variants as $allv){

                $allv->max_quantity = $this->deal_maxQty($product->productID,$product->max_quantity,$cityID);

                $allv->cart_count = $this->product_cart_count($userID,$product->productID,$allv->id);

            }

            $product->price = $this->check_deal($product->productID,$product->price,$cityID);

            $product->max_quantity = $this->deal_maxQty($product->productID,$product->max_quantity,$cityID);



        }

    }

    $response[] = array('result'=>'success', 'products'=>$products);

    echo json_encode($response);



}









    // public function update_cart()

    // {

    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $userID = $data['userID'];

    //     $productID = $data['productID'];

    //     $qty = $data['qty'];

    //     $q = (empty($data['cityID'])?$data['qty']:$data['cityID']);

    //     $check = $this->webservice_m->get_single_table("product_cart",array('userID'=>$userID, 'productID'=>$productID));

    //     $a = array('userID'=>$userID,'productID'=>$productID,'qty'=>$qty,'added_on'=>date('Y-m-d H:i:s'));



    //     //$a = array('userID'=>$userID,'qty'=>$productID,'productID'=>$qty,'added_on'=>date('Y-m-d H:i:s'));

    //     if(!empty($check))

    //     {

    //         //update

    //         if($qty == '0')

    //         {

    //             $this->db->where(array('cartID'=>$check->cartID));

    //             $this->db->delete('product_cart');

    //         } else {

    //             $this->db->where(array('cartID'=>$check->cartID));

    //             $this->db->update('product_cart',$a);

    //         }



    //     } else {

    //         //insert

    //         $this->webservice_m->table_insert('product_cart',$a);

    //     }

    //     $this->db->select('sum(qty) as count');

    //     $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID))->row();

    //     $response[] = array('result'=>'success','cart_count'=>$cart_item_count->count);

    //     echo json_encode($response);

    // }



public function update_cart()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $productID = $data['productID'];

    $variantID = $data['variantID'];

    $qty = $data['qty'];

    $q = (empty($data['cityID'])?$data['qty']:$data['cityID']);

    $check = $this->webservice_m->get_single_table("product_cart",array('userID'=>$userID, 'productID'=>$productID,'variantID'=>$variantID));

    $a = array('userID'=>$userID,'productID'=>$productID, 'variantID'=>$variantID,'qty'=>$qty,'cityID'=>$q,'added_on'=>date('Y-m-d H:i:s'));



        //$a = array('userID'=>$userID,'qty'=>$productID,'productID'=>$qty,'added_on'=>date('Y-m-d H:i:s'));

    if(!empty($check))

    {

            //update

        if($qty == '0')

        {

            $this->db->where(array('cartID'=>$check->cartID));

            $this->db->delete('product_cart');

        } else {

            $this->db->where(array('cartID'=>$check->cartID));

            $this->db->update('product_cart',$a);

        }



    } else {

            //insert

        $this->webservice_m->table_insert('product_cart',$a);
        //echo $this->db->last_query(); exit();

    }

    $this->db->select('sum(qty) as count');

    $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID))->row();

    $response[] = array('result'=>'success','cart_count'=>$cart_item_count->count);

    echo json_encode($response);

}





    // public function list_user_cart(){

    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $userID = $data['userID'];

    //     $cityID =  (empty($data['cityID'])?$data['qty']:$data['cityID']);

    //     $carts = $this->webservice_m->get_all_data_where('product_cart',array('userID'=>$userID));

    //     $products = array();

    //     $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));



    //     if(!empty($carts))

    //     {

    //         foreach($carts as $c)

    //         {

    //             $product = $this->webservice_m->get_single_table("products",array("productID"=>$c->productID));

    //             $dt = $this->webservice_m->get_single_table("products_detail",array("product_id"=>$c->productID, "city_id"=>$cityID));

    //             if(!empty($product) && !empty($dt))

    //             {

    //                 $brand = $this->get_brand($product->brand_id);

    //                 $product->product_image = base_url('admin/uploads/products/').$product->product_image;

    //                 //$product->brand = $brand->brand;

    //                 $product->brand = '';

    //                 $product->qty = $c->qty;

    //                 $product->cost_price = $dt->cost_price;

    //                 $product->retail_price = $dt->retail_price;

    //                 $product->price = $dt->price;



    //                 $product->net_price = $c->qty * $dt->price;



    //                 if ($product->in_stock != 'Y' || $dt->stock_count <= 0 || $dt->status != 'Y') {

    //                     $product->qty = '0';

    //                 }

    //                 if ($dt->stock_count < $c->qty && $c->qty > 0) {

    //                     $product->qty = $dt->stock_count;

    //                 }

    //                 if($dt->stock_count <= 0){

    //                     $product->in_stock = 'N';  

    //                 }

    //                 $product->stock_count = $dt->stock_count;

    //                 //$product->stock_count = $this->get_stock_count($product->product_name,$product->unit,$product->unit_value);

    //                 $product->price = $this->check_deal($product->productID,$product->price,$user->cityID);

    //                 if ($product->qty > 0) {

    //                     array_push($products, $product);

    //                 }



    //             }

    //         }

    //         $response[] = array('result'=>'success','products'=>$products);

    //     } else {

    //         $response[] = array('result'=>'success','products'=>array());

    //     }

    //     echo json_encode($response);

    // }





public function list_user_cart(){

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID =  (empty($data['cityID'])?$data['cityID']:$data['cityID']);

    $carts = $this->webservice_m->get_all_data_where('product_cart',array('userID'=>$userID));
//echo $this->db->last_query(); 
        //print_r($carts); exit;

    $products = array();

    $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));



    if(!empty($carts))

    {
        $list = array();

        foreach($carts as $c)

        {

            $product = $this->webservice_m->get_single_table("products",array("productID"=>$c->productID));

            $dt = $this->webservice_m->get_single_table("products_variant",array("product_id"=>$c->productID,"id"=>$c->variantID, "city_id"=>$cityID));
//echo $this->db->last_query(); 
                //print_r($dt); exit;

            if(!empty($product) && !empty($dt))

            {

                $brand = $this->get_brand($product->brand_id);

                $product->product_image = base_url('admin/uploads/products/').$product->product_image;

                    //$product->brand = $brand->brand;

                $product->brand = '';

                $product->qty = $c->qty;

                $product->cost_price = $dt->cost_price;

                $product->retail_price = $dt->retail_price;

                $product->price = $dt->price;

                $product->variantID = $dt->id;









                $product->unit = $dt->unit;

                $product->unit_value = $dt->unit_value;

                    // if ($product->in_stock != 'Y' || $dt->stock_count <= 0 || $dt->is_active != 'Y') {

                    //     $product->qty = '0';

                    // }



                    // if($dt->stock_count <= 0){

                    //     $product->in_stock = 'N';  

                    // }

                if($dt->stock_count <= $product->max_quantity)

                {

                    $product->stock_count = $dt->stock_count;

                    $a = $dt->stock_count;

                } else {

                    $product->stock_count = $product->max_quantity;

                    $a = $product->max_quantity;

                }



                $product->qty = $c->qty;

                if ($a <= $c->qty && $c->qty > 0) {

                    $product->qty = $a;

                }

                $product->net_price = $product->qty * $dt->price;



                    //$product->stock_count = $this->get_stock_count($product->product_name,$product->unit,$product->unit_value);

                $product->price = $this->check_deal($product->productID,$product->price,$user->cityID);

                if ($product->qty > 0) {

                    array_push($products, $product);

                }
               // array_push($list, $products);



            }
//print_r($products);
//print_r($list);
        }

        $response[] = array('result'=>'success','products'=>$products);

    } else {

        $response[] = array('result'=>'success','products'=>array());

    }

    echo json_encode($response);

}

public function list_user_cart1(){

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID =  (empty($data['cityID'])?$data['cityID']:'0');

    $carts = $this->webservice_m->get_all_data_where('product_cart',array('userID'=>$userID));

        //print_r($carts); exit;

    $products = array();

    $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));

    $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));

    if(!empty($carts))

    {

        foreach($carts as $c)

        {



            $product = $this->webservice_m->get_single_table("products",array("productID"=>$c->productID));

            $dt = $this->webservice_m->get_single_table("products_variant",array("product_id"=>$c->productID,"id"=>$c->variantID, "city_id"=>$cityID));

            if(!empty($product) && !empty($dt))

            {



                $brand = $this->get_brand($product->brand_id);

                $product->product_image = base_url('admin/uploads/variants/').$dt->variant_image;

                    //$product->brand = $brand->brand;

                $product->brand = '';

                $product->qty = $c->qty;

                $product->cost_price = $dt->cost_price;

                $product->retail_price = $dt->retail_price;

                $product->price = $dt->price;

                $product->variantID = $dt->id;



                $product->qty = $c->qty;

                $product->unit = $dt->unit;

                $product->unit_value = $dt->unit_value;

                $product->net_price = $c->qty * $dt->price;





                    // if ($product->in_stock != 'Y' || $dt->stock_count <= 0 || $dt->is_active != 'Y') {

                    //     $product->qty = '0';

                    // }

                    // if ($dt->stock_count < $c->qty && $c->qty > 0) {

                    //     $product->qty = $dt->stock_count;

                    // }

                    // if($dt->stock_count <= 0){

                    //     $product->in_stock = 'N';  



                    // }

                $product->stock_count = $dt->stock_count;

                    //$product->stock_count = $this->get_stock_count($product->product_name,$product->unit,$product->unit_value);

                $product->price = $this->check_deal($product->productID,$product->price,$user->cityID);

                if ($product->qty > 0) {

                    array_push($products, $product);

                }



            }

        }

        $response[] = array('result'=>'success','products'=>$products);

    } else {

        $response[] = array('result'=>'success','products'=>array());

    }

    echo json_encode($response);

}

public function delivery_charges()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $delivery_charges = 0;

    $min_order_amount = 0;

    $max_order_amount = 0;

    $free_delivery_amount = 0;

    $settings = $this->webservice_m->get_single_table('settings',array('ID'=>1),$select='*');

    $user = $this->db->get_where('users',array('ID'=>$userID))->row();

    $wallet_amount = $user->wallet;
    $cashback_amount = $user->cashback_wallet;

    if (!empty($settings)){

        $delivery_charges = $settings->delivery_charge;

        $min_order_amount = $settings->min_order_amount;

        $max_order_amount = $settings->max_order_amount;

        $free_delivery_amount = $settings->free_delivery_amount;

    }

    $response[] = array('result'=>'success','delivery_charges'=>$delivery_charges,'min_order_amount'=>$min_order_amount,'max_order_amount'=>$max_order_amount,'free_delivery_amount'=>$free_delivery_amount,'wallet_amount'=>$wallet_amount,'cashback_amount'=>$cashback_amount,'gst'=>0);

    echo json_encode($response);

}



    // public function place_order()

    // {

    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $userID = $data['userID'];

    //     $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    //     $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();



    //     // if(!isset($data['version_code']) || $data['version_code'] < 14)

    //     // {

    //     //     $sms_id = 0;

    //     //     $message = "Dear $user_info->name,\n Please update the app to place order. \n Click on below link to update.\n https://play.google.com/store/apps/details?id=com.grocery.gowisekart \n Thanks\n gowisekart.";

    //     //     $check_date = date("Y-m-d H:i:s",(time() - (600)));

    //     //     $check_prev_sms = $this->db->query("SELECT * FROM `send_update_message` WHERE `user_id` = $userID AND `version` = 14  AND `created_at` > '$check_date'")->row();



    //     //     if(empty($check_prev_sms)){

    //     //         $sms_id = $this->send_sms($user_info->mobile,$message);

    //     //         $this->db->insert('send_update_message',array('user_id'=>$userID,'version'=>14,'created_at'=>date("Y-m-d H:i:s")));

    //     //     }

    //     //     $response[] = array('result'=>'failure','orderID'=>0,'text'=>$sms_id);

    //     //     echo json_encode($response);

    //     //     return true;

    //     // }



    //     $addressID = $data['addressID'];

    //     $coupon_code = $data['coupon_code'];

    //     $coupon_amt = str_replace(',','',$data['coupon_amt']);

    //     $order_amt = str_replace(',','',$data['order_amt']);

    //     $total_amount = str_replace(',','',$data['total_amount']);

    //     $payment_method = $data['payment_method']; //'cod' or 'online'

    //     $delivery_date = date('Y-m-d',strtotime($data['delivery_date']));

    //     $delivery_slot = $data['delivery_slot'];

    //     $instruction = $data['instruction'];

    //     $transactionID = $data['transactionID'];

    //     $delivery_charges = 0;

    //     $online_payment_amount = 0;

    //     $wallet_payment_amount = 0;

    //     $user = $this->db->get_where('users',array('ID'=>$userID))->row();

    //     $user_wallet = $user->wallet;

    //     if (isset($data['delivery_charges'])){

    //         $delivery_charges = $data['delivery_charges'];

    //         $online_payment_amount = $data['online_amount'];

    //         $wallet_payment_amount = $data['wallet_amount'];

    //     }

    //     $items = json_decode($data['items']);

    //     $address = $this->webservice_m->get_single_table('user_address',array('addressID'=>$addressID));

    //     $camount = ($order_amt + $delivery_charges) - $coupon_amt;

    //     if($total_amount != $camount)

    //     {

    //         $order_amt = ($total_amount - $delivery_charges)+$ca;

    //     }

    //     $array = array(

    //         'userID' => $userID,

    //         'cityID' => $cityID,

    //         'customer_name' => $address->contact_person_name,

    //         'contact_no' => $address->contact_person_mobile,

    //         'house_no' => $address->flat_no,

    //         'apartment' => $address->building_name,

    //         'landmark' => $address->landmark,

    //         'location' => $address->location,

    //         'latitude' => $address->latitude,

    //         'longitude' => $address->longitude,

    //         'address_type' => $address->address_type,

    //         'coupon_code' => $coupon_code,

    //         'coupon_discount' => $coupon_amt,

    //         'order_amount' => $order_amt,

    //         'total_amount' => $total_amount,

    //         'payment_method' => $payment_method,

    //         'delivery_date' => $delivery_date,

    //         'delivery_slot' => $delivery_slot,

    //         'delivery_charges' => $delivery_charges,

    //         'instruction' => $instruction,

    //         'status' => 'PLACED',

    //         'added_on' => date('Y-m-d H:i:s'),

    //         'updated_on' => date('Y-m-d H:i:s')

    //     );

    //     if ($payment_method == 'online'){

    //         if ($online_payment_amount > 0)

    //         {

    //             $success = false;

    //             $error = '';

    //             try {

    //                 $ch = $this->get_curl_handle($transactionID, $online_payment_amount * 100);

    //                 //execute post

    //                 $result = curl_exec($ch);

    //                 $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    //                 if ($result === false) {

    //                     $success = false;

    //                     $error = 'Curl error: '.curl_error($ch);

    //                 } else {

    //                     $txn_description = $result;

    //                     $response_array = json_decode($result, true);

    //                     if ($http_status === 200 and isset($response_array['error']) === false) {

    //                         $success = true;

    //                     } else {

    //                         $success = false;

    //                         if (!empty($response_array['error']['code'])) {

    //                             $error = $response_array['error']['code'].':'.$response_array['error']['description'];

    //                         } else {

    //                             $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;

    //                         }

    //                     }

    //                 }

    //                 //close connection

    //                 curl_close($ch);

    //             } catch (Exception $e) {

    //                 $success = false;

    //                 $response = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');

    //                 $error = 'OPENCART_ERROR:Request to Razorpay Failed';

    //             }

    //         }else{

    //             $success = true;

    //         }



    //         if ($success === true) {

    //             if(!empty($this->session->userdata('ci_subscription_keys'))) {

    //                 $this->session->unset_userdata('ci_subscription_keys');

    //             }

    //             if ($online_payment_amount > 0){

    //                 $txn_array = array(

    //                     'userID'=>$userID,

    //                     'txn_no' => $transactionID,

    //                     'amount' => $online_payment_amount,

    //                     'type'=>'CREDIT',

    //                     'note'=>'',

    //                     'against_for' => 'order',

    //                     'paid_by'=>'online',

    //                     'orderID'=>0,

    //                     'transaction_at' => date("Y-m-d H:i:s")

    //                 );

    //                 $this->db->insert('transactions', $txn_array);

    //                 $user_wallet += $online_payment_amount;

    //                 $this->db->where(array('ID'=>$userID));

    //                 $this->db->update('users',array('wallet'=>$user_wallet));

    //             }

    //             $total_amount_order = $online_payment_amount + $wallet_payment_amount;



    //             $txn_array = array(

    //                 'userID'=>$userID,

    //                 'txn_no' => $transactionID,

    //                 'amount' => $total_amount_order,

    //                 'type'=>'DEBIT',

    //                 'note'=>'',

    //                 'against_for' => 'order',

    //                 'paid_by'=>'wallet',

    //                 'orderID'=>0,

    //                 'transaction_at' => date("Y-m-d H:i:s")

    //             );

    //             $this->db->insert('transactions', $txn_array);

    //             $txnID = $this->db->insert_id();

    //             $user_wallet -= $total_amount_order;

    //             $this->db->where(array('ID'=>$userID));

    //             $this->db->update('users',array('wallet'=>$user_wallet));

    //             $id = $this->webservice_m->table_insert('orders',$array);

    //             $this->db->delete('product_cart',array('userID'=>$userID));

    //             $this->db->where(array('transactionID'=>$txnID));

    //             $this->db->update('transactions',array('orderID'=>$id));

    //             if(!empty($items))

    //             {

    //                 foreach($items as $i)

    //                 {

    //                     $p = $this->db->get_where('products_detail',array('product_id'=>$i->productID,'city_id'=>$cityID))->row();

    //                     $p->price = $this->check_deal($p->product_id,$p->price,$user_info->cityID);

    //                     $b = array(

    //                         'orderID' => $id,

    //                         'productID' => $i->productID,

    //                         'qty' => $i->quantity,

    //                         'price' => $p->price,

    //                         'net_price' => $p->price * $i->quantity,

    //                         'status' => 'PLACED',

    //                         'added_on' => date('Y-m-d H:i:s'),

    //                         'updated_on' => date('Y-m-d H:i:s')

    //                     );

    //                     $itemID = $this->webservice_m->table_insert('order_items',$b);

    //                     $c = array(

    //                         'itemID'=>$itemID,

    //                         'orderID'=>$id,

    //                         'status'=>'PLACED',

    //                         'added_on' => date('Y-m-d H:i:s')

    //                     );

    //                     $this->webservice_m->table_insert('order_status',$c);



    //                      //Stock Update

    //                     $this->db->where(array('product_id'=>$p->product_id, 'city_id'=>$user_info->cityID));

    //                     $this->db->update('products_detail',array('stock_count'=>($p->stock_count - $i->quantity)));

    //                 }

    //             }

    //             if($id)

    //             {

    //                 $message = "Dear $user->name,\nYour order #$id is placed.  It will be delivered on $delivery_date between $delivery_slot.\nHappy Shopping!\nTeam gowisekart";



    //                 $this->send_sms($user->mobile,$message);

    //                 $notification_insert = array(

    //                     "title"=>'ORDER PLACED',

    //                     "image"=>'',

    //                     "text"=>$message,

    //                     "userID"=>$userID,

    //                     "status"=>'sent',

    //                     "added_on"=>date("Y-m-d H:i:s"),

    //                     "updated_on"=>date("Y-m-d H:i:s"),

    //                 );

    //                 $this->db->insert('notifications',$notification_insert);



    //                 $user_login = $this->db->get_where('user_login',array('userID'=>$userID))->result();

    //                 foreach ($user_login as $login)

    //                 {

    //                     if (strtolower($login->device_type) == 'android'){

    //                         $this->send_notification('ORDER PLACED', $message , $login->device_token,'');

    //                     }

    //                 }

    //                 //$this->send_sms($user->mobile,$message);



    //             }

    //             $response[] = array('result'=>'success','orderID'=>$id);

    //         }else{

    //             $response[] = array('result'=>'failure','orderID'=>0);

    //         }



    //     }else{



    //         $id = $this->webservice_m->table_insert('orders',$array);

    //         $this->db->delete('product_cart',array('userID'=>$userID));

    //         if(!empty($items))

    //         {

    //             foreach($items as $i)

    //             {

    //                 $p = $this->db->get_where('products_detail',array('product_id'=>$i->productID, 'city_id'=>$user_info->cityID))->row();

    //                 $p->price = $this->check_deal($p->product_id,$p->price,$user_info->cityID);

    //                 $b = array(

    //                     'orderID' => $id,

    //                     'productID' => $i->productID,

    //                     'qty' => $i->quantity,

    //                     'price' => $p->price,

    //                     'net_price' => $p->price * $i->quantity,

    //                     'status' => 'PLACED',

    //                     'added_on' => date('Y-m-d H:i:s'),

    //                     'updated_on' => date('Y-m-d H:i:s')

    //                 );

    //                 $itemID = $this->webservice_m->table_insert('order_items',$b);

    //                 $c = array(

    //                     'itemID'=>$itemID,

    //                     'orderID'=>$id,

    //                     'status'=>'PLACED',

    //                     'added_on' => date('Y-m-d H:i:s')

    //                 );

    //                 $this->webservice_m->table_insert('order_status',$c);



    //                 //Stock Update

    //                 $this->db->where(array('product_id'=>$p->product_id, 'city_id'=>$user_info->cityID));

    //                 $this->db->update('products_detail',array('stock_count'=>($p->stock_count - $i->quantity)));



    //             }

    //         }

    //         if($id)

    //         {

    //             $message = "Dear $user->name,\nYour order #$id will be delivered on $delivery_date between $delivery_slot. Amount to be paid Rs. $total_amount.\nYou will receive a delivery confirmation notification once the order is delivered.\nThanks,\ngowisekart.";

    //             $this->send_sms($user->mobile,$message);

    //             $notification_insert = array(

    //                 "title"=>'ORDER PLACED',

    //                 "image"=>'',

    //                 "text"=>$message,

    //                 "userID"=>$userID,

    //                 "status"=>'sent',

    //                 "added_on"=>date("Y-m-d H:i:s"),

    //                 "updated_on"=>date("Y-m-d H:i:s"),

    //             );

    //             $this->db->insert('notifications',$notification_insert);



    //             $user_login = $this->db->get_where('user_login',array('userID'=>$userID))->result();

    //             foreach ($user_login as $login)

    //             {

    //                 if (strtolower($login->device_type) == 'android'){

    //                     $this->send_notification('ORDER PLACED', $message , $login->device_token,'');

    //                 }

    //             }

    //             // $this->send_invoice_on_mail($user->userID,$id);



    //         }

    //         $response[] = array('result'=>'success','orderID'=>$id); 



    //     }



    //     echo json_encode($response);



    // }



public function place_order()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

    $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));

        // if(!isset($data['version_code']) || $data['version_code'] < 14)

        // {

        //     $sms_id = 0;

        //     $message = "Dear $user_info->name,\n Please update the app to place order. \n Click on below link to update.\n https://play.google.com/store/apps/details?id=com.grocery.gowisekart \n Thanks\n gowisekart.";

        //     $check_date = date("Y-m-d H:i:s",(time() - (600)));

        //     $check_prev_sms = $this->db->query("SELECT * FROM `send_update_message` WHERE `user_id` = $userID AND `version` = 14  AND `created_at` > '$check_date'")->row();



        //     if(empty($check_prev_sms)){

        //         $sms_id = $this->send_sms($user_info->mobile,$message);

        //         $this->db->insert('send_update_message',array('user_id'=>$userID,'version'=>14,'created_at'=>date("Y-m-d H:i:s")));

        //     }

        //     $response[] = array('result'=>'failure','orderID'=>0,'text'=>$sms_id);

        //     echo json_encode($response);

        //     return true;

        // }




    $addressID = $data['addressID'];

    $coupon_code = $data['coupon_code'];
    $type = $this->check_coupon_type($data['coupon_code']);

    $coupon_amt = str_replace(',','',$data['coupon_amt']);

    $order_amt = str_replace(',','',$data['order_amt']);

    $total_amount = str_replace(',','',$data['total_amount']);
        //$cashback_amount = str_replace(',','',$data['amount_cashback']);
    $cashback_amount = (!empty($data['amount_cashback']))? str_replace(',','',$data['amount_cashback']):'0.00';
        //echo $cashback_amount; exit;

        $payment_method = $data['payment_method']; //'cod' or 'online'

        $delivery_date = date('Y-m-d',strtotime($data['delivery_date']));

        $delivery_slot = $data['delivery_slot'];

        $instruction = $data['instruction'];

        $transactionID = $data['transactionID'];

        $delivery_charges = 0;

        $online_payment_amount = 0;

        $wallet_payment_amount = 0;

        $user = $this->db->get_where('users',array('ID'=>$userID))->row();

        $user_wallet = $user->wallet;
        $user_cashbackWallet = $user->cashback_wallet;

        if (isset($data['delivery_charges'])){

            $delivery_charges = $data['delivery_charges'];

            $online_payment_amount = $data['online_amount'];

            $wallet_payment_amount = $data['wallet_amount'];

        }

        $items = json_decode($data['items']);

        $address = $this->webservice_m->get_single_table('user_address',array('addressID'=>$addressID));

        

        if($type == 'CASHBACK')
        {
            $camount = ($order_amt + $delivery_charges) - $cashback_amount;
        } else {
            $camount = ($order_amt + $delivery_charges) - (int)$coupon_amt - $cashback_amount;
        }
        

        // if($total_amount != $camount)

        // {

        //     $order_amt = ($total_amount - $delivery_charges)+$camount;

        // }
        $customer_name = $address->contact_person_name;
        $mobile = $address->contact_person_mobile;

        $array = array(

            'userID' => $userID,

            'cityID' => $cityID,

            'customer_name' => $address->contact_person_name,

            'contact_no' => $address->contact_person_mobile,

            'house_no' => $address->flat_no,

            'apartment' => $address->building_name,

            'landmark' => $address->landmark,

            'location' => $address->location,

            'latitude' => $address->latitude,

            'longitude' => $address->longitude,

            'address_type' => $address->address_type,

            'coupon_code' => $coupon_code,
            'type' => $type,

            'coupon_discount' => $coupon_amt,

            'order_amount' => $order_amt,

            'total_amount' => $camount,

            'cashback_amount' => $cashback_amount,

            'payment_method' => $payment_method,

            'delivery_date' => $delivery_date,

            'delivery_slot' => $delivery_slot,

            'delivery_charges' => $delivery_charges,

            'instruction' => $instruction,

            'status' => 'PLACED',

            'added_on' => date('Y-m-d H:i:s'),

            'updated_on' => date('Y-m-d H:i:s')

        );
         //update cashback wallet
                //echo $cashback_amount; exit;
        $this->db->where(array('ID'=>$userID));
        $this->db->update('users',array('cashback_wallet'=>$user_cashbackWallet-$cashback_amount));
               // echo $this->db->last_query(); exit;

        if ($payment_method == 'online'){

            if ($online_payment_amount > 0)

            {

                $success = false;

                $error = '';

                try {

                    $ch = $this->get_curl_handle($transactionID, floor($online_payment_amount) * 100);

                    //execute post

                    $result = curl_exec($ch);

                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($result === false) {

                        $success = false;

                        $error = 'Curl error: '.curl_error($ch);

                    } else {

                        $txn_description = $result;

                        $response_array = json_decode($result, true);

                        if ($http_status === 200 and isset($response_array['error']) === false) {

                            $success = true;

                        } else {

                            $success = false;

                            if (!empty($response_array['error']['code'])) {

                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];

                            } else {

                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;

                            }

                        }

                    }

                    //close connection

                    curl_close($ch);

                } catch (Exception $e) {

                    $success = false;

                    $response = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');

                    $error = 'OPENCART_ERROR:Request to Razorpay Failed';

                }

            }else{

                $success = true;

            }



            if ($success === true) {

                if(!empty($this->session->userdata('ci_subscription_keys'))) {

                    $this->session->unset_userdata('ci_subscription_keys');

                }

                if ($online_payment_amount > 0){

                    $txn_array = array(

                        'userID'=>$userID,

                        'txn_no' => $transactionID,

                        'amount' => floor($online_payment_amount),

                        'type'=>'CREDIT',

                        'note'=>'',

                        'against_for' => 'order',

                        'paid_by'=>'online',

                        'orderID'=>0,

                        'transaction_at' => date("Y-m-d H:i:s")

                    );

                    $this->db->insert('transactions', $txn_array);

                    $user_wallet += floor($online_payment_amount);

                    $this->db->where(array('ID'=>$userID));

                    $this->db->update('users',array('wallet'=>$user_wallet));

                }

                $total_amount_order = floor($online_payment_amount) + $wallet_payment_amount;



                $txn_array = array(

                    'userID'=>$userID,

                    'txn_no' => $transactionID,

                    'amount' => $total_amount_order,

                    'type'=>'DEBIT',

                    'note'=>'',

                    'against_for' => 'order',

                    'paid_by'=>'wallet',

                    'orderID'=>0,

                    'transaction_at' => date("Y-m-d H:i:s")

                );

                $this->db->insert('transactions', $txn_array);

                $txnID = $this->db->insert_id();

                $user_wallet -= $total_amount_order;

                $this->db->where(array('ID'=>$userID));

                $this->db->update('users',array('wallet'=>$user_wallet));

                $id = $this->webservice_m->table_insert('orders',$array);

                $this->db->delete('product_cart',array('userID'=>$userID));

                $this->db->where(array('transactionID'=>$txnID));

                $this->db->update('transactions',array('orderID'=>$id));




                if(!empty($items))

                {

                    foreach($items as $i)

                    {

                        $p = $this->db->get_where('products_variant',array('id'=>$i->id,'city_id'=>$cityID))->row();

                        $p->price = $this->check_deal($p->product_id,$p->price,$user_info->cityID);

                        if(empty($p->price))

                        {

                            $p->price = 1;

                        }

                        $b = array(

                            'orderID' => $id,

                            'productID' => $i->productID,

                            'variantID' => $i->id,

                            'qty' => $i->quantity,

                            'price' => $p->price,

                            'net_price' => $p->price * $i->quantity,

                            'status' => 'PLACED',

                            'added_on' => date('Y-m-d H:i:s'),

                            'updated_on' => date('Y-m-d H:i:s')

                        );

                        $itemID = $this->webservice_m->table_insert('order_items',$b);

                        $c = array(

                            'itemID'=>$itemID,

                            'orderID'=>$id,

                            'status'=>'PLACED',

                            'added_on' => date('Y-m-d H:i:s')

                        );

                        $this->webservice_m->table_insert('order_status',$c);



                        //Stock Update

                        $this->db->where(array('id'=>$p->id, 'city_id'=>$user_info->cityID));

                        $this->db->update('products_variant',array('stock_count'=>($p->stock_count - $i->quantity)));

                    }

                }

                if($id)

                {

                    $message = "Dear $user->name,\nYour order #$id is placed.  It will be delivered on $delivery_date between $delivery_slot.\nHappy Shopping!\nTeam gowisekart";



                    $this->send_sms($user->mobile,$message);

                    $notification_insert = array(

                        "title"=>'ORDER PLACED',

                        "image"=>'',

                        "text"=>$message,

                        "userID"=>$userID,

                        "status"=>'sent',

                        "added_on"=>date("Y-m-d H:i:s"),

                        "updated_on"=>date("Y-m-d H:i:s"),

                    );

                    $this->db->insert('notifications',$notification_insert);



                    $user_login = $this->db->get_where('user_login',array('userID'=>$userID))->result();

                    foreach ($user_login as $login)

                    {

                        if (strtolower($login->device_type) == 'android'){

                            $this->send_notification('ORDER PLACED', $message , $login->device_token,'');

                        }

                    }

                    //$this->send_sms($user->mobile,$message);




                }

                $response[] = array('result'=>'success','orderID'=>$id);

            }else{

                $response[] = array('result'=>'failure','orderID'=>0);

            }



        }else{



            $id = $this->webservice_m->table_insert('orders',$array);
            $p = [];
            $this->db->delete('product_cart',array('userID'=>$userID));

            if(!empty($items))

            {

            	//print_r($items); exit;

                foreach($items as $i)

                {

                    //$p = $this->db->get_where('products_variant',array('product_id'=>$i->productID,'id'=>$i->id, 'city_id'=>$user_info->cityID))->row();

                    $p = $this->db->get_where('products_variant',array('product_id'=>$i->productID,'id'=>$i->id, 'city_id'=>$cityID))->row();
                    // echo $this->db->last_query();
                    // print_r($p); exit;

                    

                    if(!empty($p)){

                       //$p->price = $this->check_deal($p->product_id,$p->price,$user_info->cityID);  

                    	$p->price = $this->check_deal($p->product_id,$p->price,$cityID);  

                    }else{
                        $p->price = 1;

                    }

                    // if(empty($p->price))

                    // {

                    //     $p->price = 1;

                    // }

                    $b = array(

                        'orderID' => $id,

                        'productID' => $i->productID,

                        'variantID' => $i->id,

                        'qty' => $i->quantity,

                        'price' => $p->price,

                        'net_price' => $p->price * $i->quantity,

                        'status' => 'PLACED',

                        'added_on' => date('Y-m-d H:i:s'),

                        'updated_on' => date('Y-m-d H:i:s')

                    );

                    $itemID = $this->webservice_m->table_insert('order_items',$b);

                    $c = array(

                        'itemID'=>$itemID,

                        'orderID'=>$id,

                        'status'=>'PLACED',

                        'added_on' => date('Y-m-d H:i:s')

                    );

                    $this->webservice_m->table_insert('order_status',$c);



                    //Stock Update

                    $this->db->where(array('product_id'=>$p->product_id,'id'=>$p->id, 'city_id'=>$user_info->cityID));

                    $this->db->update('products_variant',array('stock_count'=>($p->stock_count - $i->quantity)));



                }

            }

            if($id)

            {

                $message = "Dear $user->name,\nYour order #$id will be delivered on $delivery_date between $delivery_slot. Amount to be paid Rs. $camount.\nYou will receive a delivery confirmation notification once the order is delivered.\nThanks,\ngowisekart.";

                $this->send_sms($user->mobile,$message);

                $notification_insert = array(

                    "title"=>'ORDER PLACED',

                    "image"=>'',

                    "text"=>$message,

                    "userID"=>$userID,

                    "status"=>'sent',

                    "added_on"=>date("Y-m-d H:i:s"),

                    "updated_on"=>date("Y-m-d H:i:s"),

                );

                $this->db->insert('notifications',$notification_insert);



                $user_login = $this->db->get_where('user_login',array('userID'=>$userID))->result();

                foreach ($user_login as $login)

                {

                    if (strtolower($login->device_type) == 'android'){

                        $this->send_notification('ORDER PLACED', $message , $login->device_token,'');

                    }

                }

                // $this->send_invoice_on_mail($user->userID,$id);



            }

            $response[] = array('result'=>'success','orderID'=>$id); 



        }



        $this->send_orderplace_sms($customer_name,$mobile,$id,$delivery_date,$delivery_slot);


        echo json_encode($response);



    }



    public function send_orderplace_sms($customer_name,$mobile,$orderID,$delivery_date,$delivery_slot){
      $curl = curl_init();

      curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.msg91.com/api/v5/flow/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_POSTFIELDS =>'{
              "flow_id": "61e3d2b693fac307282c9fc4",
              "sender": "GOWKRT",
              "mobiles": "91'.$mobile.'",
              "name": "'.$customer_name.'",
              "orderno":"'.$orderID.'",
              "date":"'.$delivery_date.'",
              "time":"'.$delivery_slot.'"

          }',
          CURLOPT_HTTPHEADER => array(
            'authkey: 371792AiSdLSzp61dd714fP1',
            'content-type: application/JSON',
            'Cookie: PHPSESSID=topka312cnvcm86pk4mr93avi0'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;
  }


  private function get_curl_handle($payment_id, $amount)  {



    $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';

    $key_id = 'rzp_live_kNpmPYYnMbMwQE';

    $key_secret = 'wmfTyzOTY3Rlfqm8bgrXUzVl';



        // $key_id = 'rzp_test_hknTNWccXk6Ax9';

        // $key_secret = 'n6YzcHO2caoOP5lehsnZhOUZ';



    $fields_string = "amount=$amount";

        //cURL Request

    $ch = curl_init();

        //set the url, number of POST vars, POST data

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);

    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');

    return $ch;



}

private function check_coupon_type($couponCode){
    if(!empty($couponCode)){
      $coupon =   $this->db->query("select * from offers where offer_code='$couponCode'")->row();
      if(!empty($coupon)){
        if($coupon->offer_type=='CASHBACK' || $coupon->offer_type=='CASHBACK_PERCENTAGE'){
            return 'CASHBACK';
        }
    }else{
        return '';
    }

}else{
    return '';
}

}



public function add_user_location()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $address_type = $data['address_type'];

    $location = $data['location'];

    $flat_no = $data['flat_no'];

    $building_name = $data['building_name'];

    $landmark = $data['landmark'];

    $contact_person_name = $data['contact_person_name'];

    $contact_person_mobile = $data['contact_person_mobile'];

    $note = $data['note'];

    $pincode = $data['pincode'];

    $latitude = $data['latitude'];

    $longitude = $data['longitude'];

    $check = $this->db->get_where('locality',array('pin'=>$pincode, 'status'=>'Y'))->row();

    if(!empty($check)){

        $array = array(

            'userID' => $userID,

            'location' => $location,

            'flat_no' => $flat_no,

            'building_name' => $building_name,

            'landmark' => $landmark,

            'address_type' => $address_type,

            'pincode' => $pincode,

            'latitude' => $latitude,

            'longitude' => $longitude,

            'contact_person_name' => $contact_person_name,

            'contact_person_mobile' => $contact_person_mobile,

            'note' => $note,

            'is_active' => 'Y',

            'is_default' => 'N',

            'added_on' => date('Y-m-d H:i:s')

        );



        $addressID = $this->webservice_m->table_insert('user_address',$array);



        $response[] = array('result'=>'success','addressID'=>$addressID,'message'=>'Successfully Added address');



    } else {

        $response[] = array('result'=>'failure','addressID'=>0,'message'=>'Currently !! We are not serving in that location.');

    }



    echo json_encode($response);

}



public function edit_user_location()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $addressID = $data['addressID'];

    $address_type = $data['address_type'];

    $location = $data['location'];

    $flat_no = $data['flat_no'];

    $building_name = $data['building_name'];

    $landmark = $data['landmark'];

    $pincode = $data['pincode'];

    $contact_person_name = $data['contact_person_name'];

    $contact_person_mobile = $data['contact_person_mobile'];

    $note = $data['note'];

    $latitude = $data['latitude'];

    $longitude = $data['longitude'];



    $array = array(

        'location' => $location,

        'flat_no' => $flat_no,

        'building_name' => $building_name,

        'landmark' => $landmark,

        'address_type' => $address_type,

        'pincode' => $pincode,

        'latitude' => $latitude,

        'longitude' => $longitude,

        'contact_person_name' => $contact_person_name,

        'contact_person_mobile' => $contact_person_mobile,

        'note' => $note



    );



    $address = $this->webservice_m->table_update('user_address',$array,array('addressID'=>$addressID));



    $response[] = array('result'=>'success','addressID'=>$addressID);

    echo json_encode($response);

}



public function delete_address()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $addressID = $data['addressID'];

    $this->db->where(array('addressID'=>$addressID));

    $this->db->delete('user_address');

    $response[] = array('result'=>'success','message'=>'Successfully Delete');

    echo json_encode($response);

}



public function list_location()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $address = $this->webservice_m->get_all_data_where('user_address',array('userID'=>$userID,'is_active'=>'Y'));

    $response[] = array('result'=>'success','address'=>$address);

    echo json_encode($response);



}



public function apply_coupon()

{

    $path = base_url().'uploads/';

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $offer_code = $data['offer_code'];

    $get_coupon = $this->webservice_m->get_single_table('offers',array('offer_code'=> $offer_code));

    if($get_coupon->allowed_user_times == 0)

    {

        $response[] = array('result'=>'success');

    } else {

        $check = $this->db->get_where('orders',array('userID'=>$userID,'coupon_code'=> $offer_code, 'status !='=>'CANCEL'))->result();

        if(sizeof($check) < $get_coupon->allowed_user_times)

        {

            $response[] = array('result'=>'success');

        } else {

            $response[] = array('result'=>'failure');

        }

    }



    echo json_encode($response);

}



    // public function oldslot()

    // {

    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $app_version = (!empty($data['app_version']))?$data['app_version']:0;

    //    // $booking_date = date('Y-m-d',strtotime($data['booking_date']));





    //     //$delivery_type = $data['delivery_type'];

    //     $date = date("Y-m-d",strtotime($data['booking_date']));

    //     $userID = $data['userID'];

    //     $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));            

    //     $time = date("H:i:s");



    //     $this->load->model("time_model");



    //     $time_slot = $this->time_model->get_time_slot($user->cityID);



    //     $cloasing_hours =  $this->time_model->get_closing_hours($date);



    //     $begin = new DateTime($time_slot->opening_time);



    //     $end   = new DateTime($time_slot->closing_time);



    //     $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');



    //     $times    = new DatePeriod($begin, $interval, $end);

    //     $time_array = array();

    //     $slot = array();



    //     foreach ($times as $time) {

    //         if(!empty($cloasing_hours)){

    //             foreach($cloasing_hours as $c_hr){

    //                 if($date == date("Y-m-d")){

    //                     if(strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){



    //                     }else{

    //                         $t1 = $time->format('h:i A'). ' - '. 

    //                         $time->add($interval)->format('h:i A')

    //                          ;

    //                         $time_array[] =  $time->format('h:i A'). ' - '. 

    //                         $time->add($interval)->format('h:i A')

    //                          ;

    //                     }



    //                 }else{



    //                     if(strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){



    //                     }else{

    //                         $t1 =$time->format('h:i A'). ' - '. 

    //                         $time->add($interval)->format('h:i A')

    //                          ;

    //                         $time_array[] =  $time->format('h:i A'). ' - '. 

    //                         $time->add($interval)->format('h:i A')

    //                          ;

    //                     }

    //                 }   

    //                 $slot[] = array(

    //                     'period' => $t1,

    //                     'available' => '1' ,

    //                     "delivery_price" => '30'             

    //                 );             

    //             }

    //         }else{

    //             if(strtotime($date) == strtotime(date("Y-m-d"))){

    //                 if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){

    //                     $t1 =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

    //                     $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

    //                     $slot[] = array(

    //                         'period' => $t1,

    //                         'available' => '1',

    //                         "delivery_price" => '30'           

    //                     );  

    //                 } 

    //             }else{

    //                 $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

    //                $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');



    //                $slot[] = array(

    //                 'period' => $t1,

    //                 'available' => '1',

    //                 "delivery_price" => '30'              

    //             );  

    //             }





    //         }





    //     }







    //     // if($app_version > 0)

    //     // {

    //     //     $slot1[] = array(

    //     //         'period' => "06:00 AM - 11:00 AM",

    //     //         'available' => '1',

    //     //         "delivery_price" => '30'

    //     //     );

    //     //     $slot1[] = array(

    //     //         'period' => "02:00 PM  - 05:00 PM",

    //     //         'available' => '1',

    //     //         "delivery_price" => '30'

    //     //     );

    //     //     $response[] = array('result'=>'success', 'slot'=>$slot1);

    //     // } else {

    //     //     $response[] = array('result'=>'success', 'slot'=>array());

    //     // }

    //     // var_dump($slot);

    //     $response[] = array('result'=>'success', 'slot'=>$slot);



    //     echo json_encode($response);

    // }

public function slot(){

    $data = json_decode(file_get_contents('php://input'), true);

    $app_version = (!empty($data['app_version']))?$data['app_version']:$data['cityID'];

       // $booking_date = date('Y-m-d',strtotime($data['booking_date']));



    $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));

        //$delivery_type = $data['delivery_type'];

    $date = date("Y-m-d",strtotime($data['booking_date']));

    $cityID = $data['cityID'];
        //$cityID = $app_version;

        // $userID = $data['userID'];

        // $user = $this->webservice_m->get_single_table("users",array("ID"=>$userID));            

    $time = date("H:i:s");



    $this->load->model("time_model");


    $time_slot = $this->time_model->get_time_slot($cityID);



    $cloasing_hours =  $this->time_model->get_closing_hours($date);
        //var_dump($time_slot); 


    $begin = new DateTime($time_slot->opening_time);



    $end   = new DateTime($time_slot->closing_time);



    $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');



    $times    = new DatePeriod($begin, $interval, $end);

    $time_array = array();

    $slot = array();

    $count_times = iterator_count($times);

    foreach ($times as $key=> $time) {

        $t1 ='';
        $is_close = 0;
        if(!empty($cloasing_hours)){

            foreach($cloasing_hours as $c_hr){

                if($date == date("Y-m-d")){

                    if(strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){

                        $is_close = 1;


                    }else{

                        $t1 = $time->format('h:i A'). ' - '. 

                        $time->add($interval)->format('h:i A')

                        ;

                        $time_array[] =  $time->format('h:i A'). ' - '. 

                        $time->add($interval)->format('h:i A')

                        ;
                        $is_close = 0;


                    }

                    

                }else{



                    if(strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){



                    }else{

                        $t1 =$time->format('h:i A'). ' - '. 

                        $time->add($interval)->format('h:i A')

                        ;

                        $time_array[] =  $time->format('h:i A'). ' - '. 

                        $time->add($interval)->format('h:i A')

                        ;

                    }

                }   

                $slot[] = array(

                    'period' => $t1,

                    'available' =>$this->check_slot_availabilty($t1,$cityID,$date,$time_slot->max_order),

                    "delivery_price" => '30',

                    "is_close" => $is_close,            

                );             

            }

        }else{

            if(strtotime($date) == strtotime(date("Y-m-d"))){

                if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){

                    if(date('h:i A',strtotime($time_slot->closing_time)) < $time->format('h:i A')){

                        $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                    }else{

                        if($count_times-1 != $key){

                            $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                        }else{

                            $t1 = $time->format('h:i A'). ' - '. date('h:i A',strtotime($time_slot->closing_time));

                        }

                    }



                    $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                    $slot[] = array(

                        'period' => $t1,

                        'available' =>$this->check_slot_availabilty($t1,$cityID,$date,$time_slot->max_order),

                        "delivery_price" => '30',
                        "is_close" => 0,         

                    );  

                } 

            }else{


               // echo "string";

                if(date('h:i A',strtotime($time_slot->closing_time)) < $time->format('h:i A')){

                    $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                }else{

                    if($count_times-1 != $key){

                        $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                    }else{

                        $t1 = $time->format('h:i A'). ' - '. date('h:i A',strtotime($time_slot->closing_time));

                    }

                }



                $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');



                $slot[] = array(

                    'period' => $t1,

                    'available' => $this->check_slot_availabilty($t1,$cityID,$date,$time_slot->max_order),

                    "delivery_price" => '30',
                    "is_close" => 0,               

                );  

            }





        }





    }







        // if($app_version > 0)

        // {

        //     $slot1[] = array(

        //         'period' => "06:00 AM - 11:00 AM",

        //         'available' => '1',

        //         "delivery_price" => '30'

        //     );

        //     $slot1[] = array(

        //         'period' => "02:00 PM  - 05:00 PM",

        //         'available' => '1',

        //         "delivery_price" => '30'

        //     );

        //     $response[] = array('result'=>'success', 'slot'=>$slot1);

        // } else {

        //     $response[] = array('result'=>'success', 'slot'=>array());

        // }

        // var_dump($slot);



    $response[] = array('result'=>'success', 'slot'=>$slot);



    echo json_encode($response);

}



private function check_slot_availabilty($s,$cityID,$d,$max_order)

{

    $sql = $this->db->query("SELECT COALESCE(COUNT(*),0) as order_count FROM `orders` WHERE `cityID`='$cityID' AND `delivery_slot`='$s' AND `delivery_date`='$d'")->row();

    if($d < '2021-05-06')
    {
        return 0;
    }
    return $max_order - $sql->order_count;

}



public function add_wallet()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $amount = $data['amount'];

    $txn_no = $data['transactionID'];

    $response = array();

    $success = false;

    $error = '';

    try {

        $ta = $amount * 100;

        $ch = $this->get_curl_handle($txn_no, $ta);

            //execute post

        $result = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result === false) {

            $success = false;

            $error = 'Curl error: '.curl_error($ch);

        } else {

            $txn_description = $result;

            $response_array = json_decode($result, true);

            if ($http_status === 200 and isset($response_array['error']) === false) {

                $success = true;

            } else {

                $success = false;

                if (!empty($response_array['error']['code'])) {

                    $error = $response_array['error']['code'].':'.$response_array['error']['description'];

                } else {

                    $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;

                }

            }

        }

            //close connection

        curl_close($ch);

    } catch (Exception $e) {

        $success = false;

        $response[] = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');

        $error = 'OPENCART_ERROR:Request to Razorpay Failed';

    }



    if($success == true)

    {

        $array = array(

            'userID' => $userID,

            'txn_no' => $txn_no,

            'amount' => $amount,

            'type' => 'CREDIT',

            'note' => '',

            'against_for' => 'wallet',

            'paid_by' => 'online',

            'orderID' => 0,

            'transaction_at' => date('Y-m-d H:i:s')

        );

        $id = $this->webservice_m->table_insert('transactions',$array);

        $user = $this->webservice_m->get_user(array('ID'=>$userID));

        $wallet = $amount + $user->wallet;



        $this->webservice_m->table_update('users',array('wallet'=>$wallet),array('ID'=>$userID));

        $response[] = array('result'=>'success','message'=>'successfully amount added to wallet','wallet'=>$wallet, 'error'=>$error);

    } else {

        $response[] = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ', 'error'=>$error);

    }

    echo json_encode($response); 

}



public function wallet_history()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $user = $this->webservice_m->get_user(array('ID'=>$userID));

    $history = $this->webservice_m->get_all_data_where('transactions',array('userID'=>$userID),'transactionID','DESC');

    $response[] = array('result'=>'success','message'=>'successfully amount added to wallet','wallet'=>$user->wallet,'history'=>$history);

    echo json_encode($response); 

}



    // public function my_orders()

    // {

    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $userID = $data['userID'];

    //     $ordered_products = array();

    //     $delivery_date = date('Y-m-d');

    //     $orders = $this->webservice_m->get_all_table_query("SELECT `orderID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");

    //     foreach($orders as $o)

    //     {

    //       $o->delivery_date = $delivery_date;

    //         $order_products = $this->get_ordered_products($o->orderID,$o->total_amount,$o->status,$o->delivery_date);



    //         foreach ($order_products as $product){

    //             $ordered_products[] = $product;

    //         }

    //     }



    //     $response[] = array("result"=>"success","ordered_products"=>$ordered_products);

    //     echo json_encode($response);

    // }





 // public function my_orders()

 //    {

 //        $data = json_decode(file_get_contents('php://input'), true);

 //        $userID = $data['userID'];

 //        $ordered_products = array();

 //        $delivery_date = date('Y-m-d');

 //        $orders = $this->webservice_m->get_all_table_query("SELECT `orderID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");

 //        foreach($orders as $o)

 //        {

 //          $o->delivery_date = $delivery_date;

 //            $order_products = $this->get_ordered_products($o->orderID,$o->total_amount,$o->status,$o->delivery_date);



 //            foreach ($order_products as $product){

 //                $ordered_products[] = $product;

 //            }

 //        }



 //        $response[] = array("result"=>"success","ordered_products"=>$ordered_products);

 //        echo json_encode($response);

 //    }



    //new

public function my_orders()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $cityID = (!empty($data['cityID'])?$data['cityID']:0);

    $ordered_products = array();

    $delivery_date = date('Y-m-d');

    $userDetail = $this->db->query("select * from users where ID='$userID'")->row();

    if($cityID==0){

        $cityID = $userDetail->cityID;

    }

    $orders = $this->webservice_m->get_all_table_query("SELECT `orderID`,`cityID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");

    foreach($orders as $o)

    {

      $o->delivery_date = $delivery_date;

      $order_products = $this->get_ordered_products($o->orderID,$o->total_amount,$o->status,$o->delivery_date,$o->cityID);

     // $o->orderID = $o->orderID;

      foreach ($order_products as $product){

        $ordered_products[] = $product;

    }

}



$response[] = array("result"=>"success","ordered_products"=>$ordered_products);

echo json_encode($response);

}



    // public function get_ordered_products($orderID,$total_amount,$status,$delivery_date)

    // {

    //     $query = $this->webservice_m->get_all_table_query("SELECT `itemID`, `productID`, `variantID`, `qty`, `price`, `net_price`, `status` FROM `order_items` WHERE `orderID`='$orderID'");

    //  $delivery_date = $this->webservice_m->get_single_table_query("SELECT `delivery_date` FROM `orders` WHERE `orderID`='$orderID'");

    //     if(!empty($query))

    //     {

    //         foreach($query as $q)

    //         {

    //             $p_detail = $this->get_product_name($q->productID);

    //             $q->unit = $p_detail['unit'];

    //             $q->product_name = $p_detail['name'];

    //             $q->product_image = base_url('admin/uploads/variants/').$p_detail['image'];

    //             $q->total_order_amount = $total_amount;

    //             $q->orderID = $orderID;

    //             // $product_status = $this->get_order_status($q->itemID);

    //             // if (!empty($product_status)) {

    //             //     $q->status = $product_status->status;

    //             // }

    //             $q->delivery_date= $delivery_date->delivery_date;

    //           /*array_push($query, $delivery_date);*/

    //         }

    //     }

    //     return $query;

    // }



public function get_ordered_products($orderID,$total_amount,$status,$delivery_date,$cityID)

{

    $query = $this->webservice_m->get_all_table_query("SELECT `itemID`, `productID`,`variantID`, `qty`, `price`, `net_price`, `status` FROM `order_items` WHERE `orderID`='$orderID'");

    $delivery_date = $this->webservice_m->get_single_table_query("SELECT `delivery_date` FROM `orders` WHERE `orderID`='$orderID'");

    if(!empty($query))

    {

        foreach($query as $q)

        {

            $p_detail = $this->get_product_name($q->productID,$q->variantID,$cityID);



            $q->product_name = $p_detail['name'];

            $q->product_description = $p_detail['description'];

            $q->use = $p_detail['use'];

            $q->benefit = $p_detail['benefit'];

            $q->storage = $p_detail['storage'];

            $q->product_image = base_url('admin/uploads/variants/').$p_detail['image'];

            $q->category_id = $p_detail['category_id'];

            $q->brand_id = $p_detail['brand_id'];

            $q->in_stock = $p_detail['in_stock'];

            $q->cost_price = $p_detail['cost_price'];

            $q->stock_count = $p_detail['stock_count'];

            $q->retail_price = $p_detail['retail_price'];

            $q->unit_value = $p_detail['unit_value'];

            $q->unit = $p_detail['unit'];

            $q->weight = $p_detail['weight'];

            $q->featured = $p_detail['featured'];

            $q->vegtype = $p_detail['vegtype'];

            $q->special = $p_detail['special'];

            $q->trending = $p_detail['trending'];



            $q->total_order_amount = $total_amount;

            $q->orderID = $orderID;

                // $product_status = $this->get_order_status($q->itemID);

                // if (!empty($product_status)) {

                //     $q->status = $product_status->status;

                // }

            $q->delivery_date= $delivery_date->delivery_date;

            /*array_push($query, $delivery_date);*/

        }

    }

    return $query;

}







    // public function get_product_name($productID)

    // {

    //     $query = $this->webservice_m->get_single_table('products',array('productID'=>$productID));

    //     $name =  (!empty($query->product_name))?$query->product_name:'';

    //     $image = (!empty($query->product_image))?$query->product_image:'product.png';

    //     $unit = (!empty($query->unit))?$query->unit:'piece';

    //     return array('name'=>$name,'image'=>$image,'unit'=>$unit);

    // }



    // public function get_product_name($productID)

    // {

    //     $query = $this->webservice_m->get_single_table('products',array('productID'=>$productID));

    //     $name =  (!empty($query->product_name))?$query->product_name:'';

    //     $image = (!empty($query->product_image))?$query->product_image:'product.png';

    //     $unit = (!empty($query->unit))?$query->unit:'piece';

    //     return array('name'=>$name,'image'=>$image,'unit'=>$unit);

    // }



    //new

public function get_product_name($productID,$variantID='',$cityID)

{

    $query = $this->webservice_m->get_single_table_query("select `products`.*,`products_variant`.`in_stock`,`products_variant`.`cost_price`,`products_variant`.`stock_count`,`products_variant`.`stock_count`,`products_variant`.`retail_price`,`products_variant`.`unit_value`,`products_variant`.`variant_image`,`products_variant`.`unit` from products inner join products_variant on `products`.`productID` =  `products_variant`.`product_id` where `products_variant`.`id`='$variantID' and `products_variant`.`city_id`='$cityID' order by priority ASC");

    $name =  (!empty($query->product_name))?$query->product_name:'';

    $description =  (!empty($query->product_description))?$query->product_description:'';

    $use =  (!empty($query->use))?$query->use:'';

    $benefit =  (!empty($query->benefit))?$query->benefit:'';

    $storage =  (!empty($query->storage))?$query->storage:'';

    $image = (!empty($query->variant_image))?$query->variant_image:'product.png';

    $category_id =  (!empty($query->category_id))?$query->category_id:'';

    $brand_id =  (!empty($query->brand_id))?$query->brand_id:'';

    $in_stock=  (!empty($query->in_stock))?$query->in_stock:'';

    $cost_price=  (!empty($query->cost_price))?$query->cost_price:'';

    $stock_count=  (!empty($query->stock_count))?$query->stock_count:'';

    $retail_price=  (!empty($query->retail_price))?$query->retail_price:'';

    $unit_value=  (!empty($query->unit_value))?$query->unit_value:'';

    $unit = (!empty($query->unit))?$query->unit:'piece';

    $weight=  (!empty($query->weight))?$query->weight:'';

    $featured=  (!empty($query->featured))?$query->featured:'';

    $vegtype=  (!empty($query->vegtype))?$query->vegtype:'';

    $special=  (!empty($query->special))?$query->special:'';

    $trending=  (!empty($query->trending))?$query->trending:'';

    return array('name'=>$name,'image'=>$image,'unit'=>$unit,'description'=>$description,'use'=>$use,'benefit'=>$benefit,'storage'=>$storage,'category_id'=>$category_id,'brand_id'=>$brand_id,'in_stock'=>$in_stock,'cost_price'=>$cost_price,'stock_count'=>$stock_count,'retail_price'=>$retail_price,'unit_value'=>$unit_value,'weight'=>$weight,'featured'=>$featured,'vegtype'=>$vegtype,'special'=>$special,'trending'=>$trending);

}





public function get_order_status($itemID)

{

    $status = $this->db->query("SELECT * FROM order_status WHERE itemID = '$itemID' ORDER BY statusID DESC LIMIT 1")->row();

    return $status;

}



public function change_user_image()

{

    if ($_POST)

    {

        $userID = $this->input->post('userID');

        $path = base_url('uploads/');

        if (!empty($_FILES['image']['name'])){

            $target_path = "uploads/";

            $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);

            $actual_image_name = 'user_image'.time().".".$extension;

            move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

            $this->db->where(array('ID'=>$userID));

            $this->db->update('users',array('image'=>$actual_image_name,'updated_on'=>date("Y-m-d H:i:s")));

            $result[] = array("result"=>"success","message"=>"Successfully Updated","image"=>$path.$actual_image_name);

        }else{

            $result[] = array("result"=>"failure","message"=>"Please Upload a Valid Image","image"=>'');

        }

    }else{

        $result[] = array("result"=>"failure","message"=>"Action Not Allowed","image"=>'');

    }

    echo json_encode($result);



}



public function my_profile()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $path = base_url('uploads/');

    $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

    if (!empty($user_info)){

        $user_info->image = $path.$user_info->image;

        $result[] = array("result"=>"success","message"=>"Successfully Retrieved","profile"=>$user_info,'refer_text'=>'Hey user, Please use my referral code to register to gowisekart and get cashback on first order. Use My Code is '.$user_info->referral_code.'. and to Download latest gowisekart App from play store using https://bit.ly/3EtEsEe.');

    }else{

        $result[] = array("result"=>"failure","message"=>"User Not Found","profile"=>null,'refer_text'=>'');

    }

    echo json_encode($result);

}



public function update_user_profile()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $name = $data['name'];

    $email = $data['email'];

    $path = base_url('uploads/');

    $update_array = array(

        "name"=>$name,

        "email"=>$email,

        "updated_on"=>date("Y-m-d H:i:s")

    );

    $this->db->where(array('ID'=>$userID));

    $this->db->update('users',$update_array);

    $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

    if (!empty($user_info)){

        $user_info->image = $path.$user_info->image;

        $result[] = array("result"=>"success","message"=>"Successfully Updated","profile"=>$user_info);

    }else{

        $result[] = array("result"=>"failure","message"=>"User Not Found","profile"=>null);

    }

    echo json_encode($result);

}



public function update_mobile()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $mobile = $data['mobile'];

    $check = $this->db->get_where('users',array('mobile'=>$mobile))->row();

    if (empty($check)){

        $update_array = array(

            "mobile"=>$mobile,

            "updated_on"=>date("Y-m-d H:i:s")

        );

        $this->db->where(array('ID'=>$userID));

        $this->db->update('users',$update_array);

        $result[] = array("result"=>"success","message"=>"Successfully Updated");

    }elseif($check->ID == $userID){

        $result[] = array("result"=>"success","message"=>"Same Number");

    }else{

        $result[] = array("result"=>"failure","message"=>"This Mobile Number is Already Registered with Use.");

    }

    echo json_encode($result);

}



public function cms_pages()

{

    $data = json_decode(file_get_contents('php://input'), true);

        $type = $data['type']; //type = 'about_us','privacy_policy','terms_condition','faq'

        $type_array = array('about_us','privacy_policy','terms_condition','faq');

        $page = "";

        if (in_array($type,$type_array)){

            $this->db->select($type);

            $content = $this->db->get_where('settings',array('ID'=>1))->row();

            $page = $content->$type;

        }

        $result[] = array("result"=>"success","message"=>"","data"=>$page);

        echo json_encode($result);

    }

    public function about_us()

    {

        $this->db->select('about_us');

        $data = $this->db->get_where('settings',array('ID'=>1))->row();

        $result[] = array("result"=>"success","message"=>"","data"=>$data->about_us);

        echo json_encode($result);

    }



    public function privacy_policy()

    {

        $this->db->select('privacy_policy');

        $data = $this->db->get_where('settings',array('ID'=>1))->row();

        $result[] = array("result"=>"success","message"=>"","data"=>$data->privacy_policy);

        echo json_encode($result);

    }



    public function terms_condition()

    {

        $this->db->select('terms_condition');

        $data = $this->db->get_where('settings',array('ID'=>1))->row();

        $result[] = array("result"=>"success","message"=>"","data"=>$data->terms_condition);

        echo json_encode($result);

    }



    public function contact_us()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $array = array(

            'name'=>$data['name'],

            'email'=>$data['email'],

            'mobile'=>$data['mobile'],

            'message'=>$data['message'],

            'status'=>'NEW',

            'added_on'=>date("Y-m-d H:i:s"),

            'updated_on'=>date("Y-m-d H:i:s")

        );

        $this->db->insert('enquiry',$array);

        $result[] = array("result"=>"success","message"=>"Successfully Submitted.");

        echo json_encode($result);

    }



    public function cancel_order_item()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];


        $itemID = $data['itemID'];
        $orderID = isset($data['orderID']) ? $data['orderID'] :'';

        //get user info
        $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();


        $this->db->select('order_items.*,orders.userID');

        $this->db->join('orders','order_items.orderID = orders.orderID','LEFT');

        $check = $this->db->get_where('order_items',array('order_items.itemID'=>$itemID,'orders.userID'=>$userID))->row();
//echo $this->db->last_query();
        if (!empty($check))

        {

            if ($check->status == 'PLACED' || $check->status == 'CONFIRM')

            {

                $return_amount = $check->net_price;

                $new_coupon_discount = 0;

                $this->db->where(array('itemID'=>$check->itemID));

                $this->db->update('order_items',array('status'=>'CANCEL'));

                $this->db->insert('order_status',array(

                    'itemID'=>$check->itemID,

                    'orderID'=>$check->orderID,

                    'agentID'=>0,

                    'status'=>'CANCEL',

                    'added_on'=>date("Y-m-d H:i:s")

                ));

                $orderID = $check->orderID;

                $order_info = $this->db->get_where('orders',array('orderID'=>$orderID))->row();

                $coupon_code = $order_info->coupon_code;

                if (!empty($order_info->coupon_code) && $order_info->coupon_discount >= 0 )

                {

                    $coupon_discount = $order_info->coupon_discount;

                    $new_coupon_discount = $coupon_discount;

                    $coupon_info = $this->db->get_where('offers',array('offer_code'=>$coupon_code))->row();

                    if (!empty($coupon_info))

                    {

                        $min_cart_value = $coupon_info->min_cart_value;

                        $order_amount = $order_info->order_amount;

                        if (($order_amount - $return_amount) >= $min_cart_value )

                        {

                            if ($coupon_info->offer_type == 'PERCENTAGE')

                            {

                                $offer_value = $coupon_info->offer_value;



                                if ((($order_amount - $return_amount) * ($offer_value/100)) < $coupon_info->max_discount )

                                {

                                    $new_coupon_discount = ($order_amount - $return_amount) * ($offer_value/100);

                                    $return_amount -= ($coupon_discount - $new_coupon_discount);

                                }

                            }

                        }else{

                            $coupon_code = '';

                            $new_coupon_discount = 0;

                            $return_amount -= $coupon_discount;

                        }

                    }

                }







                $this->db->where(array('orderID'=>$orderID));

                $this->db->update('orders',array('coupon_code'=>$coupon_code,'coupon_discount'=>$new_coupon_discount,'order_amount'=>($order_info->order_amount - $check->net_price),'total_amount'=>($order_info->total_amount - $return_amount)));



                //check item count & update main status

                $order_placed_amt = $this->db->query("SELECT COALESCE(SUM(`net_price`),0) as tamt FROM `order_items` WHERE `orderID`='$orderID' AND `status`='PLACED'")->row();

                if((int)$order_placed_amt->tamt == 0)

                {

                    $this->db->where(array('orderID'=>$orderID));

                    $this->db->update('orders',array('order_amount'=>'0','delivery_charges'=>'0','total_amount'=>'0','status'=>'CANCEL'));



                } 

                // elseif((int)$order_placed_amt->tamt < 501 && (int)$order_info->delivery_charges ){



                // } elseif((int)$order_placed_amt->tamt < 1001){



                // }

                $item = $this->db->get_where('order_items',array('itemID'=>$itemID))->row();

                $products = $this->db->get_where('products',array('productID'=>$item->productID))->row();

                $this->db->where(array('productID'=>$item->productID));

                $this->db->update('products',array('stock_count'=>($products->stock_count + $check->qty)));



                $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

                if($order_info->payment_method == 'cod')

                {



                    $message = "Dear $user_info->name, Your item # $products->product_name with order # $orderID has been cancelled . Thank you, GoWiseKart";
                    //$message2 = " item # $products->product_name with order # $orderID has been cancelled . Thank you, GoWiseKart";

                    
                    $this->send_sms($user_info->mobile,$message);
                   // $this->send_sms('9719466785',$message2);



                }

                if ($order_info->payment_method == 'online')

                {

                    $this->db->insert('transactions',array(

                        'userID'=>$userID,

                        'txn_no'=>'return'.$orderID,

                        'amount'=>$return_amount,

                        'type'=>'CREDIT',

                        'note'=>'',

                        'against_for'=>'return',

                        'paid_by'=>'wallet',

                        'orderID'=>$orderID,

                        'transaction_at'=>date("Y-m-d H:i:s")

                    ));

                    $item = $this->db->get_where('order_items',array('itemID'=>$itemID))->row();

                    $products = $this->db->get_where('products',array('productID'=>$item->productID))->row();

                    $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();

                    $user_wallet = $user_info->wallet;

                    $user_wallet += $return_amount;

                    $this->db->where(array('ID'=>$userID));

                    $this->db->update('users',array('wallet'=>$user_wallet));



                }

                if($order_info->payment_method == 'online')

                {



                    $message = "Dear $user_info->name, Your item #$products->product_name with orderID # $orderID has been cancelled and Rs $return_amount has been added to your Gowisekart wallet. The new credit balance in your account is Rs $user_wallet.";



                    $this->send_sms($user_info->mobile,$message);



                }



                $response[] = array('result'=>'success','msg'=>'Successfully Cancelled');

            }else{

                $response[] = array('result'=>'failure','msg'=>'You Cannot cancel this Order Item.');

            }

        }else{

            $response[] = array('result'=>'failure','msg'=>'You Cannot cancel this Order Item.');

        }

        echo json_encode($response);

    }



    public function test_web()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        echo json_encode($data);

        /*echo "json";

        var_dump(json_encode($data));

        echo "post";

        var_dump($_POST);

        echo "get";

        var_dump($_GET);*/



    }



    public function send_invoice_on_mail($userID,$orderID){

        error_reporting(-1);

        

        $data1 = array();

        $items = '';

        $ordered_products = array();

        $orders = $this->webservice_m->get_single_table_query("SELECT *, DATE_FORMAT(added_on,'%d %M %Y') as added_on, DATE_FORMAT(delivery_date,'%d %M %Y') as delivery_date  FROM `orders` WHERE ORDERID= '$orderID' ORDER BY ORDERID DESC");

        $ordered_products = $this->webservice_m->get_all_table_query("SELECT `order_items`.`itemID`, `order_items`.`qty`, `order_items`.`price`, `order_items`.`net_price`, `order_items`.`status`,`product_name` FROM `order_items` LEFT JOIN products ON order_items.productID = products.productID WHERE `orderID`='$orders->orderID'");

        

        $get_user = $this->webservice_m->get_single_table_query("SELECT  `name`, `mobile`, `email`, `image`, `wallet`, `status`, `auth_type`, `referral_code`, `referral_userID`, `added_on`, `updated_on` FROM `users` WHERE `ID`='$orders->userID'");



        $htmlContent = 'Invoice For OrderNum #'.$orderID;

        $data1['orders'] = $orders;

        $data1['items'] = $ordered_products;

        $data1['user'] = $get_user;





        //check invoice

        

        if($orders->invoice == '')

        {

            $attach = $this->generate_invoice_pdf($orders->orderID, $orders->userID); 



        } else {

           $attach = FCPATH."/pdfs/".$orderID.'-invoice.pdf'; 

       }





       $htmlContent .= $this->load->view('webservices/invoice', $data1,  TRUE);

       $bcclist = array('gowisekart@gmail.com');

       $email = $get_user->email;

        //$email = 'lureapps@gmail.com';

       $subject =  "Invoice for OrderNum #".$orderID;

       $this->send_email($email,$subject,  $htmlContent, $bcclist, $attach); 

       $file_array = explode('pdfs/', $attach); 

       $response[] = array("result"=>"success", "message"=>"Invoice Sent To Registered Email", "invoice"=>base_url('pdfs/').$file_array[1]);

       echo json_encode($response);



   }





   public function test_pdf()

   {

        //echo "Hello1";

    $orderID = $this->uri->segment(3);

    $userID = $this->uri->segment(4);

        //echo $orderID.'-'.$userID;

    $url = base_url('pdfs/').$orderID.'-invoice.pdf';

    if(!file_exists($url))

    {

        $a = $this->generate_invoice_pdf($orderID, $userID);

    }



    redirect($url);





        //$this->send_invoice_on_mail(3,3);

}



public function generate_invoice_pdf($orderID, $userID){ 



    $data1 = array();

    $items = '';

    $ordered_products = array();

    $orders = $this->webservice_m->get_single_table_query("SELECT *, DATE_FORMAT(added_on,'%d %M %Y') as added_on, DATE_FORMAT(delivery_date,'%d %M %Y') as delivery_date  FROM `orders` WHERE ORDERID= '$orderID' ORDER BY ORDERID DESC");

    $ordered_products = $this->webservice_m->get_all_table_query("SELECT `order_items`.`itemID`, `order_items`.`qty`, `order_items`.`price`, `order_items`.`net_price`, `order_items`.`status`,`product_name` FROM `order_items` LEFT JOIN products ON order_items.productID = products.productID WHERE `orderID`='$orders->orderID'");



    $get_user = $this->webservice_m->get_single_table_query("SELECT  `name`, `mobile`, `email`, `image`, `wallet`, `status`, `auth_type`, `referral_code`, `referral_userID`, `added_on`, `updated_on` FROM `users` WHERE `ID`='$orders->userID'");



    $htmlContent = 'Invoice For OrderNum #'.$orderID;

    $data1['orders'] = $orders;

    $data1['items'] = $ordered_products;

    $data1['user'] = $get_user;



    $this->load->library('Pdf');

    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);

    $pdf->SetAuthor('gowisekart');

    $pdf->SetTitle('gowisekart');

    $pdf->SetSubject('gowisekart');

    $pdf->SetKeywords('Email');



        // set default monospaced font

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



        // set margins

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



        // set auto page breaks

    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



        // set image scale factor

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



        // set some language-dependent strings (optional)

    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

        require_once(dirname(__FILE__).'/lang/eng.php');

            //$pdf->setLanguageArray($l);

    }





    $pdf->SetFont('dejavusans', '', 10);



        // add a page

    $pdf->AddPage();



       // output the HTML content

    $htmlcode = $this->load->view('webservices/invoice',$data1, TRUE);       



    $pdf->writeHTML($htmlcode, true, false, true, false, '');





    $newFile  = FCPATH."/pdfs/".$orderID.'-invoice.pdf';

    ob_clean();

        //Close and output PDF document

        //$file = $pdf->Output($newFile, 'F');

    $f = $orderID.'-invoice.pdf';



    $pdf->Output($newFile, 'F');

    return $newFile;

}

public function send_email($email,$subject,  $content, $bcclist, $attach = ''){



    $config = array(

        'protocol'  => 'mail',

        'smtp_host' => 'smtp.gmail.com',

        'smtp_port' => 587,

        'smtp_user' => 'gowisekart@gmail.com',

        'smtp_pass' => 'gowisekart@123',

        'mailtype'  => 'html',

        'charset'   => 'utf-8'

    );

    $this->email->initialize($config);

    $this->email->set_mailtype("html");

    $this->email->set_newline("\r\n");

    $this->email->to($email);

    $this->email->bcc($bcclist);

    $this->email->from('gowisekart@gmail.com','gowisekart Team');

    $this->email->subject($subject);

    $this->email->message($content);

    if($attach != ''){

        $this->email->attach($attach);            

    }

    $this->email->send();

}







    //Delivery Agent

public function hash($string) {

    return hash("sha512", $string . config_item("encryption_key"));

}

public function agent_login()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $email = $data['email'];

    $password = $this->hash($data['password']);

    $deviceID = $data['deviceID'];

    $device_token = $data['device_token'];

    $device_type = $data['device_type'];

    $check = $this->db->get_where('delivery_agent',array('email'=>$email,'password'=>$password,'is_active'=>'Y'))->row();

    if(!empty($check))

    {

        $result[] = array('result'=>'success','agent'=>$check);

    }else{

        $result[] = array('result'=>'failure','agent'=>NULL);

    }

    echo json_encode($result);

}



public function get_pending_order_list()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $agentID = $data['agentID'];

    $status = array(

        'PLACED',

        'CONFIRM',

        'OUT_FOR_DELIVERY'

    );

    $this->db->where_in($status);

        //$orders = $this->db->get_where('orders',array('agentID'=>$agentID))->result();

    $orders = $this->db->query("SELECT * FROM `orders` WHERE `agentID`='$agentID' AND (`status`='PLACED' OR `status`='CONFIRM' OR `status`='OUT_FOR_DELIVERY')")->result();

    $result[] = array('result'=>'success','orders'=>$orders, "query"=>$this->db->last_query());

    echo json_encode($result);

}



public function get_completed_order_list()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $agentID = $data['agentID'];

    $status = array(

        'DELIVERED'

    );

    $this->db->where_in($status);

    $orders = $this->db->get_where('orders',array('agentID'=>$agentID))->result();

    $result[] = array('result'=>'success','orders'=>$orders);

    echo json_encode($result);

}



public function get_order_details()

{

    $data = json_decode(file_get_contents('php://input'), true);

    $image_path = base_url('admin/uploads/variants/');

    $agentID = $data['agentID'];

    $orderID = $data['orderID'];

    $order = $this->db->get_where('orders',array('agentID'=>$agentID,'orderID'=>$orderID))->row();

    $this->db->select("order_items.*,products.product_name,products.product_image");

    $this->db->join('products','order_items.productID = products.productID','LEFT');

    $items = $this->db->get_where('order_items',array('order_items.orderID'=>$orderID))->result();

    foreach ($items as $i)

    {
        $variant = $this->db->query("select * from products_variant where id='$i->variantID'")->row();
        if(!empty($variant)){
          $i->unit_value = $variant->unit_value;
          $i->unit = $variant->unit;
      }else{
        $i->unit_value ='';
        $i->unit = '';
    }


    $i->product_image = $image_path.$i->product_image;

}

$result[] = array('result'=>'success','orders'=>$order,'items'=>$items);

echo json_encode($result);

}



public function deliver_order()

{

    $data = json_decode(file_get_contents('php://input'), true);
    

    $agentID = $data['agentID'];

    $orderID = $data['orderID'];

    $items = $this->db->get_where('order_items',array('orderID'=>$orderID))->result();

    foreach ($items as $item)

    {

        if ($item->status != 'DELIVERED' || $item->status != 'CANCEL')

        {

            $status_insert = array(

                'itemID'=>$item->itemID,

                'orderID'=>$orderID,

                'agentID'=>$agentID,

                'is_visible'=>'Y',

                'status'=>'DELIVERED',

                'added_on'=>date("Y-m-d H:i:s")

            );

            $this->db->insert('order_status',$status_insert);

            $this->db->where(array('itemID'=>$item->itemID));

            $this->db->update('order_items',array('status'=>'DELIVERED','updated_on'=>date("Y-m-d H:i:s")));

        }

        $this->db->where(array('orderID'=>$orderID));

        $this->db->update('orders',array('status'=>'DELIVERED','updated_on'=>date("Y-m-d H:i:s")));

    }



    $order = $this->db->get_where('orders',array('orderID'=>$orderID))->row();

    $user = $this->db->get_where('users',array('ID'=>$order->userID))->row();

    $redeemable_pt = floor(($order->total_amount * 2) / 100);

    $other_pt = floor(($order->total_amount * 3) / 100);

    $reward_pt_txn_insert = array(

        'user_id'=>$order->userID,

        'redeemable_pt'=>$redeemable_pt,

        'other_pt'=>$other_pt,

        'orderID'=>$order->orderID,

        'reason'=>'Order with orderID #'.$order->orderID.' delivered',

        'type'=>'credit',

        'created_at'=>date('Y-m-d H:i:s'),

        'updated_at'=>date('Y-m-d H:i:s')

    );

        // $this->db->insert('reward_pt_txn',$reward_pt_txn_insert);

        // $new_total_redeem_pt = $user->total_redeem_pt + $redeemable_pt;

        // $new_redeemable_pt = $user->redeemable_pt + $redeemable_pt;

        // $new_total_other_pt  = $user->total_other_pt + $other_pt;

        // $new_other_pt = $user->other_pt + $other_pt;

        // $user_pt_update_array = array(

        //     'total_redeem_pt'=>$new_total_redeem_pt,

        //     'redeemable_pt'=>$new_redeemable_pt,

        //     'total_other_pt'=>$new_total_other_pt,

        //     'other_pt'=>$new_other_pt

        // );

        // $this->db->where(array('ID'=>$order->userID));

        // $this->db->update('users',$user_pt_update_array);



    if($order->status == 'DELIVERED'){

            //update cashback
        if(!empty($order)){
          if($order->type=='CASHBACK'){
            $this->db->where(array('ID'=>$user->ID));
            $this->db->update('users',array('cashback_wallet'=>$user->cashback_wallet+$order->coupon_discount,'updated_on'=>date('Y-m-d H:i:s'))); 
        }  
    } 

             //referal amount update

    $totalOrder = $this->db->query("select * from orders where userID='$user->ID'")->result();

    if(!empty($totalOrder)){

        if(count($totalOrder) == 1){

            if(!empty($user->referral_userID)){

             $settings = $this->db->get_where('settings',array('id'=>1))->row();
             $refer_amount = isset($settings->refer_earn) ? $settings->refer_earn :0;
					 //amount update referal user

                        //amount update referal user

             $referalUser =  $this->db->query("select * from users where ID='$user->referral_userID'")->row();

             $this->db->where(array('ID'=>$referalUser->ID));

             $this->db->update('users',array('wallet'=>$referalUser->wallet+$refer_amount));



             $txn_array = array(

                'userID'=>$referalUser->ID,

                'txn_no' => 'RFR'.time().rand(99,999),

                //'amount' => 10,
                'amount' =>$refer_amount,
                

                'type'=>'CREDIT',

                'note'=>'',

                'against_for' => 'order',

                'paid_by'=>$order->payment_method,

                'orderID'=>$orderID,

                'transaction_at' => date("Y-m-d H:i:s")

            );

             $this->db->insert('transactions', $txn_array);
             $today = date('Y-m-d H:i:s');
             $txn_array1 = array(
                'user_id'=>$referalUser->ID,
                'previous_wallet' => $referalUser->wallet,
                'added_amount' => $refer_amount,
                'created_at' => date("Y-m-d H:i:s"),
                'expired_on' => date('Y-m-d H:i:s', strtotime($today. ' + 2 days')) ,

            );

             $this->db->insert('refer_earn_new', $txn_array1);

             $this->db->where(array('ID'=>$referalUser->ID));
             $this->db->update('users',array('wallet'=>$referalUser->wallet+$refer_amount));
             $message = 'Gowisekart is delivering handpicked farm fresh fruits, vegetables, grocery & household items.Instant Cash Amount Rs'.$refer_amount.' will be added in your Gowisekart Wallet due to Successful Referal and that will expire in 2 days.';

             $notification_insert = array(

                "title"=>'Refer & Earn',

                "image"=>'',

                "text"=>$message,

                "userID"=>$referalUser->ID,

                "status"=>'sent',

                "added_on"=>date("Y-m-d H:i:s"),

                "updated_on"=>date("Y-m-d H:i:s"),

            );

             $this->db->insert('notifications',$notification_insert);



             $user_login = $this->db->get_where('user_login',array('userID'=>$referalUser->ID))->result();

             foreach ($user_login as $login)

             {

                if (strtolower($login->device_type) == 'android'){

                    $this->send_notification('Refer & Earn', $message , $login->device_token,'');

                }

            }



        }

    }

}



$message = "Dear Customer,\nYour Order With orderID # $orderID has been delivered.\n\nThank you,\nGowisekart";

$this->send_sms($user->mobile,$message);

$message = "Dear Customer,Your Order With orderID # $orderID has been delivered.Thank you,GoWiseKart";

$notification_insert = array(

    "title"=>'ORDER DELIVERED',

    "image"=>'',

    "text"=>$message,

    "userID"=>$user->ID,

    "status"=>'sent',

    "added_on"=>date("Y-m-d H:i:s"),

    "updated_on"=>date("Y-m-d H:i:s"),

);

$this->db->insert('notifications',$notification_insert);



$user_login = $this->db->get_where('user_login',array('userID'=>$user->ID))->result();

foreach ($user_login as $login)

{

    if (strtolower($login->device_type) == 'android'){

        $this->send_notification('ORDER DELIVERED', $message , $login->device_token,'');

    }

}

}

$result[] = array('result'=>'success','message'=>'successfully updated');

echo json_encode($result);

}





    /*

    public function send_wrong_order_sms()

    {

        $orders = $this->db->query("SELECT orders.*,users.`name`,users.mobile FROM `orders` LEFT JOIN users ON orders.userID = users.ID WHERE orderID IN (11,12,13,14,15,16,17,18,19,20) ")->result();

        foreach ($orders as $o)

        {

            $message = "Dear $o->name, \n Due to some technical issue, the coupon code you have applied for order #$o->orderID will not be considered as valid coupon code, So this order has been updated with payable amount $o->total_amount . \n Sorry for inconvenience. \n Thank You \n Mr Green Man";

            //echo $message;



            echo $this->send_sms($o->mobile,$message);



        }



    }

    */

    /*

    public function delayed_order()

    {

        $orders = $this->db->query("SELECT users.`name`,users.mobile,orders.orderID FROM orders LEFT JOIN users ON orders.userID = users.ID WHERE delivery_date = '2020-03-25'")->result();

        foreach ($orders as $o)

        {

            $message = "Dear $o->name,\n Due to COVID-19, your order with orderID $o->orderID will be delivered by tomorrow evening.\n Thanks for patience. \n Thank You \n Mr Green Man";

            //echo $message;



            echo $this->send_sms($o->mobile,$message);



        }

    }*/



    public function capture_pending_payments()

    {

        $check_date = date("Y-m-d H:i:s",(time() - 240));

        $data = $this->db->query("SELECT * FROM `pnding_crone` WHERE `status`='pending' AND `created_at` < '$check_date'")->result();

        foreach($data as $d)

        {

            $function = $d->function;

            $date = date('Y-m-d H:i:s');

            $this->$function('true',$d->data);

            $this->db->query("UPDATE `pnding_crone` SET `status`='completed',`updated_at`= '$date' WHERE `id` = $d->id");

        }

        return;

    }



    public function test_notification()

    {

        $deviceToken = 'eMMJysP6jLs:APA91bHxYUMl0za1Dy4SRPv5N1TnGRc1pvFic22wQ_u1iqxcev721BGU9lKeXf6XkPnmLs0hEkggY9_qzIIG1bFkFsRQ5f_HT7YQInvsIJch6UKbUNVRERcjv2NGmZUom_BmzYgkboMp';

        $sendData = array(

            'body' => 'My Name is Satyendra',

            'title' => 'Mr Gowisekart',

            'sound' => 'Default',

            'image'=>'https://app.blue11.in/uploads/banners/banner1.jpg'

        );

        $a=$this->fcmNotification($deviceToken,$sendData);

        var_dump($a);

    }



    private function send_notification($title, $body, $deviceToken,$image){

        $deviceToken = $deviceToken;



        if(empty($image))

        {

            $image = 'https://gowisekart.com/admin/uploads/favicon1575713051.png';

        }

        $sendData = array(

            'body' => $body,

            'title' => $title,

            'sound' => 'Default',

            'image'=> $image,

        );

        $this->fcmNotification($deviceToken,$sendData);

    }



    private function fcmNotification($device_id, $sendData)

    {

        #API access key from Google API's Console

        if (!defined('API_ACCESS_KEY')){

            // define('API_ACCESS_KEY', 'AAAAz66t20U:APA91bHhgudWbmKK12QVORSXoFEdXDQclblg_SWD4skc419B_YNSqDSRbx-q8jm956o4sX7daTIChQS7hx3sg4wXT393of2MkoiD_v3K4Ii8OiQ5bg5xDJ_zRyxhqlBj03HIqUvhz5Hi');

            define('API_ACCESS_KEY', 'AAAA1HKDgQE:APA91bFGcpAMnemBJlCBYXP8Yo3aRz5f3iZaWsg4AHZR6uesM-I1MSIiVzyzbmiUZAWxbrkerqeOKvqY0daZZhLiHyWEJwXuSH8SqDdo_sUH33BXRzYeOfd9Z108OwOzKOcQmH5Ks4hL');

        }



        $fields = array

        (

            'to'    => $device_id,

            'data'  => $sendData,

            'notification'  => $sendData

        );





        $headers = array

        (

            'Authorization: key=' . API_ACCESS_KEY,

            'Content-Type: application/json'

        );

        #Send Reponse To FireBase Server

        $ch = curl_init();

        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

        curl_setopt( $ch,CURLOPT_POST, true );

        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );

        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

        $result = curl_exec($ch);

        //$data = json_decode($result);

        if($result === false)

            die('Curl failed ' . curl_error());



        curl_close($ch);

        return $result;

    }



    //Notification List

    public function list_notification()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];

        $this->db->order_by('notificationID', 'DESC');

        $this->db->limit(30);

        $notifications = $this->db->get_where('notifications',array("userID"=>$userID))->result();

        foreach ($notifications as $n)

        {

            $n->added_on = strtotime($n->added_on) ;

        }
         //update notification
        $this->db->where(array('userID'=> $userID));
        $this->db->update('notifications',array('status'=>'read','updated_on'=>date('Y-m-d H:i:s')));




        $result[] = array('result'=>'success','notifications'=>$notifications);

        echo json_encode($result);

    }

    public function city_list()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];

        $city = $this->db->get_where('city',array('status'=>'Y'))->result();

        $result[] = array('result'=>'success','city'=>$city);

        echo json_encode($result);

    }


    public function refer_banner()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];

        if(!empty($userID)){
         $user = $this->db->get_where('users',array('ID'=>$userID))->row();
         $this->db->select('refer_banner');
         $refers = $this->db->get_where('settings',array('ID'=>1))->row();
         if(!empty($refers)){
            if(!empty($refers->refer_banner)){
                $refers->refer_banner = base_url('/admin/uploads/'.$refers->refer_banner);
            }

        }
        $result[] = array('result'=>'success','refers'=>$refers);
    }else{
        $result[] = array('result'=>'failure','message'=>'userID Required','refers'=>[]);

    }

    echo json_encode($result);

}



public function refer_details(){


 $data = json_decode(file_get_contents('php://input'), true);

 $userID = $data['userID'];

 if(!empty($userID)){
     $user = $this->db->get_where('users',array('ID'=>$userID))->row();

     $this->db->select('refer_earn,refer_description,refer_image');
     $refers = $this->db->get_where('settings',array('ID'=>1))->row();
     if(!empty($refers)){
        if(!empty($refers->refer_image)){
            $refers->refer_image = base_url('/admin/uploads/'.$refers->refer_image);
        }
        $refers->referal_code = $user->referral_code;

        $refers->refer_message = '<p>Gowisekart is delivering handpicked farm fresh fruits, vegetables, grocery & household items.</p><p>Use My referal code '.$user->referral_code.'<br> Instant Cash Amount Rs'.$refers->refer_earn.' will be added in your Gowisekart Wallet on Signup that will expire in 2 days.</p><p>Order Now <p>https://bit.ly/3EtEsEe';
    }
    $result[] = array('result'=>'success','refers'=>$refers);
}else{
    $result[] = array('result'=>'failure','message'=>'userID Required','refers'=>[]);

}

echo json_encode($result);
}




public function update_products_citywise()

{

    $cities = $this->db->get_where('city',array('status'=>'Y'))->result();

    $products = $this->db->get_where('products',array())->result();



    foreach($products as $p)

    {

        foreach($cities as $c)

        {

            $a = array(

                'product_id' => $p->productID,

                'city_id' => $c->id,

                'cost_price' => $p->cost_price,

                'stock_count' => $p->stock_count,

                'price' => $p->price,

                'retail_price' => $p->retail_price,

                'vegtype' => $p->vegtype,

                'status' => 'Y',

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => date('Y-m-d H:i:s')

            );



            $this->db->insert('products_detail',$a);

        }

    }

}



    //new apis

    //get availability

public function get_availability()

{



    $data = json_decode(file_get_contents('php://input'), true);

    $userID = $data['userID'];

    $pinCode = $data['pinCode'];

    $data = $this->webservice_m->get_single_table_query("select city.id,city.title as cityName from city join locality on city.id = locality.locality WHERE locality.status='Y' and locality.pin = '$pinCode'");

    if(isset($data)){ 

        $response[] = array('result'=>'success','locality'=>$data);

    }

    else{

        $response[] = array('result'=>'failure','locality'=>null);

    }

    echo json_encode($response);

}





        //update variants

public function update_variants_citywise()

{

    $cities = $this->db->get_where('city',array('status'=>'Y'))->result();

    $products = $this->db->get_where('products',array('productID >='=>1038, 'in_stock'=>'Y'))->result();



    foreach($products as $p)

    {

        foreach($cities as $c)

        {

            $a = array(

                'product_id' => $p->productID,

                'city_id' => $c->id,

                'unit_value' => $p->unit_value,

                'unit' => $p->unit,

                'weight' => $p->weight,

                'cost_price' => $p->cost_price,

                'stock_count' => 10,

                'price' => $p->price,

                'retail_price' => $p->retail_price,

                'variant_image' => $p->product_image,

                'status' => 'Y',

                'is_default' => '1',

                'vegtype' => $p->vegtype,

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => date('Y-m-d H:i:s')

            );



            $this->db->insert('products_variant',$a);



                   // $a = array(

                   //      'product_id' => $p->productID,

                   //      'city_id' => $c->id,

                   //      'unit_value' => 2,

                   //      'unit' =>  $p->unit,

                   //      'cost_price' => 2*$p->cost_price,

                   //      'stock_count' => $p->stock_count,

                   //      'price' => 2*$p->price,

                   //      'retail_price' => 2*$p->retail_price,

                   //      'variant_image' => $p->product_image,

                   //      'is_active' => 'Y',

                   //       'is_default' => '0',

                   //      'created_at' => date('Y-m-d H:i:s'),

                   //      'updated_at' => date('Y-m-d H:i:s')

                   //  );



                   //  $this->db->insert('products_variant',$a);  

        }

    }

    echo "ok";

}



public function update_variant_price()

{

    $products = $this->db->get_where('products_detail',array('status'=>'Y'))->result();

    foreach($products as $p)

    {



        $this->db->where(array('product_id'=>$p->product_id, 'city_id'=>$p->city_id));

        $this->db->update('products_variant',array('cost_price'=>$p->cost_price, 'price'=>$p->price, 'retail_price'=>$p->retail_price, 'stock_count'=>$p->stock_count));

    }

    echo "ok";

}




    //    pravas chandra natak :-  user order list api
    //    30-07-2021

public function my_order_data()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $userID = isset($data['userID']) ? $data['userID'] : "";
    $status = isset($data['status']) ? $data['status'] : "";
    if ($userID != '') {
        $check_user_id = $this->db->get_where('users',array('id'=>$userID))->result();
        if (!empty($check_user_id)) {
            $list = array();
            if (isset($status) && !empty($status)) {
                $this->db->where(array('status'=>$status));
            }
            $this->db->order_by("orderID", "desc");

            $order_data =  $this->db->get_where('orders',array('userID'=>$userID))->result();
            foreach ($order_data as $key) {

                $order_item = $this->db->get_where('order_items',array('orderID'=>$key->orderID))->result();
                $item = array();
                foreach ($order_item as $key1) {
                    $product_data = $this->db->get_where('products',array('productID'=>$key1->productID))->row();
                    $data_item=array(
                        'itemID'                        =>$key1->itemID,
                        'productID'                     =>$key1->productID,
                        'variantID'                     =>$key1->variantID,
                        'qty'                           =>$key1->qty,
                        'price'                         =>$key1->price,
                        'net_price'                     =>$key1->net_price,
                        'status'                        =>$key1->status,
                        'added_on'                      =>$key1->added_on,
                        'product_name'                  =>$product_data->product_name,
                        'product_image'                 =>base_url('admin/uploads/variants/').$product_data->product_image,
                        'product_description'           =>$product_data->product_description,
                        'benefit'                       =>$product_data->benefit,
                    );
                    array_push($item, $data_item);
                }
                $data = array(
                    'orderID'         =>$key->orderID,
                    'cityID'          =>$key->cityID,
                    'userID'          =>$key->userID,
                    'vendorID'        =>$key->vendorID,
                    'customer_name'   =>$key->customer_name,
                    'contact_no'      =>$key->contact_no,
                    'house_no'        =>$key->house_no,
                    'apartment'       =>$key->apartment,
                    'landmark'         =>$key->landmark,
                    'location'         =>$key->location,
                    'latitude'         =>$key->latitude,
                    'longitude'        =>$key->longitude,
                    'address_type'     =>$key->address_type,
                    'agentID'          =>$key->agentID,
                    'coupon_code'      =>$key->coupon_code,
                    'type'             =>$key->type,
                    'coupon_discount'  =>$key->coupon_discount,
                    'delivery_charges' =>$key->delivery_charges,
                    'order_amount'     =>$key->order_amount,
                    'total_amount'     =>$key->total_amount,
                    'cashback_amount'  =>$key->cashback_amount,
                    'payment_method'   =>$key->payment_method,
                    'instruction'      =>$key->instruction,
                    'delivery_date'    =>$key->delivery_date,
                    'delivery_slot'    =>$key->delivery_slot,
                    'status'           =>$key->status,
                    'order_from'       =>$key->order_from,
                    'added_on'         =>$key->added_on,
                    'updated_on'       =>$key->updated_on,
                    'item'             =>$item,
                );
                array_push($list, $data);
            }
            if($list){ 
                $response[] = array('result'=>'success','message'=>'successfully','data'=>$list);
            }else{
                $response[] = array('result'=>'success','message'=>'No data','data'=>[]);
            }
        }else{
            $response[] = array('result'=>'failure','message'=>'userID Invalid','data'=>[]);
        }
    }else{
        $response[] = array('result'=>'failure','message'=>'userID Required','data'=>[]);
    }

    echo json_encode($response);
}

     //    pravas chandra nayak :-  user order CANCEL api
    //    30-07-2021

public function my_order_cancel()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $userID = isset($data['userID']) ? $data['userID'] : "";
    $orderID = isset($data['orderID']) ? $data['orderID'] : "";
    if ($userID != '') {
        if ($orderID != '') {
            $check_user_id = $this->db->get_where('users',array('id'=>$userID))->result();
            if (!empty($check_user_id)) {

                $this->db->where(array('orderID'=>$orderID,'userID'=>$userID));
                $update = $this->db->update('orders', array('status'=>'CANCEL'));

                $orders = $this->db->get_where('orders',array('orderID'=>$orderID))->row();
                $status = $orders->status;
                if($status != 'CANCEL'){ 

                    $response[] = array('result'=>'failure','message'=>'Your Request is not complete','data'=>[]);
                }else{

                    $this->db->where(array('orderID'=>$orderID));
                    $this->db->update('order_items', array('status'=>'CANCEL'));
                    $this->db->where(array('orderID'=>$orderID));
                    $this->db->update('order_status', array('status'=>'CANCEL'));

                    $response[] = array('result'=>'success','message'=>'Cancel successfully','data'=>[]);
                }
            }else{
                $response[] = array('result'=>'failure','message'=>'userID Invalid','data'=>[]);
            }
        }else{
            $response[] = array('result'=>'failure','message'=>'orderID Required','data'=>[]);
        }
    }else{
        $response[] = array('result'=>'failure','message'=>'userID Required','data'=>[]);
    }

    echo json_encode($response);
}




    // public function test(){
    //     $data = array(
    //         ['id'=>1,
    //         'name'=>'pk',
    //         'age'=>'45',],
    //         ['id'=>1,
    //         'name'=>'f',
    //         'age'=>'23',],
    //         ['id'=>2,
    //         'name'=>'pk',
    //         'age'=>'45',],
    //         ['id'=>3,
    //         'name'=>'pk',
    //         'age'=>'450',],
    //         ['id'=>3,
    //         'name'=>'pk1',
    //         'age'=>'0',]
    //     );
    //     print_r($data);
    //     foreach ($data as $key) {

    //     }
    // }


//    public function group_by() {

// $data = array(
//     array(
//         "id" => 1,
//         "name" => "Bruce Wayne",
//         "city" => "Gotham",
//         "gender" => "Male"
//     ),
//     array(
//         "id" => 2,
//         "name" => "Thomas Wayne",
//         "city" => "Gotham",
//         "gender" => "Male"
//     ),
//     array(
//         "id" => 3,
//         "name" => "Diana Prince",
//         "city" => "New Mexico",
//         "gender" => "Female"
//     ),
//     array(
//         "id" => 4,
//         "name" => "Speedy Gonzales",
//         "city" => "New Mexico",
//         "gender" => "Male"
//     )
// );
// $key = 'gender';
//     $result = array();

//     foreach($data as $val) {
//         print_r($key);
//         print_r($val);
//         exit();
//         if(array_key_exists($key, $val)){
//             $result[$val[$key]][] = $val;
//         }else{
//             $result[""][] = $val;
//         }
//     }

//     print_r($result) ;
// }

}