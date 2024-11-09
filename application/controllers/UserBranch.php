<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserBranch extends CI_Controller {

	public function __construct() {
		parent::__construct();
		is_logged_in();
	}
	
	public function index() {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/userbranch?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 			= 'User Cabang Manajemen';
		$data['user'] 			= $user;
		$data['cabang'] 		= $getData->data->branches;
		$data['users'] 			= $getData->data->users;
		$data['userbranches'] 	= $getData->data->userbranches;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("user_branch/index",$data);
		$this->load->view("templates/footer");
	
	}

	public function input() {
		$data = [
			'cabang' => $this->input->post('cabang'),
			'user' => $this->input->post('user'),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/userbranch', $data);
	}

	public function edit($id_branch) {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/userbranch?email='.$this->session->userdata('email').'&id='.$id_branch.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data->userbranch;

		echo json_encode($data);
	}

	public function update() {
		$data = [
			'userbranch_id' => $this->input->post('userbranch_id'),
			'cabang' => $this->input->post('cabang'),
			'user' => $this->input->post('user'),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/userbranch', $data);
	}

	public function delete() {
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/userbranch/'.$this->input->post('id'), $data);

	}

}
