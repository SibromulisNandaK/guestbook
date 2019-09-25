<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kunjungan extends CI_Model {
	public function __construct()
		{
		$this->db2 = $this->load->database('db2', TRUE);
	}
	public function get_karyawan(){
		$query = $this->db->query('SELECT id_karyawan,nama FROM master_republika.karyawan ORDER BY id_level ASC');
		return $query->result();
	}
	public function get_table_tamu(){
		$query = $this->db->query('SELECT * FROM tamu');
		return $query->result();
	}
	public function get_kunjungan(){
		return $this->db->select('kunjungan.id_kunjungan, tamu.email, tamu.no_telepon, tamu.jenis_kelamin, tamu.keterangan, kunjungan.keperluan, kunjungan.waktu, tamu.nama as nama_tamu, master_republika.karyawan.nama as nama_karyawan')
				 ->from('kunjungan')
				 ->join('tamu', 'tamu.id_tamu=kunjungan.id_tamu', 'left')
				 ->join('master_republika.karyawan', 'master_republika.karyawan.id_karyawan=guestbook.kunjungan.id_karyawan', 'left')
				 ->get()->result();
	}
	function search_blog($nama){
        $this->db->like('nama', $nama , 'both');
        $this->db->order_by('nama', 'ASC');
        $this->db->limit(2);
        return $this->db->get('tamu')->result();
    }
	function search_name($nama=''){
		return $this->db->select('*')
						->from('tamu')
						->where('nama', $nama)
				 		->get()->result_array();
	}
    public function masuk_db(){
		$data_tamu=array(
			'nama'=>$this->input->post('nama'),
			'email'=>$this->input->post('email'),
			'no_telepon'=>$this->input->post('no_telepon'),
			'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
			'keterangan'=>$this->input->post('keterangan')
		);
		$id = $this->input->post('id_tamu');
		$this->db->where('id_tamu', $id);
		$check= $this->db->get('tamu');

		if($check->num_rows() > 0){
			$this->db->where('id_tamu', $id)
					 ->update('tamu', $data_tamu);
		} else{		
			$this->db->insert('tamu', $data_tamu);
			$iid = $this->db->insert_id();
		}
		$input_id = ($this->input->post('id_tamu') ? $this->input->post('id_tamu') : $iid ) ;
		
		$data_kunjungan=array(
			'id_tamu'=> $input_id,
			'id_karyawan'=>$this->input->post('id_karyawan'),
			'keperluan'=>$this->input->post('keperluan'),
			'waktu'=> date("Y-m-d H:i:s")
		);
		$this->db->insert('kunjungan', $data_kunjungan);
	}
	function delete_kunjungan($id_kunjungan){
		$this->db->select('id_tamu')->from('kunjungan')->where('id_kunjungan', $id_kunjungan);
		$query = $this->db->get()->row()->id_tamu;
		// print_r($query);
		// die;
		$this->db->where('id_tamu', $query)
				 ->delete('tamu');
		
		$this->db->where('id_kunjungan', $id_kunjungan);
		$this->db->delete('kunjungan');
		return '';
	}
	public function update_kunjungan(){
        $id_kunjungan = $this->input->post('id_kunjungan');
        $this->db->select('id_tamu')
        ->from('kunjungan')
        ->where('id_kunjungan', $id_kunjungan);
        $query = $this->db->get()->row();
		// var_dump($query);
		//nama_tamu, keterangan, no_telepon, email, jenis, nama_karyawan, keperluan, waktu
        $data_tamu = $query->id_tamu;
        $dt_up_tamu=array(
            'nama'=>$this->input->post('nama_tamu'),
            'keterangan'=>$this->input->post('keterangan'),
            'no_telepon'=>$this->input->post('no_telepon'),
            'email'=>$this->input->post('email'),
            'jenis_kelamin'=>$this->input->post('jenis_kelamin')
		);
        $dt_up_kunjungan=array(
            'keperluan'=>$this->input->post('keperluan'),
            'waktu'=>$this->input->post('waktu')
        );
       $this->db->where('id_tamu', $data_tamu);
         $this->db->update('tamu', $dt_up_tamu);
        // echo $this->db->last_query();
         $this->db->where('id_kunjungan', $this->input->post('id_kunjungan'));      
         $this->db->update('kunjungan', $dt_up_kunjungan);
        // echo $this->db->last_query();   
        //  die;
                        return '';
	}
	public function detail_user($id_kunjungan=''){
        return $this->db->select('kunjungan.id_kunjungan, tamu.email, tamu.no_telepon, tamu.jenis_kelamin, tamu.keterangan, kunjungan.keperluan, kunjungan.waktu, tamu.nama as nama_tamu, master_republika.karyawan.nama as nama_karyawan')
				 ->from('kunjungan')
				 ->join('tamu', 'tamu.id_tamu=kunjungan.id_tamu', 'left')
				 ->join('master_republika.karyawan', 'master_republika.karyawan.id_karyawan=guestbook.kunjungan.id_karyawan', 'left')
				 ->where('id_kunjungan', $id_kunjungan)
				 ->get()->row();
	}   
	public function get_ket($keterangan){
		$oke = $this->db->select('keterangan')
				 ->from('tamu')
				 ->where('keterangan', $keterangan)
				 ->get();
				 $coba = $oke->row()->keterangan;
				//  print_r($keterangan);
				 print_r($coba);
				 die;	
	}
}