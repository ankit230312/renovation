<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Pages extends CI_Controller
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

    public function index()
    {
        if ($_POST){
            $array = $_POST;
            $this->home_m->update_data('settings',array('ID'=>'1'),$array);
        }
        $select = "about_us,privacy_policy,faq,terms_condition";
        $this->data['settings'] = $this->home_m->get_single_row_where('settings',array('ID'=>'1'),$select);
        $this->data['sub_view'] = 'settings/pages';
        $this->data['title'] = 'CMS Pages';
        $this->load->view("_layout",$this->data);
    }
}