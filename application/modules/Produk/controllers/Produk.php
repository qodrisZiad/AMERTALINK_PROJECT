<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Produk extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "t_stock";
	private $primary_key = "fc_stock";
	private $secondary_key = "fv_stock";
	private $kolom = array("fc_stock","fv_stock","kategori","fv_ket","fn_min","master_Properti","master_Variant","master_Uom","fc_status","fc_userid","fd_input");
	public function index(){
		if(empty($this->session->userdata('userid'))){
			redirect('Login');
		}
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Master Produk',
			'footer'    => '&copy All Rights Reserved.',
			'icon_web'  => 'favicon.png',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Produk',
			'sub_bread' => '/ Master Produk',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3],
			'kategori'  => $this->getKategori(),
			'Properti'  => $this->getProperti(),
			'ukuran' 	=> $this->getUkuran(),
			'warna'  	=> $this->getWarna(),
			'Satuan'	=> $this->getSatuan() 
		);
		$this->load->view('Template/v_header',$data);
		$this->load->view('Template/v_datatable');
		$this->load->view('Template/v_sidemenu',$data);
		$this->load->view('v_view',$data);
		$this->load->view('v_properti',$data);
		$this->load->view('v_variant',$data);
		$this->load->view('v_uom',$data);
		$this->load->view('v_img',$data);
		$this->load->view('Template/v_footer',$data);  		
		//loadView(array('v_view','v_properti','v_variant','v_uom','v_img'), $data, 0); 
	}
	public function Simpan(){
		$aksi = $this->input->post('aksi');
		$hasil = array('message'=>'', 'proses' => 0, 'nextNomor' => 0);
		$data = array(
			'fc_stock'    => $this->input->post('a1'),
			'fv_stock'    => $this->input->post('a5'),
			'fv_ket'      => $this->input->post('a6'),
			'fc_kategori' => str_pad($this->input->post('a2'),2,"0",STR_PAD_LEFT).str_pad($this->input->post('a3'),2,"0",STR_PAD_LEFT).str_pad($this->input->post('a4'),2,"0",STR_PAD_LEFT),
			'fn_min' => $this->input->post('a7'),
			'fc_status' => $this->input->post('a8'),
			'fc_userid' => $this->session->userdata('userid'),
			'fd_input' => date('Y-m-d')
		);
		if ($aksi == 'tambah') {
			$hasil['proses'] = $this->M_model->tambah("t_stock",$data);
		}else if($aksi =='update'){
			$where = array($this->primary_key => $this->input->post('a1'));
			$hasil['proses'] = $this->M_model->update("t_stock",$data,$where);
		}
		if ($hasil['proses'] > 0) {
			if ($aksi == 'tambah') {
				updateNomor("SKU");
				$hasil['nextNomor'] = getNomor("SKU");
			}
			$hasil['message'] = 'Berhasil menyimpan data';
		}else{
			$hasil['message'] = 'Gagal menyimpan data'; 
		}  
		echo json_encode($hasil);
	}
	public function Edit(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$edit = $this->M_model->getData("v_stock",$data);
		echo json_encode($edit);
	} 
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$hapus = $this->M_model->hapus("t_stock",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function data(){ 
		$tabel = "v_stock";  
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
	public function getNomor(){echo getNomor($this->uri->segment(3));}
	// INI UNTUK PROPERTI
	public function getProperti(){
		$properti = $this->M_model->getProperti();
		$arr_data = array();
			$arr_data[""] = "Pilih";
	 	 foreach ($properti as $hasil) {
	 	 	$arr_data[$hasil->fc_kdprop] = $hasil->fv_prop; 
	 	 }
		return $arr_data;
	}
	public function getSubProp(){
		$where = array('fc_stock' => $this->uri->segment(3),'fc_kdprop' => $this->uri->segment(4));
		$subkategori = $this->M_model->getSubProp($where);
		$data = "";
			$data .= "<option>Pilih</option>";
	 	 foreach ($subkategori as $hasil) { 
	 	 	$data .= "<option value='".$hasil->fc_kdsubprop."'>".$hasil->fv_subprop."</option>";  
	 	 }
		echo $data;
	}
	public function SimpanProp(){
		$aksi = $this->input->post('aksi_prop');
		$message = ""; 
		$data = array(
			'fc_stock'    => $this->input->post('sku_prop'),
			'fc_kdprop'    => $this->input->post('b1'),
			'fc_kdsubprop'    => $this->input->post('b2'),
			'fc_userid'    => $this->session->userdata('userid'),
			'fd_last_update'    => date("Y-m-d h:i:s")
		);
		if ($aksi == 'tambah') {
			$where_check = array(
				'fc_stock'     => $this->input->post('sku_prop'),
				'fc_kdprop'    => $this->input->post('b1'),
				'fc_kdsubprop' => $this->input->post('b2')
			);
			if($this->M_model->checkProp('t_stockprop',$where_check) > 0){
				$proses = '0';
			}else{
				$proses = $this->M_model->tambah("t_stockprop",$data);
			}
		}else if($aksi =='update'){
			$where = array("fc_id" => $this->input->post('a1'));
			$proses = $this->M_model->update("t_stockprop",$data,$where);
		}
		if ($proses > 0) { 
			$hasil = 'Berhasil menyimpan data';
		}else{
			$hasil = 'Gagal menyimpan data,Data sudah ada.'; 
		}  
		echo json_encode($hasil);
	}
	public function data_Prop(){ 
		$kolomProp = array("fc_id","fc_stock","fc_kdprop","fc_kdsubprop","fc_userid","fd_last_update","fv_prop","fv_subprop");
		$tabel = "v_stockProp";  
		$where = array('fc_stock' => $this->uri->segment(3));
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolomProp[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $totalData = $this->M_model->allposts_countWhere($tabel,$where); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allpostsWhere($tabel,$limit,$start,$order,$dir,$where);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_searchWhere($tabel,"fv_prop","fv_subprop",$limit,$start,$search,$order,$dir,$where); 
            $totalFiltered = $this->M_model->posts_search_countWhere($tabel,"fv_prop","fv_subprop",$search,$where);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($kolomProp) ; $i++) {
                	$hasil = $kolomProp[$i]; 
                	$nestedData[$kolomProp[$i]] = $post->$hasil;
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
	public function HapusProp(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->M_model->hapus("t_stockprop",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	//UNTUK VARIANTNYA
	public function getUkuran(){
		$ukuran = $this->M_model->getUkuran();
		$arr_data = array();
		$arr_data[""] = "Pilih";
	 	foreach ($ukuran as $hasil) {
	 	 	$arr_data[$hasil->fc_size] = $hasil->fv_size; 
	 	}
		return $arr_data;
	}
	public function getWarna(){
		$size = $this->M_model->getWarna();
		$arr_data = array();
		$arr_data[""] = "Pilih";
		foreach ($size as $hasil) {
			$arr_data[$hasil->fc_warna] = $hasil->fv_warna; 
		}
		return $arr_data;
	}
	public function SimpanVariant(){
		$aksi = $this->input->post('aksi_variant');
		$message = ""; 
		$data = array(
			'fc_stock'    => $this->input->post('sku_variant'),
			'fc_size'    => $this->input->post('c1'),
			'fc_warna'    => $this->input->post('c2'),
			'fc_userid'    => $this->session->userdata('userid')
		);
		if ($aksi == 'tambah') {
			$where_check = array(
				'fc_stock'     => $this->input->post('sku_variant'),
				'fc_size'    => $this->input->post('c1'),
				'fc_warna' => $this->input->post('c2')
			);
			if($this->M_model->checkProp('t_variant',$where_check) > 0){
				$proses = '0';
			}else{
				$proses = $this->M_model->tambah("t_variant",$data);
			}
		}else if($aksi =='update'){
			$where = array("fc_id" => $this->input->post('a1'));
			$proses = $this->M_model->update("t_variant",$data,$where);
		}
		if ($proses > 0) { 
			$hasil = 'Berhasil menyimpan data';
		}else{
			$hasil = 'Gagal menyimpan data,Data sudah ada.'; 
		}  
		echo json_encode($hasil);
	}
	public function data_Variant(){ 
		$kolomVariant = array("fc_variant","fc_stock","fv_size","fv_warna","fc_userid");
		$tabel = "v_variant";  
		$where = array('fc_stock' => $this->uri->segment(3));
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolomVariant[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $totalData = $this->M_model->allposts_countWhere($tabel,$where); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allpostsWhere($tabel,$limit,$start,$order,$dir,$where);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_searchWhere($tabel,"fv_size","fv_warna",$limit,$start,$search,$order,$dir,$where); 
            $totalFiltered = $this->M_model->posts_search_countWhere($tabel,"fv_size","fv_warna",$search,$where);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($kolomVariant) ; $i++) {
                	$hasil = $kolomVariant[$i]; 
                	$nestedData[$kolomVariant[$i]] = $post->$hasil;
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
	public function HapusVariant(){
		$kode = $this->uri->segment(3);
		$data = array("fc_variant" => $kode);
		$hapus = $this->M_model->hapus("t_variant",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	//UNTUK UOMNYA
	public function getSatuan(){
		$ukuran = $this->M_model->getSatuan();
		$arr_data = array();
		$arr_data[""] = "Pilih";
	 	foreach ($ukuran as $hasil) {
	 	 	$arr_data[$hasil->fc_satuan] = $hasil->fv_satuan; 
	 	}
		return $arr_data;
	}
	public function data_Uom(){ 
		$kolomVariant = array("fc_uom","fv_satuan","fn_uom","fc_default","fc_userid");
		$tabel = "v_uom";  
		$where = array('fc_stock' => $this->uri->segment(3));
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolomVariant[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $totalData = $this->M_model->allposts_countWhere($tabel,$where); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allpostsWhere($tabel,$limit,$start,$order,$dir,$where);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_searchWhere($tabel,"fv_satuan","fv_satuan",$limit,$start,$search,$order,$dir,$where); 
            $totalFiltered = $this->M_model->posts_search_countWhere($tabel,"fv_satuan","fv_satuan",$search,$where);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($kolomVariant) ; $i++) {
                	$hasil = $kolomVariant[$i]; 
                	$nestedData[$kolomVariant[$i]] = $post->$hasil;
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
	public function SimpanUom(){
		$aksi = $this->input->post('aksi_uom');
		$message = ""; 
		$data = array(
			'fc_stock'    => $this->input->post('sku_uom'),
			'fc_satuan'    => $this->input->post('d1'),
			'fn_uom'    => $this->input->post('d2'),
			'fc_userid'    => $this->session->userdata('userid')
		);
		if ($aksi == 'tambah') {
			$where_check = array(
				'fc_stock'     => $this->input->post('sku_uom'),
				'fn_uom'    => $this->input->post('d1')
			);
			if($this->M_model->checkProp('t_uom',$where_check) > 0){
				$proses = '0';
			}else{
				$proses = $this->M_model->tambah("t_uom",$data);
			}
		}else if($aksi =='update'){
			$where = array("fc_uom" => $this->input->post('kode_uom'));
			$proses = $this->M_model->update("t_uom",$data,$where);
		}
		if ($proses > 0) { 
			if ($this->input->post('d2') == '1') {
				$this->M_model->updateDefault($this->input->post('sku_uom'),$this->input->post('d1'),"1");
			}
			$hasil = 'Berhasil menyimpan data';
		}else{
			$hasil = 'Gagal menyimpan data,Data sudah ada.'; 
		}  
		echo json_encode($hasil);
	} 
	public function HapusUom(){
		$kode = $this->uri->segment(3);
		$data = array("fc_uom" => $kode);
		$hapus = $this->M_model->hapus("t_uom",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}

	public function HapusImg(){
		$kode = $this->uri->segment(3);
		$foto = $this->uri->segment(4);
		$data = array("fc_id" => $kode);
		$hapus = $this->M_model->hapus("t_thumbnail",$data);
		if ($hapus > 0) {
			$dir = "./assets/foto/".$foto;
			unlink($dir); 
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	//untuk gambarnya
	public function warnaProduk(){
		$kode = $this->uri->segment(3);
		$warna = $this->M_model->getWarnaProduk($kode);
		$data = "";
			$data .= "<option>Pilih</option>";
	 	 foreach ($warna as $hasil) { 
	 	 	$data .= "<option value='".$hasil->fc_warna."'>".$hasil->fv_warna."</option>";  
	 	 }
		echo $data;
	}
	public function getImage(){
		$hasile = array();
		$gambar = $this->M_model->getThumbnail($this->uri->segment(3));
		foreach ($gambar as $key) {
			$hasil['fc_id'] = $key->fc_id; 
			$hasil['fv_img'] = $key->fv_img; 
			$hasil['fv_warna'] = $key->fv_warna; 
			array_push($hasile,$hasil);
		}
		echo json_encode($hasile);
	}
	public function SimpanImg(){
		$aksi = $this->input->post('aksi_img');
		$message = ""; 
			if (!empty($_FILES['e2']['name'])) {
				upload('e2');
				$data = array(
					'fc_stock'  => $this->input->post('sku_img'), 
					'fc_warna'  => $this->input->post('e1'),
					'fv_img'    => $_FILES['e2']['name'],
					'fc_status' => "1"
				);
			}
			if ($aksi == 'tambah') {
				$proses = $this->M_model->tambah("t_thumbnail",$data);
			}
			if ($proses > 0) {
				$message = 'Berhasil menyimpan data';
			}else{
				$message = 'Gagal menyimpan data'; 
			} 
		echo json_encode($message);
	}
}