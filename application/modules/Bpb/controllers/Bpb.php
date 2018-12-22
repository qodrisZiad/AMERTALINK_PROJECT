<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Bpb extends CI_Controller
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
	private $KolomDetail = array("fc_id","fc_stock","fv_stock","variant","fv_satuan","fn_price","fn_qty","fn_total","fn_terima","fv_ket");
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Bukti Penerimaan Barang PO',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Purchase Order',
			'sub_bread' => '/ Bukti Penerimaan Barang PO',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3]
		);
		loadView('v_view', $data, 0);
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

	public function getMSTINFO(){
		$nopo = $this->uri->segment(3);
		$data = $this->M_model->getMaster(array("fc_nopo"=>$nopo));
		echo json_encode($data);
	}
	public function getDTLINFO(){
		$hasil = "";
		$nopo = $this->uri->segment(3);
		$data = $this->M_model->getDetail("v_detailPO",array("fc_branch" => $this->session->userdata("branch"),"fc_nopo"=>$nopo));
		echo json_encode($data);
	}
	public function SimpanMst(){
		$nobpb     = $this->input->post('bpb_no');
		$nopo      = $this->input->post('a1');
		$tglterima = date('Y-m-d',strtotime($this->input->post('a6')));
		$fn_qty    = $this->input->post('a7');
		$fn_total  = decimal($this->input->post('a8'));
		$check     = $this->M_model->checkBPB($nobpb);
		$ongkir	   = decimal($this->input->post('a12'));
		if ($check > 0) {
			$this->db->query("delete from tm_bpb where fc_nobpb ='".$nobpb."'");
		}
		$data = array(	"fc_branch" => $this->session->userdata('branch'),
						"fc_nobpb" => $nobpb,
						"fd_tglterima" => $tglterima,
						"fc_nopo"      => $nopo,
						"fn_qty"       => $fn_qty,
						"fn_ongkir"    => $ongkir,
						"fm_total"     => $fn_total,
						"fc_userid"    => $this->session->userdata("userid"),
						"fd_input"     => date("Y-m-d")
					);
		$trans = $this->M_model->tambah("tm_bpb",$data);
		if ($trans) {
			echo "Berhasil menyimpan data";
		}else{
			echo "Gagal menyimpan data";
		}
	}
	public function dataDetail(){ 
		$nota  = $this->uri->segment(3);
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $KolomDetail[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir']; 
        $totalData = $this->M_model->allposts_countDetail($nota); 
        $totalFiltered = $totalData;  
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->M_model->allpostsDetail($nota,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];  
            $posts =  $this->M_model->posts_searchDetail($nota,$this->primary_key,$this->secondary_key,$limit,$start,$search,$order,$dir); 
            $totalFiltered = $this->M_model->posts_search_countDetail($nota,$this->primary_key,$this->secondary_key,$search);
        } 
        $data = array();
        if(!empty($posts))
        {	$no = 1;
            foreach ($posts as $post)
            { 	
                $nestedData['no'] = $no++;
                for ($i=0; $i < count($this->KolomDetail) ; $i++) {
                	$hasil = $this->KolomDetail[$i]; 
                	$nestedData[$this->KolomDetail[$i]] = $post->$hasil;
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
	public function getDataPO(){
		$kode = $this->uri->segment(3);
		$query = $this->M_model->getdetailPO($kode);
		echo json_encode($query);
	}
	public function SimpanDtl(){
		$nobpb      = $this->session->userdata('userid');
		$fc_stock   = $this->input->post('d1');
		$fc_variant = $this->input->post('kdvar');
		$fc_satuan  = $this->input->post('kdsat');
		$fn_qty     = $this->input->post('d7');
		$fn_harga   = $this->input->post('d5');
		$fn_total   = decimal($this->input->post('d8'));
		$fv_note    = $this->input->post('d9');
		$hapuslama = $this->db->query("delete from td_bpb where fc_nobpb = '".$nobpb."' and fc_stock='".$fc_stock."' and fc_variant='".$fc_variant."' ");
		$data =  array(
				"fc_nobpb"   => $nobpb,
				"fc_stock"   => $fc_stock,
				"fc_variant" => $fc_variant,
				"fc_satuan"  => $fc_satuan,
				"fn_qty"     => $fn_qty,
				"fn_price"   => $fn_harga,
				"fn_total"   => $fn_total,
				"fc_ket"     => $fv_note
		);
		$query = $this->M_model->tambah("td_bpb",$data);
		if ($query) {
			echo "Berhasil menyimpan data";
		}else{
			echo "Gagal menyimpan data";
		}
	}
	public function HapusDtl(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->M_model->hapus("td_bpb",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function getMaster(){
		$kode = $this->uri->segment(3);
		$query = $this->db->query("select a.fc_nobpb,b.fv_supplier,b.fv_addr,b.fc_telp,b.fc_telp2,a.fd_tglterima,b.fd_po,a.fc_nopo,b.fn_qty as qty_po,a.fn_qty as terima,(b.fn_qty - a.fn_qty) as sisa,a.fn_ongkir,a.fm_total,a.fc_userid,b.fv_note from tm_bpb a LEFT OUTER JOIN v_POMST b ON b.fc_nopo=a.fc_nopo WHERE a.fc_branch='".$this->session->userdata('branch')."' AND a.fc_nopo='".$kode."'");
		echo json_encode($query->row());
	} 
	public function getDetail(){
		$hasil = "";
		$nopo = $this->uri->segment(3);
		$data = $this->db->query("select ifnull(c.fc_id,a.fc_id) as fc_id,a.fc_stock,a.fv_stock,a.variant,a.fv_satuan,concat('Rp.',IFNULL(c.fn_price,a.price)) as fn_price,a.fn_qty,ifnull(c.fn_qty,0) as fn_terima,concat('Rp.',IFNULL(c.fn_total,a.total)) as fn_total,a.fv_ket,a.fc_variant,a.fc_satuan from v_detailPO a LEFT OUTER JOIN tm_bpb b ON b.fc_nopo=a.fc_nopo LEFT OUTER JOIN td_bpb c ON c.fc_nobpb=b.fc_nobpb and c.fc_stock=a.fc_stock WHERE a.fc_nopo='".$nopo."'");
		foreach ($data->result() as $key) {
			$hasil .= "<tr>
			<td>".$key->fc_stock."</td>
			<td>".$key->fv_stock."</td>
			<td>".$key->variant."</td>
			<td>".$key->fv_satuan."</td>
			<td>".$key->fn_price."</td>
			<td>".$key->fn_qty."</td>
			<td>".$key->fn_terima."</td>
			<td>".$key->fn_total."</td>
			<td>".$key->fv_ket."</td>
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
                                      <th>Qty Terima</th>
                                      <th>Total</th>
                                      <th>Keterangan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  '.$hasil.'
                                  </tbody>
                                </table>';
	} 
	public function batalkan(){ 
		$data = array("fc_nobpb" => $this->session->userdata('userid'));
		$hapusDetail = $this->M_model->hapus("td_bpb",$data);
		$hapus = $this->M_model->hapus("tm_bpb",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}

	public function finalisasi(){
		$po_no = $this->uri->segment(3);
		$aksi  = $this->M_model->finalisasi($po_no);
		if(!empty($aksi)){
			foreach($aksi as $data){
				echo "Berhasil menyimpan data PO.Nomor Transaksi anda:".$data->no_bpb;
			}
		}else{
			echo "Gagal menyimpan data PO periksa kembali.";
		}
	}
}