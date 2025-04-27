<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Basket extends CI_Controller
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
            $products = $this->db->query("SELECT products.*,brand.brand FROM `products` LEFT JOIN brand ON products.brand_id = brand.brandID WHERE `in_stock` = 'Y' AND ($where)")->result();
        }else{
            $select = 'products.*,brand.brand';
            $join = array();
            $join[] = array(
                'table'=>'brand',
                'parameter'=>'products.brand_id = brand.brandID',
                'position'=>'LEFT'
            );
            $where = array('in_stock'=>'Y');
            $products = $this->home_m->get_all_row_where_join ('products',$where,$join,$select);
        }

        foreach ($products as $p)
        {
            $p->category_name = $this->get_product_category_name($p->category_id);
            $p->main_category_name = $this->get_product_main_category_name($p->category_id);
            $p->ordered_count = $this->get_ordered_stock($p->productID);
        }
        $main_cat = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
        $this->data['categories'] = $main_cat;
        $this->data['products'] = $products;
        $this->data['sub_view'] = 'basket/list';
        $this->data['title'] = 'Basket';
        $this->load->view("_layout",$this->data);
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

    private function get_ordered_stock($productID)
    {
        $ordered = $this->db->query("SELECT sum(`qty`)as count FROM `order_items` WHERE `productID` = $productID")->row();
        return $ordered->count;
    }

}