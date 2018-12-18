<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
class Kartustock extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model','model');
	}
	private $table = "tm_kategori";
	private $primary_key = "fc_kat";
	private $secondary_key = "fv_kat";
	private $kolom = array("fc_kat","fv_kat","fc_status","fv_pict");
	public function index(){
		is_logged();
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'subtitle'  =>'Kartustock',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Kartustock',
			'listBranch'=> getBranch(),
			'sub_bread' => '/ History Barang',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3]
		);		
		loadView('v_view', $data, 0);
	}
	public function Simpan(){
		$aksi = $this->input->post('aksi');
		$message = ""; 
			if (!empty($_FILES['a2']['name'])) {
				upload('a2');
				$data = array(
					'fv_kat'    => $this->input->post('a1'),
					'fv_pict'   => $_FILES['a2']['name'],
					'fc_status' => $this->input->post('a3')
				);
			}else{
				$data = array(
					'fv_kat'    => $this->input->post('a1'), 
					'fc_status' => $this->input->post('a3')
				);
			} 
			if ($aksi == 'tambah') {
				$proses = $this->model->tambah($data);
			}else if($aksi =='update'){
				$where = array($this->primary_key => $this->input->post('kode'));
				$proses = $this->model->update($data,$where);
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
		$edit = $this->model->getData($data);
		echo json_encode($edit);
	} 
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$foto = $this->uri->segment(4);
		$data = array($this->primary_key => $kode);
		$hapus = $this->model->hapus($data);
		if ($hapus > 0) {
			$dir = "./assets/foto/".$foto;
			unlink($dir);
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function tabledata()
    {
        $fieldList = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($fieldList as $field) {
            $no++;
            $row = array();
				$row[] = $no;
				$row[] = $field->fd_tgl;
				$row[] = $field->fc_stock;
				$row[] = $field->fv_stock;
				$row[] = $field->fv_variant;
				$row[] = $field->fc_referensi;
				$row[] = $field->fc_ket;
				$row[] = $field->fc_userid;
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
	public function getListWH(){
		$branch = $this->uri->segment(3);
		//$branch = $this->input->post('f_wh');
		$dataWH = getWarehouse($branch);
		$form_option = "<option value='%'>Pilih Warehouse</option>\n";
		foreach ($dataWH as $wh) {
			$form_option .= "<option value='$wh->fc_wh'>$wh->fv_wh</option>\n";
		}
		echo $form_option;
	}
}