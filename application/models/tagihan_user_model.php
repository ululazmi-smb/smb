<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_user_model extends CI_Model {

	private $table = 'tbl_tagihan_user';
	public function read($perusahaan, $bulan = null, $tahun = null)
	{
		$data["id_perusahaan"] = $perusahaan;
		$data["bulan_tahun"] = $bulan.$tahun;
		$this->db->where($data);
		return $this->db->get($this->table);
	}

	public function insert($perusahaan, $data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function cek_tagihan($data)
	{
		return $this->db->get_where($this->table, $data);
	}
}

/* End of file Pengguna_model.php */
/* Location: ./application/models/Pengguna_model.php */