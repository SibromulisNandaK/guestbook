<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db2', TRUE);
		$this->load->model('M_login'); 
	}
	public function index()
		{
		if($this->session->userdata('logged_in') == TRUE){
			redirect('Dashboard/index');
		} else {
			$this->load->view('v_login');
		}
	}
	public function cek_login(){
		if($this->session->userdata('logged_in') == FALSE){

			$this->form_validation->set_rules('email', 'email', 'trim|required',
			array('required' => 'Alamat email belum terisi'))
			;$this->form_validation->set_rules('password', 'password', 'trim|required',
			array('required' => 'Password belum terisi'));

			if ($this->form_validation->run() == TRUE) {
				if($this->M_login->cek_user() == TRUE){
					redirect('Dashboard/index');
				} else {
					$this->session->set_flashdata('gagal', 'Login gagal! Pastikan data yang anda masukkan benar');
					redirect('login/index');
				}
			} else {
				$this->session->set_flashdata('gagal', validation_errors());
					redirect('login/index');
			}

		} else {
			redirect('Dashboard/index');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
}
