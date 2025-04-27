<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Settings extends CI_Controller
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
            $target_path = 'uploads/';
            if ($_FILES && !empty($_FILES['logo']['name'])){
                $extension = substr(strrchr($_FILES['logo']['name'], '.'), 1);
                $actual_image_name = 'logo'. time() . "." . $extension;
                move_uploaded_file($_FILES["logo"]["tmp_name"], $target_path . $actual_image_name);
                $array['logo'] = $actual_image_name;
            }
            if ($_FILES && !empty($_FILES['favicon']['name'])){
                $extension = substr(strrchr($_FILES['favicon']['name'], '.'), 1);
                $actual_image_name = 'favicon'. time() . "." . $extension;
                move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_path . $actual_image_name);
                $array['favicon'] = $actual_image_name;
            }
            $this->home_m->update_data('settings',array('ID'=>'1'),$array);
        }
        $select = "site_name,logo,favicon,min_order_amount,max_order_amount,free_delivery_amount,delivery_charge";
        $this->data['settings'] = $this->home_m->get_single_row_where('settings',array('ID'=>'1'),$select);
        $this->data['sub_view'] = 'settings/settings';
        $this->data['title'] = 'Settings';
        $this->load->view("_layout",$this->data);
    }
}