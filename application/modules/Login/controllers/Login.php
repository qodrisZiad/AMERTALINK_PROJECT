<?php defined('BASEPATH') OR exit('Maaf akses anda kami tutup');
error_reporting(0);
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_login');
	}
	public function index($error = null){		
		is_logged();
		$data = array(
			'subtitle' => 'Login Page',
			'error' => $error
		);
		$this->load->view('v_view',$data);
	}

	public function auth(){
		$userid = $this->input->post('userid');
		$pass 	= $this->input->post('password');
		$login  = $this->m_login->login($userid,$pass); 
		if ($login == 1) {
			$row = $this->m_login->getData($userid,$pass);
			$data_user = array(
				'userid' => $userid,
				'greeting' => $row->greeting
			);
			$this->session->set_userdata($data_user);
			$hasil = 1;
		}else{
			$hasil = 0;
		}
		echo json_encode($hasil);
	}

	public function logout(){
		$this->session->unset_userdata('userid');
		redirect(site_url());
	}

}