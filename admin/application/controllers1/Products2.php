<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Products extends CI_Controller
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
        $select = 'products.*';
        $join = array();
        $this->data['products'] = $this->home_m->get_all_row_where_join ('products',array(),$join,$select);
        $this->data['sub_view'] = 'products/list';
        $this->data['title'] = 'Products';
        $this->load->view("_layout",$this->data);
    }
    
    public function sample_product_export(){ 
       // file name 
       $filename = 'products_'.date('d-m-Y').'.csv'; 
       header("Content-Description: File Transfer"); 
       header("Content-Disposition: attachment; filename=$filename"); 
       header("Content-Type: application/csv; ");
       
       // get data 
       $products = $this->db->select('productID,product_name,price,retail_price,unit_value,unit')->get('products')->result_array();

       // file creation 
       $file = fopen('php://output', 'w');
     
       $header = array("productID","product_name","price","retail_price","unit_value","unit"); 
       fputcsv($file, $header);
       foreach ($products as $key=>$line){ 
         fputcsv($file,$line); 
       }
       fclose($file); 
       exit; 
    }

    public function products_bulk_import()
    {
        $target_path = 'uploads/bulk/';
        if (!empty($_FILES['file']['name'])){
            $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
            $actual_image_name = 'product' . time() . "." . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . $actual_image_name);
            $file_path =  $target_path.$actual_image_name;
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) {
                    $productID = $row['productID'];
                    $product_name = $row['product_name'];
                    $price = $row['price'];
                    $retail_price = $row['retail_price'];
                    $unit_value = $row['unit_value'];
                    $unit = $row['unit'];
                    $check = $this->home_m->get_single_row_where('products',array('productID'=>$productID));

                    $update_data = array(
                        'product_name'=>$product_name,
                        'price'=>$price,
                        'retail_price'=>$retail_price,
                        'unit_value'=>$unit_value,
                        'unit'=>$unit  
                    );
                    if (!empty($check)){
                        $this->home_m->update_data('products',array('productID'=>$check->productID),$update_data);
                    }
                }
            }
        }
        redirect(base_url("products"));
    }

     public function add()
    {
        if ($_POST && $_FILES){
            $insert_array = $_POST;
            $insert_array['category_id'] = implode(",",$_POST['category_id']);
            $insert_array['unit'] = strtoupper($_POST['unit']);
            $insert_array['added_on'] = date("Y-m-d H:i:s");
            $insert_array['updated_on'] = date("Y-m-d H:i:s");
            if (!empty($_FILES['product_image']['name'])){
                $target_path = 'uploads/products/';
                $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
                $actual_image_name = 'product'. time() . "." . $extension;
                move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
                $insert_array['product_image'] = $actual_image_name;
                $this->home_m->insert_data('products',$insert_array);
            }
            redirect(base_url("products"));
        }else{
            $this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>0),$select='categoryID,title');
            $this->data['sub_view'] = 'products/add';
            $this->data['title'] = 'Add Product';
            $this->load->view("_layout",$this->data);
        }
    }

    public function edit($param1 = '')
    {
         if ($param1 != ''){
            if ($_POST){
                $update_array = $_POST;
                $update_array['category_id'] = implode(",",$_POST['category_id']);
                $update_array['unit'] = strtoupper($_POST['unit']);
                $update_array['updated_on'] = date("Y-m-d H:i:s");
                if (!empty($_FILES['product_image']['name'])){
                    $target_path = 'uploads/products/';
                    $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
                    $actual_image_name = 'product'. time() . "." . $extension;
                    move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
                    $update_array['product_image'] = $actual_image_name;
                }
            
                $this->home_m->update_data('products',array('productID'=>$param1),$update_array);
                redirect(base_url("products"));
            }else{
                 $join = array();
                $product = $this->home_m->get_single_row_where_join ('products',array('productID'=>$param1),$join);
                $selected_sub = explode(',',$product->category_id);
                $selected_sub = $selected_sub[0];
                $this->data['selected_category'] = $this->db->get_where('category',array('categoryID'=>$selected_sub))->row();
                $this->data['products'] = $product;
                $this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>0),$select='categoryID,title');
                $this->data['sub_view'] = 'products/edit';
                $this->data['title'] = 'Edit Product';
                $this->load->view("_layout",$this->data);
            }
        }else{
            $this->index();
        }
    }
}