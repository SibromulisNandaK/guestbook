<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_event');
		$this->load->model('M_login');
		$this->load->library('form_validation');
		$this->load->helper('date');
		error_reporting('E_ALL');
		date_default_timezone_set("Asia/Bangkok");
    }
    public function index(){
        $data['dt']= $this->M_event->get_event();
        $data['content']="v_event";
        $this->load->view('v_template', $data);
    }
    public function simpan_event(){
        $this->form_validation->set_rules('nama_event', 'Nama Event', 'trim|required',
        array('required' => 'Nama Acara belum terisi'));
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required',
        array('required' => 'Waktu belum terisi'));
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required',
        array('required' => 'Lokasi belum terisi'));
        $this->form_validation->set_rules('jenis', 'Jenis', 'trim|required',
        array('required' => 'Jenis acara belum terisi'));

        if($this->form_validation->run() == TRUE){
            $this->load->model('M_event', dt);
            $masuk = $this->dt->tambah_event();
            if($masuk == TRUE){
                $this->session->set_flashdata('pesan', 'Tambah acara berhasil');
            } else {
                $this->session->set_flashdata('gagal', 'Tambah acara gagal');
            }
            redirect(base_url('index.php/Event'), 'refresh');
        } else {
            $this->session->set_flashdata('pesan', validation_errors());
            redirect(base_url('index.php/Event'), 'refresh');
        }
    }
    public function hapus_event($id_event){
        $hapus = $this->M_event->hapus_event($id_event);
        if($hapus == TRUE){
            $this->session->set_flashdata('pesan', 'Hapus acara berhasil');
        } else {
            $this->session->set_flashdata('gagal', 'Hapus acara gagal');
        }
        redirect(base_url('index.php/Event'), 'refresh');
    }
    public function update_event(){
		$this->form_validation->set_rules('nama_event', 'Nama Event', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
		$this->form_validation->set_rules('jenis', 'Jenis', 'trim|required');
		if($this->form_validation->run() == FALSE){
		   $this->session->set_flashdata('gagal', validation_errors());
			redirect(base_url('index.php/Event'),'refresh');
		}
		else{
			$this->load->model('M_event');
			$proses_update=$this->M_event->update_event();
			if($proses_update){
			   $this->session->set_flashdata('pesan', 'Update acara berhasil');
			}
			else{
				$this->session->set_flashdata('gagal', 'Update acara gagal');
			}
			redirect(base_url('index.php/Event'), 'refresh');
		}
	}
    public function get_detail_event($id_event=''){
		$this->load->model('M_event');
		$data_detail=$this->M_event->detail_event($id_event);
		echo json_encode($data_detail);
	}
}