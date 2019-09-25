<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kunjungan extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_kunjungan');
		$this->load->model('M_login');
		$this->load->library('form_validation');
		$this->load->helper('date');
		error_reporting('E_ALL');
		date_default_timezone_set("Asia/Bangkok");
	}
	public function index(){
		$data['get_karya']= $this->M_kunjungan->get_karyawan();
		$data['record']= $this->M_kunjungan->get_table_tamu();
		$data['content']="v_kunjungan";
		$this->load->view('v_template', $data);
	}
	public function coba($keterangan){
		$this->load->model('M_Kunjungan');
		$this->M_Kunjungan->get_ket($keterangan);
	}
	function search($nama=''){ 
		$this->load->model('M_Kunjungan');
		$cari = $this->M_Kunjungan->search_name($nama);
		echo json_encode($cari);
	}
	function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->M_kunjungan->search_blog($_GET['term']);
            if (count($result) > 0) {
			foreach ($result as $row)
				$new_row=(array) $row;
				$value= $row->nama;
				$arr_result[]=array('id'=>$row->id_tamu,'label'=>$value,'attribut'=>$new_row);
					
				//$arr_result[$row->id_tamu] = $row->nama;
					//echo json_encode($arr_result);
			}
			else{
				$arr_result[]=array('id'=>'','label'=>'','attribut'=>'');	
			}
			echo json_encode($arr_result);
        }
    }
	public function simpan_kunjungan(){
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required',
		array('required' => 'Nama tidak boleh kosong'));
		$this->form_validation->set_rules('email', 'Alamat Email', 'trim|required',
		array('required' => 'Alamat Email tidak boleh kosong'));
		$this->form_validation->set_rules('no_telepon', 'No Telepon', 'trim|required',
		array('required' => 'No Telepon tidak boleh kosong'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required',
		array('required' => 'Jenis Kelamin tidak boleh kosong'));
		$this->form_validation->set_rules('id_karyawan', 'Tujuan', 'trim|required',
		array('required' => 'Tujuan tidak boleh kosong'));
		$this->form_validation->set_rules('keterangan', 'Asal Perusahaan', 'trim|required',
		array('required' => 'Asal Perusahaan tidak boleh kosong'));
		$this->form_validation->set_rules('keperluan', 'Keperluan', 'trim|required',
        array('required' => 'Keperluan tidak boleh kosong'));
        
        if($this->form_validation->run() == TRUE){
			$this->load->model('M_Kunjungan');
			$cek= $this->M_Kunjungan->masuk_db();
			if($cek == TRUE){
				$this->session->set_flashdata('pesan', 'Tambah data kunjungan berhasil');
			}
			else{
				$this->session->set_flashdata('pesan', 'Tambah data kunjungan berhasil');
			}
			redirect(base_url('index.php/Kunjungan'));
			}
         else {
            $this->session->set_flashdata('gagal', validation_errors());
            redirect(base_url('index.php/Kunjungan'), 'refresh');
        }
	}
	public function data_kunjungan(){
		$data['data_kunjungan']=$this->M_kunjungan->get_kunjungan();
		$data['record']= $this->M_kunjungan->get_table_tamu();
		$data['content']="v_tabel_kunjungan";
		$this->load->view('v_template', $data);
	}
	function daftar_tamu(){
		$data=array(array('id'=>1,'text'=>'nama1'),array('id'=>2,'text'=>'nama2'));
		echo json_encode($data);
	}
	public function delete_kunjungan($id_kunjungan){

		$this->M_kunjungan->delete_kunjungan($id_kunjungan);
		redirect(base_url('index.php/Kunjungan/data_kunjungan'), 'refresh');
	}
	public function get_detail_user($id_kunjungan=''){
		$data_detail=$this->M_kunjungan->detail_user($id_kunjungan);
		echo json_encode($data_detail);
	}
	public function update_kunjungan($function_cont){
		$this->form_validation->set_rules('nama_tamu', 'Nama tamu', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Asal sekolah', 'trim|required');
		$this->form_validation->set_rules('no_telepon', 'No telepon', 'trim|required');
		$this->form_validation->set_rules('email', 'Alamat Email', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('keperluan', 'Keperluan', 'trim|required');
		$this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
		if($this->form_validation->run() == FALSE){
		   $this->session->set_flashdata('pesan', validation_errors());
			redirect(base_url('index.php/Kunjungan/'.$function_cont),'refresh');
		}
		else{
			$proses_update=$this->M_kunjungan->update_kunjungan();
			redirect(base_url('index.php/Kunjungan/'.$function_cont), 'refresh');
		}
	}
}