<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class ProductItem extends CI_Controller
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
        $this->product_category_management();
    }

    public function product_category_management($param1 = '',$param2 = '')
    {
        if ($param1 == 'edit' && $param2 != ''){
            if ($_POST){
                // var_dump($_FILES);
                $update_array = $_POST;
                if (!empty($_FILES['icon']['name'])) {
                    $target_path = 'uploads/category/';
                    $extension = substr(strrchr($_FILES['icon']['name'], '.'), 1);
                    $actual_image_name = 'icon'. time() . "." . $extension;
                    move_uploaded_file($_FILES["icon"]["tmp_name"], $target_path . $actual_image_name);
                    $update_array['icon'] = $actual_image_name;
                }
                if (!empty($_FILES['image']['name'])){
                    $target_path = 'uploads/category/';
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name1 = 'image'. time() . "." . $extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name1);
                    $update_array['image'] = $actual_image_name1;
                }
                $this->home_m->update_data('category',array('categoryID'=>$param2),$update_array);
                //echo $this->db->last_query();
                redirect(base_url("category/product_category_management"));
            }else{
              
                $this->data['par_category'] = $this->home_m->get_all_row_where('category',array('parent'=>'0','categoryID !='=>$param2),$select='*');
                $this->data['category'] = $this->home_m->get_single_row_where('category',array('categoryID'=>$param2));
                $this->data['sub_view'] = 'category/edit';
                $this->data['title'] = 'Category';
                $this->load->view("_layout",$this->data);
            }
        }elseif($param1 == 'add'){
            // if ($_POST && $_FILES){

          
            if ($_POST){
                
                $insert_array = $_POST;

                // if(!empty($_FILES['image']['name'])){
                //     $target_path = 'uploads/category/';
                //     $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                //     $actual_image_name1 = 'image'. time() . "." . $extension;
                //     move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name1);
                //     $insert_array['image'] = $actual_image_name1;
                // }
                // if (!empty($_FILES['icon']['name'])){
                //     $target_path = 'uploads/category/';
                //     $extension = substr(strrchr($_FILES['icon']['name'], '.'), 1);
                //     $actual_image_name = 'icon'. time() . "." . $extension;
                //     move_uploaded_file($_FILES["icon"]["tmp_name"], $target_path . $actual_image_name);
                    
                //     $insert_array['icon'] = $actual_image_name;
                       
                // }
                $this->home_m->insert_data('item_category',$insert_array);
                redirect(base_url("ProductItem/product_category_management"));
            }else{
                // die("vtlhl");
                $this->data['category'] = $this->home_m->get_all_row_where('item_category',array('parent' => '0'),$select='*');
               
                $this->data['sub_view'] = 'item_cate/add';
                $this->data['title'] = 'Add Category';
                $this->load->view("_layout",$this->data);
            }
        }else{
           
            $select = 'item_category.*,parent.title as parent_cat';
            $join = array();
            $join[] = array(
                'table'=>'item_category as parent',
                'parameter'=>'item_category.parent = parent.categoryID',
                'position'=>'LEFT'
            );
              $this->data['category'] = $this->home_m->get_all_row_where_join('item_category',array(),$join,$select);
            $this->data['sub_view'] = 'item_cate/list';
            $this->data['title'] = 'Product Category';
            $this->load->view("_layout",$this->data);
        }
    }

    public function get_subcategory($categoryID)
    {
        $this->db->select('categoryID,title');
        $subcategory = $this->db->get_where('category',array('parent'=>$categoryID))->result();
        echo json_encode($subcategory);
    }
}