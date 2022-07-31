<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}

	public function login()
	{
		if($this->session->userdata('status') !== 'login')
		{
			if($this->input->post("email"))
			{
				$email = $this->input->post("email");
				if($this->auth_model->getEmail($email)->num_rows() > 0)
				{					
					$data = $this->auth_model->getEmail($email)->row();
					if (md5($this->input->post('password') == $data->password)) {
						$userdata = array(
							'id' => $data->id,
							'email' => $data->email,
							'nama' => $data->username,
							'id_perusahaan' => $data->perusahaan,
							'status' => 'login'
						);
						$this->session->set_userdata($userdata);
						echo json_encode('sukses');
					} else {
						echo json_encode('passwordsalah');
					}
				} else {
					echo json_encode('tidakada');
				}
			} else {
				$this->load->view('login');
			}
		} else {
			redirect('/');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */