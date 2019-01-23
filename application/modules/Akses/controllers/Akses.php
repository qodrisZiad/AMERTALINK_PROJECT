<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 

class Akses extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model','model');
	}
	private $table = "t_hakakses";
	private $primary_key = "fc_idmenu";
	private $secondary_key = "fv_menu";
	private $kolom = array("fc_userid","fv_menu","fc_idmenu","fc_input","fc_update","fc_delete","fc_view");
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'  =>'Hak Akses',			
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Hak Akses',
			'sub_bread' => '/ Mengatur Akses Tiap Pengguna',
			'listuser'	=> $this->getListUser(),
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3] 
		);
		loadView('v_view', $data);
	}
	public function Simpan(){
		$aksi = $this->input->post('aksi');
		$menu = $this->input->post('b1');
		$message = "";  
		if (count($menu) > 0){
			foreach ($menu as $key => $value) {
				$data_input = array(
					'fc_userid'	=> $this->input->post('b0'),
					'fc_idmenu'	=> $value,
					'fc_input'	=>( ($this->input->post('b2a') != '')? $this->input->post('b2a') : '0' ),
					'fc_update'	=>( ($this->input->post('b2b') != '')? $this->input->post('b2b') : '0' ),
					'fc_delete'	=>( ($this->input->post('b2c') != '')? $this->input->post('b2c') : '0' ),
					'fc_view'	=>( ($this->input->post('b2d') != '')? $this->input->post('b2d') : '0' ),
					'fc_userinput'	=> $this->session->userdata('userid'),
					'fd_input'	=> date("Y-m-d")
				);
				$proses = $this->model->tambah($data_input);
			}
		}
			if ($proses > 0) {
				resetMenuSession();
				$message = 'Berhasil menyimpan data';
			}else{
				$message = 'Gagal menyimpan data'; 
			} 
		echo json_encode($message);
	}	
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$user = $this->uri->segment(4);
		$data = array('fc_idmenu' => $kode, 'fc_userid' => $user);
		$hapus = $this->model->hapus($data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data ".$kode;
			resetMenuSession();
		}else{
			echo "Gagal menghapus data ".$kode;
		}
	}
	public function data(){ 
		$tabel = $this->table; 		
		$user = $this->input->post('data');
        $totalData = $this->model->getDataMenu($user,1); 
		$totalFiltered = $totalData;  
		$data = $this->model->getDataMenu($user,2);        
        $json_data = array(
					"user"			  => $user,
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
		echo json_encode($json_data); 
	}	
	private function getListUser(){                    
		$users = $this->model->getDataUser();
		$list = '';                   
		foreach ($users as $user) {                    
			$list .= '<option value="'.$user->fc_userid.'">'.$user->fc_userid.'</option>';
		}
		return $list;
	}
	public function listmenu(){
		$hasil = '';
		$user = $this->input->get('b0');
		$list = $this->model->getListMenu($user);
		foreach ($list as $value) {
			$hasil .= "<option value='".$value->fc_id."'>$value->fv_menu</option> \n";
		}
		if($user=='') { echo ''; } else { echo $hasil; }
	}
}