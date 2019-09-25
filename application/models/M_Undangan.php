<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Undangan extends CI_Model {
	public function __construct(){
        $this->db2 = $this->load->database('db2', TRUE);
        $this->load->model('M_event');
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
    }
    // Umum
    public function sudah_hadir($id_undangan){
        $data_hadir = array(
            'status_kehadiran'=>'Sudah Hadir'
        );
        $this->db->where('id_undangan',$id_undangan);
        $this->db->update('Undangan',$data_hadir );
    }
    public function belum_hadir($id_undangan){
        $data_hadir = array(
            'status_kehadiran'=>'Belum Hadir'
        );
        $this->db->where('id_undangan',$id_undangan);
        $this->db->update('Undangan',$data_hadir );
        $this->generate_qr($id_undangan);
    }
    public function get_undangan($id_event){    
        $oy = $this->db->select('guestbook.tamu.nama as nama_tamu, undangan.jenis_tamu, master_republika.karyawan.nama as nama_karyawan, undangan.status_kehadiran, undangan.id_undangan, tamu.id_tamu')
        ->from('undangan')
        ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
        ->join('event', 'undangan.id_event=event.id_event','left')
        ->join('master_republika.karyawan','undangan.id_karyawan=master_republika.karyawan.id_karyawan','left')
        ->where('undangan.id_event', $id_event);
        return $this->db->get()->result();
    }
    public function get($id_event){
        $this->db->select("*")
        ->from('undangan')
        ->join('event', 'event.id_event=undangan.id_event')
        ->join('tamu', 'tamu.id_tamu=undangan.id_tamu')
        ->where('id_event', $id_event);
        $query = $this->db->get()->result();
    }
    public function get_karyawan(){
		$query = $this->db->query('SELECT id_karyawan, nama FROM master_republika.karyawan ORDER BY id_level ASC');
		return $query->result();
	}
    public function hapus_undangan($id_undangan){
        $this->db->where('id_undangan', $id_undangan);
        return $this->db->delete('undangan');
    }
    public function send_db($id_event){
        $status_kehadiran = 'Belum Hadir';
        $nama = implode(',', $this->input->post('id_karyawan'));
        $data = array();
        $oke = array($nama,false);
        $oke = explode(',',$nama);
        $index = 0;
        foreach($oke as $data_tamu){
            // echo '<br>'.$data_tamu;
            array_push($data, array(
                'id_event'=> $id_event,
                'id_tamu'=> $data_tamu[$index],
                'status_kehadiran'=> 'Belum Hadir'
            ));
            $index++;
        }
        return
        $this->db->insert_batch('undangan', $data);
    }
    public function masuk_db($id_event){
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
		
		$data_undangan=array(
            'id_event'=>$id_event,
            'id_tamu'=> $input_id,
            'id_karyawan'=>'0',
            'status_kehadiran'=>'Belum Hadir',
            'jenis_tamu'=>'Eksternal'
		);
        $this->db->insert('undangan', $data_undangan);
        $id_undangan = $this->db->insert_id();
        $this->generate_qr($id_undangan);
        return $id_undangan;
    }
    public function masuk_db_internal($id_event){
        $data_karyawan = array(
            'id_event'=>$id_event,
            'id_tamu'=>'0',
            'id_karyawan'=>$this->input->post('id_karyawan'),
            'status_kehadiran'=>'Belum Hadir',
            'jenis_tamu'=>'Internal'
        );
        $this->db->insert('undangan', $data_karyawan);
        $id_undangan = $this->db->insert_id();
        $this->generate_qr($id_undangan);
        return $id_undangan;
    }
    public function get_table_tamu(){
		$query = $this->db->query('SELECT * FROM tamu');
		return $query->result();
	}
	function search_blog($nama){
        $this->db->like('nama', $nama , 'both');
        $this->db->order_by('nama', 'ASC');
        $this->db->limit(2);
        return $this->db->get('tamu')->result();
    }
    // Fun Science
    public function dashboard_fs(){
        $query = $this->db->select('id_event')
                          ->from('event')
                          ->like("nama_event","Fun Science")
                          ->get();   
        return $query->row()->id_event;
    }
    public function get_undangan_khusus($id_event){
        $query = $this->db->select('tamu.nama, tamu.email, tamu.jenis_kelamin, tamu.no_telepon, tamu.keterangan, undangan.id_undangan, undangan.id_tamu, undangan.opsi1, undangan.opsi2, undangan.status_kehadiran')
                          ->from('undangan')
                          ->join('event', 'undangan.id_event=event.id_event', 'left')
                          ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
                          ->where('undangan.id_event', $id_event);
        return $this->db->get()->result();
    }
    public function judul_acara($id_event){
        $tampil = $this->db->query("SELECT nama_event FROM event WHERE id_event = '$id_event' ");  
        return $tampil->result();
    }
    public function tambah_undangan_khusus($id_event){
        $data_peserta = array(
            'nama'=>$this->input->post('nama'),
            'no_telepon'=>$this->input->post('no_telepon'),
            'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
            'keterangan'=>$this->input->post('keterangan'),
            'email'=>$this->input->post('email')
        );
        $this->db->insert('tamu', $data_peserta);
        $iid = $this->db->insert_id();
        $data_undangan_opsi = array(
            'id_event'=>$id_event,
            'id_tamu'=>$iid,
            'id_karyawan'=>'0',
            'status_kehadiran'=>'Belum Hadir',
            'jenis_tamu'=>'Eksternal',
            'opsi1'=>$this->input->post('opsi1'), //nama_ortu
            'opsi2'=>$this->input->post('opsi2')  //alamat
        );
        // print_r ($data_peserta);print_r($data_undangan_opsi);die;
        $this->db->insert('undangan', $data_undangan_opsi);
        $id_undangan = $this->db->insert_id();
        $this->generate_qr($id_undangan);
        return $id_undangan;
    }
    public function search_blog_fs($nama_peserta){
        $this->db->like('nama_peserta', $nama_peserta , 'both');
        $this->db->order_by('nama_peserta', 'ASC');
        $this->db->limit(3);
        return $this->db->get('fun_science')->result();
    }
    public function nama_peserta_sertif($id_undangan){
        $query = $this->db->select('tamu.nama')
                          ->from('undangan')
                          ->join('event', 'undangan.id_event=event.id_event', 'left')
                          ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
                          ->where('id_undangan', $id_undangan)
                          ->get();    
        return $query->row()->nama;
    }
    public function update_user(){
        $id_undangan = $this->input->post('id_undangan');
        $this->db->select('id_tamu')
        ->from('undangan')
        ->where('id_undangan', $id_undangan);
        $query = $this->db->get()->row();
        // var_dump($query);
        $data_tamu = $query->id_tamu;
        $dt_up_user=array(
            'nama'=>$this->input->post('nama'),
            'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
            'no_telepon'=>$this->input->post('no_telepon'),
            'keterangan'=>$this->input->post('keterangan'),
            'email'=>$this->input->post('email')
        );
        $dt_up_undangan=array(
            'opsi1'=>$this->input->post('opsi1'),
            'opsi2'=>$this->input->post('opsi2'),
            'status_kehadiran'=>$this->input->post('status_kehadiran')
        );
       $this->db->where('id_tamu', $data_tamu);
         $this->db->update('tamu', $dt_up_user);
        // echo $this->db->last_query();
         $this->db->where('id_undangan', $this->input->post('id_undangan'));      
         $this->db->update('undangan', $dt_up_undangan);
        // echo $this->db->last_query();   
        //  die;
                        return '';
    }
    // Latihan Akuntansi Masjid
    // QR
    public function generate_qr($id_undangan){
        $idqr = $id_undangan;
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $image_name='QR'.$idqr.'.png'; //buat name dari qr code sesuai dengan nim
        $params['data'] = $idqr; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }
    public function ambil_keterangan($id_undangan){
        $query = $this->db->select('tamu.keterangan')
                          ->from('undangan')
                          ->join('event', 'undangan.id_event=event.id_event', 'left')
                          ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
                          ->where('id_undangan', $id_undangan)
                          ->get();
        return $query->row()->keterangan;
    }
    // Cetak Sertifikat
    public function get_nama_acara($id_undangan){
        $this->db->select('nama_event')
                 ->from('undangan')
                 ->join('event', 'undangan.id_event=event.id_event','left')
                 ->where('id_undangan', $id_undangan);
                 $query = $this->db->get();
                 $data_acara = $query->result();
                 return $data_acara[0]->nama_event;
    }
    public function ambil_jabatan($id_undangan){
        $query = $this->db->select('opsi1')
                          ->from('undangan')
                          ->where('id_undangan', $id_undangan)
                          ->get();
        return $query->row()->opsi1;
    }
    // SEND EMAIL
    public function undangan_email($id_undangan){
        $this->db->select('id_tamu')
                 ->from('undangan')
                 ->where('undangan.id_undangan', $id_undangan);
                 $cek = $this->db->get('')->result();
                foreach($cek as $dt){
                    $data= $dt->id_tamu;
                }
        if($data == 0){
            $this->db->select('master_republika.karyawan.email, ')
                     ->from('undangan')
                     ->join('master_republika.karyawan','undangan.id_karyawan=master_republika.karyawan.id_karyawan','left')
                     ->where('id_undangan', $id_undangan);
                     $query = $this->db->get();
                     $data_email = $query->result();
                     return $data_email[0]->email;
        } else {
            $this->db->select('tamu.email')
                     ->from('undangan')
                     ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
                     ->where('id_undangan', $id_undangan);
            $query = $this->db->get();
            $data_email = $query->result();
            return $data_email[0]->email;
        }
    }
    public function data_email($id_event, $id_undangan){
        $this->db->select('undangan.id_undangan, event.nama_event, event.lokasi, event.jenis, event.detail')
                 ->select('DATE_FORMAT(waktu, "%W %d %M %Y") as waktu', FALSE)
                 ->select('DATE_FORMAT(waktu, "%k:%i WIB") as jam', FALSE)
                    ->from('undangan')
                    ->join('event', 'undangan.id_event=event.id_event','left')
                    ->where('undangan.id_undangan', $id_undangan)
                    ->where('undangan.id_event', $id_event);
        // $wkwk = $this->db->get()->row();
        // print_r ($wkwk);
                    return $this->db->get()->row();
    }
    public function get_email_tamu($id_event){
        $oke = $this->db->select('tamu.email')
                        ->from('undangan')
                        ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
                        ->where('undangan.id_event', $id_event)
                        ->where('jenis_tamu', 'Eksternal');
                        $oi = $this->db->get()->result();
                        // print_r($oi);
                        // die;
                        return $oi;
    }
    public function get_email_karyawan($id_event){
        $oke = $this->db->select('master_republika.karyawan.email')
                        ->from('undangan')
                        ->join('master_republika.karyawan','undangan.id_karyawan=master_republika.karyawan.id_karyawan','left')
                        ->where('undangan.id_event', $id_event)
                        ->where('jenis_tamu', 'Internal');
                        $oi = $this->db->get()->result();
                        // print_r($oi);
                        // die;
                        return $oi;
    }
    public function get_email_internal($id_karyawan){
        $this->db->select('master_republika.karyawan.email')
                 ->from('master_republika.karyawan')
                 ->where('id_karyawan', $id_karyawan);
                 $query = $this->db->get();
                 $data_email = $query->result();
                 return $data_email[0]->email;
    }
    
    public function detail_user($id_undangan=''){
        return $this->db->select('tamu.nama, tamu.email, tamu.no_telepon, tamu.jenis_kelamin, tamu.keterangan, undangan.opsi1, undangan.opsi2, undangan.status_kehadiran, undangan.id_undangan')
        ->from('undangan')
        ->join('tamu', 'undangan.id_tamu = tamu.id_tamu','left')
        ->where('id_undangan', $id_undangan)
        ->get()
        ->row();
    }    

}