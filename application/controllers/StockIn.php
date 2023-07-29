<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stockin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

  	public function index() {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/stock?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 		= 'Stock In';
		$data['user'] 		= $user;
		$data['suppliers'] 	= $getData->data->suppliers;
		$data['items'] 	    = $getData->data->items;
		$data['stocks'] 	= $getData->data->stocks;
		$data['unititems'] 	= $getData->data->unititems;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("transaction/stockin/index",$data);
		$this->load->view("templates/footer");

	}

  	public function input() {
		$data = [
			'item_id' => htmlspecialchars($this->input->post('item',true)),
			'type' => 'in',
			'detail' => htmlspecialchars($this->input->post('detail',true)),
			'supplier_id' => htmlspecialchars($this->input->post('supplier',true)),
			'unit' => htmlspecialchars($this->input->post('unit_name',true)),
			'unit_qty' => htmlspecialchars($this->input->post('qty_unit',true)),
			'unit_price' => htmlspecialchars($this->input->post('qty_price',true)),
			'item_qty' => htmlspecialchars($this->input->post('qty_item',true)),
			'user_id' => $this->session->userdata('user_id'),
			'date' => strtotime($this->input->post('tanggal')),
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/stock', $data);
	}

  	public function delete() {
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/stock/'.$this->input->post('id'), $data);

	}

}
