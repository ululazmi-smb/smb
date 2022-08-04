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
		$this->load->model('pengguna_model');
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
						"id" => $pengguna->id,
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

	public function get_user_by_id()
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
			$id_user = $this->input->post("id_user");
			if($this->pelanggan_model->read_pelanggan_by_id($id_user, $perusahaan)->num_rows() > 0)
			{
				$data_user = $this->pelanggan_model->read_pelanggan_by_id($id_user, $perusahaan)->row();
				if($this->pengguna_model->read_user_pengguna_by_id($id_user, $perusahaan)->num_rows() > 0)
				{
					$data_login = $this->pengguna_model->read_user_pengguna_by_id($id_user, $perusahaan)->row();
					$data = array(
						"email" => $data_login->username,
						"username" => $data_login->nama_user,
						"nama_pelanggan" => $data_user->nama_pelanggan,
						"nomor_tagihan" => $data_user->nomor_tagihan,
						"alamat" => $data_user->alamat,
						"no_telp" => $data_user->no_telp,
						"id_telegram" => $data_user->id_telegram,
						"id_paket" => $data_user->id_paket,
						"paket" => $data_user->paket,
						"harga_paket" => $data_user->harga,
						"tanggal_pemasangan" => $data_user->tanggal_pemasangan,
						"jatuh_tempo" => $data_user->jatuh_tempo,
						"akun_pppoe" => $data_user->akun_pppoe,
						"ip_address" => $data_user->ip_address,
						"status" => $data_user->status
					);
				} else {
					$data = array(
						"email" =>"",
						"username" => "",
						"nama_pelanggan" => $data_user->nama_pelanggan,
						"nomor_tagihan" => $data_user->nomor_tagihan,
						"alamat" => $data_user->alamat,
						"no_telp" => $data_user->no_telp,
						"id_telegram" => $data_user->id_telegram,
						"id_paket" => $data_user->id_paket,
						"paket" => $data_user->paket,
						"harga_paket" => $data_user->harga,
						"tanggal_pemasangan" => $data_user->tanggal_pemasangan,
						"jatuh_tempo" => $data_user->jatuh_tempo,
						"akun_pppoe" => $data_user->akun_pppoe,
						"ip_address" => $data_user->ip_address,
						"status" => $data_user->status
					);
				}
				$pengguna = array(
					"data" => $data
				);
			} else {
				$pengguna = array(
					"error" => "error",
					"messages" => "error auth api"
				);
			}
		}
		echo json_encode($pengguna);
	}

	public function add_user()
	{
		header('Content-type: application/json');
		$key = $this->uri->segment(3);
		$perusahaan = $this->session->userdata('id_perusahaan');
		if($this->paket_perusahaan_model->read($perusahaan)->num_rows() > 0)
		{
			$n = date("mdY");
			if($this->pelanggan_model->read_nomor_tagihan($perusahaan)->num_rows() > 0)
			{
				$read_nomor_tagihan = $this->pelanggan_model->read_nomor_tagihan($perusahaan)->row();
				$belakang_tagihan = substr($read_nomor_tagihan->nomor_tagihan, 8,6);
				$depan_tagihan = substr($read_nomor_tagihan->nomor_tagihan, 0,8);
				if($depan_tagihan == $n)
				{
					$belakang_tagihan = $belakang_tagihan + 1;
					$kosong = "";
					for($i = 0; $i < (6 - strlen($belakang_tagihan)); $i++)
					{
						$kosong = $kosong."0";
					}
					$belakang_tagihan = $kosong.$belakang_tagihan;
				} else {
					$belakang_tagihan = "000001";
				}
			} else {
				$belakang_tagihan = "000001";
			}
			$nomor_tagihan = $n.$belakang_tagihan;
			$email = $this->input->post("email");
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$nama_pelanggan = $this->input->post("nama_pelanggan");
			$alamat = $this->input->post("alamat");
			$no_tlp = $this->input->post("no_tlp");
			$id_telegram = $this->input->post("id_telegram");
			$tanggal_pemasangan = $this->input->post("tanggal_pemasangan");
			$jatuh_tempo = $this->input->post("jatuh_tempo");
			$akun_pppoe = $this->input->post("akun_pppoe");
			$ip_address = $this->input->post("ip_address");
			$list_paket = $this->input->post("list_paket");
			$status_user = $this->input->post("status_user");
			$status = $this->input->post("status_f");
			$paket = $this->paket_model->get_paket($list_paket, $perusahaan)->row();
				if($status == "add")
				{
					if($this->pelanggan_model->read($perusahaan)->num_rows() < $this->paket_perusahaan_model->read($perusahaan)->row()->max_user)
					{
						if($username == "")
						{
							$pengguna = array(
								"error" => "error",
								"messages" => "username harus di isi"
							);
						} else if($email == "")
						{
							$pengguna = array(
								"error" => "error",
								"messages" => "pengguna harus di isi"
							);
						} else if ($password == "") 
						{
							$pengguna = array(
								"error" => "error",
								"messages" => "password harus di isi"
							);
						} else {
							if($this->pengguna_model->cek_email($email)->num_rows() > 0)
							{
								$pengguna = array(
									"error" => "error",
									"messages" => "email sudah di gunakan"
								);
							} else {
								$data = array(
									"nomor_tagihan" => $nomor_tagihan,
									"nama_pelanggan" => $nama_pelanggan,
									"alamat" => $alamat,
									"no_telp" => $no_tlp,
									"id_telegram" => $id_telegram,
									"id_paket" => $list_paket,
									"paket" => $paket->nama,
									"harga" => $paket->harga,
									"tanggal_pemasangan" => $tanggal_pemasangan,
									"jatuh_tempo" => $jatuh_tempo,
									"akun_pppoe" => $akun_pppoe,
									"ip_address" => $ip_address,
									"status" => $status_user,
									"id_perusahaan" => $perusahaan
								);
								if($this->pelanggan_model->add_pelanggan($data, $perusahaan))
								{
									$data2 = array(
										"username" => $email,
										"nama_user" => $username,
										"password" => md5($password),
										"level" => "user",
										"foto" => "avatar.png",
										"id_perusahaan" => $perusahaan,
										"id_pelanggan" => $this->db->insert_id()
									);
									if($this->pengguna_model->add_pengguna($data2))
									{
										$pengguna = array(
											"error" => "success",
											"messages" => "success insert data"
										);
									} else {
										$pengguna = array(
											"error" => "error",
											"messages" => "gagal insert data"
										);
									}
								} else {
									$pengguna = array(
										"error" => "error",
										"messages" => "gagal insert data"
									);
								}
							}
						}
					} else {
						$pengguna = array(
							"error" => "error",
							"messages" => "jumlah akun sudah melebihi limit silahkan upgrade paket anda"
						);
					}
				} else if ($status == "edit") {
					$id_user = $this->input->post("id_user");
					$data = array(
						"nama_pelanggan" => $nama_pelanggan,
						"alamat" => $alamat,
						"no_telp" => $no_tlp,
						"id_telegram" => $id_telegram,
						"id_paket" => $list_paket,
						"paket" => $paket->nama,
						"harga" => $paket->harga,
						"tanggal_pemasangan" => $tanggal_pemasangan,
						"jatuh_tempo" => $jatuh_tempo,
						"akun_pppoe" => $akun_pppoe,
						"ip_address" => $ip_address,
						"status" => $status_user,
					);
					if($this->pelanggan_model->edit_pelanggan($data, $id_user,$perusahaan))
					{
						$pengguna = array(
							"error" => "success",
							"messages" => "data berhasil di simpan"
						);
					} else {
						$pengguna = array(
							"error" => "error",
							"messages" => "gagal simpan data"
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
		echo json_encode($pengguna);
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
						"id" => $this->paket_model->get_paket($id, $perusahaan)->row()->id,
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
						"nomor_tagihan" => $pengguna->nomor_tagihan,
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