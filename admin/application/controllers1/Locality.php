<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Locality extends CI_Controller
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
    }
*/
    public function index()
    {
        $select = 'locality.*';
        $join = array();
        $this->data['locality'] = $this->home_m->get_all_row_where_join ('locality',array(),$join,$select);
        $this->data['sub_view'] = 'locality/list';
        $this->data['title'] = 'Locality';
        $this->load->view("_layout",$this->data);
    }

    public function add()
    {
        if ($_POST){
            $insert_array = $_POST;
            $insert_array['added_on'] = date("Y-m-d H:i:s");
            $insert_array['updated_on'] = date("Y-m-d H:i:s");
            $this->home_m->insert_data('locality',$insert_array);
            redirect(base_url("locality"));
        }else{
            $this->data['cities'] = $this->home_m->get_all_row_where ('city',array('status'=>'Y'));
            $this->data['sub_view'] = 'locality/add';
            $this->data['title'] = 'Add Locality';
            $this->load->view("_layout",$this->data);
        }
    }

    public function edit($param1 = '')
    {
        if ($param1 != ''){
            if ($_POST){
                $update_array = $_POST;
                $update_array['updated_on'] = date("Y-m-d H:i:s");
                $this->home_m->update_data('locality',array('ID'=>$param1),$update_array);
                redirect(base_url("locality"));
            }else{
                $join = array();
                $this->data['locality'] = $this->home_m->get_single_row_where_join ('locality',array('ID'=>$param1),$join);
                $this->data['cities'] = $this->home_m->get_all_row_where ('city',array('status'=>'Y'));
                $this->data['sub_view'] = 'locality/edit';
                $this->data['title'] = 'Edit Locality';
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
                'ID'=>$param1
            );
            $this->home_m->delete_data('locality',$where);
            redirect(base_url("locality"));
        }else{
            $this->index();
        }
    }

    public function bulk_import(){
        if ($_FILES)
        {
            $target_path = 'uploads/bulk/';
            if (!empty($_FILES['file']['name'])){
                $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
                $actual_image_name = 'locality' . time() . "." . $extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . $actual_image_name);
                $file_path =  $target_path.$actual_image_name;
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    foreach ($csv_array as $row) {
                        $locality = $row['locality'];
                        $cityID = $row['cityID'];
                        $pin = $row['pin_code'];
                        $status = $row['status'];
                        $check = $this->home_m->get_single_row_where('locality',array('locality'=>$cityID,'pin'=>$pin),'ID');
                        $check1 = $this->home_m->get_single_row_where('city',array('id'=>$cityID));
                        if(!empty($check1)){
                            if (empty($check)){
                                $insert = array(
                                    'locality'=>$cityID,
                                    'pin'=>$pin,
                                    'status'=>$status,
                                    'added_on'=>date("Y-m-d H:i:s"),
                                    'updated_on'=>date("Y-m-d H:i:s")
                                );
                                $this->home_m->insert_data('locality',$insert);
                            }else{
                                $this->home_m->update_data('locality',array('ID'=>$check->ID),array('status'=>'Y'));
                            }
                        }
                    }
                }else{
                    redirect(base_url("locality"));
                }
            }
            redirect(base_url("locality"));
        }else{
            $this->index();
        }
    }
}