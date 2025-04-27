<?php


class Stock extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_check_auth();
    }

    private function _check_auth(){
        if($this->session->userdata('role') != 'admin'){
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $this->data['list'] = $this->db->query("SELECT * FROM `stock`")->result();
        $this->data['sub_view'] = 'stock/list';
        $this->data['title'] = 'Stock';
        $this->load->view("_layout",$this->data);
    }

    public function add()
    {
        $this->data['products'] = $this->db->query("SELECT `product_name`,`unit` FROM `products` GROUP BY `product_name`")->result();
        $this->data['sub_view'] = 'stock/add';
        $this->data['title'] = 'Add Stock';
        $this->load->view("_layout",$this->data);
    }

    public function store()
    {
        if ($_POST)
        {
            $product_name = $_POST['product'];
            $unit = $_POST['unit'];
            $value = $_POST['value'];
            $unit_price = $_POST['unit_price'];
            $update = false;
            $check = $this->db->query("SELECT * FROM `stock` WHERE `product` = '$product_name'")->row();
            if (!empty($check))
            {
                $old_stock = $check->value;
                $new_stock = $old_stock;
                $new_unit_price = $unit_price;
                if ($check->unit == $unit)
                {
                    $update = true;
                    $new_stock = $value + $old_stock;
                }elseif ($unit == 'kg' && $check->unit == 'gm')
                {
                    $update = true;
                    $new_stock = ($value * 1000) + $old_stock;
                    $new_unit_price = $unit_price / 1000;
                }elseif ($unit == 'gm' && $check->unit == 'kg')
                {
                    $update = true;
                    $new_stock = ($value / 1000) + $old_stock;
                    $new_unit_price = $unit_price * 1000;
                }
                if ($update === true)
                {
                    $update_array = array(
                        'cost_price'=>$new_unit_price,
                        'last_price'=>$new_unit_price,
                        'value'=>$new_stock,
                        'updated_at'=>date("Y-m-d H:i:s")
                    );
                    $this->db->where(array('id'=>$check->id));
                    $this->db->update('stock',$update_array);
                }

            }else{
                $update = true;
                $insert_array = array(
                    'product'=>$product_name,
                    'unit'=>$unit,
                    'cost_price'=>$unit_price,
                    'last_price'=>$unit_price,
                    'value'=>$value,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                );
                $this->db->insert('stock',$insert_array);
            }
            if ($update === true)
            {
                $stock_txn = array(
                    'product'=>$product_name,
                    'unit'=>$unit,
                    'value'=>$value,
                    'price'=>$unit_price,
                    'status'=>'in',
                    'reason'=>'Stock Added',
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                );
                $this->db->insert('stock_txn',$stock_txn);
            }
        }
        if (!empty($_POST['redirect_url']))
        {
            redirect($_POST['redirect_url']);
        }
        redirect('stock');
    }

    public function remove()
    {
        $this->data['products'] = $this->db->query("SELECT `product_name`,`unit` FROM `products` GROUP BY `product_name`")->result();
        $this->data['sub_view'] = 'stock/remove';
        $this->data['title'] = 'Add Stock';
        $this->load->view("_layout",$this->data);
    }

    public function update()
    {
        if ($_POST)
        {
            $product_name = $_POST['product'];
            $unit = $_POST['unit'];
            $value = $_POST['value'];
            $reason = $_POST['reason'];
            $unit_price = $_POST['unit_price'];
            $update = false;
            $check = $this->db->query("SELECT * FROM `stock` WHERE `product` = '$product_name'")->row();
            if (!empty($check))
            {
                $old_stock = $check->value;
                $new_stock = $old_stock;
                if ($check->unit == $unit)
                {
                    $update = true;
                    $new_stock = $old_stock - $value;
                }elseif ($unit == 'kg' && $check->unit == 'gm')
                {
                    $update = true;
                    $new_stock = $old_stock - ($value * 1000);
                }elseif ($unit == 'gm' && $check->unit == 'kg')
                {
                    $update = true;
                    $new_stock = $old_stock - ($value / 1000);
                }
                if ($update === true)
                {
                    $update_array = array(
                        'value'=>$new_stock,
                        'updated_at'=>date("Y-m-d H:i:s")
                    );
                    $this->db->where(array('id'=>$check->id));
                    $this->db->update('stock',$update_array);
                }

            }
            if ($update === true)
            {
                $stock_txn = array(
                    'product'=>$product_name,
                    'unit'=>$unit,
                    'value'=>$value,
                    'status'=>'out',
                    'reason'=>$reason,
                    'price'=>$unit_price,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                );
                $this->db->insert('stock_txn',$stock_txn);
            }
        }
        if (!empty($_POST['redirect_url']))
        {
            redirect($_POST['redirect_url']);
        }
        redirect('stock');
    }

}