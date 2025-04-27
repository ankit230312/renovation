<?php
/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:38:27
 */

class Login extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->_check_auth();
        $this->load->model("login_m");
    }
    private function _check_auth(){
        if($this->session->userdata('name')){
            redirect(base_url("home"));
        }
    }
    public function index()
    {
        if ($_POST){
            $username = trim($this->input->post('username'));
            $password = trim($this->input->post('password'));
            if ($username == '' || $password == ''){
                $this->data['error'] = 'Please fill all the fields';
                $this->data['title'] = 'Login';
                $this->load->view("login/index",$this->data);
            }else{
                $check = $this->login_m->check_user($username,$password);
                if ($check){
                    redirect(base_url("home"));
                }else{
                    $this->data['error'] = 'Username or Password Incorrect';
                    $this->data['title'] = 'Login';
                    $this->load->view("login/index",$this->data);
                }
            }
        }else{
            $this->data['title'] = 'Login';
            $this->load->view("login/index",$this->data);
        }
    }
}