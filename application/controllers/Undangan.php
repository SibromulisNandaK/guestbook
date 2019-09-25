<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Undangan extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->model('M_Undangan', '', TRUE);
        $this->load->library('pdf');
        $this->load->helper('tanggal_helper');
        $this->load->helper('file');
    }
    public function index($id_event){
        $this->get_autocomplete();
        $data['get_karya']= $this->M_Undangan->get_karyawan();
        $data['content']="v_undangan";
        $data['isi_tabel']=$this->M_Undangan->get_undangan($id_event);
        $data['judul_acara']=$this->M_Undangan->judul_acara($id_event);
        $this->load->view('v_template', $data);
    }
    public function sudah_hadir($id_undangan,$function_cont, $id_event){
        $ambil=$this->M_Undangan->sudah_hadir($id_undangan);
        $url_gambar = ('./assets/images/qr/QR'.$id_undangan.'.png');
        unlink($url_gambar);
        redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event.'/#'.$id_undangan));
    }
    public function belum_hadir($id_undangan,$function_cont, $id_event){
        $ambil=$this->M_Undangan->belum_hadir($id_undangan);
        redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event.'/#'.$id_undangan));
    }
    public function getUn($id_event){
        $this->load->model('M_Undangan');
        $this->M_Undangan->get();
        redirect(base_url('index.php/Undangan'));
    }
	public function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->M_Undangan->search_blog($_GET['term']);
        
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
    public function tambah_undangan($id_event, $function_cont){
        $this->form_validation->set_rules('nama', 'nama', 'trim|required',
        array('required' => 'Nama undangan belum terisi'));
        $this->form_validation->set_rules('email', 'email', 'trim|required',
        array('required' => 'Email belum terisi'));
        $this->form_validation->set_rules('no_telepon', 'no_telepon', 'trim|required',
        array('required' => 'No telepon belum terisi'));
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'trim|required',
        array('required' => 'Jenis kelamin belum terisi'));
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required',
        array('required' => 'Keterangan belum terisi'));
        
        if($this->form_validation->run() == TRUE){
            $this->load->model('M_Undangan');
            $id_undangan = $this->M_Undangan->masuk_db($id_event);

            if(isset($_POST['kirim_eks'])&& $_POST['kirim_eks']=='kirim_eks'){
                $data = $this->M_Undangan->undangan_email($id_undangan);
                $data_undangan = $this->M_Undangan->data_email($id_event, $id_undangan);
                $config = [
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'protocol'  => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_user' => '',    
                    'smtp_pass' => '',      
                    'smtp_port' => 465,
                    'crlf'      => "\r\n",
                    'newline'   => "\r\n"
                ];
                $kirim_data=((array)$data_undangan);
                $card = $this->load->view('v_email_undangan', $kirim_data, true);
                $this->load->library('email', $config);
                $this->email->from('noreply@tes.com', 'Republika Online');
                $this->email->to($data);
                $this->email->attach(base_url().'/assets/images/qr/QR'.$id_undangan.'.png');
                $this->email->subject('You have a new invitation.');
                // echo $card;
                // die;
                $this->email->message($card);
                if($this->email->send()) {
                    redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
                }   else {
                    redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
                }
            } else {
                redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
            }
            if($id_undangan){
                $this->session->set_flashdata('pesan', 'Tambah undangan berhasil');
            } else {
                $this->session->set_flashdata('gagal', 'Tambah undangan gagal');
            }
            redirect(base_url('index.php/Undangan/index/'.$id_event), 'refresh');
        } else {
            // echo validation_errors();
            $this->session->set_flashdata('gagal', validation_errors());
            redirect(base_url('index.php/Undangan/index/'.$id_event), 'refresh');
        }
    }
    public function tambah_undangan_internal($id_event, $function_cont){
        
        $this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'trim|required',
        array('required' => 'Nama karyawan belum terisi'));

        if($this->form_validation->run() == TRUE){
            $coba = $this->input->post('id_karyawan');
            $data = $this->M_Undangan->get_email_internal($coba);
        $id_undangan = $this->M_Undangan->masuk_db_internal($id_event);
        if(isset($_POST['kirim_in'])&& $_POST['kirim_in']=='kirim_in'){
            $data = $this->M_Undangan->undangan_email($id_undangan);
            $data_undangan = $this->M_Undangan->data_email($id_event, $id_undangan);
            $config = [
                'mailtype'  => 'html',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_user' => '',    
                'smtp_pass' => '',      
                'smtp_port' => 465,
                'crlf'      => "\r\n",
                'newline'   => "\r\n"
            ];
            $kirim_data=((array)$data_undangan);
            $card = $this->load->view('v_email_undangan', $kirim_data, true);
            $this->load->library('email', $config);
            $this->email->from('noreply@tes.com', 'Republika Online');
            $this->email->to($data);
            $this->email->attach(base_url().'/assets/images/qr/QR'.$id_undangan.'.png');
            $this->email->subject('You have a new invitation.');
            // echo $card;
            // die;
            $this->email->message($card);
            if($this->email->send()) {
                $this->session->set_flashdata('pesan', 'Undangan berhasil terkirim');
                redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
            }   else {
                $this->session->set_flashdata('gagal', 'Undangan tidak terkirim');
                redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
            }
        } else {
            $this->session->set_flashdata('pesan', 'Tambah undangan berhasil');
            redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
        }
        } else {
            // echo validation_errors();
            $this->session->set_flashdata('gagal', validation_errors());
            redirect(base_url('index.php/Undangan/index/'.$id_event), 'refresh');
        }
            redirect(base_url('index.php/Undangan/index/'.$id_event), 'refresh');
    }
    public function simpan_kunjungan(){
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required',
		array('required' => 'Nama belum terisi'));
		$this->form_validation->set_rules('email', 'Alamat Email', 'trim|required',
		array('required' => 'Alamat Email belum terisi'));
		$this->form_validation->set_rules('no_telepon', 'No Telepon', 'trim|required',
		array('required' => 'No Telepon belum terisi'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required',
		array('required' => 'Jenis Kelamin belum terisi'));
		$this->form_validation->set_rules('id_karyawan', 'Tujuan', 'trim|required',
		array('required' => 'Tujuan belum terisi'));
		$this->form_validation->set_rules('asal', 'Asal Perusahaan', 'trim|required',
		array('required' => 'Asal Perusahaan belum terisi'));
		$this->form_validation->set_rules('keperluan', 'Keperluan', 'trim|required',
        array('required' => 'Keperluan belum terisi'));
        
        if($this->form_validation->run() == TRUE){
			$this->load->model('M_Kunjungan');
			$cek= $this->M_Kunjungan->masuk_db();
			if($cek == TRUE){
				echo "berhasil";
			}
			else{
				echo "gagal";
			}
			redirect(base_url('index.php/Kunjungan'));
			}
         else {
            echo validation_errors();
            $this->session->set_flashdata('gagal', validation_errors());
            redirect(base_url('index.php/Kunjungan'), 'refresh');
        }
    }
    public function hapus_undangan($id_undangan,$function_cont, $id_event){
        $hapus = $this->M_Undangan->hapus_undangan($id_undangan);
        if($hapus == TRUE){
            $this->session->set_flashdata('pesan', 'Hapus peserta berhasil');
            // echo 'oke';
            // die;
        } else {
            $this->session->set_flashdata('gagal', 'Hapus peserta gagal');
            echo 'eko';
            die;
        }
        redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
    }
     //** FUN SCIENCE **\\
     public function tabel_fun_science($id_event){
        $data['content']="v_tabel_fun_science";
        $data['isi_tabel']=$this->M_Undangan->get_undangan($id_event);
        $data['isi_tabel_fs']=$this->M_Undangan->get_undangan_khusus($id_event);
        $this->load->view('v_template', $data);
    }
    public function tambah_peserta_khusus($id_event, $function_cont){
        // die;
        $this->form_validation->set_rules('nama', 'Nama peserta', 'trim|required',
        array('required' => 'Baris 1 belum terisi'));
        $this->form_validation->set_rules('keterangan', 'Asal sekolah', 'trim|required',
        array('required' => 'Baris 2 belum terisi'));
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'trim|required',
        array('required' => 'Baris 3 belum terisi'));
        $this->form_validation->set_rules('opsi1', 'Nama orang tua', 'trim|required',
        array('required' => 'Baris 4 belum terisi'));
        $this->form_validation->set_rules('no_telepon', 'No telepon', 'trim|required',
        array('required' => 'Baris 5 belum terisi'));
        $this->form_validation->set_rules('opsi2', 'Alamat', 'trim|required',
        array('required' => 'Baris 6 belum terisi'));
        if($this->form_validation->run() == TRUE){
            $id_undangan= $this->M_Undangan->tambah_undangan_khusus($id_event);
            if(isset($_POST['kirim_in'])&& $_POST['kirim_in']=='kirim_in'){
                $data = $this->M_Undangan->undangan_email($id_undangan);
                $data_undangan = $this->M_Undangan->data_email($id_event, $id_undangan);
                $config = [
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'protocol'  => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_user' => '',    
                    'smtp_pass' => '',      
                    'smtp_port' => 465,
                    'crlf'      => "\r\n",
                    'newline'   => "\r\n"
                ];
                $kirim_data=((array)$data_undangan);
                $card = $this->load->view('v_email_undangan', $kirim_data, true);
                $this->load->library('email', $config);
                $this->email->from('noreply@tes.com', 'Republika Online');
                $this->email->to($data);
                $this->email->attach(base_url().'/assets/images/qr/QR'.$id_undangan.'.png');
                $this->email->subject('You have a new invitation.');
                // echo $card;
                // die;
                $this->email->message($card);
                if($this->email->send()) {
                    $this->session->set_flashdata('pesan', 'Undangan berhasil terkirim');
                    redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
                }   else {
                    $this->session->set_flashdata('gagal', 'Undangan tidak terkirim');
                    redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
                }
            } else {
                $this->session->set_flashdata('pesan', 'Tambah undangan berhasil');
                redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
            }
			if($id_undangan == FALSE){
                redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event), 'refresh');
            }
			else{
                redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event), 'refresh');
            
            }
			redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
            }
            
         else {
            $this->session->set_flashdata('gagal', validation_errors());
            redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event), 'refresh');
        }
    }
    public function get_autocomplete_fs(){
        if (isset($_GET['term'])) {
            $result = $this->M_Undangan->search_blog_fs($_GET['term']);
            if (count($result) > 0) {
			foreach ($result as $row)
				$new_row=(array) $row;
				$value= $row->nama_peserta;
				$arr_result[]=array('id_peserta'=>$row->id_peserta,'label'=>$value,'attribut'=>$new_row);
			}
			else{
				$arr_result[]=array('id'=>'','label'=>'','attribut'=>'');	
			}
			echo json_encode($arr_result);
        }
    }
    public function cetak_sertifikat($id_undangan){
        $tanggal_sertifikat = tanggal();
        $namapeserta = $this->M_Undangan->nama_peserta_sertif($id_undangan);
        $asal_sekolah = $this->M_Undangan->ambil_keterangan($id_undangan);
        $img_sertifikat = base_url('assets/images/new_fs.png');
        $pdf = new FPDF('l','mm','A4');
        $pdf->AddFont('Schadow-BT','','Schadow-BT.php');
        $pdf->AddFont('Boogaloo','','Boogaloo-Regular.php');
        $pdf->AddPage('O');
        $pdf->Image("$img_sertifikat",0,0,297,210);
        $pdf->SetFont('Boogaloo','',32);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,80,"$namapeserta",0,1,'C');
        $pdf->SetFont('Boogaloo','',15);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,-60,"$asal_sekolah",0,1,'C');
        $pdf->SetFont('Schadow-BT','',14);
        $pdf->Cell(0,78,'Telah mengikuti Program Pelatihan',0,1,'C');
        $pdf->setY(-12);
        $pdf->SetFont('Schadow-BT','',14);
        $pdf->Cell(285,-48,"Jakarta, $tanggal_sertifikat",0,1,'C');
        $pdf->setY(-170.5);
        $pdf->SetFont('Schadow-BT','',14);
        $pdf->Cell(0,0,'Diberikan kepada: ',0,1,'C');
        $fileName = 'Sertifikat Fun Science_' .$namapeserta. '.pdf';
        $pdf->Output($fileName, 'D');
    }
    public function cetak_sertifikat_akm($id_undangan){
        $tanggal_sertifikat = tanggal();
        $namapeserta = $this->M_Undangan->nama_peserta_sertif($id_undangan);
        $masjid = $this->M_Undangan->ambil_keterangan($id_undangan);
        $jabatan = $this->M_Undangan->ambil_jabatan($id_undangan);
        $img_sertifikat = base_url('assets/images/Sertifikat_AM.jpg');
        $pdf = new FPDF('l','mm','A4');
        $pdf->AddPage('O');
        $pdf->Image("$img_sertifikat",0,0,297,210);        
        $pdf->SetFont('Arial','B',28);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,115,"$namapeserta",0,1,'C');
        $pdf->SetFont('arial','',16);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,-90,"$jabatan Masjid $masjid",0,1,'C');
        $pdf->setY(-25);
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(278,-48,"Jakarta, $tanggal_sertifikat",0,1,'C');
        $fileName = 'Sertifikat Akuntansi Masjid_' .$namapeserta. '.pdf';
        $pdf->Output($fileName, 'D');
    }
    public function cetak_sertifikat_akmn($id_undangan){
        $tanggal_sertifikat = tanggal();
        $namapeserta = $this->M_Undangan->nama_peserta_sertif($id_undangan);
        $masjid = $this->M_Undangan->ambil_keterangan($id_undangan);
        $jabatan = $this->M_Undangan->ambil_jabatan($id_undangan);
        $img_sertifikat = base_url('assets/images/Piagam_AM.jpg');
        $pdf = new FPDF('l','mm','A4');
        $pdf->AddPage('O');
        $pdf->Image("$img_sertifikat",0,0,297,210);        
        $pdf->SetFont('Arial','B',26);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,105,"$namapeserta",0,1,'C');
        $pdf->SetFont('arial','',16);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,-80,"$jabatan",0,1,'C');
        $pdf->setY(-25);
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(278,-48,"Jakarta, $tanggal_sertifikat",0,1,'C');
        $fileName = 'Piagam Akuntansi Masjid_' .$namapeserta. '.pdf';
        $pdf->Output($fileName, 'D');
    }
    public function cetak_piagam_masjid($id_undangan){
        $tanggal_sertifikat = tanggal();
        $masjid = $this->M_Undangan->ambil_keterangan($id_undangan);
        $img_sertifikat = base_url('assets/images/Piagam_AM.jpg');
        $pdf = new FPDF('l','mm','A4');
        $pdf->AddPage('O');
        $pdf->Image("$img_sertifikat",0,0,297,210);        
        $pdf->SetFont('Arial','B',26);
        $pdf->setTextColor(35, 31, 32);
        $pdf->Cell(0,105,"Masjid $masjid",0,1,'C');
        $pdf->setY(-25);
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(278,-48,"Jakarta, $tanggal_sertifikat",0,1,'C');
        $fileName = 'Piagam Akuntansi Masjid_' .$masjid. '.pdf';
        $pdf->Output($fileName, 'D');
    }
    //**  END OF FUN SCIENCE **\\
    public function akuntansi_masjid($id_event){
        $data['content']="v_akuntansi_masjid";
        $data['isi_tabel_am']=$this->M_Undangan->get_undangan_khusus($id_event);
        $this->load->view('v_template', $data);
    }
    public function undangan_email($id_undangan,$function_cont,$id_event){
        $data = $this->M_Undangan->undangan_email($id_undangan);
        $data_undangan = $this->M_Undangan->data_email($id_event, $id_undangan);
        // $id = explode(',', $id_undangan);
        // $data_email = array_merge($data_undangan, $id);
        // print_r($data_email);
        // print_r($data_undangan);
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => '',    
            'smtp_pass' => '',      
            'smtp_port' => 465,
            'crlf'      => "\r\n",
            'newline'   => "\r\n"
        ];
        $kirim_data=((array)$data_undangan);
        $card = $this->load->view('v_email_undangan', $kirim_data, true);
        $this->load->library('email', $config);
        $this->email->from('noreply@tes.com', 'Republika Online');
        $this->email->to($data);
        // $this->email->attach($card);
		$this->email->attach(base_url().'/assets/images/qr/QR'.$id_undangan.'.png', "inline");
        $this->email->subject('You have a new invitation.');
        // echo $url_gambar; 
        // echo $card;
        // die;
        $this->email->message($card);
        if($this->email->send()) {
            redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
       }
       else {
            echo 'Email tidak berhasil dikirim';
            echo '<br />';
            echo $this->email->print_debugger();
            die;
            redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event));
       }
    }
    public function send_email($id_event){
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => '',    
            'smtp_pass' => '',      
            'smtp_port' => 465,
            'crlf'      => "\r\n",
            'newline'   => "\r\n"
        ];
        $this->load->library('email', $config);
        $mesg=$this->load->view('v_kunjungan');
		$this->email->from('noreply@tes.com', 'Republika');
		$this->email->to();
        $email_tamu = $this->M_Undangan->get_email_tamu($id_event);
        $email_karyawan = $this->M_Undangan->get_email_karyawan($id_event);
        $result = array_merge($email_karyawan, $email_tamu);
        print_r($result);
        die;
        $ccbanyak = array();
        // print_r ($result);
        foreach($result as $value){
            echo $value->email."<br>";
            // array_push($ccbanyak,$value['email']);
        }
        die;
		$this->email->cc($ccbanyak);
		$this->email->subject('Anda mendapatkan undangan ');
		$this->email->message($mesg);
		$this->email->send();
    }
    public function get_detail_user($id_undangan=''){
		$data_detail=$this->M_Undangan->detail_user($id_undangan);
		echo json_encode($data_detail);
    }
    // public function nama($id_undangan){
    //     $coba = $this->M_Undangan->nama_peserta_sertif($id_undangan);
    //     print_r($coba);echo $coba;die;
    // }
    public function update_peserta($function_cont,$id_event){
		$this->form_validation->set_rules('nama', 'Nama peserta', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Asal sekolah', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('opsi1', 'Nama ortu', 'trim|required');
		$this->form_validation->set_rules('email', 'Alamat Email', 'trim|required');
		$this->form_validation->set_rules('opsi2', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('no_telepon', 'No telepon', 'trim|required');
		if($this->form_validation->run() == FALSE){
		   $this->session->set_flashdata('pesan', validation_errors());
			redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event),'refresh');
		}
		else{
			$proses_update=$this->M_Undangan->update_user();
			redirect(base_url('index.php/Undangan/'.$function_cont.'/'.$id_event), 'refresh');
		}
	}
}