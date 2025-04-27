<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Abandon_cart extends CI_Controller
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

    private function get_cart_products($userID)
    {
        $total = $this->db->query("SELECT COALESCE(count(cartID),0) as count FROM product_cart WHERE userID = '$userID'")->row();
        return $total->count;
    }

    public function index()
    {
        
         $distinct_user = $this->home_m->get_all_table_query("SELECT  DISTINCT userID  from product_cart where `added_on` > now() - interval 30 day");
         foreach ($distinct_user as $d){
          $d->users = $this->home_m->get_all_table_query("SELECT * FROM `users` WHERE `ID` ='$d->userID'");         
           $d->get_cart_products = $this->get_cart_products($d->userID);
            }
        $this->data['distinct_user'] = $distinct_user;
        $this->data['sub_view'] = 'abandon_cart/list';
        $this->data['title'] = 'Abandon Cart';
        $this->load->view("_layout",$this->data);
    }
   
    public function get_products($userID = '')
    {
        if ($userID != ''){
            $userID = $userID;
            $this->data['users'] = $this->home_m->get_single_row_where('users',array('ID'=>$userID),$select='*');
            $this->data['get_products'] = $this->home_m->get_all_row_where('product_cart',array('userID'=>$userID));
            $this->data['title'] = "User cart Products" ;
            $this->data['sub_view'] = "abandon_cart/cart_products" ;
            $this->load->view('_layout',$this->data);
        }else{
            $this->index();
        }
    }

   
}