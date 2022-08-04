<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('Auth_model');
		$this->load->model('Tagihan_user_model');
		$this->load->model('pengguna_model');
		$this->load->model('pelanggan_model');
		$this->load->model('paket_perusahaan_model');
	}

	public function index()
	{
		$this->load->view('transaksi');
	}
	
	public function generate()
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
			if($this->pengguna_model->read($perusahaan)->num_rows() > 0)
			{
				if($this->pelanggan_model->read($perusahaan)->num_rows() > 0)
				{
					$no = 0;
					$tahun = $this->input->post("tahun");
					$bulan = $this->input->post("bulan");
					foreach($this->pelanggan_model->read($perusahaan)->result() as $data)
					{
						if($data->status == "active")
						{
							$data = array(
								"id_pelanggan" => $data->id_pelanggan,
								"nama_tagihan" => $data->paket,
								"bulan_tahun" => $bulan.$tahun,
								"jumlah_bayar" => $data->harga,
								"terbayar" => "0",
								"tanggal_bayar" => "0000-00-00",
								"jatuh_tempo" => $data->jatuh_tempo,
								"status_bayar" => "0",
								"id_perusahaan" => $perusahaan
							);
							if($this->Tagihan_user_model->cek_tagihan($data)->num_rows() > 0)
							{
								
							} else {
								if($this->Tagihan_user_model->insert($perusahaan, $data))
								{
									$no++;
								}
							}
						}
					}
					$pengguna = array(
						"error" => "success",
						"messages" => "berhasil menggenerate ".$no." tagihan"
					);
				} else {
					$pengguna = array(
						"error" => "error",
						"messages" => "tidak ada pelanggan yang di generate"
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

	public function read_transaksi()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->Auth_model->key($key) == false)
		{
			$pengguna = array(
				"error" => "error",
				"messages" => "error auth api",
				'data' => array()
			);
		} else {
			if($this->pengguna_model->read($perusahaan)->num_rows() > 0)
			{
				$tahun = $this->input->post("tahun");
				$bulan = $this->input->post("bulan");
				if($this->Tagihan_user_model->read($perusahaan, $bulan, $tahun)->num_rows() > 0)
				{
					foreach($this->Tagihan_user_model->read($perusahaan, $bulan, $tahun)->result() as $ring)
					{
						if($ring->status_bayar == "0")
						{
							$status_bayar = "belum lunas";
						} else if($ring->status_bayar == "0"){
							$status_bayar = "lunas";
						}
						if($this->pelanggan_model->read_pelanggan_by_id($ring->id_pelanggan, $perusahaan)->num_rows() > 0)
						{
							$rs = $this->pelanggan_model->read_pelanggan_by_id($ring->id_pelanggan, $perusahaan)->row();
							$nomor_tagihan = $rs->nomor_tagihan;
							$nama = $rs->nama_pelanggan;
							$bulan = substr($ring->bulan_tahun,0,2);
							$tahun = substr($ring->bulan_tahun,2,4);
							$data[] = array(
								'nomor_tagihan' => $nomor_tagihan,
								'nama' => $nama,
								'nama_paket' => $ring->nama_tagihan,
								'bulan_tahun' => $bulan."/".$tahun,
								'tagihan' => $ring->jumlah_bayar,
								'jatuh_tempo' => $ring->jatuh_tempo,
								'status_bayar' => $status_bayar,
								'action' => '<td align="center"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal" onclick="edit('."'".$ring->id."'".')">Edit</button></td>'
							);
						} else {
							$data = array();
						}
					}
				} else {
					$data = array();
				}
			} else {
				$data = array();
			}
			$pengguna = array(
				"error" => "success",
				'data' => $data
			);
		}
		echo json_encode($pengguna);
	}
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */