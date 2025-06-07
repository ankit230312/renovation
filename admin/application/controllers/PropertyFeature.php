<?php

/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class PropertyFeature extends CI_Controller
{
    function __construct()
    {
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
        $this->propertyFeature_m();
    }

    public function propertyFeature_m($param1 = '', $param2 = '')
    {




        if ($param1 == 'edit' && $param2 != '') {
            if ($_POST) {

                // print_r($_FILES);
                // die();
                // var_dump($_FILES);
                $update_array = $_POST;
                if (!empty($_FILES['icon']['name'])) {
                    $target_path = 'uploads/brand/';
                    $extension = substr(strrchr($_FILES['icon']['name'], '.'), 1);
                    $actual_image_name = 'icon' . time() . "." . $extension;
                    move_uploaded_file($_FILES["icon"]["tmp_name"], $target_path . $actual_image_name);
                    $update_array['icon'] = $actual_image_name;
                }
                if (!empty($_FILES['image']['name'])) {
                    $target_path = 'uploads/brand/';
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name1 = 'image' . time() . "." . $extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name1);
                    $update_array['image'] = $actual_image_name1;
                }

                $this->home_m->update_data('brand', array('brandID' => $param2), $update_array);
                //echo $this->db->last_query();
                redirect(base_url("brand/brand_management"));
            } else {
                $this->data['par_category'] = $this->home_m->get_all_row_where('brand', array('brandID !=' => $param2), $select = '*');
                $this->data['category'] = $this->home_m->get_single_row_where('brand', array('brandID' => $param2));
                $this->data['sub_view'] = 'brand/edit';
                $this->data['title'] = 'Brand';
                $this->load->view("_layout", $this->data);
            }
        } elseif ($param1 == 'add') {


            // if ($_POST && $_FILES){
            if ($_POST) {
                $insert_array = $_POST;
                // echo "<pre>";
                // print_r($insert_array);
                // die;

                // echo "<pre>";
                // print_r($insert_array);
                // die;

                // if(!empty($_FILES['image']['name'])){
                //     $target_path = 'uploads/brand/';
                //     $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                //     $actual_image_name1 = 'image'. time() . "." . $extension;
                //     move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name1);
                //     $insert_array['image'] = $actual_image_name1;
                // }


                $this->home_m->insert_data('floor_dimensions', $insert_array);
                redirect(base_url("propertyFeature/propertyFeature_m/add"));
            } else {
                // $this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>'0'),$select='*');
                $this->data['products'] = $this->home_m->get_all_row_where('products', []);
                $this->data['sub_view'] = 'propertyFeature/add';
                $this->data['title'] = 'Add Feature Feature';
                $this->load->view("_layout", $this->data);
            }
        } else {
            $select = 'SELECT p.product_name , ft.floor_type , fd.room_type, fd.area_sqft, fd.status,fd.id FROM floor_dimensions fd JOIN products p ON p.productID = fd.property_id JOIN floor_type ft ON ft.floor_id = fd.property_type_id;';

            $this->data['products'] = $this->home_m->get_all_table_query($select);
            $this->data['sub_view'] = 'propertyFeature/list';
            $this->data['title'] = 'Property Feature';
            $this->load->view("_layout", $this->data);
        }
    }

    public function get_brand($brandID)
    {
        $this->db->select('brandID,title');
        $brand = $this->db->get_where('brand', array('brandID' => $brandID))->result();
        echo json_encode($brand);
    }

    public function get_property_types()
    {
        $property_id = $this->input->post('property_id');

        $this->db->select('floor_id, floor_type');
        $this->db->from('floor_type');
        $this->db->where('property_id', $property_id);
        $query = $this->db->get();
        $result = $query->result_array();

        echo json_encode($result);
    }
}
