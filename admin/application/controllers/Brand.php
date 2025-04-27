<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Brand extends CI_Controller
{
    function __construct() {
        parent::__construct();
       // $this->_check_auth();
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
        $this->brand_management();
    }

    public function brand_management($param1 = '',$param2 = '')
    {
        if ($param1 == 'edit' && $param2 != ''){
            if ($_POST){

                // print_r($_FILES);
                // die();
                // var_dump($_FILES);
                $update_array = $_POST;
                if (!empty($_FILES['icon']['name'])) {
                    $target_path = 'uploads/brand/';
                    $extension = substr(strrchr($_FILES['icon']['name'], '.'), 1);
                    $actual_image_name = 'icon'. time() . "." . $extension;
                    move_uploaded_file($_FILES["icon"]["tmp_name"], $target_path . $actual_image_name);
                    $update_array['icon'] = $actual_image_name;
                }
                if (!empty($_FILES['image']['name'])){
                    $target_path = 'uploads/brand/';
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name1 = 'image'. time() . "." . $extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name1);
                    $update_array['image'] = $actual_image_name1;
                }
                 
                $this->home_m->update_data('brand',array('brandID'=>$param2),$update_array);
                //echo $this->db->last_query();
                redirect(base_url("brand/brand_management"));
            }else{
                $this->data['par_category'] = $this->home_m->get_all_row_where('brand',array('brandID !='=>$param2),$select='*');
                $this->data['category'] = $this->home_m->get_single_row_where('brand',array('brandID'=>$param2));
                $this->data['sub_view'] = 'brand/edit';
                $this->data['title'] = 'Brand';
                $this->load->view("_layout",$this->data);
            }
        }elseif($param1 == 'add'){

           
            if ($_POST && $_FILES){
                $insert_array = $_POST;

                if(!empty($_FILES['image']['name'])){
                    $target_path = 'uploads/brand/';
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name1 = 'image'. time() . "." . $extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name1);
                    $insert_array['image'] = $actual_image_name1;
                }

                // print_r($insert_array);
                // die();
                // if (!empty($_FILES['icon']['name'])){
                //     $target_path = 'uploads/category/';
                //     $extension = substr(strrchr($_FILES['icon']['name'], '.'), 1);
                //     $actual_image_name = 'icon'. time() . "." . $extension;
                //     move_uploaded_file($_FILES["icon"]["tmp_name"], $target_path . $actual_image_name);
                    
                //     $insert_array['icon'] = $actual_image_name;
                       
                // }
                $this->home_m->insert_data('brand',$insert_array);
                redirect(base_url("brand/brand_management"));
            }else{
                $this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>'0'),$select='*');
                $this->data['sub_view'] = 'brand/add';
                $this->data['title'] = 'Add Brand';
                $this->load->view("_layout",$this->data);
            }
        }else{
            $select = 'select * from brand';
           
            $this->data['category'] = $this->home_m->get_all_table_query($select);
            $this->data['sub_view'] = 'brand/list';
            $this->data['title'] = 'Brand';
            $this->load->view("_layout",$this->data);
        }
    }

    public function get_brand($brandID)
    {
        $this->db->select('brandID,title');
        $brand = $this->db->get_where('brand',array('brandID'=>$brandID))->result();
        echo json_encode($brand);
    }
}