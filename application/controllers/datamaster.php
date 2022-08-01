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
		$this->load->model('pengguna_model');
	}

	public function datapaket()
	{
		$this->load->view('datamaster_datapaket');
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
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */