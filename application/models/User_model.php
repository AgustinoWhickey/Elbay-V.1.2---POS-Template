<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function getUsers()
    {
        return $this->db->get('user')->result();
    }

    public function insertuser($data)
    {
        $aksi = $this->db->insert('user', $data);
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }
	
	public function deleteuser($id)
    {
        if (empty($id)) {
            echo 2;
        } else {
			$aksi = $this->db->where('id_user', $id)->delete('user');
			if ($aksi) {
				echo 1;
			} else {
				echo 0;
			}
        }
    }
	
	public function updateuser($data)
	{
		$arr = [
			'nama_user' => $data['nama_user'],
			'role' => $data['role']
		];

		$this->db->update('user', $arr, ['id_user' => $data['iduser']]);

		return $this->db->affected_rows() == 1;
	
	}
	
	
	public function getUser($iduser)
    {
        $this->db->select('*');
        $this->db->where('id_user', $iduser);
        $aksi = $this->db->get('user')->result_array();
        return $aksi;
    }
}
