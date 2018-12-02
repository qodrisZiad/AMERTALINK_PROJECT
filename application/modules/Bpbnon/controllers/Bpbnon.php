<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Bpbnon extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "tm_bpbnon";
	private $primary_key = "fc_nobpb";
	private $secondary_key = "fv_warna";
	private $kolom = array("fc_branch","fc_nobpb","fd_bpb","fc_kdsupplier","fc_wh","fn_jenis","fn_qty","fv_note","fc_userid"); 
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Penerimaan Barang non PO',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('nik'),
			'userid'    => $this->session->userdata('userid'),
			'bread'     => 'BPB',
			'sub_bread' => '/ Penerimaan Barang Non PO',
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
		$aksi     = $this->input->post('aksi');
		$nobpb     = $this->input->post("a1");
		$tglbpb    = date('Y-m-d',strtotime($this->input->post("a2")));
		$supplier = $this->input->post("a3");
		$branch   = $this->input->post("a4");
		$wh       = $this->input->post("a5");
		//$estimasi = date("Y-m-d",strtotime($this->input->post("a6")));
		$catatan  = $this->input->post("a8");
		$userid   = $this->input->post("a9");
			$message = ""; 
			$data = array(
				'fc_branch'     => $this->session->userdata("branch"),
				'fc_nobpb'      => $nobpb,
				'fd_bpb'        => $tglbpb,
				'fc_kdsupplier' => $supplier,
				'fc_wh'         => $wh,
				'fd_input'      => date("Y-m-d"),
				'fc_userid'     => $userid,
				'fc_status'     => "I",
				'fv_note'       => $catatan
			);
			$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb" => $nobpb,"fc_status" => "I");
			if ($this->checkMst($where) == 0) {
				$proses = $this->M_model->tambah("tm_bpbnon",$data);
			}else if($this->checkMst($where) > 0){
				$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb" => $nobpb);
				$proses = $this->M_model->update("tm_bpbnon",$data,$where);
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
		$nobpb = $this->uri->segment(4);
		$data = array("fc_branch" => $branch,"fc_nobpb" => $nobpb);
		$edit = $this->M_model->getData("tm_bpbnon",$data);
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
		$tabel = "tm_bpbnon";
		$kolomLaporan = array("fc_nobpb","fc_kdsupplier","fc_wh","fn_jenis","fn_qty","fm_total","fc_status");  
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
		$kolomDetail = array("fc_id","fc_nobpb","fc_stock","fv_stock","variant","fv_satuan","fn_qty","price","fv_ket");
		$tabel = "v_detailBPBnon";  
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolom[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $where = array("fc_branch" => $this->session->userdata('branch'),"fc_nobpb" => $this->uri->segment(3));
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
			$nobpb       = $this->input->post("nobpb");
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
							"fc_nobpb"    => $nobpb,
							"fc_stock"    => $sku,
							"fc_variant"  => $varian,
							"fc_satuan"   => $satuan,
							"fn_qty"      => $qty,
							"fv_ket"      => $keterangan,
							"fn_price"	  => $item_harga,
							"fn_total"	  => $total_harga,
							"fc_status"   => "I"
							);
			if ($aksi == "tambah") {
				$data = $this->M_model->tambah("td_bpbnon",$data);
			}else if($aksi == "update"){
				$where = array("fc_id" => $kode);
				$data = $this->M_model->update("td_bpbnon",$data,$where);
			}
			if ($data > 0) {
				echo "Berhasil Menyimpan";
			}else{
				echo "Gagal Menyimpan";
			}
	}
	public function HapusDetail(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->M_model->hapus("td_bpbnon",$data);
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
		$nobpb = $this->uri->segment(4);
		$data = array("fc_branch" => $branch,"fc_nobpb" => $nobpb);
		$edit = $this->M_model->getData("tm_bpbnon",$data);
		echo json_encode($edit);
	} 
// ------------------------- end detail data ---------------------------------------- 
	public function total(){
		$hasil = $this->db->select("count(*) as total")->from("td_bpbnon")->where(array("fc_nobpb" => $this->uri->segment(3)))->get();
		echo json_encode($hasil->row());
	}
	public function Finalisasi(){  
		$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb" => $this->session->userdata('userid'));
		$data = array("fc_status" => "F","fc_nobpb" => getNomor("BPBNON"));
		$edit = $this->M_model->update("tm_bpbnon",$data,$where); 
		if ($edit) {
			echo "Berhasil menyimpan data.No BPB anda ".getNomor("BPBNON");
			updateNomor("BPBNON");
		}else{
			echo "Gagal Menyimpan";
		}
	} 
}