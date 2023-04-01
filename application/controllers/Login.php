<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model","form");
    }

    public function index()
    {
      if(isset($_SESSION['logged_in'])){
        redirect('home');
      } else {
        $this->load->view("login");
      }
    }

    public function check_login(){
      $data = [
        'email' => $this->input->post('email'),
        'password' => $this->input->post('password'),
        'X-API-KEY' => 'restapi123'
      ];
      return send_api('http://localhost/Elbay/Elbay-V.1.2/api/login', $data);
    }

    public function logout()
    {
        unset($_SESSION);
        $this->session->sess_destroy();
        redirect('auth');	
    }
}
