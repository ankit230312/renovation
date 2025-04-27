<?php


class Stock extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_check_auth();
        $this->load->model('home_m');
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
        $this->data['list'] = $this->db->query("SELECT * FROM `stock`")->result();
        $this->data['sub_view'] = 'stock/list';
        $this->data['title'] = 'Stock';
        $this->load->view("_layout", $this->data);
    }

    // public function add()
    // {
    //     $this->data['products'] = $this->db->query("SELECT `product_name`,`unit` FROM `products` GROUP BY `product_name`")->result();
    //     if ($_POST) {


    //         $insert_array = $_POST;
    //         $insert_array['unit'] = strtoupper($_POST['unit']);
    //         $insert_array['added_on'] = date("Y-m-d H:i:s");
    //         $insert_array['updated_on'] = date("Y-m-d H:i:s");
    //         $id = 0;

    //         //add variant


    //         $insert_array['product'] = $this->input->post('product');
    //         $insert_array['unit'] = $this->input->post('unit');
    //         $insert_array['value'] = $this->input->post('value');
    //         $insert_array['cost_price'] = $this->input->post('cost_price');
    //         $insert_array['last_price'] = $this->input->post('last_price');
    //         $stockID = $this->home_m->insert_data('stock', $insert_array);
    //         print_r($stockID);
    //         die();


    //         //echo $this->db->last_query(); exit;
    //         redirect(base_url("stock"));
    //     } else {
    //         $this->data['stock'] = $this->home_m->get_all_table_query('SELECT * FROM `stock`');
    //         $this->data['sub_view'] = 'stock/add';
    //         $this->data['title'] = 'Add Stock';
    //         $this->load->view("_layout", $this->data);
    //     }
    //     $this->data['sub_view'] = 'stock/add';
    //     $this->data['title'] = 'Add Stock';
    //     $this->load->view("_layout", $this->data);
    // }
    public function add()
    {
        $this->data['products'] = $this->db->query("SELECT `product_name`,`unit` FROM `products` GROUP BY `product_name`")->result();
        if ($_POST) {
            $insert_array = $_POST;
            $insert_array['product'] = $this->input->post('product');
            $insert_array['unit'] = $this->input->post('unit');
            $insert_array['value'] = $this->input->post('value');
            $insert_array['cost_price'] = $this->input->post('cost_price');
            $insert_array['last_price'] = $this->input->post('last_price');
          

            $stockID = $this->home_m->insert_data('stock', $insert_array);

            if ($stockID) {
                // Data inserted successfully
                redirect(base_url("stock"));
            } else {
                // There was an error
                $error = $this->db->error();
                echo "Error: " . $error['message'];
            }
        } else {
            $this->data['stock'] = $this->home_m->get_all_table_query('SELECT * FROM `stock`');
            $this->data['sub_view'] = 'stock/add';
            $this->data['title'] = 'Add Stock';
            $this->load->view("_layout", $this->data);
        }
    }


    // public function add_()
    // {

    //     if ($_POST && $_FILES) {

    //         $insert_array = $_POST;


    //         $insert_array['unit'] = strtoupper($_POST['unit']);
    //         $insert_array['added_on'] = date("Y-m-d H:i:s");
    //         $insert_array['updated_on'] = date("Y-m-d H:i:s");
    //         $id = 0;

    //         //add variant
    //         $insert_variant = array();

    //         $insert_variant['retail_price'] = $this->input->post('retail_price');
    //         $insert_variant['price'] = $this->input->post('price');
    //         $insert_variant['unit_value'] = $this->input->post('unit_value');
    //         $insert_variant['unit'] = $this->input->post('unit');
    //         $insert_variant['weight'] = $this->input->post('weight');
    //         $insert_variant['stock_count'] = $this->input->post('stock_count');
    //         $insert_variant['cost_price'] = $this->input->post('cost_price');
    //         $insert_variant['is_default'] = 1;
    //         $insert_variant['in_stock'] = $this->input->post('in_stock');


    //         //echo $this->db->last_query(); exit;
    //         redirect(base_url("stock"));
    //     } else {
    //         $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => 0), $select = 'categoryID,title');
    //         $this->data['sub_view'] = 'stock/add_';
    //         $this->data['title'] = 'Add Stock';
    //         $this->load->view("_layout", $this->data);
    //     }
    // }



    public function store()
    {
        if ($_POST) {
            $product_name = $_POST['product'];
            $unit = $_POST['unit'];
            $value = $_POST['value'];
            $unit_price = $_POST['unit_price'];
            $update = false;
            $check = $this->db->query("SELECT * FROM `stock` WHERE `product` = '$product_name'")->row();
            if (!empty($check)) {
                $old_stock = $check->value;
                $new_stock = $old_stock;
                $new_unit_price = $unit_price;
                if ($check->unit == $unit) {
                    $update = true;
                    $new_stock = $value + $old_stock;
                } elseif ($unit == 'kg' && $check->unit == 'gm') {
                    $update = true;
                    $new_stock = ($value * 1000) + $old_stock;
                    $new_unit_price = $unit_price / 1000;
                } elseif ($unit == 'gm' && $check->unit == 'kg') {
                    $update = true;
                    $new_stock = ($value / 1000) + $old_stock;
                    $new_unit_price = $unit_price * 1000;
                }
                if ($update === true) {
                    $update_array = array(
                        'cost_price' => $new_unit_price,
                        'last_price' => $new_unit_price,
                        'value' => $new_stock,
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->where(array('id' => $check->id));
                    $this->db->update('stock', $update_array);
                }
            } else {
                $update = true;
                $insert_array = array(
                    'product' => $product_name,
                    'unit' => $unit,
                    'cost_price' => $unit_price,
                    'last_price' => $unit_price,
                    'value' => $value,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('stock', $insert_array);
            }
            if ($update === true) {
                $stock_txn = array(
                    'product' => $product_name,
                    'unit' => $unit,
                    'value' => $value,
                    'price' => $unit_price,
                    'status' => 'in',
                    'reason' => 'Stock Added',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('stock_txn', $stock_txn);
            }
        }
        if (!empty($_POST['redirect_url'])) {
            redirect($_POST['redirect_url']);
        }
        redirect('stock');
    }

    public function remove()
    {
        $this->data['products'] = $this->db->query("SELECT `product_name`,`unit` FROM `products` GROUP BY `product_name`")->result();
        $this->data['sub_view'] = 'stock/remove';
        $this->data['title'] = 'Add Stock';
        $this->load->view("_layout", $this->data);
    }

    public function update()
    {
        if ($_POST) {
            $product_name = $_POST['product'];
            $unit = $_POST['unit'];
            $value = $_POST['value'];
            $reason = $_POST['reason'];
            $unit_price = $_POST['unit_price'];
            $update = false;
            $check = $this->db->query("SELECT * FROM `stock` WHERE `product` = '$product_name'")->row();
            if (!empty($check)) {
                $old_stock = $check->value;
                $new_stock = $old_stock;
                if ($check->unit == $unit) {
                    $update = true;
                    $new_stock = $old_stock - $value;
                } elseif ($unit == 'kg' && $check->unit == 'gm') {
                    $update = true;
                    $new_stock = $old_stock - ($value * 1000);
                } elseif ($unit == 'gm' && $check->unit == 'kg') {
                    $update = true;
                    $new_stock = $old_stock - ($value / 1000);
                }
                if ($update === true) {
                    $update_array = array(
                        'value' => $new_stock,
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->where(array('id' => $check->id));
                    $this->db->update('stock', $update_array);
                }
            }
            if ($update === true) {
                $stock_txn = array(
                    'product' => $product_name,
                    'unit' => $unit,
                    'value' => $value,
                    'status' => 'out',
                    'reason' => $reason,
                    'price' => $unit_price,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('stock_txn', $stock_txn);
            }
        }
        if (!empty($_POST['redirect_url'])) {
            redirect($_POST['redirect_url']);
        }
        redirect('stock');
    }
}
