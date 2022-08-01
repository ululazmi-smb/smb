<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function login()
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get('pengguna')->row();
	}

	public function getEmail($email)
	{
		$this->db->where('email', $email);
		return $this->db->get('tbl_user');
	}

	public function key($key)
	{
		$sql = $this->db->get_where("tbl_key", array("key_api" => $key));
		if($sql->num_rows() > 0)
		{
			return true;
		} else {
			return false;
		}
	}

}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */