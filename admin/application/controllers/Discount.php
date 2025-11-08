<?php

/**

 * Created by PhpStorm.

 * User: kshit

 * Date: 2019-05-13

 * Time: 11:37:15

 */



class Discount extends CI_Controller

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



        $select = 'offers.*';

        $join = array();

        $this->data['offers'] = $this->home_m->get_all_row_where_join('offers', array(), $join, $select);

        $this->data['sub_view'] = 'coupons/list';

        $this->data['title'] = 'Coupons';

        $this->load->view("_layout", $this->data);
    }



    public function add()
    {

        if ($_POST) {

            $insert_array = $_POST;

            $insert_array['offer_code'] = strtoupper($_POST['offer_code']);
            //$insert_array['offer_type'] = $this->input->post('offer_type');

            $insert_array['added_on'] = date("Y-m-d H:i:s");

            $check = $this->home_m->get_single_row_where('offers', array('offer_code' => $_POST['offer_code']), $select = '*');

            if (empty($check)) {

                $this->home_m->insert_data('offers', $insert_array);
                //echo $this->db->last_query(); exit;

                redirect(base_url("coupons"));
            } else {

                $this->data['error'] = 'Coupon code Already Exist';

                $this->data['sub_view'] = 'coupons/add';

                $this->data['title'] = 'Add Coupons';

                $this->load->view("_layout", $this->data);
            }
        } else {

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

    public function booking_amount($param = '', $id = '')
    {
        $this->load->database();
        $this->load->helper(['form', 'url']);
        $this->load->library('session');

        // ADD Booking Amount
        if ($param == 'add') {

            if ($_POST) {
                $offer_type  = $this->input->post('offer_type');
                $offer_value = $this->input->post('offer_value');
                $is_active   = $this->input->post('is_active');

                if (empty($offer_type) || empty($offer_value)) {
                    $this->data['error'] = "Please fill all required fields.";
                } else {
                    $data = [
                        'offer_type'  => $offer_type,
                        'offer_value' => $offer_value,
                        'is_active'   => $is_active,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s')
                    ];

                    $this->db->insert('booking_amount', $data);
                    $this->session->set_flashdata('success', 'Booking amount added successfully!');
                    redirect(base_url('Discount/booking_amount'));
                    exit;
                }
            }

            $this->data['sub_view'] = 'booking_amount/add';
            $this->data['title'] = 'Add Booking Amount';
            $this->load->view("_layout", $this->data);
        }

        // EDIT Booking Amount
        elseif ($param == 'edit' && !empty($id)) {

            // Fetch existing record
            $this->data['booking'] = $this->db->get_where('booking_amount', ['id' => $id])->row_array();

            if (empty($this->data['booking'])) {
                show_404();
            }

            // When form submitted
            if ($_POST) {
                $offer_type  = $this->input->post('offer_type');
                $offer_value = $this->input->post('offer_value');
                $is_active   = $this->input->post('is_active');

                if (empty($offer_type) || empty($offer_value)) {
                    $this->data['error'] = "Please fill all required fields.";
                } else {
                    $data = [
                        'offer_type'  => $offer_type,
                        'offer_value' => $offer_value,
                        'is_active'   => $is_active,
                        'updated_at'  => date('Y-m-d H:i:s')
                    ];

                    $this->db->where('id', $id);
                    $this->db->update('booking_amount', $data);

                    $this->session->set_flashdata('success', 'Booking amount updated successfully!');
                    redirect(base_url('Discount/booking_amount'));
                    exit;
                }
            }

            $this->data['sub_view'] = 'booking_amount/edit';
            $this->data['title'] = 'Edit Booking Amount';
            $this->load->view("_layout", $this->data);
        }

        // LIST Booking Amount
        else {
            $this->db->order_by('id', 'DESC');
            $this->data['booking_amounts'] = $this->db->get('booking_amount')->result_array();

            $this->data['sub_view'] = 'booking_amount/list';
            $this->data['title'] = 'Booking Amount List';
            $this->load->view("_layout", $this->data);
        }

        if ($param == 'delete' && !empty($id)) {
            $this->db->where('id', $id)->delete('booking_amount');
            $this->session->set_flashdata('success', 'Booking amount deleted successfully!');
            redirect(base_url('Discount/booking_amount'));
            exit;
        }
    }
}
