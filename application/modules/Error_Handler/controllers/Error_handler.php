<?php defined('BASEPATH') or exit('maaf akses anda kami tutup');
class Error_handler extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function index(){
		$data = array('title' => 'Amertalink Store',
			'footer' => '©2018 All Rights Reserved.',
			'icon_web'=>'favicon.png'
		);
		$this->load->view('v_view',$data);
	}
}