<?php
	defined('BASEPATH') or exit('direct access not allowed');
	/**
	* 
	*/
	class Akses extends CI_Controller
	{
		private $table_main 		= "t_hakakses";
		private $table_view 		= "v_hakakses";
		//ini untuk pencarian data di
		private $primary_key_view 	= "fv_menu";
		private $secondary_key_view = "fv_submenu";
		//ini untuk update delete
		private $primary_key 		= "fn_id";
		private $kolom = array("fn_id","fc_userid","fv_menu","fv_submenu","fc_view","fc_edit","fc_add","fc_delete","fc_userinput");

		function __construct()
		{
			parent::__construct();
			$this->load->model('M_akses');
			is_logged();
		}

		public function index( $error = null )
		{			
			$level = $this->session->userdata('level');
			$halaman = $this->uri->segment(1);
			$data = array(							
				'greeting' 	=> 'EDOM',
				'bread' 	=> 'EDOM',
				'sub_bread' => '/ Master Kategori',
				'input'		=> $hakakses_user[0],
				'update'	=> $hakakses_user[1],
				'delete'	=> $hakakses_user[2],
				'view'		=> $hakakses_user[3],
				'subtitle' 	=> 'Akses',
				'error' 	=> $error,
				'path' 		=> base_url().'assets/'
						); 
			loadView('v_view', $data, 0);
		}

		public function LoadData(){ 
			$id = $this->uri->segment(3);			
	        $customtable = "SELECT
						a.fn_id AS fn_id,
						a.fc_branch AS fc_branch,
						a.fc_userid AS fc_userid,
						a.fc_idmenu AS fc_idmenu,
						a.fc_idsubmenu AS fc_idsubmenu,
						a.fc_view AS fc_view,
						a.fc_edit AS fc_edit,
						a.fc_add AS fc_add,
						a.fc_delete AS fc_delete,
						a.fc_userinput AS fc_userinput,
						a.fd_input AS fd_input,
						b.fv_menu AS fv_menu,
						c.fv_menu AS fv_submenu
					FROM
						(
							(
								t_hakakses a
								JOIN t_menu b ON (
									(
										b.fc_idmenu = a.fc_idmenu
									)
								)
							)
							JOIN t_submenu c ON (
								(
									(
										c.fc_idmenu = b.fc_idmenu
									)
									AND (
										c.fc_idsubmenu = a.fc_idsubmenu
									)
								)
							)
						)
					WHERE 
						a.fc_userid = '$id'
					ORDER BY
						a.fc_idmenu,
						a.fc_idsubmenu
					";
	        $data = array();
	        if( $this->db->query( $customtable )->num_rows() > 0)
	        {	
	        	$data = $this->db->query( $customtable )->result_array();
	        } 
	        $json_data = array( "data" => $data );
	        echo json_encode($json_data); 
		}

		public function SubmenuList(){
			$id = $this->uri->segment(3); $hasil = "";
			$list = $this->HakModel->listsubmenu( $id );
			foreach ($list as $value) {
				$hasil .= "<option value='".$value->fc_idsubmenu."_".$value->fc_idmenu."'>$value->fv_menu</option> \n";
			}
			echo $hasil;
		}
		// ini untuk proses simpannya
		public function Simpan(){
			$tabel = $this->table_main; 
			$act = $this->input->post('aksi');
			$submenu = $this->input->post('b1'); // array
			if ( count($submenu) > 0 ) {
				foreach ($submenu as $key => $value) {
					$pecah = explode("_", $value);	//aa_b
					$data_update = array(
							'fc_userid' => $this->uri->segment(3),
							'fc_idmenu'  => $pecah[1],
							'fc_idsubmenu'  => $pecah[0],
							'fc_view'	=> ( ($this->input->post('b2a') != '')? $this->input->post('b2a') : 'N' ),
							'fc_edit' 	=> ( ($this->input->post('b2b') != '')? $this->input->post('b2b') : 'N' ),
							'fc_add' 	=> ( ($this->input->post('b2c') != '')? $this->input->post('b2c') : 'N' ),
							'fc_delete' => ( ($this->input->post('b2d') != '')? $this->input->post('b2d') : 'N' ),
							'fc_userinput'  => $this->session->userdata('userid')
						); 
					$where = array($this->primary_key => $this->input->post('kode'));  
					if($act == 'tambah'){
						$aksi = $this->functionbase->simpan($tabel,$data_update); 
					}else if($act == 'update'){
						$aksi = $this->functionbase->update($tabel,$data_update,$where); 
					}
				}
			} 

			if($aksi > 0){
				echo 'Aksi Berhasil';
			}else{
				echo 'Gagal data <br>';
			}
		} 

		public function Edit(){
			$tabel = $this->table_main;
			$where = array($this->primary_key => $this->uri->segment(3));
			$aksi = $this->functionbase->getData($tabel, $where);
			echo json_encode($aksi);
		} 

		public function Hapus(){
			$tabel = $this->table_main;
			$where = array($this->primary_key => $this->uri->segment(3));
			$aksi = $this->functionbase->del($tabel,$where);
			if($aksi > 0){
				echo 'Berhasil menghapus data';
			}else{
				echo 'Gagal menghapus data';
			}
		}		
	}