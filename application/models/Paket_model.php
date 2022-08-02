<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket_model extends CI_Model {

	private $table = 'tbl_paket_internet';
	public function read($perusahaan)
	{
		$this->db->where('id_perusahaan', $perusahaan);
		return $this->db->get($this->table);
	}

	public function get_paket($id, $id_perusahaan)
	{
		$this->db->where(array("id" => $id, "id_perusahaan" => $id_perusahaan));
		return $this->db->get($this->table);
	}

	public function add($nama, $harga, $id_perusahaan)
	{
		return $this->db->insert($this->table, array("nama" => $nama, "harga" => $harga, "id_perusahaan" => $id_perusahaan));
	}

	public function edit($id, $nama, $harga, $id_perusahaan)
	{
		return $this->db->update($this->table, array("nama" => $nama, "harga" => $harga), array("id" => $id));
	}
}

/* End of file Pengguna_model.php */
/* Location: ./application/models/Pengguna_model.php */