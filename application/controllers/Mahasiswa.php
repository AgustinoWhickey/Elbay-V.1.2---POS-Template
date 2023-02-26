<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Mahasiswa_model');
		$this->load->model('Jurusan_model');
		$this->load->library('form_validation');
	}
	
	public function index(){
		if(isset($_SESSION['logged_in']))
		{
			$data['judul'] 	= 'Halaman Mahasiswa';
			$data['mahasiswa'] = $this->Mahasiswa_model->getAllMahasiswa();

			if($this->input->post('keyword')){
				$data['mahasiswa'] = $this->Mahasiswa_model->cariDataMahasiswa();
			}

			$this->load->view("templates/head",$data);
			$this->load->view("mahasiswa/index",$data);
			$this->load->view("templates/footer");

		} else {
			$this->load->view("login");
		}
	
	}

	public function tambah(){
		$data['judul'] = 'Form Tambah Data Mahasiswa';
		$data['jurusan'] 	= $this->Jurusan_model->getAllJurusan();

		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('nrp','NRP','required|numeric');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('tgllahir','Tanggal Lahir','required');

		if($this->form_validation->run()==FALSE){
			$this->load->view('templates/head',$data);
			$this->load->view('mahasiswa/tambah',$data);
			$this->load->view('templates/footer');
		}else{
			$this->Mahasiswa_model->tambahDataMahasiswa();
			$this->session->set_flashdata('flash', 'Ditambahkan');
			redirect('mahasiswa');
		}
	}

	public function hapus($nim){
		$this->Mahasiswa_model->hapusDataMahasiswa($nim);
		$this->session->set_flashdata('flash','Berhasil Dihapus');
		redirect('mahasiswa');
	}

	public function detail($nim){
		$data['judul'] 	= 'Detail Data Mahasiswa';
		$data['mahasiswa'] 	= $this->Mahasiswa_model->getMahasiswaById($nim);
		$this->load->view('templates/head',$data);
		$this->load->view('mahasiswa/detail',$data);
		$this->load->view('templates/footer');
	}

	public function edit($nim){
		$data['judul'] 		= 'Form Ubah Data Mahasiswa';
		$data['mahasiswa'] 	= $this->Mahasiswa_model->getMahasiswaById($nim);
		$data['jurusan'] 	= $this->Jurusan_model->getAllJurusan();

		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('nrp','NRP','required|numeric');
		$this->form_validation->set_rules('email','Email','required|valid_email');

		if($this->form_validation->run()==FALSE){
			$this->load->view('templates/head',$data);
			$this->load->view('mahasiswa/edit',$data);
			$this->load->view('templates/footer');
		}else{
			$this->Mahasiswa_model->ubahDataMahasiswa();
			$this->session->set_flashdata('flash', 'Diubah');
			redirect('mahasiswa');
		}
	}

	public function album()
	{
		$data['judul'] 		= 'Album Mahasiswa';

		$albumpath 		= realpath(index_page()).'\assets\images';
		$albumpath_url 	= base_url().'assets/images/';

		$files = scandir($albumpath);
		$files = array_diff($files, array('.','..','/'));
		$images = array();

		foreach ($files as $value) {
			$images [] = array(
				'url' => $albumpath_url.$value,
				'thumb_url' => $albumpath_url.$value,
			);
		}

		$data['images'] = $images;

		$this->load->view('templates/head',$data);
		$this->load->view('mahasiswa/album',$data);
		$this->load->view('templates/footer');
	}

}
