<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 

class Akses extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "t_hakakses";
	private $primary_key = "fc_id";
	private $secondary_key = "fv_menu";
	private $kolom = array("fc_userid","fv_menu","fc_input","fc_update","fc_delete","fc_view");
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'  =>'Master SubKategori',			
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Sub-Kategori',
			'sub_bread' => '/ Master SubKategori',
			'listuser'	=> $this->getListUser(),
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3] 
		);
		loadView('v_view', $data, 0);
	}
	public function Simpan(){
		$aksi = $this->input->post('aksi');
		$message = "";  
			if (!empty($_FILES['a3']['name'])) {
				upload('a3');
				$data = array(
					'fc_kat'    => $this->input->post('a1'), 
					'fv_subkat'    => $this->input->post('a2'), 
					'fv_pict' => $_FILES['a3']['name'],
					'fc_status' => $this->input->post('a4')
				);
			}else{
				$data = array(
					'fc_kat'    => $this->input->post('a1'), 
					'fv_subkat'    => $this->input->post('a2'), 
					'fc_status' => $this->input->post('a4')
				);
			}
			if ($aksi == 'tambah') {
				$proses = $this->M_model->tambah($data);
			}else if($aksi =='update'){
				$where = array($this->primary_key => $this->input->post('kode'));
				$proses = $this->M_model->update($data,$where);
			}
			if ($proses > 0) {
				$message = 'Berhasil menyimpan data';
			}else{
				$message = 'Gagal menyimpan data'; 
			} 
		echo json_encode($message);
	}
	public function Edit(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$edit = $this->M_model->getData($data);
		echo json_encode($edit);
	} 
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$hapus = $this->M_model->hapus($data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function data(){ 
		$tabel = $this->table; 		
        $totalData = $this->M_model->getDataMenu(1); 
		$totalFiltered = $totalData;  
		$data = $this->M_model->getDataMenu(0);        
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
        echo json_encode($json_data); 
	} 
	private function getListUser(){
		$users = $this->M_model->getDataUser();
		$list = '';
	 	 foreach ($users as $user) {
	 	 	$list .= '<option value="'.$user->fc_userid.'">'.$user->fc_userid.'</option>';
	 	 }
		return $list;
	}
}