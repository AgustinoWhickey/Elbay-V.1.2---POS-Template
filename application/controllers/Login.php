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

    public function ceklogin()
    {
		$aksi = $this->form->ceklogin($_POST['username']);
        if(password_verify($_POST['password'],$aksi[0]["password"])){
			$data = [
				'id' => $aksi[0]['id_user'],
				'username' => $aksi[0]['nama_user'],
				'role' => $aksi[0]['role'],
				'logged_in' => TRUE
			];
			$this->session->set_userdata($data);
			echo 1;
		} else {
			echo 0;
		}
    }

    public function logout()
    {
        unset($_SESSION);
		$this->session->sess_destroy();
		redirect('login');	
    }
}
