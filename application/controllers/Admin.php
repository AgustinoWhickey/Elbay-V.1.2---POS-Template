<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
	}
	
	public function index(){
		$status = $this->input->get('status');

		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/admin?email='.$this->session->userdata('email').'&status='.$status.'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['chart'] = $getData->data->sales->chart;
		$data['chart2'] = $getData->data->sales->chart2;
		$data['chart_year'] = $getData->data->sales->chart_year;
		$data['user'] 	= $user;
		$data['total_penjualan'] = $getData->data->sales->total_penjualan_bulan_ini;
		$data['total_item_terjual'] = $getData->data->sales->total_item_terjual_bulan_ini;
		$data['total_pengeluaran'] = $getData->data->sales->total_pengeluaran_bulan_ini;
		$data['title'] 	= 'Dashboard';
		
		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("admin/index",$data);
		$this->load->view("templates/footer_dashboard",$data);
	}

}
