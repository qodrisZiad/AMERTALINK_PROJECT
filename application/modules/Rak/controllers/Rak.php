<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Rak extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "tm_rak";
	private $primary_key = "fc_rak";
	private $secondary_key = "fv_rak";
	private $kolom = array("fc_rak","fv_rak","fn_max","fc_status","fc_userid");
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Master Rak',
			'footer'    => '&copy All Rights Reserved.',
			'icon_web'  => 'favicon.png',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Rak',
			'sub_bread' => '/ Master Rak',
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
			$data = array(
				'fv_rak' => $this->input->post('a1'),
				'fn_max' => $this->input->post('a2'),
				'fc_status'	 => $this->input->post('a3'),
				'fc_userid'	 => $this->session->userdata('userid')
			);
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
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolom[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $totalData = $this->M_model->allposts_count($tabel); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allposts($tabel,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_search($tabel,$this->primary_key,$this->secondary_key,$limit,$start,$search,$order,$dir); 
            $totalFiltered = $this->M_model->posts_search_count($tabel,$this->primary_key,$this->secondary_key,$search);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($this->kolom) ; $i++) {
                	$hasil = $this->kolom[$i]; 
                	$nestedData[$this->kolom[$i]] = $post->$hasil;
                }  
                $data[] = $nestedData; 
            }
        } 
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
        echo json_encode($json_data); 
	} 
}