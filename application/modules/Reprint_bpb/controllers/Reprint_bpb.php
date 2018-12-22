<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
class Reprint_bpb extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model','model');
	}
	
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'  =>'Bukti Penerimaan Barang',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Bukti Penerimaan Barang',
			'sub_bread' => ' / Cetak Ulang BPB',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3]
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
			$row[] = "<a class='btn btn-warning' onclick=detail('".$field->fc_nobpb."')>Detail</a>";
            $row[] = $field->fc_nobpb;
            $row[] = $field->fc_nopo;
            $row[] = format_tanggal_indo($field->fd_bpb);
            $row[] = $field->fv_supplier;
			$row[] = $field->warehouse;
			$row[] = $field->untuk_cabang;
			$row[] = rupiah($field->fm_total); 
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
	public function getMSTINFO(){
		$bpbno = $this->uri->segment(3);
		$data = $this->model->getData("v_printBPB",array("fc_nobpb"=>$bpbno));
		echo json_encode($data);
	}
	public function getDTLINFO(){
		$hasil = "";
		$bpbno = $this->uri->segment(3);
		$data = $this->model->getDetail("v_detailPrintBPB",array("fc_branch" => $this->session->userdata("branch"),"fc_nobpb"=>$bpbno));
		foreach ($data as $key) {
			$hasil .= "<tr>
			<td>".$key->fc_stock."</td>
			<td>".$key->fv_stock."</td>
			<td>".$key->variant."</td>
			<td>".$key->fv_satuan."</td>
			<td>Rp.".$key->price."</td>
			<td>".$key->fn_qty."</td>
			<td>".$key->fn_uom."</td>
			<td>".$key->konversi."</td>
			<td>Rp.".$key->total."</td>
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
								  <tr><td colspan=4 align=center height=50px;>Sales<br><br><br><br><br><br>[  __________________  ]</td>
								  <td colspan=5 align=center height=50px;>Penerima<br><br><br><br><br><br>['.$this->session->userdata('userid').']</td></tr>
                                  </tbody>
                                </table>';
	}
	public function cetak(){
		$printCode = $this->uri->segment(3);
		$getData =  $this->db->query("select po_status from v_printBPB where fc_nobpb='".$printCode."'");
		$tabel_data = "";
		foreach($getData->result() as $data){
			if($data->po_status == '1'){
				$tabel_data = "tm_bpb";
			}else{
				$tabel_data ="tm_bpbnon";
			}
		}
		$add_hutang = $this->model->addHutang($printCode); 
		$aksi = $this->model->update("tm_bpb",array("fc_status" => "P"),array("fc_nobpb" => $printCode));
		if ($aksi > 0) { 
			echo "Berhasil";
		}else{
			echo "Gagal";
		} 
	} 
}