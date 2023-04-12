<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
      if(isset($_SESSION['logged_in'])){
        redirect('home');
      } else {
        $data['title'] 	= 'Admin Login Page';

			  $this->load->view("templates/auth_header",$data);
        $this->load->view("auth/login");
        $this->load->view("templates/auth_footer");
      }
    }

    public function check_login(){
      $data = [
        'email' => $this->input->post('email'),
        'password' => $this->input->post('password'),
        'X-API-KEY' => 'restapi123'
      ];

      api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/login', $data);
    }

    public function logout()
    {
        unset($_SESSION);
        $this->session->sess_destroy();
        redirect('auth');	
    }
}
