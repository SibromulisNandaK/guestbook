<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_event extends CI_Model {
	public function __construct(){
		$this->db2 = $this->load->database('db2', TRUE);
    }
    public function get_event(){
        $this->db->select('*');
        $this->db->select('DATE_FORMAT(waktu, "%W %e %M %Y") as waktu', FALSE);
        $this->db->select('DATE_FORMAT(waktu, "%k:%i WIB") as jam', FALSE);
        $this->db->from('event');
        $this->db->order_by('waktu', 'desc');
        $query = $this->db->get()->result();
        return $query;
    }
    public function tambah_event(){
        $data_event = array(
            'nama_event'=>$this->input->post('nama_event'),
            'waktu'=>$this->input->post('waktu'),
            'detail'=>$this->input->post('detail'),
            'lokasi'=>$this->input->post('lokasi'),
            'jenis'=>$this->input->post('jenis')
        );
        $masuk=$this->db->insert('event', $data_event);
        return $masuk;
    }
    public function hapus_event($id_event){
        $this->db->where('id_event', $id_event);
        return $this->db->delete('event');
    }
    public function detail_event($id_event=''){
        return $this->db->where('id_event', $id_event)->get('event')->row();
    }
    public function update_event(){
        $dt_up_event=array(
            'id_event'=>$this->input->post('id_event'),
            'nama_event'=>$this->input->post('nama_event'),
            'waktu'=>$this->input->post('waktu'),
            'detail'=>$this->input->post('detail'),
            'lokasi'=>$this->input->post('lokasi'),
            'jenis'=>$this->input->post('jenis')
        );
        return $this->db->where('id_event', $this->input->post('id_event'))->update('event', $dt_up_event);
    }
}