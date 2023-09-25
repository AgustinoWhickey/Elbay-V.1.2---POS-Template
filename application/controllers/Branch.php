<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct() {
		parent::__construct();
		is_logged_in();
	}
	
	public function index() {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/branch?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 			= 'Cabang Manajemen';
		$data['user'] 			= $user;
		$data['branches'] 		= $getData->data->branches;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("branch/index",$data);
		$this->load->view("templates/footer");
	
	}

	public function input() {
		$data = [
			'name' => $this->input->post('nama'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'description' => $this->input->post('description'),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/branch', $data);
	}

	public function edit($id_branch) {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/branch?email='.$this->session->userdata('email').'&id='.$id_branch.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data->branch;

		echo json_encode($data);
	}

	public function update() {
		$data = [
			'branch_id' => $this->input->post('branch_id'),
			'name' => $this->input->post('nama'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'description' => $this->input->post('description'),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/branch', $data);
	}

	public function delete() {
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/branch/'.$this->input->post('id'), $data);

	}

}
