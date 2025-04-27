<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Enquiry extends CI_Controller
{
    function __construct() {
        parent::__construct();
        //$this->_check_auth();
    }

    /*private function _check_auth(){
        if($this->session->userdata('role') != 'admin'){
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }*/

    public function index()
    {   
      //  $enquiry = $this->db->query("SELECT * FROM `enquiry` WHERE `status`='NEW' ")->result();
        $this->db->from('enquiry');
        $this->db->order_by("enquiryID", "asc");
        $query = $this->db->get(); 
       //$this->db->last_query();

        $enquiry =  $query->result();


        $this->data['enquiry'] = $enquiry;
        $this->data['sub_view'] = 'enquiry/list';
        $this->data['title'] = 'Enquiry';
        $this->load->view("_layout",$this->data);
    }

    public function update_status_new()
    {
        $status = '';
        if($_POST)
        {
            $enquiryID = $_POST['id'];
            $status = $_POST['status'];
            $reply = isset($_POST['reply']) ? $_POST['reply'] :'';
            $this->db->where(array('enquiryID'=>$enquiryID));
            $this->db->update('enquiry',array('status'=>$status,'reply'=>$reply));
        }
        echo $status;
    }


}