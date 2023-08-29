<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
		parent::__construct();
		is_logged_in();
	}
	
	public function index() {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/category?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 			= 'Kategori Manajemen';
		$data['user'] 			= $user;
		$data['categories'] 	= $getData->data->categories;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("product/category/index",$data);
		$this->load->view("templates/footer");
	
	}

	public function input() {
		$data = [
			'nama' => $this->input->post('nama'),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/category', $data);
	}

	public function edit($id_category) {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/category?email='.$this->session->userdata('email').'&id='.$id_category.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data->categories;

		echo json_encode($data);
	}

	public function update() {
		$data = [
			'category_id' => $this->input->post('category_id'),
			'nama' => htmlspecialchars($this->input->post('nama',true)),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/category', $data);
	}

	public function delete() {
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/category/'.$this->input->post('id'), $data);

	}

}
