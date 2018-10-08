<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session'); 
	}
	function index(){
		if(empty($this->session->userdata('userid'))){
			redirect('Login');
		}
		$data = array(
			'title'     =>'AmertaLink Store',
			'footer'    => '&copy All Rights Reserved.',
			'icon_web'  => 'favicon.png',
			'greeting'  => $this->session->userdata('greeting'),
			'userid'       => $this->session->userdata('userid'),
			'bread'     => 'HOME',
			'sub_bread' =>' /homepage'
		);
		$this->load->view('Template/v_header',$data);
		$this->load->view('Template/v_sidemenu',$data);
		$this->load->view('v_view',$data);
		$this->load->view('Template/v_footer',$data);
	}
}