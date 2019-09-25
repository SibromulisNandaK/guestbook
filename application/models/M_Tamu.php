<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Tamu extends CI_Model {
    
	public function __construct()
	    {
		$this->db2 = $this->load->database('db2', TRUE);
    }
	public function get_table(){
		$query = $this->db->query('SELECT * FROM tamu');
		return $query->result();
	}
    public function delete($id_tamu){
        $this->db->where('id_tamu', $id_tamu);
        return $this->db->delete('tamu');
	}
	public function detail_user($id_tamu=''){
        return $this->db->where('id_tamu', $id_tamu)->get('tamu')->row();
	}
	public function update_user(){
        $dt_up_user=array(
            'id_tamu'=>$this->input->post('id_tamu'),
            'nama'=>$this->input->post('nama'),
            'email'=>$this->input->post('email'),
            'no_telepon'=>$this->input->post('no_telepon'),
            'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
            'keterangan'=>$this->input->post('keterangan')
        );
        return $this->db->where('id_tamu', $this->input->post('id_tamu'))->update('tamu', $dt_up_user);
    }
}