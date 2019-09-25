<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Undangan');
    }
    public function index(){
        if($this->session->userdata('logged_in')== TRUE){
        $data['content']="v_dashboard";
        $data['id_fs']=$this->M_Undangan->dashboard_fs();
        // print_r($data);
        // die;
		$this->load->view('v_template', $data);
        }
    }
}
?>