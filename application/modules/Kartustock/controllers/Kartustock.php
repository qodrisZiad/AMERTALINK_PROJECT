<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
class Kartustock extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model');
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
				$proses = $this->M_model->tambah($data);
			}else if($aksi =='update'){
				$where = array($this->primary_key => $this->input->post('kode'));
				$proses = $this->M_model->update($data,$where);
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
		$edit = $this->M_model->getData($data);
		echo json_encode($edit);
	} 
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$foto = $this->uri->segment(4);
		$data = array($this->primary_key => $kode);
		$hapus = $this->M_model->hapus($data);
		if ($hapus > 0) {
			$dir = "./assets/foto/".$foto;
			unlink($dir);
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
	public function ajax_list()
    {
        $list = $this->M_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $datalist) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $datalist->fc_branch;
            $row[] = $datalist->fc_wh;
            $row[] = $datalist->fd_tgl;
            $row[] = $datalist->fc_stock;
            $row[] = $datalist->fc_variant;
            $row[] = $datalist->fc_uom;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_model->count_all(),
                        "recordsFiltered" => $this->M_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
}