<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('Auth_model');
		$this->load->model('pengguna_model');
		$this->load->model('paket_perusahaan_model');
	}

	public function index()
	{
		$this->load->view('pelanggan');
	}

	public function read()
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
				foreach ($this->pengguna_model->read($perusahaan)->result() as $pengguna) {
					$data[] = array(
						'username' => $pengguna->username,
						'nama' => $pengguna->nama_user,
						'level' => $pengguna->level,
						'foto' => '<img src="'.base_url("uploads/user/").$pengguna->foto.'" widht="75" alt="" height="75">',
						'action' => '<td align="center"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal" onclick="edit('."'".$pengguna->id."'".')">Edit</button></td>'
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

	public function edit()
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
			$username = $this->input->post("username");
			$email = $this->input->post("email");
			$id_user = $this->input->post("id");
			$password = $this->input->post("password");
			if($this->paket_perusahaan_model->read($perusahaan)->num_rows() > 0)
			{
			if($this->pengguna_model->cek_email($email)->num_rows() > 0)
				{
					$pengguna = array(
						"error" => "error",
						"messages" => "email sudah ada"
					);
				} else {
					if($this->pengguna_model->edit($perusahaan, $username, $password, $email, $id_user))
					{
						$pengguna = array(
							"error" => "success",
							"messages" => ""
						);
					} else  {
						$pengguna = array(
							"error" => "error",
							"messages" => "error update"
						);
					}
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
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */