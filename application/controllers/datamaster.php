<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class datamaster extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('Auth_model');
		$this->load->model('paket_model');
		$this->load->model('pelanggan_model');
		$this->load->model('paket_perusahaan_model');
	}

	public function datapaket()
	{
		$this->load->view('datamaster_datapaket');
	}

	public function datapelanggan()
	{
		$this->load->view('datamaster_datapelanggan');
	}
	
	public function read()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->Auth_model->key($key) == false)
		{
			$data = array(
				"error" => "error",
				"messages" => "error auth api"
			);
			$pengguna = array(
				'data' => $data
			);
		} else {
			if($this->paket_model->read($perusahaan)->num_rows() > 0)
			{
				foreach ($this->paket_model->read($perusahaan)->result() as $pengguna) {
					$data[] = array(
						'paket' => $pengguna->nama,
						'harga' => $pengguna->harga,
						'action' => '<td align="center"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal" onclick="edit('."'".$pengguna->id."'".')">Edit</button><button class="btn btn-sm btn-danger" onclick="remove('."'".$pengguna->id."'".')">Delete</button></td>'
					);
				}
			} else {
				$data = array();
			}
			$pengguna = array(
				'data' => $data
			);
		}
		echo json_encode($pengguna);
	}

	public function add_user()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->Auth_model->key($key) == false)
		{
			$pengguna = array(
				"error" => "error",
				"messages" => "error auth api"
			);
		} else {
			$status = $this->input->post("status");
			if($status == "add")
			{
				if($this->paket_perusahaan_model->read($perusahaan)->num_rows() > 0)
				{

				} else {

				}
			}
		}
	}

	public function add_paket()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->Auth_model->key($key) == false)
		{
			$pengguna = array(
				"error" => "error",
				"messages" => "error auth api"
			);
		} else {
			$status = $this->input->post("status");
			$nama = $this->input->post("nama");
			$harga = $this->input->post("harga");
			if($this->paket_perusahaan_model->read($perusahaan)->num_rows() > 0)
			{
				if($status == "add")
				{
					if($this->paket_model->add($nama, $harga, $perusahaan))
					{
						$pengguna = array(
							"error" => "success",
							"messages" => "Berhasil Di tambahkan",
						);
					} else {
						$pengguna = array(
							"error" => "error",
							"messages" => "gagal menambahkan"
						);
					}
				} else if($status == "edit"){
					$id = $this->input->post("id");
					if($this->paket_model->edit($id,$nama, $harga, $perusahaan))
					{
						$pengguna = array(
							"error" => "success",
							"messages" => "Berhasil Di ubah",
						);
					} else {
						$pengguna = array(
							"error" => "error",
							"messages" => "gagal mengubah"
						);
					}
				} else {
					$pengguna = array(
						"error" => "error",
						"messages" => "no status"
					);
				}
			} else {
				$pengguna = array(
					"error" => "error",
					"messages" => "silahkan melakukan pendaftaran paket ke admin agar dapat menggunakan fitur ini"
				);
			}
		}
		echo json_encode($pengguna);
	}

	public function get_paket()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->Auth_model->key($key) == false)
		{
			$pengguna = array(
				"error" => "error",
				"messages" => "error auth api"
			);
		} else {
			$id = $this->input->post("id");
			if($this->paket_model->get_paket($id, $perusahaan)->num_rows() > 0)
			{
				$pengguna = array(
					"error" => "success",
					"messages" => "",
					"data" => array(
						"nama" => $this->paket_model->get_paket($id, $perusahaan)->row()->nama,
						"harga" => $this->paket_model->get_paket($id, $perusahaan)->row()->harga
					)
				);
			} else {
				$pengguna = array(
					"error" => "error",
					"messages" => "id tidak di temukan"
				);
			}
		}
		echo json_encode($pengguna);
	}

	public function read_pelanggan()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->Auth_model->key($key) == false)
		{
			$data = array(
				"error" => "error",
				"messages" => "error auth api"
			);
			$pengguna = array(
				'data' => $data
			);
		} else {
			if($this->pelanggan_model->read($perusahaan)->num_rows() > 0)
			{
				foreach ($this->pelanggan_model->read($perusahaan)->result() as $pengguna) {
					$data[] = array(
						'nama' => $pengguna->nama_pelanggan,
						'alamat' => $pengguna->alamat,
						'no_tlp' => $pengguna->no_telp,
						'tanggal_pemasangan' => $pengguna->tanggal_pemasangan,
						'jatuh_tempo' => $pengguna->jatuh_tempo,
						'pppoe' => $pengguna->akun_pppoe,
						'ip' => $pengguna->ip_address,
						'paket' => $pengguna->paket,
						'harga' => $pengguna->harga,
						'status' => $pengguna->status,
						'action' => '<td align="center"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal" onclick="edit('."'".$pengguna->id_pelanggan."'".')">Edit</button><button class="btn btn-sm btn-danger" onclick="remove('."'".$pengguna->id_pelanggan."'".')">Delete</button></td>'
					);
				}
			} else {
				$data = array();
			}
			$pengguna = array(
				'data' => $data
			);
		}
		echo json_encode($pengguna);
	}
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */