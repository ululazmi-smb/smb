<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class paket_perusahaan_model extends CI_Model {

	private $table = 'tbl_paket_perusahaan';
	public function read($perusahaan)
	{
		$this->db->where('id_perusahaan', $perusahaan);
		$this->db->where('status', "aktif");
		return $this->db->get($this->table);
	}
}

/* End of file Pengguna_model.php */
/* Location: ./application/models/Pengguna_model.php */