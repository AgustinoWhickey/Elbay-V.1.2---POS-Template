<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

  	public function index() {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/user?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 		= 'Data User';
		$data['user'] 		= $user;
		$data['users'] 		= $getData->data->users;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("user/index",$data);
		$this->load->view("templates/footer");

	}

  	public function input() {
		$data = [
			'name' => htmlspecialchars($this->input->post('name',true)),
			'email' => htmlspecialchars($this->input->post('email',true)),
			'image' => 'default.jpg',
			'password' => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
			'role_id' =>  $this->input->post('role') ?? 3,
			'is_active' => $this->input->post('status'), // type 0 if you want to activate send email
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/user', $data);
	}

	public function edit($id_user)
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/user?email='.$this->session->userdata('email').'&id='.$id_user.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data;

		echo json_encode($data);
	}

	public function update()
	{
		$password = '';
		if($this->input->post('pass') != ''){
			$password = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);
		} else {
			$password = $this->input->post('oldpass');
		}
		$data = [
			'user_id' => $this->input->post('id'),
			'name' => htmlspecialchars($this->input->post('name',true)),
			'email' => htmlspecialchars($this->input->post('email',true)),
			'image' => 'default.jpg',
			'password' => $password,
			'role_id' =>  $this->input->post('role') ?? 3,
			'is_active' => $this->input->post('status'), // type 0 if you want to activate send email
			'X-API-KEY' => 'restapi123'
		];
	
		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/user', $data);
	}

  	public function delete() {
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/user/'.$this->input->post('id'), $data);

	}

}
