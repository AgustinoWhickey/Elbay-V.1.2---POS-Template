<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("register_model","form");
    }

    public function index()
    {
        $this->load->view("register");
    }

    public function insertregister()
    {
		$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		$data = array(
            'password' => $password,
            'nama_user' => $_POST['username']
        );
        $aksi = $this->form->insertregister($data);
		echo $aksi;
    }
}
