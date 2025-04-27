<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Users extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->_check_auth();
        $this->load->model("home_m");
    }

    private function _check_auth(){
        if($this->session->userdata('role') != 'admin'){
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }

    private function get_total_orders($userID)
    {
        $total = $this->db->query("SELECT COALESCE(count(orderID),0) as count FROM orders WHERE userID = '$userID'")->row();
        return $total->count;
    }
   private function get_total_referral($userID)
    {
        $total = $this->db->query("SELECT COALESCE(count(ID),0) as count FROM users WHERE referral_userID = '$userID'")->row();
        return $total->count;
    }
   public function get_referral_name()
    {
        $id = $this->input->post('id');
        $referral_list = $this->home_m->get_all_table_query("SELECT `name` FROM `users` WHERE `referral_userID` ='$id'");
        echo json_encode($referral_list);
    }

    public function index()
    {
         $users = $this->home_m->get_all_row_where ('users',array(),'*');
        foreach ($users as $u){
            $u->total_orders = $this->get_total_orders($u->ID);
            $u->total_referral = $this->get_total_referral($u->ID);
        }
        $this->data['users'] = $users;
        $this->data['sub_view'] = 'users/list';
        $this->data['title'] = 'App Users';
        $this->load->view("_layout",$this->data);
    }
    public function report(){
        $users = $this->home_m->get_all_row_where ('users',array(),'*');
        foreach ($users as $u){
            $u->total_orders = $this->get_total_orders($u->ID);
            $u->total_referral = $this->get_total_referral($u->ID);
        }
        $this->data['users'] = $users;
        $this->data['sub_view'] = 'users/report';
        $this->data['title'] = 'All Users';
        $this->load->view("_layout",$this->data);
    }
    public function add_wallet()
    {
        if ($_POST)
        {
            $userID = $_POST['ID'];
            $amount = $_POST['amount'];
            $txn_no = $_POST['txn_no'];
            if ($amount > 0 && $userID != 0 && $userID != '')
            {
                $user = $this->db->get_where("users",array('ID'=>$userID))->row();
                if (!empty($user))
                {
                    $txn_insert = array(
                        "userID"=>$userID,
                        "txn_no"=>$txn_no,
                        "amount"=>$amount,
                        "type"=>'CREDIT',
                        "note"=>'wallet',
                        "against_for"=>'wallet',
                        "paid_by"=>'admin',
                        "orderID"=>0,
                        "transaction_at"=>date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions',$txn_insert);
                    $user_wallet = $user->wallet + $amount;
                    $this->db->where(array('ID'=>$userID));
                    $this->db->update('users',array('wallet'=>$user_wallet));
                    $message = "Hi $user->name\n ₹$amount has been credited in your wallet \n Thank You \n Mr Green Man";
                    $this->send_sms($user->mobile,$message);
                }
            }
        }
        redirect(base_url("users"));
    }
 public function add_cashback()
    {
        if ($_POST)
        {

            $userID = $_POST['ID'];
            $amount = $_POST['amount'];
            if ($amount > 0 && $userID != 0 && $userID != '')
            {
                $user = $this->db->get_where("users",array('ID'=>$userID))->row();
                var_dump($amount);
                var_dump($userID);
                if (!empty($user))
                {
                    $txn_insert = array(
                        "userID"=>$userID,
                        "txn_no"=>'',
                        "amount"=>$amount,
                        "type"=>'CREDIT',
                        "note"=>'Cashback',
                        "against_for"=>'wallet',
                        "paid_by"=>'admin',
                        "orderID"=>0,
                        "transaction_at"=>date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions',$txn_insert);
                    echo $this->db->last_query();
                    $user_wallet = $user->wallet + $amount;
                    $this->db->where(array('ID'=>$userID));
                    $this->db->update('users',array('cashback_wallet'=>$amount));
                    $message = "Hi $user->name\n You get cashback of ₹$amount in your wallet. \n Thank You \n Gowise Kart";
                    $this->send_sms($user->mobile,$message);
                }
            }
        }
        redirect(base_url("users"));
    }
    public function order_details($userID = '')
    {
        if ($userID != ''){
            $userID = $userID;
            $this->data['users'] = $this->home_m->get_single_row_where('users',array('ID'=>$userID),$select='*');
            $this->data['orders'] = $this->home_m->get_all_row_where('orders',array('userID'=>$userID));
            $this->data['title'] = "User Order Details" ;
            $this->data['sub_view'] = "order_details" ;
            $this->load->view('_layout',$this->data);
        }else{
            $this->index();
        }
    }

    public function profile($userID = '')
    {
        if ($userID != ''){
            $this->index();
        }else{
            $this->index();
        }
    }

    public function wallet($userID = '')
    {
        if ($userID != ''){
            $this->index();
        }else{
            $this->index();
        }
    }

    public function orders($userID = '')
    {
        if ($userID != ''){
            $this->index();
        }else{
            $this->index();
        }
    }

    public function change_user_type()
    {
        if ($_POST)
        {
            $userID = $_POST['ID'];
            $type = $_POST['TYPE'];
            $this->db->where(array('ID'=>$userID));
            $this->db->update('users',array('is_redeem_store'=>$type));
        }
        redirect(base_url("users"));
    }
      public function transactions($userID = '')
    {
        if ($userID != ''){
            $userID = $userID;
            $this->data['users'] = $this->home_m->get_single_row_where('users',array('ID'=>$userID),$select='*');
            $this->data['transactions'] = $this->home_m->get_all_row_where('wallet_transaction',array('userID'=>$userID));
            $this->data['title'] = "User Transactions" ;
            $this->data['sub_view'] = "users/transaction" ;
            $this->load->view('_layout',$this->data);
        }else{
            $this->index();
        }
    }

    public function send_sms($mobile, $message){
        $sender = "GROCST";
        $message = urlencode($message);

        $msg = "sender=".$sender."&route=4&country=91&message=".$message."&mobiles=".$mobile."&authkey=284738AIuEZXRVCDfj5d26feae";

        $ch = curl_init('http://api.msg91.com/api/sendhttp.php?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        $result = curl_close($ch);
        return $res;
    }
}