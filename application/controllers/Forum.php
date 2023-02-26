<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Forum_model','forum');
		$this->load->library('form_validation');
	}

	public function index()
	{
		if(isset($_SESSION['logged_in']))
		{
			$data['judul'] 			= 'Forum Mahasiswa';
			$data['topik'] 			= $this->forum->getAllForumTopik();
			$data['allkategori'] 	= $this->forum->getAllForumKategori();
			$data['kategori'] 		= $this->forum->getKategoriTopik();
			$data['tanggapan'] 		= $this->forum->getTanggapanTopik();

			$this->load->view('templates/head',$data);
			$this->load->view('forum/index',$data);
			$this->load->view('templates/footer');
		}
	}

	public function tambah_tanggapan()
	{
		$data = [
			'id_user' => 1,
			'id_topik' => $this->input->post('topikid'),
			'isi_tanggapan' => $this->input->post('tanggapan'),
			'tgl_tanggapan' => date('Y-m-d h:i:sa',strtotime('now')),
		];
		$this->db->insert('data_forum_tanggapan',$data);
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Comment telah Ditambahkan!</div>');
		redirect('forum');
	}

}
