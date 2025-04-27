<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Schedule_hour extends CI_Controller
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
        $this->session->set_userdata(array("page"=>"delivery"));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('opening_time', 'Start Hour', 'trim|required');
        $this->form_validation->set_rules('closing_time', 'End Hour', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            if($this->form_validation->error_string()!="")
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
        }
        else
        {
            $array = array(
                "date"=>date("Y-m-d",strtotime($this->input->post("date"))),
                "from_time"=>date("H:i:s",strtotime($this->input->post("opening_time"))),
                "to_time"=>date("H:i:s",strtotime($this->input->post("closing_time")))
            );
            $this->db->insert("closing_hours",$array);
        }

        $this->load->model("time_model");
        $timeslot = $this->time_model->get_closing_date(date("Y-m-d"));
        $this->data["schedule"] = $timeslot;
        $this->data["title"] = 'Schedule Hour';
        $this->data["sub_view"] = "slots/closing_hours";
        $this->load->view('_layout', $this->data);
    }

    function delete_closing_date($id){
        $this->db->query("Delete from closing_hours where id = '".$id."'");
        redirect("schedule_hour");

    }

}