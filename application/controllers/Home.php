<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index($nama=''){
		if(isset($_SESSION['logged_in']))
		{
			$data['judul'] 	= 'Halaman Home';
			$data['nama'] 	= $nama;
			$this->load->view("templates/head",$data);
			$this->load->view("home/index",$data);
			$this->load->view("templates/footer");

		} else {
			$this->load->view("login");
		}
	
	}

}
