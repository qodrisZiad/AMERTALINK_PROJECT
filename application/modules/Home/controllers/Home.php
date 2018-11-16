<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index(){		
		is_logged();
		$data = array(
			'subtitle'  =>'Home Page',
			'greeting'  => $this->session->userdata('greeting'),
			'userid'    => $this->session->userdata('userid'),
			'bread'     => 'HOME',
			'sub_bread' =>' /homepage'
		);		
		loadView('v_view', $data, 1);
	}
}