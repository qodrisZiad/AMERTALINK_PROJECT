<?php defined('BASEPATH') or exit('maaf akses anda ditutup.');
error_reporting(0);
class Karyawan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('M_model');
	}
	private $table = "tm_karyawan";
	private $primary_key = "fc_nik";
	private $secondary_key = "fv_sname";
	private $kolom = array("fc_branch","fc_nik","fv_sname","fv_lname","sex","fc_ktp","fv_tmp_lahir","fd_lahir","fc_hp","fc_hp2","fv_addr_ktp","fv_addr","fd_masuk","fv_jabatan","fv_pict","fc_status");
	public function index(){
		if(empty($this->session->userdata('userid'))){
			redirect('Login');
		}
        $hakakses_user = getAkses($this->uri->segment(1));
		$data = array(
			'title'     =>'PAYROLL SYSTEM',
			'footer'    => '&copy All Rights Reserved.Design System by Garuda Createch',
			'icon_web'  => 'favicon.png',
			'greeting'  => $this->session->userdata('greeting'),
			'nik'       => $this->session->userdata('nik'),
			'bread'     => 'Karyawan',
			'sub_bread' => '/Data Karyawan',
			'input'		=> $hakakses_user[0],
			'update'	=> $hakakses_user[1],
			'delete'	=> $hakakses_user[2],
			'view'		=> $hakakses_user[3],
			'jabatan'	=> $this->getJabatan(),
			'cabang'	=> $this->getBranch()
		);
		$this->load->view('Template/v_header',$data);
		$this->load->view('Template/v_datatable');
		$this->load->view('Template/v_sidemenu',$data);
		$this->load->view('v_view',$data);
		$this->load->view('Template/v_footer',$data);
	}
	public function Simpan(){
			$aksi = $this->input->post('aksi');
			$message = "";
			$data = array(
				'fc_nik'       => $this->input->post('a1'),
				'fv_sname'     => $this->input->post('a2'),
				'fv_lname'     => $this->input->post('a3'),
				'fc_sex'       => $this->input->post('a4'),
				'fc_ktp'       => $this->input->post('a5'),
				'fv_tmp_lahir' => $this->input->post('a6'),
				'fd_lahir'     => $this->input->post('a7'),
				'fc_hp'        => $this->input->post('a8'),
				'fc_hp2'       => $this->input->post('a9'),
				'fv_addr_ktp'  => $this->input->post('a10'),
				'fv_addr'      => $this->input->post('a11'),
				'fd_masuk'     => $this->input->post('a13'),
				'fc_jabatan'   => $this->input->post('a12'),
				'fv_pict'      => $_FILES['a14']['name'],
				'fc_status'    => $this->input->post('a15'),
				'fc_branch'    => $this->input->post('a16')
			);
			if (!empty($_FILES['a14']['name'])) {
				$config['upload_path']          = './assets/foto/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 50000;
                $this->load->library('upload', $config);
                $this->upload->do_upload("a14");
			}
			if ($aksi == 'tambah') {
				$proses = $this->M_model->tambah("tm_karyawan",$data);
				updateNomor('NIK');
			}else if($aksi == 'update'){
				$where = array('fc_nik'=>$this->input->post('kode'));
				$proses = $this->M_model->update("tm_karyawan",$data,$where);
			}
			if ($proses > 0) {
				$message = 'Berhasil menyimpan data';
			}else{
				$message = 'Gagal menyimpan data';
			}
		echo json_encode($message);
	}

	public function SimpanUser(){
		$aksi         = $this->input->post('aksi_user');
		$nik          = $this->input->post('kode_user');
		$branch       = $this->input->post('branch_user');
		$userid       = $this->input->post('b1');
		$password     = encryptPass($this->input->post('b1'));
		$data         = array(
						"fc_branch"   => $branch,
						"fc_nik"      => $nik,
						"fc_userid"   => $userid,
						"fc_password" => $password,
						"fc_hold"     => "0",
						"fd_input"    => date("Y-m-d")
						);
		if ($aksi =="tambah") {
			$aksi = $this->M_model->tambah("tm_user",$data);
		}else{
			$where = array("fc_nik" => $nik);
			$aksi = $this->M_model->update("tm_user",$data,$where);
		}
		if ($aksi > 0) {
			echo "Berhasil disimpan";
		}else{
			echo "Gagal Disimpan";
		}
	}

	public function Edit(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$edit = $this->M_model->getData($this->table,$data);
		echo json_encode($edit);
	}
	public function Hapus(){
		$kode = $this->uri->segment(3);
		$data = array($this->primary_key => $kode);
		$getData = $this->M_model->data($data);
		foreach ($getData as $key) {
			$dir = "./assets/foto_karyawan/".$key->fv_pict;
			unlink($dir);
			$hapus = $this->M_model->hapus("tm_karyawan",$data);
		}
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
	public function getJabatan(){
		$jabatan = $this->M_model->getJabatan();
		$arr_data = array();
			$arr_data[""] = "Pilih Jabatan";
	 	 foreach ($jabatan as $hasil) {
	 	 	$arr_data[$hasil->fc_jabatan] = $hasil->fv_jabatan;
	 	 }
		return $arr_data;
	}
	public function getBranch(){
		$jabatan = $this->M_model->getBranch();
		$arr_data = array();
			$arr_data[""] = "Pilih Cabang";
	 	 foreach ($jabatan as $hasil) {
	 	 	$arr_data[$hasil->fc_branch] = $hasil->fv_branch;
	 	 }
		return $arr_data;
	}
	public function getNomor(){
		echo getNomor($this->uri->segment(3));
	}
	public function getUser(){
		$branch = $this->uri->segment(3);
		$kode = $this->uri->segment(4);
		$data = array("fc_nik" => $kode,"fc_branch" => $branch);
		$edit = $this->M_model->getData("tm_user",$data);
		echo json_encode($edit);
	}
}