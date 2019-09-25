<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Fun_Science extends CI_Model {
    function __construct(){
        $this->db2 = $this->load->database('db2', TRUE);
    }
    public function masuk_db(){
        $data_peserta = array(
            'nama_peserta'=> $this->input->post('nama_peserta'),
            'asal_sekolah'=> $this->input->post('asal_sekolah'),
            'jenis_kelamin'=> $this->input->post('jenis_kelamin'),
            'nama_ortu'=> $this->input->post('nama_ortu'),
            'no_telepon'=>$this->input->post('no_telepon'),
            'alamat'=>$this->input->post('alamat')
        );
        return $this->db->insert('fun_science',$data_peserta);
    }
    function search_name($nama_peserta=''){
		return $this->db->select('*')
						->from('fun_science')
						->where('nama_peserta', $nama_peserta)
				 		->get()->result_array();
	}
    function search_blog_fs($nama_peserta){
        $this->db->like('nama_peserta', $nama_peserta , 'both');
        $this->db->order_by('nama_peserta', 'ASC');
        $this->db->limit(3);
        return $this->db->get('tamu')->result();
    }
    public function get_table(){
        $query =  $this->db->query("SELECT * FROM fun_science");
        return $query->result();
    }
    public function delete_peserta($id_peserta){
        $this->db->where('id_peserta', $id_peserta);
        return $this->db->delete('Fun_Science');
    }
    public function sudah_hadir($id_peserta){
        $data_hadir = array(
            'status_kehadiran'=>'Sudah Hadir'
        );
        $this->db->where('id_peserta',$id_peserta);
        $this->db->update('Fun_Science',$data_hadir );
    }
    public function detail_user($id_peserta=''){
        return $this->db->where('id_peserta', $id_peserta)->get('fun_science')->row();
    }
    public function update_user(){
        $dt_up_user=array(
            'id_peserta'=>$this->input->post('id_peserta'),
            'nama_peserta'=>$this->input->post('nama_peserta'),
            'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
            'nama_ortu'=>$this->input->post('nama_ortu'),
            'no_telepon'=>$this->input->post('no_telepon'),
            'alamat'=>$this->input->post('alamat'),
            'status_kehadiran'=>$this->input->post('status_kehadiran')
        );
        return $this->db->where('id_peserta', $this->input->post('id_peserta'))->update('fun_science', $dt_up_user);
    }
}