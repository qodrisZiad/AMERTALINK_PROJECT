<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Appr_po extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "v_POMST";
	private $primary_key = "fc_nopo";
	private $secondary_key = "fv_supplier";
	private $kolom = array("fc_nopo","fc_branch","fd_po","fc_kdsupplier","fv_supplier","fv_addr","fc_telp","fc_telp2","fd_estdatang","fn_qty","total","fc_userid","fv_note","untuk_cabang","warehouse","fc_status","fc_approve","fc_approve_by");
	private $kolom_Detail = array("fc_id","fc_branch","fc_nopo","fc_stock","fv_stock","variant","fv_satuan","price","fn_qty","fn_uom","konversi","total"); 
	public function index(){
		if(empty($this->session->userdata('userid'))){
			redirect('Login');
		}
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Approval PO',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Purchase',
			'sub_bread' => '/ Approval PO',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3]
		);
		loadview('v_view', $data, 0);
	} 
	public function Edit(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$edit = $this->M_model->getData("v_POMST",$data);
		echo json_encode($edit);
	}
	public function EditDtl(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$edit = $this->M_model->getData("v_detailPO",$data);
		echo json_encode($edit);
	} 
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$checkData = $this->db->query("select * from td_po where fc_nopo = (select fc_nopo from td_po where fc_id='".$kode."')");
		if ($checkData->num_rows() > 1) {
			$hapus = $this->M_model->hapus("td_po",$data);
			if ($hapus > 0) {
				echo "Berhasil menghapus data";
			}else{
				echo "Gagal menghapus data";
			}
		}else{
			echo "Gagal Menghapus data. Detail tidak boleh kurang dari 1";
		}
	}
	public function Approve(){
		$kode = $this->uri->segment(3);
		$data = array("fc_approve" => "1","fc_approve_by" => $this->session->userdata("userid"));
		$hapus = $this->M_model->update("tm_po",$data,array("fc_nopo" => $kode));
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}public function Cancel(){
		$kode = $this->uri->segment(3);
		$data = array("fc_status" => "C");
		$hapus = $this->M_model->update("tm_po",$data,array("fc_nopo" => $kode));
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
		$nopo = $this->uri->segment(3);
		$limit         = $this->input->post('length');
		$start         = $this->input->post('start');
		$order         = $kolom_Detail[$this->input->post('order')[0]['column']];
		$dir           = $this->input->post('order')[0]['dir']; 
		$totalData     = $this->M_model->allposts_count_Detail($nopo); 
		$totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allposts_Detail($limit,$start,$nopo);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_search_Detail($limit,$start,$search,$nopo); 
            $totalFiltered = $this->M_model->posts_search_count_Detail($search,$nopo);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($this->kolom_Detail) ; $i++) {
                	$hasil = $this->kolom_Detail[$i]; 
                	$nestedData[$this->kolom_Detail[$i]] = $post->$hasil;
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
	public function dataItem(){ 
		$kolomDetail = array("fc_stock","fv_stock","kategori","fn_onhand");
		$tabel = "v_stock";  
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolom[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];  
        $totalData = $this->M_model->allposts_count_Item($tabel); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allposts_Item($tabel,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_search_Item($tabel,"fc_stock","fv_stock",$limit,$start,$search,$order,$dir); 
            $totalFiltered = $this->M_model->posts_search_count_Item($tabel,"fc_stock","fv_stock",$search);
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
	public function getStock(){
		$fc_stock = $this->uri->segment(3); 
		$data = array("fc_stock" => $fc_stock);
		$edit = $this->M_model->getData("t_stock",$data);
		echo json_encode($edit);
	}
	public function getSatuan(){
		$stockcode = $this->uri->segment(3);
		$data .= "<option value=''>Pilih Satuan</option>";
		foreach (getSatuan($stockcode) as $satuan) {
			$data .= "<option value='".$satuan->fc_uom."#".$satuan->fn_uom."'>".$satuan->fv_satuan."</option>"; 
		}
		echo $data;
	}
	public function getVariant(){
		$stockcode = $this->uri->segment(3);
		$data .= "<option value=''>Pilih Variant</option>";
		foreach (getVariant($stockcode) as $variant) {
			$data .= "<option value='".$variant->fc_variant."'>".$variant->fv_size." | ".$variant->fv_warna."</option>"; 
		}
		echo $data;
	}
	public function simpanDtl(){  
		$sku        = $this->input->post("d1");
		$price      = $this->input->post("d3");
		$variant    = $this->input->post("d4");
		$satuan     = explode("#",$this->input->post("d5"));
		$qty        = $this->input->post("d6");
		$subtotal   = $this->input->post("d7");
		$keterangan = $this->input->post("d8");
		$data       = array(
						"fc_variant"    => $variant,
						"fc_satuan"     => $satuan[0],
						"fn_qty"        => $qty,
						"fn_qty_terima" => 0,
						"fn_qty_sisa"   => $qty,
						"fn_price"      => $price,
						"fn_total"      => $subtotal,
						"fv_ket"        => $keterangan 
						); 
		$data = $this->M_model->update("td_po",$data,array("fc_id" => $this->input->post('kode'))); 
		if ($data > 0) {
			echo "Berhasil Menyimpan";
		}else{
			echo "Gagal Menyimpan";
		}
	}
}