<?php

/**

 * Created by PhpStorm.

 * User: kshit

 * Date: 2019-05-13

 * Time: 11:37:15

 */



class Coupons extends CI_Controller

{

    function __construct() {

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

        $this->data['offers'] = $this->home_m->get_all_row_where_join ('offers',array(),$join,$select);

        $this->data['sub_view'] = 'coupons/list';

        $this->data['title'] = 'Coupons';

        $this->load->view("_layout",$this->data);

        

    }



    public function add()

    {

        if ($_POST){

            $insert_array = $_POST;

            $insert_array['offer_code'] = strtoupper($_POST['offer_code']);
            //$insert_array['offer_type'] = $this->input->post('offer_type');

            $insert_array['added_on'] = date("Y-m-d H:i:s");

            $check = $this->home_m->get_single_row_where('offers',array('offer_code'=>$_POST['offer_code']),$select='*');

            if (empty($check)){

                $this->home_m->insert_data('offers',$insert_array);
                //echo $this->db->last_query(); exit;

                redirect(base_url("coupons"));

            }else{

                $this->data['error'] = 'Coupon code Already Exist';

                $this->data['sub_view'] = 'coupons/add';

                $this->data['title'] = 'Add Coupons';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $this->data['sub_view'] = 'coupons/add';

            $this->data['title'] = 'Add Coupons';

            $this->load->view("_layout",$this->data);

        }

    }



    public function edit($param1 = '')

    {

        if ($param1 != ''){

            if ($_POST){

                $update_array = $_POST;
                $update_array['offer_type'] = $this->input->post('offer_type');

                $this->home_m->update_data('offers',array('offerID'=>$param1),$update_array);

                redirect(base_url("coupons"));

            }else{

                $join = array();

                $this->data['offers'] = $this->home_m->get_single_row_where_join ('offers',array('offerID'=>$param1),$join);

                $this->data['sub_view'] = 'coupons/edit';

                $this->data['title'] = 'Edit Product';

                $this->load->view("_layout",$this->data);

            }

        }else{

            $this->index();

        }

    }

}