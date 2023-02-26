<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends CI_Model
{
    public function getAllForumTopik()
    {
    	$query = $this->db->get('data_forum_topik');
    	return $query->result_array();
    }

    public function getAllForumKategori(){
    	$query = $this->db->get('data_forum_kategori');
    	return $query->result_array();
    }

    public function getAllForumTanggapan(){
    	$query = $this->db->get('data_forum_tanggapan');
    	return $query->result_array();
    }

    public function getKategoriTopik()
    {
    	$this->db->select('*');
    	$this->db->from('data_forum_topik');
    	$this->db->join('data_forum_kategori','data_forum_kategori.id = data_forum_topik.id_kategori');
    	$query = $this->db->get();
    	return $query->result_array();
    }
}
