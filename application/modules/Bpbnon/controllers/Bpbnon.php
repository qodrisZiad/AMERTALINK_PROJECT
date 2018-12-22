<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Bpbnon extends CI_Controller
{
	private $hakakses_user;
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model','model');
		$this->hakakses_user = getAkses($this->uri->segment(1));
	}
	private $table = "v_POMST";
	private $primary_key = "fc_nopo";
	private $secondary_key = "fv_supplier";
	private $kolom = array("fc_nopo","fc_branch","fd_po","fc_kdsupplier","fv_supplier","fv_addr","fc_telp","fc_telp2","fd_estdatang","fn_qty","total","fc_userid","fv_note","untuk_cabang","warehouse","fc_status","fc_approve","fc_approve_by");
	private $KolomDetail = array("fc_id","fc_stock","fv_stock","variant","fv_satuan","fn_price","fn_qty","fn_total","fn_terima","fv_ket");
	public function index(){
		is_logged();        
		$data = array(
			'subtitle'     =>'Penerimaan Barang Tanpa PO',
			'greeting'  	=> $this->session->userdata('greeting'),
			'nik'       	=> $this->session->userdata('userid'),
			'bread'     	=> 'BPB',
			'sub_bread' 	=> '/ Bukti Penerimaan Barang Non PO',
			'listSupplier'	=> self::getListSupplier(),
			'listWarehouse'	=> getWarehouse($this->session->userdata('branch'), 2),
			'input'			=> $this->hakakses_user[0],
			'update'		=> $this->hakakses_user[1],
			'delete'		=> $this->hakakses_user[2],
			'view'			=> $this->hakakses_user[3]
		);
		loadView('v_view', $data, 0);
	}

	public function getTableData()
    {
        $fieldList = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($fieldList as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->fv_wh;
            $row[] = $field->fd_bpb;
            $row[] = $field->fv_supplier;
            $row[] = $field->fn_jenis;
			$row[] = $field->fn_qty;
			$row[] = $field->fm_total;
			if(!empty($field->fc_userid)){	$row[] = $field->fc_userid; } else { $row[] = "<a class='btn btn-warning'>kosong</a>"; }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model->count_all(),
                        "recordsFiltered" => $this->model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
	public function getTableDataSKU()
    {
		// prepare for custom query 
		$tableName = 'v_stock';
		$columnOrder = array('fc_stock');
		$columnSearch = array('fc_stock','fv_stock');
		$defaultOrder = array('fc_kategori' => 'asc');

        $fieldList = $this->model->get_datatables($tableName, $columnOrder, $columnSearch, $defaultOrder);
        $data = array();
        $no = $_POST['start'];
        foreach ($fieldList as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->kategori;
            $row[] = $field->fc_stock;
            $row[] = $field->fv_stock;
            $row[] = "<button class='btn btn-info' onclick=pilih('".$field->fc_stock."')>Pilih</button>";
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model->count_all($tableName),
                        "recordsFiltered" => $this->model->count_filtered($tableName, $columnOrder, $columnSearch, $defaultOrder),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
	public function getTableDataDetil()
    {
		// prepare for custom query 
		$tableName = 'v_detailBPBnon';
		$columnOrder = array('fc_stock','fv_stock','variant','total');
		$columnSearch = array('fc_stock','fv_stock','kategori');
		$defaultOrder = array('fc_id' => 'asc');

        $fieldList = $this->model->get_datatables($tableName, $columnOrder, $columnSearch, $defaultOrder);
        $data = array();
        $no = $_POST['start'];
        foreach ($fieldList as $field) {
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $field->fc_stock;
			$row[] = $field->fv_stock;
			$row[] = $field->fv_satuan;
			$row[] = $field->fn_qty;
			$row[] = $field->price;
			if ($this->hakakses_user[2]==1) {
				$row[] = "<button class='btn btn-danger' onclick=hapusDetail('".$field->fc_id."')>Hapus</button>";
			} else {
				$row[] = "No-Access";
			}
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model->count_all($tableName),
                        "recordsFiltered" => $this->model->count_filtered($tableName, $columnOrder, $columnSearch, $defaultOrder),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
	public function getTableDataReview()
    {
		// prepare for custom query 
		$tableName = 'v_detailBPBnon';
		$columnOrder = array('fc_stock','fv_stock','variant','total');
		$columnSearch = array('fc_stock','fv_stock','kategori');
		$defaultOrder = array('fc_id' => 'asc');

        $fieldList = $this->model->get_datatables($tableName, $columnOrder, $columnSearch, $defaultOrder);
        $data = array();
        $no = $_POST['start'];
        foreach ($fieldList as $field) {
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $field->fc_stock;
			$row[] = $field->fv_stock;
			$row[] = $field->fv_satuan;
			$row[] = $field->fn_qty;
			$row[] = $field->price;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model->count_all($tableName),
                        "recordsFiltered" => $this->model->count_filtered($tableName, $columnOrder, $columnSearch, $defaultOrder),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
	public function getReview(){
		$nobpb = $this->uri->segment(3);
		$where = array('fc_nobpb' => $nobpb);
		$data = $this->model->getData('v_bpbnon', $where);
		echo json_encode($data);
	}
	public function getListSupplier(){
		$result = "<option>-- Pilih Supplier --</option>\n";
		$dataSupplier = getSupplier(0);
		foreach ($dataSupplier as $supplier) {
			$result .= "<option value='$supplier->fc_kdsupplier'>$supplier->fv_supplier</option>\n"; 
		}
		return $result;
	}
	public function SimpanMst(){
		$result = array('proses' => 0, 'message'=> '');
		$aksi     = $this->input->post('aksi');
		$nobpb     = $this->input->post("bpb_no");
		$supplier = $this->input->post("a2");
		$branch   = $this->input->post("a3");
		$wh       = ($this->input->post("a4")!='') ? $this->input->post("a4") : $this->input->post("wh");
		$tglbpb    = date('Y-m-d',strtotime($this->input->post("a5")));
		//$estimasi = date("Y-m-d",strtotime($this->input->post("a6")));
		$catatan  = $this->input->post("a8");
		$userid   = $this->input->post("a11");
			$message = ""; 
			$data = array(
				'fc_branch'     => $this->session->userdata("branch"),
				'fc_nobpb'      => $nobpb,
				'fd_bpb'        => $tglbpb,
				'fc_kdsupplier' => $supplier,
				'fc_wh'         => $wh,
				'fd_input'      => date("Y-m-d H:m:s"),
				'fc_userid'     => $userid,
				'fc_status'     => "I",
				'fv_note'       => $catatan
			);
			$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb" => $nobpb,"fc_status" => "I");
			if ($this->model->checkMst($where) == 0) {
				// jika statusnya I dan nobpb = userid maka di input
				$proses = $this->model->tambah("tm_bpbnon",$data);
			}else if($this->model->checkMst($where) > 0){
				$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb" => $nobpb);
				$proses = $this->model->update("tm_bpbnon",$data,$where);
			}
			if ($proses > 0) {
				$result['proses'] 	= $proses;
				$result['message'] 	= 'Berhasil menyimpan data';
				$result['nobpb']	= $nobpb;
			}else{
				$result['message'] = 'Gagal menyimpan data';
			} 
		echo json_encode($result);
	}
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array("fc_nobpb" => $kode);
		$hapus = $this->model->hapus("tm_bpbnon",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function total(){
		$hasil = $this->db->select("count(*) as total")->from("td_bpbnon")->where(array("fc_nobpb" => $this->uri->segment(3)))->get();
		echo json_encode($hasil->row());
	}
	public function Finalisasi(){  
		$where = array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb" => $this->session->userdata('userid'));
		$data = array("fc_status" => "F","fc_nobpb" => getNomor("BPBNON"));
		$edit = $this->model->update("tm_bpbnon",$data,$where); 
		if ($edit) {
			echo "Berhasil menyimpan data.No BPB anda ".getNomor("BPBNON");
			updateNomor("BPBNON");
		}else{
			echo "Gagal Menyimpan";
		}
	} 
/*--------------------------------------------------------------------------------------------- start detil function */
	public function simpanDetail(){
		$aksi       = $this->input->post("aksiDetail");
		$kode       = $this->input->post("kodeDetail");
		$nobpb       = $this->input->post("nobpb");
		$sku        = $this->input->post("b1");
		// $size       = $this->input->post("b2"); // useless
		// $color		= $this->input->post("b3"); // useless
		$satuan     = $this->input->post("b4");
		$qty        = $this->input->post("b5");
		$keterangan = $this->input->post("b6");
		//$varian 	= $this->input->post("kode_varian");
		$item_harga = $this->input->post("item_harga");
		$total_harga = $this->input->post("total_harga");
		$data       = array(
						"fc_branch"	  => $this->session->userdata("branch"),
						"fc_nobpb"    => $nobpb,
						"fc_stock"    => $sku,
						"fc_satuan"   => $satuan,
						"fn_qty"      => $qty,
						"fv_ket"      => $keterangan,
						"fn_price"	  => $item_harga,
						"fn_total"	  => $total_harga,
						"fc_status"   => "I"
						);
		if ($aksi == "tambah") {
			$data = $this->model->tambah("td_bpbnon",$data);
		}else if($aksi == "update"){
			$where = array("fc_id" => $kode);
			$data = $this->model->update("td_bpbnon",$data,$where);
		}
		if ($data > 0) {
			echo "Berhasil Menyimpan";
		}else{
			echo "Gagal Menyimpan";
		}
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
	public function HapusDetail(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->model->hapus("td_bpbnon",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
/*--------------------------------------------------------------------------------------------- end detil function */
	
}