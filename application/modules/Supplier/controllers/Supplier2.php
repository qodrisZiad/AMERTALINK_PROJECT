<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Supplier extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "tm_supplier";
	private $primary_key = "fc_kdsupplier";
	private $secondary_key = "fv_supplier";
	private $kolom = array("fc_kdsupplier","fv_supplier","fv_addr","fc_telp","fc_telp2","fv_owner","fd_join","fd_kunjungan","fn_hutang","fd_last_trans","fc_userid","fc_status");
	public function index(){
		if(empty($this->session->userdata('userid'))){
			redirect('Login');
		}
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'title'     =>'Master Supplier',
			'footer'    => '&copy All Rights Reserved.',
			'icon_web'  => 'favicon.png',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Supplier',
			'sub_bread' => '/ Master Supplier',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3]
		);
		$this->load->view('Template/v_header',$data);
		$this->load->view('Template/v_datatable');
		$this->load->view('Template/v_sidemenu',$data);
		$this->load->view('v_view',$data);
		$this->load->view('Template/v_footer',$data);
	}
	public function Simpan(){
		$aksi = $this->input->post('aksi');
		$message = ""; 
			$data = array(
				'fc_kdsupplier' => $this->input->post('a1'),
				'fv_supplier'	 => $this->input->post('a2'),
				'fv_addr'	 => $this->input->post('a3'),
				'fc_telp'	 => $this->input->post('a4'),
				'fc_telp2'	 => $this->input->post('a5'),
				'fv_owner'	 => $this->input->post('a6'),
				'fd_kunjungan'	 => $this->input->post('a7'),
				'fd_join'	 => $this->input->post('a8'),
				'fc_status'	 => $this->input->post('a9'),
				'fc_userid'	 => $this->session->userdata('userid')
			);
			if ($aksi == 'tambah') {
				$proses = $this->M_model->tambah($data);
			}else if($aksi =='update'){
				$where = array($this->primary_key => $this->input->post('a1'));
				$proses = $this->M_model->update($data,$where);
			}
			if ($proses > 0) {
				if ($aksi == 'tambah') {
					updateNomor("SUPL");
				}
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