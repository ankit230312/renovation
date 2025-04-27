<?php

/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:38:27
 */

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_check_auth();
        $this->load->model("login_m");
    }
    private function _check_auth()
    {
        if ($this->session->userdata('name')) {
            redirect(base_url("home"));
        }
    }
    public function index()
    {
        if ($_POST) {
            $username = trim($this->input->post('username'));
            $password = trim($this->input->post('password'));
            $mobile = trim($this->input->post('mobile'));
            $otp = trim($this->input->post('otp_'));
    
            // First, validate OTP
            $verify = $this->db->get_where('admin', array('mobile' => $mobile, 'otp' => $otp))->row();
           
            if (empty($verify)) {
                // OTP not valid, show error and return
                $this->data['error'] = 'OTP not verified';
                $this->data['title'] = 'Login';
                $this->load->view("login/index", $this->data);
                return; // Ensure the execution stops here
            }
    
            // Now, check for empty fields
            if ($username == '' || $password == '') {
                $this->data['error'] = 'Please fill all the fields';
                $this->data['title'] = 'Login';
                $this->load->view("login/index", $this->data);
                return; // Ensure the execution stops here
            } 
    
            // Now, perform the login check
            $check = $this->login_m->check_user($username, $password, $otp);
            if ($check) {
                redirect(base_url("home"));
            } else {
                $this->data['error'] = 'Username or Password Incorrect';
                $this->data['title'] = 'Login';
                $this->load->view("login/index", $this->data);
                return; // Ensure the execution stops here
            }
        } else {
            // Initial page load when no POST data is available
            $this->data['title'] = 'Login';
            $this->load->view("login/index", $this->data);
        }
    }
    

    public function send_otp()
    {
        $mobile = $this->input->post('mobile');

        
        $otp = "1234";

        // Update the user record with the OTP (assuming you have a users table)
        $this->db->where('mobile', $mobile);
        $this->db->update('admin', ['otp' => $otp]);

        
        $response = array('result' => 'success', 'message' => 'OTP sent successfully');
        echo json_encode($response);
    }
}
