<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Purchase extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
	}
	private $table = "tm_warna";
	private $primary_key = "fc_warna";
	private $secondary_key = "fv_warna";
	private $kolom = array("fc_stock","kategori","fv_stock","fn_onhand"); 
	private $kolom_Detail = array("fc_id","fc_branch","fc_nopo","fc_stock","fv_stock","variant","fv_satuan","price","fn_qty","fn_uom","konversi","total"); 
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Master Purchase Order',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('nik'),
			'userid'       => $this->session->userdata('userid'),
			'bread'     => 'Purchase Order',
			'sub_bread' => '/ Master Purchase Order',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3]
		);
		loadView('v_view', $data, 0); 
	}
// ------------------------- master data ----------------------------------------					
	public function SimpanMst(){ 
		$nopo      = $this->input->post("a1");
		$tglpo     = date('Y-m-d',strtotime($this->input->post("a2")));
		$supplier  = $this->input->post("a3");
		$branch    = $this->input->post("a4");
		$wh        = $this->input->post("a5");
		$estimasi  = date("Y-m-d",strtotime($this->input->post("a6")));
		$catatan   = $this->input->post("a9"); 
		$tglInput  = date('Y-m-d H:i:s',strtotime($this->input->post("a10")));
		$userinput = $this->input->post("a11");
		$message   = ""; 
		$data = array(
			'fc_branch'     => $this->session->userdata("branch"),
			'fc_nopo'       => $nopo,
			'fd_po'         => $tglpo,
			'fc_kdsupplier' => $supplier,
			'fc_branch_to'  => $branch,
			'fc_wh'         => $wh,
			'fd_estdatang'  => $estimasi,
			'fd_input'      => $tglInput,
			'fc_userid'     => $userinput,
			'fc_status'     => "I",
			'fv_note'       => $catatan,
			'fc_approve'       => '0'
		);
		$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nopo" => $nopo,"fc_status" => "I");
		if ($this->checkMst($where) == 0) {
			$proses = $this->M_model->tambah("tm_po",$data);
		}else if($this->checkMst($where) > 0){
			$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nopo" => $nopo);
			$proses = $this->M_model->update("tm_po",$data,$where);
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
	public function getPO(){
		$branch = $this->uri->segment(3);
		$nopo = $this->uri->segment(4);
		$data = array("fc_branch" => $branch,"fc_nopo" => $nopo);
		$edit = $this->M_model->getData("tm_po",$data);
		echo json_encode($edit);
	}
	public function getWareHouse(){
		$branch = $this->uri->segment(3);
		$data .= "<option value=''>Pilih Gudang</option>";
		foreach (getWareHouse($branch) as $wh) {
			$data .= "<option value='".$wh->fc_wh."'>".$wh->fv_wh."</option>"; 
		}
		echo $data;
	}  
// ------------------------- end data ----------------------------------------	
// ------------------------- detail data ----------------------------------------									
	public function dataDetail(){  
		$limit         = $this->input->post('length');
		$start         = $this->input->post('start');
		$order         = $kolom_Detail[$this->input->post('order')[0]['column']];
		$dir           = $this->input->post('order')[0]['dir']; 
		$totalData     = $this->M_model->allposts_count_Detail(); 
		$totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allposts_Detail($limit,$start);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_search_Detail($limit,$start,$search); 
            $totalFiltered = $this->M_model->posts_search_count_Detail($search);
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
	public function dataPODetail(){ 
		$kolomDetail = array("fc_id","fc_nopo","fc_stock","fv_stock","fv_size","fv_satuan","fn_qty","fn_konversi","fv_ket");
		$tabel = "v_detailPO";  
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $kolom[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $where = array("fc_branch" => $this->session->userdata('branch'),"fc_nopo" => $this->uri->segment(3));
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
	public function simpanDtl(){  
			$sku        = $this->input->post("d1");
			$price      = $this->input->post("d3");
			$variant    = $this->input->post("d4");
			$satuan     = explode("#",$this->input->post("d5"));
			$qty        = $this->input->post("d6");
			$subtotal   = $this->input->post("d7");
			$keterangan = $this->input->post("d8");
			$data       = array(
							"fc_branch"     => $this->session->userdata('branch'),
							"fc_nopo"       => $this->session->userdata('userid'),
							"fc_stock"      => $sku,
							"fc_variant"    => $variant,
							"fc_satuan"     => $satuan[0],
							"fn_qty"        => $qty,
							"fn_qty_terima" => 0,
							"fn_qty_sisa"   => $qty,
							"fn_price"      => $price,
							"fn_total"      => $subtotal,
							"fv_ket"        => $keterangan,
							"fc_status"     => "I"
							); 
			$data = $this->M_model->tambah("td_po",$data); 
			if ($data > 0) {
				echo "Berhasil Menyimpan";
			}else{
				echo "Gagal Menyimpan";
			}
	}
	public function HapusDetail(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->M_model->hapus("td_po",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	} 
	public function dataItem(){ 
		$kolomDetail = array("fc_stock","fv_stock","kategori","fn_onhand");
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
// ------------------------- end detail data ---------------------------------------- 
	public function total(){
		$hasil = $this->db->select("count(*) as total")->from("td_po")->where(array("fc_nopo" => $this->uri->segment(3)))->get();
		echo json_encode($hasil->row());
	}
	public function Finalisasi(){  
		$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nopo" => $this->session->userdata('userid'));
		$data = array("fc_status" => "F","fc_nopo" => $this->session->userdata('userid'));
		$edit = $this->M_model->update("tm_po",$data,$where); 
		$update = $this->db->query("call final_PO('".$this->session->userdata('branch')."','".$this->session->userdata('userid')."')");
		if ($edit) {
			$no_Trx = $this->M_model->getTrxerror(array("fc_userid" => $this->session->userdata("userid")));
			$this->M_model->hapus("t_trxDummy",array('fc_userid' => $this->session->userdata("userid")));
			echo "Berhasil menyimpan data,\n".$no_Trx; 
		}else{
			echo "Gagal Menyimpan";
		}
	}
	public function batalkan(){
		$kode = $this->uri->segment(3);
		$data = array("fc_nopo" => $kode);
		$hapus = $this->M_model->hapus("tm_po",$data);
		if ($hapus > 0) {
			$no_Trx = $this->M_model->getTrxerror(array("fc_userid" => $this->session->userdata("userid")));
			$this->M_model->hapus("t_trxDummy",array('fc_userid' => $this->session->userdata("userid")));
			echo "Berhasil menghapus data,\n".$no_Trx;
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function getMSTINFO(){
		$nopo = $this->uri->segment(3);
		$data = $this->M_model->getData("v_POMST",array("fc_nopo"=>$nopo));
		echo json_encode($data);
	}
	public function getDTLINFO(){
		$hasil = "";
		$nopo = $this->uri->segment(3);
		$data = $this->M_model->getDetail("v_detailPO",array("fc_branch" => $this->session->userdata("branch"),"fc_nopo"=>$nopo));
		foreach ($data as $key) {
			$hasil .= "<tr>
			<td>".$key->fc_stock."</td>
			<td>".$key->fv_stock."</td>
			<td>".$key->variant."</td>
			<td>".$key->fv_satuan."</td>
			<td>".$key->price."</td>
			<td>".$key->fn_qty."</td>
			<td>".$key->fn_uom."</td>
			<td>".$key->konversi."</td>
			<td>".$key->total."</td>
			</tr>";
		}
		echo '<table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th>SKU</th>
                                      <th>Nama Item</th>
                                      <th>Variant</th>
                                      <th>Satuan</th>
                                      <th>Harga</th>
                                      <th>Qty</th>
                                      <th>Qty UOM</th>
                                      <th>Konversi</th>
                                      <th>Sub Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  '.$hasil.'
                                  </tbody>
                                </table>';
	} 
}
