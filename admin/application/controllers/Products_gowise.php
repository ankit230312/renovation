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
        $id = $this->session->userdata('adminID');
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
                $admin_cat = $this->db->query("SELECT `category_id` FROM `admin` WHERE `id` = $id AND `status` = 'Y'")->row();
                $main_cat = $this->home_m->get_all_table_query("SELECT * FROM `category` WHERE `categoryID` IN($admin_cat->category_id) ");
                $subcat = $this->home_m->get_all_table_query("SELECT categoryID FROM `category` WHERE `parent` = $cat ");
                foreach ($subcat  as $s) {
                 $subcat_array[] = 'FIND_IN_SET('.$s->categoryID.',`category_id`)';
             }
             $where1 = implode('OR ',$subcat_array);


             $products = $this->db->query("SELECT products_variant.stock_count as st_ct,products_variant.status as p_st,products_variant.retail_price as rp, products_variant.id as pd_id,products_variant.cost_price as cp, products_variant.stock_count as sc,products.* FROM `products` LEFT JOIN products_variant ON products_variant.product_id = products.productID  WHERE products_variant.status = 'Y' AND products_variant.city_id = '$cityID' AND ($where1)")->result(); 

         }elseif($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'subadmin'){
           if($cat==0){
                //echo $where; exit;
              $main_cat = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
              $products = $this->db->query("SELECT distinct products_variant.product_id,products.* from products_variant left join products on products_variant.product_id=products.productID where products_variant.stock_count=0")->result();
          }else{
            $main_cat = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
            $products = $this->db->query("SELECT products.* FROM `products` WHERE (`in_stock` = 'Y' OR `in_stock` = 'N') AND ($where)")->result();
        }

    }



}elseif($this->session->userdata('role') == 'vendor'){

   $admin_cat = $this->db->query("SELECT `category_id` FROM `admin` WHERE `id` = $id AND `status` = 'Y'")->row();
   $main_cat = $this->home_m->get_all_table_query("SELECT * FROM `category` WHERE `categoryID` IN($admin_cat->category_id) ");
   $subcat = $this->home_m->get_all_table_query("SELECT * FROM `category` WHERE `parent` IN($admin_cat->category_id) ");
   foreach ($subcat as $sub)
   {
    $subcat_array[] = 'FIND_IN_SET('.$sub->categoryID.',`category_id`)';
}
$where1 = implode('OR ',$subcat_array);
$products = $this->db->query("SELECT products_variant.stock_count as st_ct,products_variant.status as p_st,products_variant.retail_price as rp, products_variant.id as pd_id,products_variant.cost_price as cp, products_variant.stock_count as sc,products.* FROM `products` LEFT JOIN products_variant ON products_variant.product_id = products.productID  WHERE products_variant.status = 'Y' AND products_variant.city_id = '$cityID' AND  products.category_id IN ($sub->categoryID) ")->result(); 
}else{
    $main_cat = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
    $products = $this->db->query("SELECT products.* FROM `products` WHERE (`in_stock` = 'Y' OR `in_stock` = 'N') ORDER BY productID DESC")->result();
    //echo $this->db->last_query();

}
foreach ($products as $p)
{
    $p->category_name = $this->get_product_category_name($p->category_id);
    $p->main_category_name = $this->get_product_main_category_name($p->category_id);
}
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
    $this->db->where_in('categoryID',$categoryID);
    $cat=$this->db->get('category');
    $query = $cat->result();
    // $query = $this->db->query("select * FROM category WHERE categoryID IN ($categoryID)")->result();
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


    $this->db->where('categoryID',$$categoryID[0]);
    $cat=$this->db->get('category');
    $query = $cat->row();


    //$query = $this->db->query("select category.parent,category.title FROM category WHERE category.categoryID  = $categoryID[0]")->row();
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

