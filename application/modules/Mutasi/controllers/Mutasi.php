<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Mutasi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "tm_mutasi";
	private $primary_key = "fc_nomutasi";
	private $secondary_key = "fv_warna";
	private $kolom = array("fc_nomutasi","fd_mutasi","fc_branch","fc_wh","fc_branch_to","fc_wh_to","fn_jenis","fn_qty","fm_total","fv_note","fc_userid","fc_status"); 
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Mutasi Barang',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('nik'),
			'userid'    => $this->session->userdata('userid'),
			'bread'     => 'Mutasi Barang',
			'sub_bread' => '/ Antar Cabang [Gudang]',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3],
			'branch'	=> $this->session->userdata('branch')
		);
		loadView('v_view', $data, 0);
	}
// ------------------------- master data ----------------------------------------					
	public function SimpanMst(){
		$aksi     	 = $this->input->post('aksi');
		$nomutasi 	 = $this->input->post("a1");
		//$tglmutasi 	 = date('Y-m-d',strtotime($this->input->post("a2")));
		$tglmutasi 	 = $this->input->post("a2");
		$branch 	 = $this->input->post("a3");
		$wh   	 	 = $this->input->post("a4");
		$branch_to   = $this->input->post("a5");
		$wh_to       = ($this->input->post("a6")!='') ? $this->input->post("a6") : $this->input->post("wh_to");
		$catatan  	 = $this->input->post("a8");
		$userid   	 = $this->input->post("a9");
			$message = ""; 
			$data = array(
				'fc_branch'     => $this->session->userdata("branch"),
				'fc_nomutasi'      	=> $nomutasi,
				'fd_mutasi'        	=> $tglmutasi,
				'fc_branch' 		=> $branch,
				'fc_wh'         	=> $wh,
				'fc_branch_to' 		=> $branch_to,
				'fc_wh_to'         	=> $wh_to,
				'fd_input'      	=> date("Y-m-d H:m:s",time()),
				'fc_userid'     	=> $userid,
				'fv_note'       	=> $catatan
			);
			$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nomutasi" => $nomutasi,"fc_status" => "I");
			if ($this->checkMst($where) == 0) {
				// jika statusnya I dan nomutasi = userid maka di input
				$proses = $this->M_model->tambah("tm_mutasi",$data);
			}else if($this->checkMst($where) > 0){
				$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nomutasi" => $nomutasi);
				$proses = $this->M_model->update("tm_mutasi",$data,$where);
			}
			if ($proses > 0) {
				$message = 'Berhasil menyimpan data';
			}else{
				$message = 'Gagal menyimpan data'; 
			} 
		echo json_encode($message);
	}
	public  function checkMst($where){
		$data = $this->M_model->checkMst($where);
		return $data;
	}
	public function EditMst(){
		$branch = $this->uri->segment(3);
		$nomutasi = $this->uri->segment(4);
		$data = array("fc_branch" => $branch,"fc_nomutasi" => $nomutasi, "fc_status != " => "F");
		$edit = $this->M_model->getData("tm_mutasi",$data);
		echo json_encode($edit);
	}
	// public function getWareHouse($branch){
	// 	$branch = $this->uri->segment(3);
	// 	$data .= "<option value=''>Pilih Gudang</option>";
	// 	foreach (getWareHouse($branch) as $wh) {
	// 		$data .= "<option value='".$wh->fc_wh."'>".$wh->fv_wh."</option>"; 
	// 	}
	// 	echo $data;
	// }  
