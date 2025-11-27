<?php

/**
 * Created by PhpStorm.
 * User: kshit
 * Date: 2019-05-13
 * Time: 11:37:15
 */

class Contact extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->_check_auth();
        $this->load->model("home_m");
    }





    public function index()
    {
  $contact = $this->home_m->get_all_row_where ('contact_form',array(),'*');
        
         $this->data['contact'] = $contact;
        $this->data['sub_view'] = 'contact/list';
        $this->data['title'] = 'Contact List';
        $this->load->view("_layout", $this->data);
    }
}