// public function sample_product_export(){ 
//        // file name 
//  $filename = 'products_'.date('d-m-Y').'.csv'; 
//  header("Content-Description: File Transfer"); 
//  header("Content-Disposition: attachment; filename=$filename"); 
//  header("Content-Type: application/csv; ");

//        // get data 
//  $products = $this->db->select('productID,product_name,product_description,category_id,price,retail_price,unit_value,unit,stock_count,cost_price','vegtype')->get_where('products',array('in_stock'=>'Y'))->result_array();

//        // file creation 
//  $file = fopen('php://output', 'w');

//  $header = array("productID","product_name","product_description","category_id","selling_price","mrp","unit_value","unit","stock_count","cost_price","cityID","default_variant");
//  fputcsv($file, $header);
//  foreach ($products as $key=>$line){ 
//    $line['default_variant']=1;
//    $line['cityID']=1;
//    fputcsv($file,$line); 
// }
// fclose($file); 
// exit; 
// }
//new export
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

    $header = array("productID","product_name","product_description","category_id","selling_price","mrp","unit_value","unit","stock_count","cost_price","default_variant","category_name","city_id");
    fputcsv($file, $header);
    foreach ($products as $key=>$line){ 
      $line['default_variant']=1;
      $line['category_name']=$this->get_name($line['category_id']);
      $line['city_id']=1;
      fputcsv($file,$line); 
  }
  fclose($file); 
  exit; 
}

//city and category wise exports
public function products_bulk_import_city(){ 
    $cityID = $this->input->post('cityID');
    $categoryID = $this->input->post('categoryID');
    $products='';
    // file name 
    $filename = 'products_city'.date('d-m-Y').'.csv'; 
    header("Content-Description: File Transfer"); 
    header("Content-Disposition: attachment; filename=$filename"); 
    header("Content-Type: application/csv;");
    
    // get data 
    if($cityID!='' && $categoryID==''){
        $products =$this->db->query("select products.productID,products.product_name,products.product_description,products.category_id,products_variant.price,products_variant.retail_price,products_variant.unit_value,products_variant.unit,products_variant.stock_count,products_variant.cost_price,products_variant.is_default,products_variant.city_id from products_variant inner join products on products_variant.product_id=products.productID where products_variant.city_id='$cityID'")->result_array();
    }
    if($categoryID!='' && $cityID==''){
        $products =$this->db->query("select products.productID,products.product_name,products.product_description,products.category_id,products_variant.price,products_variant.retail_price,products_variant.unit_value,products_variant.unit,products_variant.stock_count,products_variant.cost_price,products_variant.is_default,products_variant.city_id from products_variant inner join products on products_variant.product_id=products.productID where products.category_id='$categoryID'")->result_array();  
    }
    if($cityID!='' && $categoryID!=''){
        $products =$this->db->query("select products.productID,products.product_name,products.product_description,products.category_id,products_variant.price,products_variant.retail_price,products_variant.unit_value,products_variant.unit,products_variant.stock_count,products_variant.cost_price,products_variant.is_default,products_variant.city_id from products_variant inner join products on products_variant.product_id=products.productID where products_variant.city_id='$cityID' and products.category_id='$categoryID'")->result_array();   
    }


    // file creation 
    $file = fopen('php://output', 'w');
    $header = array("productID","product_name","product_description","category_id","selling_price","mrp","unit_value","unit","stock_count","cost_price","default_variant","city_id","category_name","city_name");
    fputcsv($file, $header);
    foreach ($products as $key=>$line){ 
    //   $line['default_variant']=$line['is_default'];
      $line['category_name']=$this->get_name($line['category_id']);
      $line['city_id']=$line['city_id'];
      $line['city_Name']=$this->cityname($line['city_id']);
      fputcsv($file,$line); 
  }
  fclose($file); 
  exit; 
}

 //get category name
public function get_name($categoryID)
{
    $q = $this->db->query("SELECT  `title` FROM `category` WHERE `categoryID`='$categoryID'")->row();
    if(!empty($q))
    {
        return $q->title;
    }
    return 'GowiseKart Products';
}

//get city name
public function cityname($cityID)
{
    $q = $this->db->query("SELECT  `title` FROM `city` WHERE `id`='$cityID'")->row();
    if(!empty($q))
    {
        return $q->title;
    }
    return '0';
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


    //new import
// public function products_bulk_import()
// {
//         //echo "ok"; exit;
//     $target_path = 'uploads/bulk/';
//     if (!empty($_FILES['file']['name'])){
//         $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
//         $actual_image_name = 'product' . time() . "." . $extension;
//         move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . $actual_image_name);
//         $file_path =  $target_path.$actual_image_name;
//         if ($this->csvimport->get_array($file_path)) {
//             $csv_array = $this->csvimport->get_array($file_path);
//             foreach ($csv_array as $row) {

//                 $productID = $row['productID'];
//                 $product_name = $row['product_name'];
//                 $description = $row['product_description'];
//                 $categoryID = $row['category_id'];
//                 $cost_price = $row['cost_price'];
//                 $price = $row['selling_price'];
//                 $retail_price = $row['mrp'];
//                 $unit_value = $row['unit_value'];
//                 $unit = $row['unit'];
//                 $stock_count = $row['stock_count'];
//                 $default_variant = $row['default_variant'];
//                 $city_id = $row['city_id'];
//                     //$variantID = $row['variantID'];

//                 $check = $this->home_m->get_single_row_where('products',array('productID'=>$productID));

//                     //$check1 = $this->home_m->get_single_row_where('product_variants',array('id'=>$variantID));
//                     //data insert and update in product table
//                 if (!empty($check)){
//                         //echo "check"; exit;
//                     if($default_variant==1){

//                         $update_data = array(
//                             'product_name'=>$product_name,
//                             'price'=>$price,
//                             'retail_price'=>$retail_price,
//                             'unit_value'=>$unit_value,
//                             'unit'=>$unit,
//                             'stock_count'=>($check->stock_count + $stock_count),
//                             'cost_price'=>$cost_price
//                         );
//                         $this->home_m->update_data('products',array('productID'=>$productID),$update_data);

//                     }
//                     $check1 = $this->home_m->get_single_row_where('products_variant',array('product_id'=>$productID, 'unit_value'=>$unit_value, 'unit'=>$unit,'city_id'=>$city_id));
//                     $update_variant = array(
//                         'product_id'=>$productID,
//                         'city_id'=>$city_id,
//                         'retail_price'=>$retail_price,
//                         'price'=>$price,
//                         'cost_price'=>$cost_price,
//                         'unit_value'=>$unit_value,
//                         'unit'=>$unit,
//                         'stock_count'=>($check->stock_count + $stock_count),
//                         'cost_price'=>$cost_price,
//                         'is_default'=>$default_variant
//                     );
//                     if(!empty($check1))
//                     {
//                             // update
//                         $this->home_m->update_data('products_variant',array('id'=>$check1->id),$update_variant);
//                     } else {
//                             // insert
//                              //$this->home_m->insert_data('products_variant',$update_variant);
//                      $Cities = $this->db->query("select * from city where status='Y'")->result();
//                      foreach($Cities as $city){
//                         $updateUndefaultvariant = array(
//                             'product_id'=> $productID,
//                             'city_id'=> $city->id,
//                             'retail_price'=>$retail_price,
//                             'price'=>$price,
//                             'cost_price'=>$cost_price,
//                             'unit_value'=>$unit_value,
//                             'unit'=>$unit,
//                             'stock_count'=>$stock_count,
//                             'cost_price'=>$cost_price,
//                             'is_default'=>$default_variant
//                         );
//                         $this->home_m->insert_data('products_variant',$updateUndefaultvariant);
//                     }
//                 }

//             } else{
//                         //echo $productID; exit;
//                 if($default_variant==1){
//                     $data = array(
//                         'productID'=>$productID,
//                         'product_name'=>$product_name,
//                         'product_description'=>$description,
//                         'use'=>'',
//                         'benefit'=>'',
//                         'storage'=>'',
//                         'product_image'=>'',
//                         'category_id'=>$categoryID,
//                         'brand_id'=>'',
//                         'in_stock'=>'Y',
//                         'stock_count'=>$stock_count,
//                         'price'=>$price,
//                         'cost_price'=>$cost_price,
//                         'retail_price'=>$retail_price,
//                         'unit_value'=>$unit_value,
//                         'unit'=>$unit,
//                         'featured'=>'',
//                         'vegtype'=>'V',
//                     );
//                     $p_id = $this->home_m->insert_data('products', $data);
//                        // echo $this->db->last_query(); exit;
//                     if($p_id){
//                         $Cities = $this->db->query("select * from city where status='Y'")->result();
//                         foreach($Cities as $city){
//                             $insert_variant = array(
//                                 'product_id'=> $p_id,
//                                 'city_id'=> $city->id,
//                                 'retail_price'=>$retail_price,
//                                 'price'=>$price,
//                                 'cost_price'=>$cost_price,
//                                 'unit_value'=>$unit_value,
//                                 'unit'=>$unit,
//                                 'stock_count'=>$stock_count,
//                                 'cost_price'=>$cost_price,
//                                 'is_default'=>$default_variant
//                             );
//                             $this->home_m->insert_data('products_variant',$insert_variant);
//                         }

//                     }

//                 }else{
//                     $Cities = $this->db->query("select * from city where status='Y'")->result();
//                     foreach($Cities as $city){
//                         $updateUndefaultvariant = array(
//                             'product_id'=> $productID,
//                             'city_id'=> $city->id,
//                             'retail_price'=>$retail_price,
//                             'price'=>$price,
//                             'cost_price'=>$cost_price,
//                             'unit_value'=>$unit_value,
//                             'unit'=>$unit,
//                             'stock_count'=>$stock_count,
//                             'cost_price'=>$cost_price,
//                             'is_default'=>$default_variant
//                         );
//                         $this->home_m->insert_data('products_variant',$updateUndefaultvariant);
//                     }

//                         //     $Cities = $this->db->query("select * from city where status='Y'")->result();
//                         //     foreach($Cities as $city){
//                         //      $updateUndefaultvariant = array(
//                         //         'product_id'=> $productID,
//                         //         'city_id'=> $city->id,
//                         //         'retail_price'=>$retail_price,
//                         //         'price'=>$price,
//                         //         'cost_price'=>$cost_price,
//                         //         'unit_value'=>$unit_value,
//                         //         'unit'=>$unit,
//                         //         'stock_count'=>$stock_count,
//                         //         'cost_price'=>$cost_price,
//                         //         'is_default'=>$default_variant
//                         //     );
//                         //   $this->home_m->insert_data('products_variant',$updateUndefaultvariant);
//                         // }

//                 }

//             }
//         }
//     }
// }
// redirect(base_url("products"));
// }

public function products_bulk_import()
{
        //echo "ok"; exit;
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
                $description = $row['product_description'];
                $categoryID = $row['category_id'];
                $cost_price = $row['cost_price'];
                $price = $row['selling_price'];
                $retail_price = $row['mrp'];
                $unit_value = $row['unit_value'];
                $unit = $row['unit'];
                $stock_count = $row['stock_count'];
                $default_variant = $row['default_variant'];
                $city_id = $row['city_id'];
                $check = $this->home_m->get_single_row_where('products',array('productID'=>$productID));
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
                       $this->home_m->update_data('products',array('productID'=>$productID),$update_data);

                   }else{
                    $check1 = $this->home_m->get_single_row_where('products_variant',array('product_id'=>$productID, 'unit_value'=>$unit_value, 'unit'=>$unit,'city_id'=>$city_id));
                    $update_variant = array(
                        'product_id'=>$productID,
                        'city_id'=>$city_id,
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
                       $Cities = $this->db->query("select * from city where status='Y'")->result();
                       foreach($Cities as $city){
                        $updateUndefaultvariant = array(
                            'product_id'=> $productID,
                            'city_id'=> $city->id,
                            'retail_price'=>$retail_price,
                            'price'=>$price,
                            'cost_price'=>$cost_price,
                            'unit_value'=>$unit_value,
                            'unit'=>$unit,
                            'stock_count'=>$stock_count,
                            'cost_price'=>$cost_price,
                            'is_default'=>$default_variant
                        );
                        $this->home_m->insert_data('products_variant',$updateUndefaultvariant);
                    }
                }

            }


        } else{
            if($default_variant==1 && $city_id==0){
                $data = array(
                    'productID'=>$productID,
                    'product_name'=>$product_name,
                    'product_description'=>$description,
                    'use'=>'',
                    'benefit'=>'',
                    'storage'=>'',
                    'product_image'=>'',
                    'category_id'=>$categoryID,
                    'brand_id'=>'',
                    'in_stock'=>'Y',
                    'stock_count'=>$stock_count,
                    'price'=>$price,
                    'cost_price'=>$cost_price,
                    'retail_price'=>$retail_price,
                    'unit_value'=>$unit_value,
                    'unit'=>$unit,
                    'featured'=>'',
                    'vegtype'=>'V',
                );
                $p_id = $this->home_m->insert_data('products', $data);
                if($p_id){
                    $Cities = $this->db->query("select * from city where status='Y'")->result();
                    foreach($Cities as $city){
                        $insert_variant = array(
                            'product_id'=> $p_id,
                            'city_id'=> $city->id,
                            'retail_price'=>$retail_price,
                            'price'=>$price,
                            'cost_price'=>$cost_price,
                            'unit_value'=>$unit_value,
                            'unit'=>$unit,
                            'stock_count'=>$stock_count,
                            'cost_price'=>$cost_price,
                            'is_default'=>$default_variant
                        );
                        $this->home_m->insert_data('products_variant',$insert_variant);
                    }

                }

            }else{
                if($city_id==0){
                    $Cities = $this->db->query("select * from city where status='Y'")->result();
                    foreach($Cities as $city){
                        $updateUndefaultvariant = array(
                            'product_id'=> $productID,
                            'city_id'=> $city->id,
                            'retail_price'=>$retail_price,
                            'price'=>$price,
                            'cost_price'=>$cost_price,
                            'unit_value'=>$unit_value,
                            'unit'=>$unit,
                            'stock_count'=>$stock_count,
                            'cost_price'=>$cost_price,
                            'is_default'=>$default_variant
                        );
                        $this->home_m->insert_data('products_variant',$updateUndefaultvariant);
                    }
                }
            }

        }
    }
}
}
redirect(base_url("products"));
}


public function add()
{
    $this->_check_auth();
    if ($_POST && $_FILES){
        $actual_image_name = '';
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
            $productId = $this->home_m->insert_data('products',$insert_array);
        }
        if($productId > 0)
        {
                //add variant
            $insert_variant = array();
            $insert_variant['product_id'] = $productId;
            $insert_variant['retail_price'] =$this->input->post('retail_price');
            $insert_variant['price'] = $this->input->post('price');
            $insert_variant['unit_value'] = $this->input->post('unit_value');
            $insert_variant['unit'] = $this->input->post('unit');
            $insert_variant['weight'] = $this->input->post('weight');
            $insert_variant['stock_count'] = $this->input->post('stock_count');
            $insert_variant['cost_price'] = $this->input->post('cost_price');
            $insert_variant['is_default'] = 1;
            $insert_variant['in_stock'] = $this->input->post('in_stock');
                //echo $insert_variant['stock_count']; exit;
            copy($target_path . $actual_image_name, "uploads/variants/". $actual_image_name);
            $insert_variant['variant_image'] = $actual_image_name;
            $this->city_wise_variant_price($productId,$insert_array['retail_price'],$insert_variant['price'], $insert_variant['unit_value'], $insert_variant['unit'],$insert_variant['stock_count'],$insert_array['cost_price'],$insert_variant['is_default'],$insert_variant['in_stock'],$insert_variant['variant_image'],$insert_array['vegtype'], $insert_variant['weight']);
        }
            //echo $this->db->last_query(); exit;
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
    //city wise variants
public function city_wise_variant_price($productID,$retail_price,$price,$unit_value,$unit,$stock_count,$cost_price,$is_default,$in_stock,$variantImage,$vegtype,$weight)
{
        //echo "pricedd".$price; exit;
    $cities = $this->db->get_where('city',array('status'=>'Y'))->result();
    foreach($cities as $c)
    {
        $a = array(
            'product_id' => $productID,
            'city_id' => $c->id,
            'retail_price' => $retail_price,
            'price' => $price,
            'unit_value' => $unit_value,
            'unit' => $unit,
            'weight' => $weight,
            'stock_count' => $stock_count,
            'cost_price' => $cost_price,
            'is_default' => $is_default,
            'in_stock' => $in_stock,
            'variant_image' => $variantImage,
            'vegtype' => $vegtype,
            'status' => 'Y',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('products_variant',$a);
    }
        //echo $this->db->last_query(); exit;
    return true;
}

    //add variant details
public function add_variant_detail()
{

    $variantID =  $this->uri->segment(3);
    
    if ($_POST){
        // var_dump($_POST);
        // exit;
             //echo "ok"; exit;
        $product_id=$this->input->post('products_id');
                //echo  $product_id; exit;
        $insert['product_id']=$product_id;
        $counter=$this->input->post('counter');
                //echo $counter; exit;
        for($i=0; $i<=$counter;$i++) {
            $city_id=$this->input->post('city_id'.$i);
            $is_default =$this->input->post('is_default'.$i);
            $variantID =$this->input->post('variantID'.$i);
            $insert['city_id']=$city_id;
            $retail_price =$this->input->post('retail_price'.$i);
            $price=$this->input->post('price'.$i);
            $stock_count=$this->input->post('stock_count'.$i);
                    //echo $stock_count; exit;
            $cost_price=$this->input->post('cost_price'.$i);
            $unit_value=$this->input->post('unit_value'.$i);
            $unit=$this->input->post('unit'.$i);
            $status=$this->input->post('status'.$i);
            $insert['retail_price']=$retail_price;
            $insert['price']=$price;
            $insert['stock_count']=$stock_count;
            $insert['unit_value']=$unit_value;
            $insert['unit']=$unit;
            $insert['status']=$status;
            $check_s = $this->home_m->get_all_row_where('products_variant',array('city_id'=>$city_id,'product_id'=>$product_id,'id'=>$variantID));
            if(!empty($check_s)){
             foreach($check_s as $check){
                $insert['updated_at'] = date("Y-m-d H:i:s");
                $this->home_m->update_data('products_variant',array('city_id'=>$city_id,'product_id'=>$product_id),$insert);
                        // echo $this->db->last_query(); die(); exit();
            }


        }elseif($retail_price !='' && $price !='' && $stock_count !='' && $cost_price !=''){
            $insert['updated_at'] = date("Y-m-d H:i:s");
            $insert['created_at'] = date("Y-m-d H:i:s");
            $this->home_m->insert_data('products_variant',$insert);
        }
    }
    redirect(base_url("products"));
}else{
    $this->data['city'] = $this->home_m->get_all_row_where('city',array('status'=>'Y'));
    $this->data['product'] = $this->home_m->get_all_row_where('products_variant',array());
    $this->data['v_id'] = $variantID;
    $this->data['sub_view'] = 'products/variant_detail';
    $this->data['title'] = 'Locality Wise Product Price';
    $this->load->view("_layout",$this->data);
}
}


public function add_detail()
{
        //$this->_check_auth();

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


        $this->db->where(array('product_id'=>$productID));
        $this->db->update('products_variant',array('status'=>$in_stock));
    }
    redirect(base_url("products"));
}

    //variant
public function var_active_inactive()
{
    if ($_POST)
    {
        $variantID = $_POST['variantID'];
        $in_stock = $_POST['in_stock'];
        $this->db->where(array('id'=>$variantID));
        $this->db->update('products_variant',array('in_stock'=>$in_stock));

    }
    redirect(base_url("products"));
}
    // public function stockupdate()
    // {
    //     if ($_POST)
    //     {
    //         $productID = $_POST['productID'];
    //         $stock_count = $_POST['stock_count'];
    //         $this->db->where(array('id'=>$productID));
    //         $this->db->update('products_detail',array('stock_count'=>$stock_count));
    //     }
    //     redirect(base_url("products"));
    // }

    //variant stock variant
public function var_stockupdate()
{
    if ($_POST)
    {
        $variantID = $_POST['variantID'];
        $stockCount = $_POST['stockCount'];
        $this->db->where(array('id'=>$variantID));
        $this->db->update('products_variant',array('stock_count'=>$stockCount));
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
        $product = $this->home_m->get_single_table("select * from products where productID='$product_id'");
        $vegtype = $product->vegtype;
        $insert_array = array();
        $insert_array['product_id'] = $product_id;
        $insert_array['retail_price'] =$this->input->post('retail_price');
        $insert_array['price'] = $this->input->post('price');
        $insert_array['unit_value'] = $this->input->post('unit_value');
        $insert_array['unit'] = $this->input->post('unit');
        $insert_array['stock_count'] = $this->input->post('stock_count');
        $insert_array['cost_price'] = $this->input->post('cost_price');
        $insert_array['in_stock'] = $this->input->post('in_stock');
        if (!empty($_FILES['product_image']['name'])){
            $target_path = 'uploads/variants/';
            $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
            $actual_image_name = 'product'. time() . "." . $extension;
            move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
            $insert_array['variant_image'] = $actual_image_name;
        }
        $this->city_wise_variant_price($product_id,$insert_array['retail_price'],$this->input->post('price'),$this->input->post('unit_value'), $this->input->post('unit'),$this->input->post('stock_count'),$this->input->post('cost_price'),$is_default=0, $this->input->post('in_stock'),$actual_image_name,$vegtype);
                 //echo $this->db->last_query(); exit;
        redirect(base_url("products"));
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
        $insert_array['in_stock'] = $this->input->post('in_stock');
        if (!empty($_FILES['product_image']['name'])){
            $target_path = 'uploads/variants/';
            $extension = substr(strrchr($_FILES['product_image']['name'], '.'), 1);
            $actual_image_name = 'product'. time() . "." . $extension;
            move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_path . $actual_image_name);
            $insert_array['variant_image'] = $actual_image_name;
        }else{
            $insert_array['variant_image'] = $this->input->post('hidden_image');
        }
        //update image for all cities
        $updateImg = $insert_array['variant_image'];
        if(!empty($imagesUpdate)){
            $variantData = $this->db->query("select * from products_variant where id='$id'")->row();
            $update_img  = array(
                'variant_image' => $updateImg 
            );
            $this->home_m->update_data('products_variant',array('product_id'=>$variantData->product_id,'unit_value'=>$variantData->unit_value,'unit'=>$variantData->unit),$update_img);
        }
        $vid = $this->home_m->update_data('products_variant',array('id'=>$id),$insert_array);
                //echo $this->db->last_query();
        if($vid){
            $getData = $this->db->query("select * from products_variant where id='$id' and is_default='1'")->row();
            if(!empty($getData)){
                        //echo $getData->product_id; exit;
                $this->db->where(array('productID'=>$getData->product_id));
                $this->db->update('products',array('cost_price'=>$this->input->post('cost_price'),'price'=>$this->input->post('price'),'retail_price'=>$this->input->post('retail_price')));
            }
            redirect(base_url("products"));
        }       
    }else{
        $single_variant = $this->db->query("SELECT * FROM `products_variant` WHERE `id` =".$id)->row();
        $this->data['single_variant'] =  $single_variant;
        $this->data['sub_view'] = 'products/update_variant';
        $this->data['title'] = 'Update Variants';
        $this->load->view("_layout",$this->data);
    }
}

    //show all variants
