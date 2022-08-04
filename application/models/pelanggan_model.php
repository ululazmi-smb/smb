<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pelanggan_model extends CI_Model {

	private $table = 'tbl_pelanggan';
	public function read($perusahaan)
	{
		$this->db->where('id_perusahaan', $perusahaan);
		return $this->db->get($this->table);
	}

	public function read_pelanggan_by_id($id, $perusahaan)
	{
		$this->db->where(array('id_perusahaan' => $perusahaan, "id_pelanggan" => $id));
		return $this->db->get($this->table);
	}

	public function read_nomor_tagihan($perusahaan)
	{
		$id = $this->db->select_max('id_pelanggan');
		$id = $this->db->where(array("id_perusahaan" => $perusahaan));
    	$id = $this->db->get($this->table)->row();
		$ds = $this->db->select('nomor_tagihan');
		$ds = $this->db->where(array("id_pelanggan" => $id->id_pelanggan));
		$ds = $this->db->get($this->table);
		return $ds;
	}

	public function add_pelanggan($data, $perusahaan)
	{
		$sql = $this->db->insert($this->table, $data);
		return $sql;
	}
	
	public function edit_pelanggan($data, $id, $perusahaan)
	{
		return $this->db->update($this->table, $data, array("id_perusahaan" => $perusahaan, "id_pelanggan" => $id));
	}
}

/* End of file Pengguna_model.php */
/* Location: ./application/models/Pengguna_model.php */