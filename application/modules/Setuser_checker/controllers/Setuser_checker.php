<?php defined('BASEPATH') or exit('maaf akses anda ditutup.'); 
class Setuser_checker extends CI_Controller
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
			'subtitle'  =>'Setting Checker',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('userid'),
			'bread'     => 'Setting Checker',
			'sub_bread' => ' / Checker BPB',
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
			$row[] = "<a class='btn btn-primary' onclick=detail('".$field->fc_nobpb."')>Edit</a> <a class='btn btn-danger' onclick=hapus('".$field->fc_id."')>Hapus</a>";
            $row[] = $field->fc_nobpb;
            $row[] = $field->fv_nama; 
            $row[] = $field->fc_stock;
			$row[] = $field->fv_stock;
			$row[] = $field->fv_note;
			$row[] = $field->fc_userinput;
			$row[] = format_tanggal_indo($field->fd_input);
			$row[] = $field->fc_status; 
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
	public function getStock(){
		$fc_stock = $this->uri->segment(3); 
		$data = array("fc_stock" => $fc_stock);
		$edit = $this->model->getData("t_stock",$data);
		echo json_encode($edit);
	}  
	public function simpan(){
		$data = array(
					"fc_branch" => $this->session->userdata('branch'),
					"fc_userid" => $this->input->post("a1"),
					"fc_nobpb" 	=> $this->input->post("a2"),
					"fc_stock" 	=> $this->input->post("a3"),
					"fv_note" 	=> $this->input->post("a5"),
					"fc_status" => "I",
					"fc_userinput" =>$this->input->post("a7"),
					"fd_input"  => date('Y-m-d',strtotime($this->input->post("a6")))
		);
		if($this->input->post("aksi") == "tambah"){
			$aksi = $this->model->tambah("td_user_check",$data);
		}else if($this->input->post("aksi") == "update"){
			$where = array("fc_id" => $this->input->post("kode"));
			$aksi = $this->model->update("td_user_check",$data,$where);
		}
		if ($aksi > 0) {
			$message = 'Berhasil menyimpan data';
		}else{
			$message = 'Gagal menyimpan data'; 
		} 
		echo json_encode($message);
	} 
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array("fc_id" => $kode);
		$hapus = $this->model->hapus("td_user_check",$data);
		if ($hapus > 0) {
			echo "Berhasil menghapus data";
		}else{
			echo "Gagal menghapus data";
		}
	}
}