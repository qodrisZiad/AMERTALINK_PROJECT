<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
error_reporting(0);
class Reprint_po extends CI_Controller
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
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'     =>'Reprint PO',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Purchase Order',
			'sub_bread' => '/ Reprint PO',
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
	public function cetak(){
		$printCode = $this->uri->segment(3);
		$aksi = $this->M_model->update("tm_po",array("fc_print" => "1"),array("fc_nopo" => $printCode));
		if ($aksi > 0) {
			echo "Berhasil";
		}else{
			echo "Gagal";
		}
	}  
}