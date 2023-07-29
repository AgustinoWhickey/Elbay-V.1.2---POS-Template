<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller
{
  public function __construct()
  {
		parent::__construct();
		is_logged_in();
	}

  public function index()
	{
    $getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/supplier?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 		= 'Supplier Manajemen';
		$data['user'] 		= $user;
    $data['suppliers'] 	= $getData->data->suppliers;

		$this->load->view("templates/header",$data);
    $this->load->view("templates/sidebar",$data);
    $this->load->view("templates/topbar",$data);
    $this->load->view("supplier/index",$data);
    $this->load->view("templates/footer");
	
	}

  public function input()
	{
		$data = [
			'name' => htmlspecialchars($this->input->post('name',true)),
			'phone' => htmlspecialchars($this->input->post('telepon',true)),
			'address' => htmlspecialchars($this->input->post('address',true)),
			'description' => htmlspecialchars($this->input->post('deskripsi',true)),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/supplier', $data);
	}

  public function edit($id_supplier)
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/supplier?email='.$this->session->userdata('email').'&id='.$id_supplier.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data;

		echo json_encode($data);
	}

  public function update()
	{
		$data = [
			'supplier_id' => $this->input->post('id'),
      'name' => htmlspecialchars($this->input->post('name',true)),
      'phone' => htmlspecialchars($this->input->post('telepon',true)),
      'address' => htmlspecialchars($this->input->post('address',true)),
      'description' => htmlspecialchars($this->input->post('deskripsi',true)),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/supplier', $data);
	}

  public function delete()
	{
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/supplier/'.$this->input->post('id'), $data);

	}

}
