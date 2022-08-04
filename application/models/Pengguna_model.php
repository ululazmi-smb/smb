<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model {

	private $table = 'tb_user_pengguna';
	public function read($perusahaan)
	{
		$this->db->where('id_perusahaan', $perusahaan);
		return $this->db->get($this->table);
	}

	public function edit($id_perusahaan = null, $username = null, $password = null, $email = null, $id = null)
	{
		$data = array();
		if($username != null || $username != "")
		{
			$data["nama_user"] = $username;
		}
		if($password != null || $password != "")
		{
			$data["password"] = md5($password);
		}
		if($email != null || $email != "")
		{
			$data["username"] = $email;
		}
		return $this->db->update($this->table, $data, array("id_perusahaan" => $id_perusahaan, "id" => $id));
	}

	public function cek_email($email)
	{
		$this->db->where('username', $email);
		return $this->db->get($this->table);
	}

	public function read_user_pengguna_by_id($id, $perusahaan)
	{
		$this->db->where(array('id_perusahaan' => $perusahaan, "id_pelanggan" => $id));
		return $this->db->get($this->table);
	}

	public function add_pengguna($data)
	{
		$sql = $this->db->insert($this->table, $data);
		return $sql;
	}
}

/* End of file Pengguna_model.php */
/* Location: ./application/models/Pengguna_model.php */