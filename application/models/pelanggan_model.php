<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pelanggan_model extends CI_Model {

	private $table = 'tbl_pelanggan';
	public function read($perusahaan)
	{
		$this->db->where('id_perusahaan', $perusahaan);
		return $this->db->get($this->table);
	}

	
}

/* End of file Pengguna_model.php */
/* Location: ./application/models/Pengguna_model.php */