public function all_variants($p_id=''){ 
    $all_variants = $this->db->query("SELECT * FROM `products_variant` WHERE `product_id` =".$p_id)->result();
    foreach ($all_variants as $value) {
        $value->cityName = $this->get_cityName($value->city_id); 
    }
    $this->data['all_variants'] = $all_variants;
    $this->data['sub_view'] = 'products/all_variants';
    $this->data['title'] = 'All variants';
    $this->load->view("_layout",$this->data);
}

    //get city name
public function get_cityName($cityID){
    $city  =   $this->db->query("select * from city where id='$cityID'")->row(); 
    return $city->title;
}

   // update_singleVarinat
    //get city name
public function update_singleVarinat(){
  $variantID =  $_POST['variantID'];
  if(!empty($variantID)){
      $updateVariant = array(
        'retail_price' =>$_POST['retail_price'], 
        'price' =>$_POST['price'], 
        'stock_count' =>$_POST['stock_count'], 
        'unit_value' =>$_POST['unit_value'], 
        'unit' =>$_POST['unit'],
        'in_stock' =>$_POST['in_stock']
    );

      $this->db->where(array('id'=>$variantID));
      $this->db->update('products_variant',$updateVariant);
      echo "success";

  }

}
public function update_singleVarinat1()
{
   $v_id =  $_POST['v_id'];
   $data_Variant = array(
    'retail_price'            => $this->input->post('retail_price[]'),
    'price'     => $this->input->post('price[]'),
    'stock_count' => $this->input->post('stock_count[]'),
    'unit_value'       => $this->input->post('unit_value[]'),
    'unit1'       => $this->input->post('unit1[]'),
    'weight'       => $this->input->post('weight[]'),
    'in_stock'       => $this->input->post('in_stock[]'),
    'variantID'  => $this->input->post('variantID[]'),
);
  // print_r($data_Variant);exit();

   foreach ($data_Variant['retail_price'] as $key => $data) {
     $info = array( 'retail_price' => isset($data_Variant['retail_price'][$key])? $data_Variant['retail_price'][$key] : '',
       'price' => isset($data_Variant['price'][$key])? $data_Variant['price'][$key] : '',
       'stock_count' => isset($data_Variant['stock_count'][$key])? $data_Variant['stock_count'][$key] : '',
       'unit_value' => isset($data_Variant['unit_value'][$key])? $data_Variant['unit_value'][$key] : '',
       'unit' => isset($data_Variant['unit1'][$key])? $data_Variant['unit1'][$key] : '',
       'weight' => isset($data_Variant['weight'][$key])? $data_Variant['weight'][$key] : '',
       'in_stock' => isset($data_Variant['in_stock'][$key])? $data_Variant['in_stock'][$key] : '',
   );
     $data_Variant['variantID'][$key];
  //print_r($info);
     $this->db->where(array('id'=>$data_Variant['variantID'][$key]));
     $this->db->update('products_variant',$info);
//echo  $this->db->last_query(); exit();

 }
 redirect('products/add_variant_detail/'.$v_id);
}
}