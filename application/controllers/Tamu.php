<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tamu extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
        $this->load->model('M_kunjungan');
        $this->load->model('M_Tamu');
		$this->load->model('M_login');
		$this->load->library('form_validation');
		$this->load->helper('date');
		error_reporting('E_ALL');
		date_default_timezone_set("Asia/Bangkok");
	}
	public function index(){
        $data['table']=$this->M_Tamu->get_table();
		$data['content']="v_tamu";
		$this->load->view('v_template', $data);
	}
	public function get_detail_user($id_tamu='')
	{
		$this->load->model('M_Tamu');
		$data_detail=$this->M_Tamu->detail_user($id_tamu);
		echo json_encode($data_detail);
	}
	public function update(){
		$this->form_validation->set_rules('nama', 'Nama ', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('no_telepon', 'No telepon', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis kelamin', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		if($this->form_validation->run() == FALSE){
		   $this->session->set_flashdata('pesan', validation_errors());
			redirect(base_url('index.php/Tamu/'),'refresh');
		}
		else{
			$this->load->model('M_Tamu');
			$proses_update=$this->M_Tamu->update_user();
			if($proses_update){
			   $this->session->set_flashdata('pesan', 'Update tamu berhasil');
			}
			else{
				$this->session->set_flashdata('pesan', 'Update tamu gagal');
			}
			redirect(base_url('index.php/Tamu'), 'refresh');
		}
	}
    public function delete($id_tamu){
        $this->load->model('M_Tamu');
        $hapus = $this->M_Tamu->delete($id_tamu);
        if(($hapus)==TRUE){
            $this->session->set_flashdata('pesan', 'Hapus data peserta berhasil');
        } else{
            $this->session->set_flashdata('gagal', 'Hapus data peserta gagal');
        }
        redirect(base_url('index.php/Tamu/index/'), 'refresh');
    }
}