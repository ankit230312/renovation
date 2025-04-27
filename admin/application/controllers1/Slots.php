<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Slots extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->_check_auth();
        $this->load->model("home_m");
    }

    private function _check_auth(){
        if($this->session->userdata('role') != 'admin'){
            $this->session->sess_destroy();
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $this->load->model("time_model");
        $this->load->model("home_m");
        $timeslot = $this->time_model->get_time_slot();
        $this->load->library('form_validation');
        $counter=$this->input->post('counter');


        // print_r($this->input->post());
        // die;



            for($i=0; $i<=$counter;$i++) {
        $this->form_validation->set_rules('opening_time'.$i, 'Opening Hour', 'trim|required');
        $this->form_validation->set_rules('closing_time'.$i, 'Closing Hour', 'trim|required');
        }
        if ($this->form_validation->run() == FALSE)
        {
            if($this->form_validation->error_string()!="")
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                    <i class="fa fa-warning"></i>
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Warning!</strong> '.$this->form_validation->error_string().'
                </div>');
        }else{
            for($i=0; $i<=$counter;$i++) {
                $city_id=$this->input->post('city_id'.$i);
                $insert['city_id']=$city_id;
                $opening_time = date("H:i:s",strtotime($this->input->post('opening_time'.$i)));
                $closing_time = date("H:i:s",strtotime($this->input->post('closing_time'.$i)));
                $max_order = $this->input->post('max_order'.$i);
                $interval=$this->input->post('interval'.$i);
                $insert['opening_time']=$opening_time;
                $insert['closing_time']=$closing_time ;
                $insert['time_slot']=$interval;
                $insert['max_order']=$max_order;
                $check_s = $this->home_m->get_single_row_where('time_slots',array('city_id'=>$city_id));
                if(!empty($check_s)){
                    //echo "okkk";
                    $this->home_m->update_data('time_slots',array('city_id'=>$city_id),$insert);
                }elseif($opening_time !='' && $closing_time  !='' && $interval !=''){
                   // echo 'err';
                    $this->home_m->insert_data('time_slots',$insert);
                }
            }
            //die;
        }
        // $timeslot = $this->time_model->get_time_slot();
        // $this->data["schedule"] = $timeslot;
        $this->data["city"] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));
        $this->data["title"] = 'TIME SLOTS';
        $this->data["sub_view"] = "slots/index";
        $this->load->view('_layout', $this->data);
    }



}