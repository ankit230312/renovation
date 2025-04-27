<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class City extends CI_Controller
{
    function __construct() {
        parent::__construct();
        //$this->_check_auth();
        $this->load->model("home_m");
    }

    /*private function _check_auth(){
        if($this->session->userdata('role') != 'admin'){
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }*/

    public function index()
    {  
        $this->data['city'] = $this->home_m->get_all_row_where('city',array());
        $this->data['sub_view'] = 'city/list';
        $this->data['title'] = 'City';
        $this->load->view("_layout",$this->data);
    }

    public function add()
    {
        if ($_POST){
            $insert_array = $_POST;
            $insert_array['created_at'] = date("Y-m-d H:i:s");
            $insert_array['updated_at'] = date("Y-m-d H:i:s");
            $this->home_m->insert_data('city',$insert_array);
            redirect(base_url("city"));
        }else{
            $this->data['sub_view'] = 'city/add';
            $this->data['title'] = 'Add City';
            $this->load->view("_layout",$this->data);
        }
    }

    public function edit($param1 = '')
    {
        if ($param1 != ''){
            if ($_POST){
                $update_array = $_POST;
                $update_array['updated_at'] = date("Y-m-d H:i:s");
                $this->home_m->update_data('city',array('id'=>$param1),$update_array);
                redirect(base_url("city"));
            }else{
                $join = array();
                $this->data['city'] = $this->home_m->get_single_row_where_join ('city',array('id'=>$param1),$join);
                $this->data['sub_view'] = 'city/edit';
                $this->data['title'] = 'Edit City';
                $this->load->view("_layout",$this->data);
            }
        }else{
            $this->index();
        }
    }

    public function delete($param1 = '',$param2 = '')
    {
        if ($param1 != '' && $param2 == md5($param1)){
            $where = array(
                'id'=>$param1
            );
            $this->home_m->delete_data('city',$where);
            redirect(base_url("city"));
        }else{
            $this->index();
        }
    }

    public function bulk_import()
    {
        if ($_FILES)
        {
            $target_path = 'uploads/bulk/';
            if (!empty($_FILES['file']['name'])){
                $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
                $actual_image_name = 'city' . time() . "." . $extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . $actual_image_name);
                $file_path =  $target_path.$actual_image_name;
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    foreach ($csv_array as $row) {
                        $city = $row['city'];
                        $pin = $row['pin_code'];
                        $check = $this->home_m->get_single_row_where('city',array('title'=>$city),'id');
                        if (empty($check)){
                            $insert = array(
                                'title'=>$city,
                                'status'=>'Y',
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s")
                            );
                            $this->home_m->insert_data('city',$insert);
                        }else{
                            $this->home_m->update_data('city',array('id'=>$check->ID),array('status'=>'Y'));
                        }
                    }
                }else{
                    redirect(base_url("city"));
                }
            }
            redirect(base_url("city"));
        }else{
            $this->index();
        }
    }
}