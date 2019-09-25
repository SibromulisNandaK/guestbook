<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {
    function __construct(){
        $this->db2 = $this->load->database('db2', TRUE);
    }
    public function cek_user(){
        $email = $this->input->post('email');
        $scrt = "P3djaten";
        $password = sha1($this->input->post('password').$scrt);

        $query = $this->db2->join('Level','Level.id_level=Karyawan.id_level')
						  ->where('email',$email)
						  ->where('password',$password)
                          ->get('karyawan');

        if($this->db2->affected_rows() > 0){

            $data_login = $query->row();

            $data_session = array(
                                'email'=> $data_login->email,
                                'password'=> $data_login->password,
                                'logged_in'=> TRUE,
                                'nama'=>$data_login->nama,
                                'id_karyawan'=>$data_login->id_karyawan,
                                'nama_level'=> $data_login->nama_level,
                                'id_level'=> $data_login->id_level
            );
            $this->session->set_userdata($data_session);

            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function menu(){
        $query = $this->db2->join('relasi','menu.id_menu=relasi.id_menu')
                          ->join('level','relasi.id_level=level.id_level')
                          ->join('aplikasi', 'aplikasi.id_aplikasi=menu.id_aplikasi')
                          ->where('aplikasi.id_aplikasi', '2')
						  ->where('relasi.id_level',$this->session->userdata('id_level'))
                          ->get('menu');

        if($this->db2->affected_rows() > 0){
      //  echo $this->db->last_query()
            $data = $query->result_array();
            return $data;
        }
    }
}