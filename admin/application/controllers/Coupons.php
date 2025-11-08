<?php

/**

 * Created by PhpStorm.

 * User: kshit

 * Date: 2019-05-13

 * Time: 11:37:15

 */



class Coupons extends CI_Controller

{

    function __construct()
    {

        parent::__construct();

        //$this->_check_auth();

        $this->load->model("home_m");
    }



    /* private function _check_auth(){

        if($this->session->userdata('role') != 'admin' ){

            $this->session->sess_destroy();

            redirect(base_url("login"));

        }

    }

*/

    public function index()
    {
        // Select desired columns
        $this->db->select('
        offers.*,
        GROUP_CONCAT(DISTINCT products_item.product_name SEPARATOR ", ") AS product_names
    ');
        $this->db->from('offers');

        // Join offer_products and products_item
        $this->db->join('offer_products', 'offer_products.offer_id = offers.offerID', 'left');
        $this->db->join('products_item', 'products_item.productID = offer_products.product_id', 'left');

        // Group by offerID to avoid duplicate rows (since one offer can have many products)
        $this->db->group_by('offers.offerID');

        // Execute query
        $query = $this->db->get();
        $this->data['offers'] = $query->result();

        // Page setup
        $this->data['sub_view'] = 'coupons/list';
        $this->data['title'] = 'Coupons';
        $this->load->view('_layout', $this->data);
    }




    public function add()
    {
        if ($_POST) {
            // Prepare data for the 'offers' table
            $insert_array = [
                'offer_code'       => strtoupper($this->input->post('offer_code')),
                'offer_type'       => $this->input->post('offer_type'),
                'offer_value'      => $this->input->post('offer_value'),
                'description'      => $this->input->post('description'),
                'terms'            => $this->input->post('terms'),
                'min_cart_value'   => $this->input->post('min_cart_value'),
                'max_discount'     => $this->input->post('max_discount'),
                'allowed_user_times' => $this->input->post('allowed_user_times'),
                'start_date'       => $this->input->post('start_date'),
                'end_date'         => $this->input->post('end_date'),
                'apply_on'         => $this->input->post('apply_on'),
                'is_active'        => $this->input->post('is_active'),
                'added_on'         => date("Y-m-d H:i:s")
            ];

            // Check if coupon code already exists
            $check = $this->home_m->get_single_row_where('offers', ['offer_code' => $insert_array['offer_code']]);

            if (empty($check)) {
                // Insert into offers table
                $offer_id = $this->home_m->insert_data('offers', $insert_array);

                // If the discount applies to specific products, insert into mapping table
                $apply_on = $this->input->post('apply_on');
                $product_ids = $this->input->post('product_ids'); // This is an array

                if ($apply_on === 'ITEM' && !empty($product_ids) && is_array($product_ids)) {
                    foreach ($product_ids as $pid) {
                        $this->home_m->insert_data('offer_products', [
                            'offer_id'   => $offer_id,
                            'product_id' => $pid
                        ]);
                    }
                }

                // Redirect after successful insert
                redirect(base_url("coupons"));
            } else {
                // Coupon already exists
                $this->data['error'] = 'Coupon code Already Exist';
                $this->data['sub_view'] = 'coupons/add';
                $this->data['title'] = 'Add Coupons';
                $this->load->view("_layout", $this->data);
            }
        } else {
            // Fetch only active products for dropdown
            $this->data['products'] = $this->home_m->get_all_row_where(
                'products_item',
                ['status' => 'active'],
                '*'
            );

            $this->data['sub_view'] = 'coupons/add';
            $this->data['title'] = 'Add Coupons';
            $this->load->view("_layout", $this->data);
        }
    }






    public function edit($param1 = '')

    {

        if ($param1 != '') {

            if ($_POST) {

                $update_array = $_POST;
                $update_array['offer_type'] = $this->input->post('offer_type');

                $this->home_m->update_data('offers', array('offerID' => $param1), $update_array);

                redirect(base_url("coupons"));
            } else {

                $join = array();

                $this->data['offers'] = $this->home_m->get_single_row_where_join('offers', array('offerID' => $param1), $join);

                $this->data['sub_view'] = 'coupons/edit';

                $this->data['title'] = 'Edit Product';

                $this->load->view("_layout", $this->data);
            }
        } else {

            $this->index();
        }
    }


    public function delete($param1 = '')
    {
        if ($param1 != '') {
            // Delete from offers table
            $this->home_m->delete_data('offers', array('offerID' => $param1));

            // Also delete related entries from offer_products table
            $this->home_m->delete_data('offer_products', array('offer_id' => $param1));

            redirect(base_url("coupons"));
        } else {
            $this->index();
        }
    }
}
