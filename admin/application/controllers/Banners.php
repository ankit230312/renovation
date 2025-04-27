<?php

/**

 * Created by PhpStorm.

 * User: kshit

 * Date: 2019-05-13

 * Time: 11:37:15

 */



class Banners extends CI_Controller

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

        $this->app_banners();

    }



    public function app_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                $this->home_m->update_data('app_banners',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/app_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('app_banners',array('bannerID'=>$param2),$join);

                $this->data['category'] = $this->home_m->get_all_row_where('category',array('parent'=>'0'),$select='*');
                $this->data['all_subcategory'] = $this->db->query("select categoryID,title from category where parent!='0'")->result();
                 $this->data['all_deal'] = $this->db->query("select dealID,productID from deals")->result();
                $this->data['all_products'] = $this->db->query("select productID,product_name from products")->result();

                $this->data['sub_view'] = 'banners/app/edit';

                $this->data['title'] = 'Edit App Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    $this->home_m->insert_data('app_banners',$insert_array);

                }

                redirect(base_url("banners/app_banners"));

            }else{

                $this->data['category'] = $this->home_m->get_all_row_where('category',array(),$select='*');

                $this->data['sub_view'] = 'banners/app/add';

                $this->data['title'] = 'Add App Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'app_banners.*,category.title as category';

            $join = array();

            $join[] = array(

                'table'=>'category',

                'parameter'=>'app_banners.categoryID = category.categoryID',

                'position'=>'LEFT'

            );

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('app_banners',array(),$join,$select);

            $this->data['sub_view'] = 'banners/app/list';

            $this->data['title'] = 'App Banners';

            $this->load->view("_layout",$this->data);

        }

    }

  

  public function web_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/web_banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                $this->home_m->update_data('web_banners',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/web_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('web_banners',array('bannerID'=>$param2),$join);

                $this->data['category'] = $this->home_m->get_all_row_where('category',array(),$select='*');

                $this->data['sub_view'] = 'banners/web/edit';

                $this->data['title'] = 'Edit Web Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/web_banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    $this->home_m->insert_data('web_banners',$insert_array);

                }

                redirect(base_url("banners/web_banners"));

            }else{

                $this->data['category'] = $this->home_m->get_all_row_where('category',array(),$select='*');

                $this->data['sub_view'] = 'banners/web/add';

                $this->data['title'] = 'Add Web Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'web_banners.*,category.title as category';

            $join = array();

            $join[] = array(

                'table'=>'category',

                'parameter'=>'web_banners.categoryID = category.categoryID',

                'position'=>'LEFT'

            );

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('web_banners',array(),$join,$select);

            $this->data['sub_view'] = 'banners/web/list';

            $this->data['title'] = 'Web Banners';

            $this->load->view("_layout",$this->data);

        }

    }





    public function featured_prod_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                $this->home_m->update_data('featured_banner',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/featured_prod_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('featured_banner',array('bannerID'=>$param2),$join);

                $select = 'products.productID,products.product_name';

                $this->data['products'] = $this->home_m->get_all_row_where('products',array(),$select);

                $this->data['sub_view'] = 'banners/products/edit';

                $this->data['title'] = 'Edit Featured Product Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    $this->home_m->insert_data('featured_banner',$insert_array);

                }

                redirect(base_url("banners/featured_prod_banners"));

            }else{

                $select = 'products.productID,products.product_name';

                $this->data['products'] = $this->home_m->get_all_row_where('products',array(),$select);

                $this->data['sub_view'] = 'banners/products/add';

                $this->data['title'] = 'Add Featured Product Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'featured_banner.*,products.product_name';

            $join = array();

            $join[] = array(

                'table'=>'products',

                'parameter'=>'featured_banner.productID = products.productID',

                'position'=>'LEFT'

            );

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('featured_banner',array(),$join,$select);

            $this->data['sub_view'] = 'banners/products/list';

            $this->data['title'] = 'Featured Product Banners';

            $this->load->view("_layout",$this->data);

        }

    }



    public function gift_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                if ($update_array['status'] == 'Y'){

                    $this->home_m->update_data('gift_banner',array(),array('status'=>'N'));

                }

                $this->home_m->update_data('gift_banner',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/gift_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('gift_banner',array('bannerID'=>$param2),$join);

                $this->data['sub_view'] = 'banners/gift/edit';

                $this->data['title'] = 'Edit Gift Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    if ($insert_array['status'] == 'Y'){

                        $this->home_m->update_data('gift_banner',array(),array('status'=>'N'));

                    }

                    $this->home_m->insert_data('gift_banner',$insert_array);

                }

                redirect(base_url("banners/gift_banners"));

            }else{

                $this->data['sub_view'] = 'banners/gift/add';

                $this->data['title'] = 'Add Gift Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'gift_banner.*';

            $join = array();

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('gift_banner',array(),$join,$select);

            $this->data['sub_view'] = 'banners/gift/list';

            $this->data['title'] = 'Gift Banners';

            $this->load->view("_layout",$this->data);

        }

    }



    public function new_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                // if ($update_array['status'] == 'Y'){

                //     $this->home_m->update_data('new_banner',array(),array('status'=>'N'));

                // }

                $this->home_m->update_data('new_banner',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/new_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('new_banner',array('bannerID'=>$param2),$join);

                $this->data['sub_view'] = 'banners/new/edit';

                $this->data['title'] = 'Edit New Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    // if ($insert_array['status'] == 'Y'){

                    //     $this->home_m->update_data('new_banner',array(),array('status'=>'N'));

                    // }

                    $this->home_m->insert_data('new_banner',$insert_array);

                }

                redirect(base_url("banners/new_banners"));

            }else{

                $this->data['sub_view'] = 'banners/new/add';

                $this->data['title'] = 'Add New Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'new_banner.*';

            $join = array();

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('new_banner',array(),$join,$select);

            $this->data['sub_view'] = 'banners/new/list';

            $this->data['title'] = 'New Banners';

            $this->load->view("_layout",$this->data);

        }

    }



    public function deal_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                if ($update_array['status'] == 'Y'){

                    $this->home_m->update_data('deal_banner',array(),array('status'=>'N'));

                }

                $this->home_m->update_data('deal_banner',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/deal_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('deal_banner',array('bannerID'=>$param2),$join);

                $this->data['sub_view'] = 'banners/deal/edit';

                $this->data['title'] = 'Edit Deal Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    if ($insert_array['status'] == 'Y'){

                        $this->home_m->update_data('deal_banner',array(),array('status'=>'N'));

                    }

                    $this->home_m->insert_data('deal_banner',$insert_array);

                }

                redirect(base_url("banners/deal_banners"));

            }else{

                $this->data['sub_view'] = 'banners/deal/add';

                $this->data['title'] = 'Add Deal Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'deal_banner.*';

            $join = array();

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('deal_banner',array(),$join,$select);

            $this->data['sub_view'] = 'banners/deal/list';

            $this->data['title'] = 'Deal Banners';

            $this->load->view("_layout",$this->data);

        }

    }

    //get category and products
    public function get_categoryProducts()
    {
        $data = '';
        $type = $_POST['type'];
        if($type=='category'){
            $this->db->select('categoryID,title');
            $data = $this->db->get_where('category',array('parent'=>0))->result();

        }elseif($type=='subcategory'){
            $this->db->select('categoryID,title');
            $data = $this->db->get_where('category',array('parent!='=>0))->result();

        }elseif($type=='deal'){
            $this->db->select('dealID,productID');
            $data = $this->db->get_where('deals',array('status='=>'Y'))->result();

        }
        else{
            $this->db->select('productID,product_name');
            $data = $this->db->get_where('products',array())->result();
        }
        echo json_encode($data);
    }


     public function web_other_banners($param1='',$param2='')

    {

        if ($param1 == 'edit' && $param2 != ''){

            if ($_POST){

                $update_array = $_POST;

                $update_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/other_banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $update_array['banner'] = $actual_image_name;

                }

                $this->home_m->update_data('web_other_banners',array('bannerID'=>$param2),$update_array);

                redirect(base_url("banners/web_other_banners"));

            }else{

                $join = array();

                $this->data['banners'] = $this->home_m->get_single_row_where_join ('web_other_banners',array('bannerID'=>$param2),$join);

                $this->data['category'] = $this->home_m->get_all_row_where('category',array(),$select='*');

                $this->data['sub_view'] = 'banners/other/edit';

                $this->data['title'] = 'Edit Other Web  Banners';

                $this->load->view("_layout",$this->data);

            }

        }elseif ($param1 == 'add'){

            if ($_POST && $_FILES){

                $insert_array = $_POST;

                $insert_array['added_on'] = date("Y-m-d H:i:s");

                $insert_array['updated_on'] = date("Y-m-d H:i:s");

                if (!empty($_FILES['banner']['name'])){

                    $target_path = 'uploads/banners/other_banners/';

                    $extension = substr(strrchr($_FILES['banner']['name'], '.'), 1);

                    $actual_image_name = 'banner'. time() . "." . $extension;

                    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_path . $actual_image_name);

                    $insert_array['banner'] = $actual_image_name;

                    $this->home_m->insert_data('web_other_banners',$insert_array);

                }

                redirect(base_url("banners/web_other_banners"));

            }else{

                $this->data['category'] = $this->home_m->get_all_row_where('category',array(),$select='*');

                $this->data['sub_view'] = 'banners/other/add';

                $this->data['title'] = 'Add Other Web Banners';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $select = 'web_other_banners.*,category.title as category';

            $join = array();

            $join[] = array(

                'table'=>'category',

                'parameter'=>'web_other_banners.categoryID = category.categoryID',

                'position'=>'LEFT'

            );

            $this->data['banners'] = $this->home_m->get_all_row_where_join ('web_other_banners',array(),$join,$select);

            $this->data['sub_view'] = 'banners/other/list';

            $this->data['title'] = 'Other Web Banners';

            $this->load->view("_layout",$this->data);

        }

    }



}