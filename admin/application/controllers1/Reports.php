<?php


class Reports extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_check_auth();
        $this->load->model("home_m");
    }

    private function _check_auth()
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $delivery_date = date("Y-m-d");
        if (isset($_GET['delivery_date']) && $_GET['delivery_date'] != '')
        {
            $delivery_date = date("Y-m-d",strtotime($_GET['delivery_date']));
        }
        $where = "WHERE orders.delivery_date = '$delivery_date'";
        if (isset($_GET['status']) && $_GET['status'] != '')
        {
            $status = $_GET['status'];
            $where .= " AND orders.status = '$status' AND order_items.status = '$status'";
        }else{
            $where .= " AND orders.status != 'CANCEL' AND order_items.status != 'CANCEL'";
        }
        if (isset($_GET['apartment']) && $_GET['apartment'] != '')
        {
            $apartment = $_GET['apartment'];
            $where .= " AND orders.appartment = '$apartment'";
        }
        if (isset($_GET['cat']) && $_GET['cat'] != '')
        {
            $cat = $_GET['cat'];
            $sub_cat_array = array();
            $sub_cat = $this->db->query("SELECT `categoryID` FROM `category` WHERE `parent` = $cat AND `status`='Y'")->result();
            foreach ($sub_cat as $sub)
            {
                $sub_cat_array[] = 'FIND_IN_SET('.$sub->categoryID.',`category_id`)';
            }
            $where .= " AND (".implode('OR ',$sub_cat_array).')';
        }
        $group_by = " GROUP BY order_items.productID";
        $sql = "SELECT products.productID,products.product_name,products.category_id,products.weight,products.unit,products.unit_value,SUM(order_items.qty) as qty,SUM(order_items.net_price) as net_price FROM `order_items` LEFT JOIN orders ON order_items.orderID = orders.orderID LEFT JOIN products ON order_items.productID = products.productID ";
        $orders = $this->db->query($sql.$where.$group_by)->result();
        foreach ($orders as $o)
        {
            $o->main_category_name = $this->get_product_main_category_name($o->category_id);
        }
        $this->data['apartments'] = $this->db->query("SELECT `appartment` as apartment FROM `appartment` WHERE `status` = 'Y'")->result();
        $this->data['orders'] = $orders;
        $main_cat = $this->db->query("SELECT `categoryID`,`title` FROM `category` WHERE `parent` = 0 AND `status` = 'Y'")->result();
        $this->data['categories'] = $main_cat;
        $this->data['sub_view'] = 'reports/product_order';
        $this->data['title'] = 'Product Order Report';
        $this->load->view("_layout", $this->data);
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

    public function sales_report()
    {
        $start_date = date("Y-m-d");
        $end_date = date("Y-m-d");
        $apartmentID = 0;
        if ($_POST)
        {
            if (!empty($_POST['start_date']))
            {
                $start_date = date("Y-m-d",strtotime($_POST['start_date']));
            }
            if (!empty($_POST['end_date']))
            {
                $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            }
            $apartmentID = $_POST['apartmentID'];
        }
        $orders = $this->db->query("")->result();
        $data['apartmentID'] = $apartmentID;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['apartments'] = $this->db->query("SELECT `ID`,`appartment` FROM `appartment` WHERE `status` = 'Y'")->result();
    }
    public function transactions()
    {
        $this->data['transactions'] = $this->db->query("SELECT * FROM `transactions`")->result();
        $this->data['sub_view'] = 'transaction/history';
        $this->data['title'] = 'Transactions Reports';
        $this->load->view("_layout", $this->data);
    }
}