// ------------------------- end data ----------------------------------------	
// ------------------------- data intro ----------------------------------------									
	public function data(){ 
		$tabel = "v_mutasi";
		$kolomLaporan = array("fc_nomutasi","fd_mutasi","fc_branch","fv_branch","fv_wh","fv_branch_to","fv_wh_to","fn_jenis","fn_qty","fm_total","fv_note","fc_userid","fc_status");   
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
                for ($i=0; $i < count($kolomLaporan) ; $i++) {
                	$hasil = $kolomLaporan[$i]; 
                	$nestedData[$kolomLaporan[$i]] = $post->$hasil;
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
// ------------------------- end data intro ----------------------------------------
// ------------------------- detail data ----------------------------------------											
	public function dataBPBDetail(){ 
		$kolomDetail = array("fc_id","fc_nomutasi","fc_stock","fv_stock","variant","fv_satuan","fn_qty","price","fv_ket");
		$tabel = "v_detailMutasi";  
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolom[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $where = array("fc_branch" => $this->session->userdata('branch'),"fc_nomutasi" => $this->uri->segment(3));
        $totalData = $this->M_model->allposts_count($tabel,$where); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allposts($tabel,$limit,$start,$order,$dir,$where);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_search($tabel,"fc_stock","fv_stock",$limit,$start,$search,$order,$dir,$where); 
            $totalFiltered = $this->M_model->posts_search_count($tabel,"fc_stock","fv_stock",$search,$where);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($kolomDetail) ; $i++) {
                	$hasil = $kolomDetail[$i]; 
                	$nestedData[$kolomDetail[$i]] = str_replace("'","",$post->$hasil);
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
	public function simpanDetail(){
			$aksi       = $this->input->post("aksiDetail");
			$kode       = $this->input->post("kodeDetail");
			$nomutasi   = $this->input->post("nomutasi");
			$wh_asal    = $this->input->post("wh_asal");
			$sku        = $this->input->post("b1");
			$size       = $this->input->post("b2"); // useless
			$color		= $this->input->post("b3"); // useless
			$satuan     = $this->input->post("b4");
			$qty        = $this->input->post("b5");
			$keterangan = $this->input->post("b6");
			$varian 	= $this->input->post("kode_varian");
			$item_harga = $this->input->post("item_harga");
			$total_harga = $this->input->post("total_harga");
			$data       = array(
							"fc_branch"	  => $this->session->userdata("branch"),
							"fc_wh"	  	  => $wh_asal,
							"fc_nomutasi"    => $nomutasi,
							"fc_stock"    => $sku,
							"fc_variant"  => $varian,
							"fc_uom"	  => $satuan,
							"fn_qty"      => $qty,
							"fv_ket"      => $keterangan,
							"fn_price"	  => $item_harga,
							"fn_total"	  => $total_harga,
							"fc_status"   => "I"
							);
			if ($aksi == "tambah") {
				$data = $this->M_model->tambah("td_mutasi",$data);
			}else if($aksi == "update"){
				$where = array("fc_id" => $kode);
				$data = $this->M_model->update("td_mutasi",$data,$where);
			}
			if ($data > 0) {
				echo "Berhasil Menyimpan";
			}else{
				echo "Gagal Menyimpan";
			}
	}
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array("fc_nomutasi" => $kode);
		$hapus = $this->M_model->hapus("tm_mutasi",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function HapusDetail(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->M_model->hapus("td_mutasi",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function dataItem(){ 
		$kolomDetail = array("fc_stock","fv_stock","kategori");
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
            $posts =  $this->M_model->posts_search($tabel,"fc_stock","fv_stock",$limit,$start,$search,$order,$dir); 
            $totalFiltered = $this->M_model->posts_search_count($tabel,"fc_stock","fv_stock",$search);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($kolomDetail) ; $i++) {
                	$hasil = $kolomDetail[$i]; 
                	$nestedData[$kolomDetail[$i]] = $post->$hasil;
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
	public function getListWarehouse(){
		$wh = $this->uri->segment(3); 
		$data .= "<option value=''>Pilih Warehouse</option>";
		foreach (getWareHouse($wh) as $gudang) {
			$data .= "<option value='".$gudang->fc_wh."'>".$gudang->fv_wh."</option>"; 
		}
		echo $data;
	}
	public function getSize(){
		$stockcode = $this->uri->segment(3);
		$data .= "<option value=''>Pilih Ukuran</option>";
		foreach (getSize($stockcode) as $size) {
			$data .= "<option value='".$size->fc_size."'>".$size->fv_size."</option>"; 
		}
		echo $data;
	}
	public function getHarga(){	
		$data = array("harga"=>$this->uri->segment(4),"varian"=>$this->uri->segment(5));	
		echo json_encode($data); // index 1 adalah harga beli
	}
	public function getWarna(){
		$stockcode = $this->uri->segment(3);
		$size = $this->uri->segment(4);
		$data .= "<option value=''>Pilih Warna</option>";
		foreach (getWarna($stockcode,$size) as $warna) {
			$data .= "<option value='".$warna->fc_warna."/".$warna->fn_hargabeli."/".$warna->fc_variant."'>".$warna->fv_warna."</option>"; 
		}
		echo $data;
	}
	public function getSatuan(){
		$stockcode = $this->uri->segment(3);
		$data .= "<option value=''>Pilih Satuan</option>";
		foreach (getSatuan($stockcode) as $satuan) {
			$data .= "<option value='".$satuan->fc_uom."'>".$satuan->fv_satuan."</option>"; 
		}
		echo $data;
	}
	public function getStock(){
		$stockcode = $this->uri->segment(3); 
		echo json_encode(getStock($stockcode));
	}
	public function EditDtl(){
		$branch = $this->uri->segment(3);
		$nomutasi = $this->uri->segment(4);
		$data = array("fc_branch" => $branch,"fc_nomutasi" => $nomutasi);
		$edit = $this->M_model->getData("tm_mutasi",$data);
		echo json_encode($edit);
	} 
// ------------------------- end detail data ---------------------------------------- 
	public function total(){
		$hasil = $this->db->select("count(*) as total")->from("td_mutasi")->where(array("fc_nomutasi" => $this->uri->segment(3)))->get();
		echo json_encode($hasil->row());
	}
	public function Finalisasi(){  
		$no_mutasi = getNomor("MUTASI");		
		$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nomutasi" => $this->session->userdata('userid'));
		$data = array("fc_status" => "F","fc_nomutasi" => $no_mutasi);
		$edit = $this->M_model->update("tm_mutasi",$data,$where); 
		if ($edit) {
			echo "Berhasil menyimpan data!\nNomor MUTASI anda ".getNomor("MUTASI");
			// insert kartustock barang keluar dari gudang asal
			$getDetilRow = $this->M_model->getData('td_mutasi',array('fc_nomutasi' => $no_mutasi),1);
			foreach($getDetilRow as $row ){
				if( $row->fc_nomutasi != ''){
					insertKartuStock($row->fc_branch, $row->fc_wh, $row->fc_stock, $row->fc_variant, $row->fc_uom, 0, $row->fn_qty, $row->fc_nomutasi, 'MUTASI BARANG',$this->session->userdata('userid'));
					//insertKartuStock('KDR001','WHR000010', 'BRG0000006', '15', '26', 0, 12, 'MT000002', 'MUTASI BARANG',$this->session->userdata('userid'));
				}				
			}
			updateNomor("MUTASI");
		}else{
			echo "Gagal Menyimpan";
		}
	} 
}