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
        
        $this->load->model("home_m");
    }

    private function _check_auth(){
        if($this->session->userdata('role') != 'admin'){
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }
   
    public function index(){
        // echo $this->session->userdata('role');die();
            $cityID = $this->session->userdata('cityID');
        if (isset($_GET['cat']))
        { 
            $cat = $_GET['cat'];
            $sub_cat_array = array();
            $sub_cat = $this->db->query("SELECT `categoryID` FROM `category` WHERE `parent` = $cat AND `status`='Y'")->result();
            foreach ($sub_cat as $sub)
            {
                $sub_cat_array[] = 'FIND_IN_SET('.$sub->categoryID.',`category_id`)';
            }
            $where = implode('OR ',$sub_cat_array);
            if($this->session->userdata('role') == 'vendor'){
                $products = $this->db->query("SELECT products_detail.retail_price as rp,products_detail.status as p_st,products_detail.stock_count as st_ct, products_detail.id as pd_id,products_detail.cost_price as cp, products_detail.stock_count as sc,products.* FROM `products` LEFT JOIN products_detail ON products_detail.product_id = products.productID WHERE products_detail.status = 'Y' AND products_detail.city_id = '$cityID' AND ($where)")->result();
            }elseif($this->session->userdata('role') == 'admin'){
                $products = $this->db->query("SELECT products.* FROM `products` WHERE (`in_stock` = 'Y' OR `in_stock` = 'N') AND ($where)")->result();
            }
        }elseif($this->session->userdata('role') == 'vendor'){
            $products = $this->db->query("SELECT products_detail.stock_count as st_ct,products_detail.status as p_st,products_detail.retail_price as rp, products_detail.id as pd_id,products_detail.cost_price as cp, products_detail.stock_count as sc,products.* FROM `products` LEFT JOIN products_detail ON products_detail.product_id = products.productID WHERE products_detail.status = 'Y' AND products_detail.city_id = '$cityID'")->result();
        }else{

            $products = $this->db->query("SELECT products.* FROM `products` WHERE (`in_stock` = 'Y' OR `in_stock` = 'N')")->result();
        }
        foreach ($products as $p)
        {
            $p->category_name = $this->get_product_category_name($p->category_id);
            $p->main_category_name = $this->get_product_main_category_name($p->category_id);
        }
        $main_cat = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
        $this->data['categories'] = $main_cat;
        
        $this->data['products'] = $products;
        $this->data['sub_view'] = 'products/list';
        $this->data['title'] = 'Products';
        $this->load->view("_layout",$this->data);
    }

    public function delete_products($productID){
        $this->db->where(array('productID'=>$productID));
        $this->db->update('products',array('in_stock'=>'D'));
        redirect('products');
    }

    private function get_cost_price($product_name,$unit,$unit_value){
        $cost_price = 0;
        $stock_count = 0;
        $stock = $this->db->query("SELECT * FROM `stock` WHERE `product` = '$product_name'")->row();
        if (!empty($stock))
        {
            $multiplier = 1;
            if ($unit != $stock->unit)
            {
                if (strtoupper($unit) == 'KG' && strtoupper($stock->unit) == 'GM')
                {
                    $multiplier = $multiplier * 1000;
                }elseif (strtoupper($unit) == 'GM' && strtoupper($stock->unit) == 'KG')
                {
                    $multiplier = $multiplier / 1000;
                }
            }
            $stock_count = $stock->value/($unit_value * $multiplier);
            $cost_price = $unit_value * $multiplier * $stock->last_price;
        }
        return array('price'=>$cost_price,'count'=>$stock_count);
    }

    private function get_product_category_name($categoryID)
    {
        $query = $this->db->query("select category.title FROM category WHERE category.categoryID IN ($categoryID)")->result();
        $category_name = array();
        foreach ($query as $q)
        {
            $category_name[] = $q->title;
        }
        return implode(',',$category_name);

    }

    private function get_product_main_category_name($categoryID)
    {
        $categoryID = explode(',',$categoryID);
        $query = $this->db->query("select category.parent,category.title FROM category WHERE category.categoryID  = $categoryID[0]")->row();
        if ($query->parent != 0)
        {
            $query = $this->db->query("select category.parent,category.title FROM category WHERE category.categoryID  = $query->parent")->row();
        }
        $category_name = $query->title;
        return $category_name;

    }

    // public function sample_product_export(){ 
    //     $this->_check_auth();
    //    // file name 
    //    $filename = 'products_'.date('d-m-Y').'.csv'; 
    //    header("Content-Description: File Transfer"); 
    //    header("Content-Disposition: attachment; filename=$filename"); 
    //    header("Content-Type: application/csv; ");
       
    //    // get data 
    //    $products = $this->db->select('productID,product_name,price,retail_price,unit_value,unit,stock_count,cost_price,in_stock')->get_where('products',array('in_stock'=>'Y'))->result_array();
    //    $city = $this->db->select('id,title')->get_where('city',array('status'=>'Y'))->result_array();
    //    // file creation 
    //    $file = fopen('php://output', 'w');
     
    //    $header = array("productID","product_name","selling_price","mrp","unit_value","unit","stock_count","cost_price","status","cityID","title","variantID");
    //    fputcsv($file, $header);
    //    $count =1;
    //    foreach ($city as $key=>$line){
    //        foreach ($products as $k=>$li){
    //             $li['cityID'] = $line['id'];
    //             $li['city_name'] = $line['title'];
    //             $li['variantID'] = $count;
    //             fputcsv($file,$li); 
    //             $count++;
    //        }
    //    }
    //    fclose($file); 
    //    exit; 
    // }

    public function sample_product_export(){ 
       // file name 
       $filename = 'products_'.date('d-m-Y').'.csv'; 
       header("Content-Description: File Transfer"); 
       header("Content-Disposition: attachment; filename=$filename"); 
       header("Content-Type: application/csv; ");
       
       // get data 
       $products = $this->db->select('productID,product_name,product_description,category_id,price,retail_price,unit_value,unit,stock_count,cost_price','vegtype')->get_where('products',array('in_stock'=>'Y'))->result_array();

       // file creation 
       $file = fopen('php://output', 'w');
     
       $header = array("productID","product_name","product_description","category_id","selling_price","mrp","unit_value","unit","stock_count","cost_price","cityID","default_variant");
       fputcsv($file, $header);
       foreach ($products as $key=>$line){ 
         $line['default_variant']=1;
         $line['cityID']=1;
         fputcsv($file,$line); 
       }
       fclose($file); 
       exit; 
    }

    // public function products_bulk_import()
    // {
    //     $this->_check_auth();
    //     $target_path = 'uploads/bulk/';
    //     $cityID = $this->input->post('cityID');
    //     // var_dump($cityID);
    //     if (!empty($_FILES['file']['name'])){
    //         $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
    //         $actual_image_name = 'product' . time() . "." . $extension;
    //         move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . $actual_image_name);
    //         $file_path =  $target_path.$actual_image_name;
    //         if ($this->csvimport->get_array($file_path)) {
    //             $csv_array = $this->csvimport->get_array($file_path);
    //             // echo '<pre>';
    //             // var_dump($csv_array);die();
    //             foreach ($csv_array as $row) {
    //                 $productID = $row['productID'];
    //                 $product_name = $row['product_name'];
    //                 $price = $row['selling_price'];
    //                 $retail_price = $row['mrp'];
    //                 $unit_value = $row['unit_value'];
    //                 $unit = $row['unit'];
    //                 $stock_count = $row['stock_count'];
    //                 $cost_price = $row['cost_price'];
    //                 $check = $this->home_m->get_single_row_where('products',array('productID'=>$productID));
    //                 $check1 = $this->home_m->get_single_row_where('products_detail',array('product_id'=>$productID,'city_id'=>$cityID));
    //                 if (!empty($check)){
    //                     $update_data = array(
    //                         'product_name'=>$product_name,
    //                         'unit_value'=>$unit_value,
    //                         'unit'=>$unit,
    //                     );
    //                     $this->home_m->update_data('products',array('productID'=>$check->productID),$update_data);
    //                 }
    //                 $update_data1 = array(
    //                     'city_id' => $cityID,
    //                     'product_id' => $productID,
    //                     'price'=>$price,
    //                     'retail_price'=>$retail_price,
    //                     'stock_count'=>($check1->stock_count + $stock_count),
    //                     'cost_price'=>$cost_price
    //                 );
    //                 if (sizeof($check1)>0){
    //                      $this->home_m->update_data('products_detail',array('id'=>$check1->id),$update_data1);
    //                 }else{
    //                     $this->home_m->insert_data('products_detail',$update_data1);
    //                 }
    //             }
    //         }
    //     }
    //     redirect(base_url("products"));
    // }
    // public function products_bulk_import(){
    //     $this->_check_auth();
    //     $target_path = 'uploads/bulk/';
    //     // $cityID = $this->input->post('cityID');
    //     // var_dump($cityID);
    //     if (!empty($_FILES['file']['name'])){
    //         $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
    //         $actual_image_name = 'product' . time() . "." . $extension;
    //         move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . $actual_image_name);
    //         $file_path =  $target_path.$actual_image_name;
    //         if ($this->csvimport->get_array($file_path)) {
    //             $csv_array = $this->csvimport->get_array($file_path);
    //             // echo '<pre>';
    //             // var_dump($csv_array);die();
    //             foreach ($csv_array as $row) {
    //                 $productID = $row['productID'];
    //                 $variantID = $row['variantID'];
    //                 $product_name = $row['product_name'];
    //                 $price = $row['selling_price'];
    //                 $retail_price = $row['mrp'];
    //                 $unit_value = $row['unit_value'];
    //                 $unit = $row['unit'];
    //                 $stock_count = $row['stock_count'];
    //                 $cost_price = $row['cost_price'];
    //                 $status = $row['status'];
    //                 $cityID = $row['cityID'];
    //                 $check = $this->home_m->get_single_row_where('products',array('productID'=>$productID));
    //                 $check1 = $this->home_m->get_single_row_where('products_variant',array('product_id'=>$productID,'city_id'=>$cityID,'id'=>$variantID));
    //                 $detail_check = $this->home_m->get_single_row_where('products_detail',array('product_id'=>$productID,'city_id'=>$cityID));
    //                 if (!empty($check)){
    //                     $update_product = array(
    //                         'product_name'=>$product_name,
    //                         'unit_value'=>$unit_value,
    //                         'unit'=>$unit,
    //                     );
    //                     $this->home_m->update_data('products',array('productID'=>$check->productID),$update_product);
    //                 }
    //                 $update_variant = array(
    //                     'city_id' => $cityID,
    //                     'product_id' => $productID,
    //                     'price'=> $price,
    //                     'retail_price'=> $retail_price,
    //                     'stock_count'=> ($check1->stock_count + $stock_count),
    //                     'cost_price'=> $cost_price,
    //                     'unit_value'=> $unit_value,
    //                     'unit'=> $unit,
    //                     'is_active'=> $status
    //                 );
    //                 $update_detail = array(
    //                     'city_id' => $cityID,
    //                     'product_id' => $productID,
    //                     'price'=>$price,
    //                     'retail_price'=>$retail_price,
    //                     'stock_count'=>($detail_check->stock_count + $stock_count),
    //                     'cost_price'=>$cost_price,
    //                     'is_variant'=>'Y',
    //                     'status'=> $status
    //                 );
    //                 if (sizeof($detail_check)>0){
    //                     $this->home_m->update_data('products_detail',array('id'=>$check1->id),$update_detail);
    //                 }else{
    //                     $this->home_m->insert_data('products_detail',$update_detail);
    //                 }
    //                 if (sizeof($check1)>0){
    //                      $this->home_m->update_data('products_variant',array('id'=>$check1->id),$update_variant);
    //                 }else{
    //                     $this->home_m->insert_data('products_variant',$update_variant);
    //                 }
    //             }
    //         }
    //     }
    //     redirect(base_url("products/get_product_detail"));
    // }

  //import data
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
                    $description = $row['description'];
                    $categoryID = $row['category_id'];
                    $cost_price = $row['cost_price'];
                    $price = $row['selling_price'];
                    $retail_price = $row['mrp'];
                    $unit_value = $row['unit_value'];
                    $unit = $row['unit'];
                    $stock_count = $row['stock_count'];
                    $default_variant = $row['default_variant'];
                    $cityID = $row['cityID'];
                    //$variantID = $row['variantID'];

                    $check = $this->home_m->get_single_row_where('products',array('productID'=>$productID));
                    //$check1 = $this->home_m->get_single_row_where('products_variant',array('id'=>$variantID));
                    //data insert and update in product table
                    if (!empty($check)){
                    	if($default_variant==1){
                    	
	                        $update_data = array(
	                            'product_name'=>$product_name,
	                            'price'=>$price,
	                            'retail_price'=>$retail_price,
	                            'unit_value'=>$unit_value,
	                            'unit'=>$unit,
	                            'stock_count'=>($check->stock_count + $stock_count),
	                            'cost_price'=>$cost_price
	                        );
	                        //$this->home_m->update_data('products',array('productID'=>$productID),$update_data);
	                        
                    	}
                    	$check1 = $this->home_m->get_single_row_where('products_variant',array('product_id'=>$productID, 'quantity'=>$unit_value, 'unit'=>$unit));
                    	$update_variant = array(
	                        'product_id'=>$productID,
	                        'city_id'=>$cityID,
	                        'retail_price'=>$retail_price,
	                        'price'=>$price,
	                        'cost_price'=>$cost_price,
	                        'unit_value'=>$unit_value,
	                        'unit'=>$unit,
	                        'stock_count'=>($check->stock_count + $stock_count),
	                        'cost_price'=>$cost_price,
	                        'is_default'=>$default_variant
	                    );
                    	if(!empty($check1))
	                    {
	                        // update
	                        $this->home_m->update_data('products_variant',array('id'=>$check1->id),$update_variant);
	                    } else {
	                        // insert
	                         $this->home_m->insert_data('products_variant',$update_variant);
	                    }
                        
                    } else{
                        $p_id = $this->home_m->insert_data('products', $update_data);
                        if($p_id){
                        	$insert_variant = array(
	                            'product_id'=> $p_id,
	                            'city_id'=>$cityID,
	                            'retail_price'=>$retail_price,
	                            'price'=>$price,
	                            'cost_price'=>$cost_price,
	                            'unit_value'=>$unit_value,
	                            'unit'=>$unit,
	                            'is_default'=>$default_variant,
	                            'stock_count'=>($check->stock_count + $stock_count),
	                            'cost_price'=>$cost_price,
	                            'is_default'=>$default_variant
	                        );
                          $this->home_m->insert_data('products_variant',$update_data);
                        }
                    }
                }
            }
        }
        redirect(base_url("get_product_detail"));
    }
    public function add()
    {
        $this->_check_auth();
        if ($_POST && $_FILES){
            $insert_array = $_POST;
            $insert_array['category_id'] = implode(",",$_POST['category_id']);
            $insert_array['storage'] = '';
            $insert_array['unit'] = strtoupper($_POST['unit']);
            $insert_array['added_on'] = date("Y-m-d H:i:s");
            $insert_array['updated_on'] = date("Y-m-d H:i:s");
            $id = 0;
            if (!empty($_FILES['product_image']['name'])){
                $target_path = 'uploads/products/';
                $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
                $actual_image_name = 'product'. time() . "." . $extension;
                move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
                $insert_array['product_image'] = $actual_image_name;
                $id = $this->home_m->insert_data('products',$insert_array);
            }
            if($id > 0)
            {
                $this->city_wise_price($id, $insert_array['cost_price'],0,$insert_array['retail_price'],$insert_array['price'],$insert_array['vegtype']);
            }
            redirect(base_url("products"));
        }else{
            $this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>0),$select='categoryID,title');
            $this->data['sub_view'] = 'products/add';
            $this->data['title'] = 'Add Product';
            $this->load->view("_layout",$this->data);
        }
    }

    public function city_wise_price($productID, $cost_price, $stock_count=0, $retail_price, $price, $vegtype)
    {

        $cities = $this->db->get_where('city',array('status'=>'Y'))->result();
        foreach($cities as $c)
        {
            $a = array(
                'product_id' => $productID,
                'city_id' => $c->id,
                'cost_price' => $cost_price,
                'stock_count' => $stock_count,
                'price' => $price,
                'retail_price' => $retail_price,
                'vegtype' => $vegtype,
                'status' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->insert('products_detail',$a);
        }
        return true;
    }
    public function add_detail()
    {
        $this->_check_auth();
        
        $product_id ='';
        if ($_POST){
                $product_id=$this->input->post('products_id');
                $insert['product_id']=$product_id;
                $counter=$this->input->post('counter');
                for($i=0; $i<=$counter;$i++) {
                    $variants = $this->input->post('variants'.$i);
                    $old_variants = $this->input->post('old_variants'.$i);
                    $old_counter = $this->input->post('old_counter'.$i);
                    $city_id=$this->input->post('city_id'.$i);
                    foreach ($variants as $k => $va) {
                        foreach ($va as $krrr => $va1) {
                            if($va1 ==''){
                                unset($variants[$k]);
                            }
                        }
                    }
                    $variant_image = $_FILES['variants'.$i];
                    foreach ($variant_image  as $k => $va) {
                        if($_FILES['variants'.$i][$k][0]['variant_image'] ===''|| $_FILES['variants'.$i][$k][0]['variant_image'] === 4 || $_FILES['variants'.$i][$k][0]['variant_image'] === 0){
                            unset($variant_image[$k]);
                        }
                    }
                    $insert['city_id']=$city_id;
                    $retail_price =$this->input->post('retail_price'.$i);
                    $price=$this->input->post('price'.$i);
                    $stock_count=$this->input->post('stock_count'.$i);
                    $cost_price=$this->input->post('cost_price'.$i);
                    $status=$this->input->post('status'.$i);
                    $is_variant=$this->input->post('is_variant'.$i);
                    if($is_variant == 'on'){
                        $is_variant = 'Y';
                    }else{
                        $is_variant = 'N';
                    }
                    for($j=0; $j<=$old_counter;$j++) {
                        $old_variants = $this->input->post('old_variants'.$i.$j);
                        if(!empty($old_variants)){
                            if($old_variants['is_active'] == 'on'){
                                $old_variants['is_active'] = 'Y';
                            }else{
                                $old_variants['is_active'] = 'N';
                            }
                            $this->home_m->update_data('products_variant',array('id'=>$old_variants['id'],'city_id'=>$city_id),$old_variants);
                        }
                    }
                    $insert['retail_price']=$retail_price;
                    $insert['price']=$price;
                    $insert['stock_count']=$stock_count;
                    $insert['cost_price']=$cost_price;
                    $insert['status']=$status;
                    $insert['is_variant']=$is_variant;
                    $data['delivery_charges']=$delivery_charges;
                    $check_s = $this->home_m->get_single_row_where('products_detail',array('city_id'=>$city_id,'product_id'=>$product_id));
                    if(!empty($check_s)){
                        $insert['updated_at'] = date("Y-m-d H:i:s");
                        $this->home_m->update_data('products_detail',array('city_id'=>$city_id,'product_id'=>$product_id),$insert);
                            if($is_variant = 'Y'){
                                $v_id ='';
                            foreach ($variants as $k => $va) {
                                $va['city_id'] = $city_id;
                                $va['product_id'] = $product_id;
                                $va['updated_at'] = date("Y-m-d H:i:s");
                                $va['created_at'] = date("Y-m-d H:i:s");    

                                    $v_id = $this->home_m->insert_data('products_variant',$va);
                                }
                                if(!empty($variant_image['name'])){
                                    foreach ($variant_image['name'] as $krrr => $va1) {
                                        $target_path = 'uploads/variants/';
                                        $extension = substr(strrchr($va1['variant_image'], '.'), 1);
                                        $actual_image_name = 'pvariant'. time() . "." . $extension;
                                        if(move_uploaded_file($variant_image['tmp_name'][$krrr]['variant_image'], $target_path . $actual_image_name)){
                                            $this->home_m->update_data('products_variant',array('id'=>$v_id),array('variant_image' =>$actual_image_name));
                                        }
                                        
                                    }
                                }
                            }
                    }elseif($retail_price !='' && $price !='' && $stock_count !='' && $cost_price !=''){
                        $insert['updated_at'] = date("Y-m-d H:i:s");
                        $insert['created_at'] = date("Y-m-d H:i:s");
                        $product_id = $this->home_m->insert_data('products_detail',$insert);
                        if($is_variant = 'Y'){

                            foreach ($variants as $k => $va) {
                                $va['city_id'] = $city_id;
                                $va['product_id'] = $product_id;
                                
                            }
                            $this->home_m->insert_data('products_variant',$variants);
                            echo $this->db->last_query();
                        }
                    }
                }
                redirect(base_url("products/add_detail/".$product_id));
        }else{
            $this->data['city'] = $this->home_m->get_all_row_where('city',array('status'=>'Y'));
            $this->data['product'] = $this->home_m->get_all_row_where('products',array());
            $this->data['sub_view'] = 'products/product_detail';
            $this->data['title'] = 'Locality Wise Product Price';
            $this->load->view("_layout",$this->data);
        }
    }
    function make_json($param) {
      $array = array();
      $i=-1;
      if(sizeof($param) > 0){
        foreach ($param as $key=> $row) {
            $i++;
          if ($row != '') {
            $row['id'] = $i;
            array_push($array, $row);
          }
        }
      }
      // var_dump($array);die()
      return json_encode($array);
    }
    public function edit($param1 = ''){
        if ($param1 != ''){
            if ($_POST){
                $update_array = $_POST;
                $update_array['category_id'] = implode(",",$_POST['category_id']);
                //$update_array['unit'] = strtoupper($_POST['unit']);
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

    public function update_stock()
    {
        if ($_POST)
        {
            $productID = $_POST['productID'];
            $value = $_POST['value'];
            $parameter = strtolower($_POST['parameter']);
            $unit_price = $_POST['unit_price'];
            if ($parameter == 'add' || $parameter == 'remove')
            {
                $stock = $this->db->get_where('products',array('productID'=>$productID))->row();
                if (!empty($stock))
                {
                    if ($parameter == 'remove')
                    {
                        $new_stock = $stock->stock_count -= $value;
                    }else{
                        $new_stock = $stock->stock_count += $value;
                    }
                    $this->db->where(array('productID'=>$productID));
                    $this->db->update('products',array('stock_count'=>$new_stock,'cost_price'=>$unit_price));
                }
            }
        }
        redirect(base_url("products"));
    }

    public function active_inactive()
    {
        if ($_POST)
        {
            $productID = $_POST['productID'];
            $in_stock = $_POST['in_stock'];
            $this->db->where(array('productID'=>$productID));
            $this->db->update('products',array('in_stock'=>$in_stock));
           
        }
        redirect(base_url("products"));
    }
    public function stockupdate()
    {
        if ($_POST)
        {
            $productID = $_POST['productID'];
            $stock_count = $_POST['stock_count'];
            $this->db->where(array('id'=>$productID));
            $this->db->update('products_detail',array('stock_count'=>$stock_count));
        }
        redirect(base_url("products"));
    }
    public function get_product_detail(){
        if (isset($_GET['cat'])){ 
            $cat = $_GET['cat'];
            $sub_cat_array = array();
            $sub_cat = $this->db->query("SELECT `categoryID` FROM `category` WHERE `parent` = $cat AND `status`='Y'")->result();
            foreach ($sub_cat as $sub)
            {
                $sub_cat_array[] = 'FIND_IN_SET('.$sub->categoryID.',`category_id`)';
            }
            $where = implode('OR ',$sub_cat_array);
            $products = $this->db->query("SELECT * FROM products_variant LEFT JOIN products ON products.productID = products_variant.product_id  where ($where) ORDER BY id DESC")->result();
        }else{
            $products = $this->db->query("SELECT * FROM products_variant LEFT JOIN products ON products.productID = products_variant.product_id  ORDER BY id DESC")->result();
        }

        foreach ($products as $p){
            $p->category_name = $this->get_product_category_name($p->category_id);
            $p->main_category_name = $this->get_product_main_category_name($p->category_id);
        }

        $this->data['products_detail'] = $products;
        $this->data['categories'] = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
        $this->data['cities'] = $this->home_m->get_city();
        $this->data['sub_view'] = 'products/product_detail_list';
        $this->data['title'] = 'Edit Product';
        $this->load->view("_layout",$this->data);
    }
    //add variants
    public function add_variants()
    {
        if ($_POST){

                $product_id=$this->input->post('product_id');
                $insert_array = array();
                $insert_array['product_id'] = $product_id;
                $insert_array['retail_price'] =$this->input->post('retail_price');
                $insert_array['price'] = $this->input->post('price');
                $insert_array['unit_value'] = $this->input->post('unit_value');
                $insert_array['unit'] = $this->input->post('unit');
                $insert_array['stock_count'] = $this->input->post('stock_count');
                $insert_array['cost_price'] = $this->input->post('cost_price');
                $insert_array['is_active'] = $this->input->post('is_active');
                if (!empty($_FILES['product_image']['name'])){
                    $target_path = 'uploads/variants/';
                    $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
                    $actual_image_name = 'product'. time() . "." . $extension;
                    move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
                    $insert_array['variant_image'] = $actual_image_name;
                }
                $city = $this->db->query("SELECT * FROM `city` WHERE `status` ='Y'")->result();
                $id ='';
                foreach ($city as $c) {
                    $insert_array['city_id'] = $c->id;
                    $id = $this->home_m->insert_data('products_variant',$insert_array);
                }
                if($id>0){
                    redirect(base_url("products"));
                }       
        }else{
            //$this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>0),$select='categoryID,title');
            $this->data['sub_view'] = 'products/add_variants';
            $this->data['title'] = 'Add Variants';
            $this->load->view("_layout",$this->data);
        }
    }
    //update variant
    public function update_variant($id="")
    {
        if ($_POST){
                $id=$this->input->post('id');
                $insert_array = array();
                $insert_array['retail_price'] =$this->input->post('retail_price');
                $insert_array['price'] = $this->input->post('price');
                $insert_array['unit_value'] = $this->input->post('unit_value');
                $insert_array['unit'] = $this->input->post('unit');
                $insert_array['cost_price'] = $this->input->post('cost_price');
                $insert_array['is_active'] = $this->input->post('is_active');
                if (!empty($_FILES['product_image']['name'])){
                    $target_path = 'uploads/variants/';
                    $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
                    $actual_image_name = 'product'. time() . "." . $extension;
                    move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
                    $insert_array['variant_image'] = $actual_image_name;
                }else{
                    $insert_array['variant_image'] = $this->input->post('hidden_image');
                }
                $id = $this->home_m->update_data('products_variant',array('id'=>$id),$insert_array);
                if($id){
                    redirect(base_url("products"));
                }       
        }else{
            $retail_price='';
            $price='';
            $unit_value='';
            $unit='';
            $cost_price='';
            $is_active='';
            $variant_image='';
            $single_variants = $this->db->query("SELECT * FROM `products_variant` WHERE `id` =".$id)->result();
            foreach($single_variants as $value){
                $retail_price = $value->retail_price;
                $price = $value->price;
                $unit_value = $value->unit_value;
                $unit = $value->unit;
                $cost_price = $value->cost_price;
                $is_active = $value->is_active;
                $variant_image = $value->variant_image;
            }
            //echo $variant_image; exit;
            $this->data['id'] = $id;
            $this->data['retail_price'] = $retail_price;
            $this->data['price'] = $price;
            $this->data['unit_value'] = $unit_value;
            $this->data['unit'] = $unit;
            $this->data['cost_price'] = $cost_price;
            $this->data['is_active'] = $is_active;
            $this->data['variant_image'] = $variant_image;

            $this->data['sub_view'] = 'products/update_variant';
            $this->data['title'] = 'Add Variants';
            $this->load->view("_layout",$this->data);
        }
    }

    //show all variants
    public function all_variants($p_id=''){ 
        $all_variants = $this->db->query("SELECT * FROM `products_variant` WHERE `product_id` =".$p_id)->result();
        $this->data['all_variants'] = $all_variants;
        $this->data['sub_view'] = 'products/all_variants';
        $this->data['title'] = 'All variants';
        $this->load->view("_layout",$this->data);
    }
}