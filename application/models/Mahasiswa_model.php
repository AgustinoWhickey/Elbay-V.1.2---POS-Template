<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
    public function getAllMahasiswa()
    {
    	$query = $this->db->get('mahasiswa');
    	return $query->result_array();
    }

    public function tambahDataMahasiswa()
    {
    	$data = [
    		'nama'            => $this->input->post('nama',true),
    		'nim'             => $this->input->post('nrp',true),
            'email'           => $this->input->post('email',true),
    		'tanggal_lahir'   => $this->input->post('tgllahir'),
    		'jurusan'         => $this->input->post('jurusan'),
    	];

    	$this->db->insert('mahasiswa',$data);
    }

    public function hapusDataMahasiswa($nim)
    {
    	$this->db->where('nim',$nim);
    	$this->db->delete('mahasiswa');
    }

    public function getMahasiswaById($nim)
    {
    	return $this->db->get_where('mahasiswa',['nim'=>$nim])->row_array();
    }

    public function cariDataMahasiswa()
    {
    	$keyword = $this->input->post('keyword');
    	$this->db->like('nama',$keyword);
    	$this->db->or_like('nim',$keyword);
    	$this->db->or_like('email',$keyword);
    	return $this->db->get('mahasiswa')->result_array();
    }

    public function ubahDataMahasiswa()
    {
    	$data = [
    		'nama'    => $this->input->post('nama',true),
    		'nim'     => $this->input->post('nrp',true),
    		'email'   => $this->input->post('email',true),
    		'jurusan' => $this->input->post('jurusan'),
    	];

    	$this->db->where('nim',$this->input->post('nrp'));
    	$this->db->update('mahasiswa',$data);
    }

}
