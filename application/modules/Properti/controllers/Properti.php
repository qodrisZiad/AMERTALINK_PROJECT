<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Properti extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "tm_prop";
	private $primary_key = "fc_kdprop";
	private $secondary_key = "fv_prop";
	private $kolom = array("fc_kdprop","fv_prop","fc_status");
	private $kolomDetail = array("fc_kdsubprop","fc_kdprop","fv_subprop","fc_kat","fc_subkat","fc_subsubkat","fv_kat","fv_subkat","fv_subsubkat","fc_status");
	public function index(){
		if(empty($this->session->userdata('userid'))){
			redirect('Login');
		}
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'  =>'Master Properti',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Properti',
			'sub_bread' => '/ Master Properti',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3],
			'kategori'  => $this->getKategori() 
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
					'fv_prop'    => $this->input->post('a1'), 
					'fc_status' => $this->input->post('a2')
				);
			if ($aksi == 'tambah') {
				$proses = $this->M_model->tambah("tm_prop",$data);
			}else if($aksi =='update'){
				$where = array($this->primary_key => $this->input->post('kode'));
				$proses = $this->M_model->update("tm_prop",$data,$where);
			}
			if ($proses > 0) {
				$message = 'Berhasil menyimpan data';
			}else{
				$message = 'Gagal menyimpan data'; 
			} 
		echo json_encode($message);
	}
	public function SimpanDetail(){
		$aksi = $this->input->post('aksiDetail');
		$message = ""; 
				$data = array(
					'fc_kdprop'   => $this->input->post('kodeMaster'), 
					'fv_subprop'  => $this->input->post('b4'),
					'fc_status'   => $this->input->post('b5'),
					'fc_kategori' => str_pad($this->input->post('b1'),2,"0",STR_PAD_LEFT).str_pad($this->input->post('b2'),2,"0",STR_PAD_LEFT).str_pad($this->input->post('b3'),2,"0",STR_PAD_LEFT)
				);
			if ($aksi == 'tambah') {
				$proses = $this->M_model->tambah("td_prop",$data);
			}else if($aksi =='update'){
				$where = array("fc_kdsubprop" => $this->input->post('kodeDetail'));
				$proses = $this->M_model->update("td_prop",$data,$where);
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
		$edit = $this->M_model->getData("tm_prop",$data);
		echo json_encode($edit);
	} 
	public function EditDetail(){
		$kode = $this->uri->segment(3);
		$data = array("fc_kdsubprop" => $kode);
		$edit = $this->M_model->getData("v_detailProp",$data);
		echo json_encode($edit);
	}
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$hapus = $this->M_model->hapus("tm_prop",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function HapusDetail(){
		$kode = $this->uri->segment(3);
		$data = array("fc_kdsubprop" => $kode);
		$hapus = $this->M_model->hapus("td_prop",$data);
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
	public function dataDetail(){ 
		$whereMaster = array('fc_kdprop' => $this->uri->segment(3));
		$tabel = "v_detailProp";  
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolomDetail[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $totalData = $this->M_model->allposts_countDetail($tabel,$whereMaster); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allpostsDetail($tabel,$whereMaster,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_searchDetail($tabel,$whereMaster,"fv_subprop","fv_kat",$limit,$start,$search,$order,$dir); 
            $totalFiltered = $this->M_model->posts_search_countDetail($tabel,$whereMaster,"fv_subprop","fv_kat",$search);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($this->kolomDetail) ; $i++) {
                	$hasil = $this->kolomDetail[$i]; 
                	$nestedData[$this->kolomDetail[$i]] = $post->$hasil;
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
	public function getKategori(){
		$jabatan = $this->M_model->getKategori();
		$arr_data = array();
			$arr_data[""] = "Pilih Kategori";
	 	 foreach ($jabatan as $hasil) {
	 	 	$arr_data[$hasil->fc_kat] = $hasil->fv_kat; 
	 	 }
		return $arr_data;
	}
	public function getSubkategories(){
		if (!empty($this->uri->segment(3))) {
			$where = array('fc_kat' => $this->uri->segment(3),'fc_status' => '1');
		}else{
			$where = array('fc_status' => '1');
		}
		$subkategori = $this->M_model->getSubkategori($where);
		$data = "";
			$data .= "<option>Pilih</option>";
	 	 foreach ($subkategori as $hasil) { 
	 	 	$data .= "<option value='".$hasil->fc_subkat."'>".$hasil->fv_subkat."</option>";  
	 	 }
		echo $data;
	}
	public function getSubSubkategories(){
		if (!empty($this->uri->segment(3))) {
			$where = array('fc_kdkat' => $this->uri->segment(3),'fc_kdsubkat' => $this->uri->segment(4),'fc_status' => '1');
		}else{
			$where = array('fc_status' => '1');
		}
		$subkategori = $this->M_model->getSubSubkategori($where);
		$data = "";
		$data .= "<option>Pilih</option>";
	 	 foreach ($subkategori as $hasil) { 
	 	 	$data .= "<option value='".$hasil->fc_kdsubsubkat."'>".$hasil->fv_subsubkat."</option>";  
	 	 }
		echo $data;
	}
}