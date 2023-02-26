<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Peoples extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Peoples_model');
		$this->load->library('pagination');
		$this->load->library('form_validation');
	}
	
	public function index(){
		if(isset($_SESSION['logged_in']))
		{
			if($this->input->post('submit')){
				$data['keyword'] = $this->input->post('keyword');
				$this->session->set_userdata('keyword',$data['keyword']);
			}else{
				$data['keyword'] = $this->session->userdata('keyword');

			}

			// $config['total_rows']		= $this->Peoples_model->countAllPeoples();
			$this->db->like('name',$data['keyword']);
			$this->db->from('peoples');
			$config['total_rows'] 		= $this->db->count_all_results();
			$config['per_page']			= 12;

			$this->pagination->initialize($config);

			$data['judul'] 			= 'Halaman Peoples';
			$data['total_rows'] 	= $config['total_rows'];
			$data['peoples'] 		= $this->Peoples_model->getAllPeoples();
			$data['start']			= $this->uri->segment(3);
			$data['people'] 		= $this->Peoples_model->getPeople($config['per_page'],$data['start'],$data['keyword']);

			$this->load->view("templates/head",$data);
			$this->load->view("peoples/index",$data);
			$this->load->view("templates/footer");

		} else {
			$this->load->view("login");
		}
	
	}

}
