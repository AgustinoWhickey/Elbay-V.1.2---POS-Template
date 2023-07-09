<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ItemMenu extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
	}
	
	public function index()
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 		= 'Item Manajemen';
		$data['user'] 		= $user;
		$data['items'] 		= $getData->data->items;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("product/item_menu/index",$data);
		$this->load->view("templates/footer");
	
	}

	public function input()
	{
		$image = '';
		if(isset($_FILES['image'])) {
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/upload/items';
			$config['file_name'] = 'img-'.$this->input->post('name');

			$this->load->library('upload',$config);
			if($this->upload->do_upload('image')){
				$image = $this->upload->data('file_name');
			} 
		}

		$data = [
			'name' => htmlspecialchars($this->input->post('name',true)),
			'unit' => htmlspecialchars($this->input->post('unit',true)),
			'unit_price' => htmlspecialchars($this->input->post('unit_price',true)),
			'stock' => htmlspecialchars($this->input->post('stock',true)),
			'image' => $image,
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu', $data);
	}

	public function edit($id_item)
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu?email='.$this->session->userdata('email').'&id='.$id_item.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data->items;

		echo json_encode($data);
		
	}

	public function edit_menu_item($id)
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/menuitem?email='.$this->session->userdata('email').'&id='.$id.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data->items;

		echo json_encode($data);
		
	}

	public function delete()
	{
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu/'.$this->input->post('id'), $data);

		if($this->input->post('gambar') != '') {
			unlink('./assets/img/upload/items/'.$this->input->post('gambar'));
		}

	}

	public function update()
	{
		$image = $this->input->post('image');

		if(isset($_FILES['image'])) {
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/upload/items';
			$config['file_name'] = 'img-'.$this->input->post('name');

			$this->load->library('upload',$config);
			$fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			if($image != ''){
				unlink('./assets/img/upload/items/img-'.$this->input->post('name').'.'.$fileExt);
			}
			if($this->upload->do_upload('image')){
				$image = $this->upload->data('file_name');
			}
		}

		$data = [
			'id' => $this->input->post('id'),
			'name' => htmlspecialchars($this->input->post('name',true)),
			'unit' => htmlspecialchars($this->input->post('unit',true)),
			'unit_price' => htmlspecialchars($this->input->post('unit_price',true)),
			'stock' => htmlspecialchars($this->input->post('stock',true)),
			'image' => $image,
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu', $data);
	}

}
