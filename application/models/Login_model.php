<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function ceklogin($user)
    {
        $this->db->select('*');
        $this->db->where('nama_user', $user);
        $aksi = $this->db->get('user')->result_array();
        return $aksi;
    }
}
