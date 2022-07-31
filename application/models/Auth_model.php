<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function login()
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get('pengguna')->row();
	}

	public function getEmail($emal)
	{
		$this->db->where('email', $email);
		return $this->db->get('tbl_user');
	}

}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */