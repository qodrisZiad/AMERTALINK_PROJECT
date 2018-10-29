<?php defined('BASEPATH') or exit('maaf akses anda kita tutup');
	function getMenu(){
		$ci=& get_instance();
    	$ci->load->database();
		$where = array('a.fc_userid'=>$ci->session->userdata('userid'),'b.fc_hold'=>'0',"IFNULL(b.fc_parent,'-')"=>'-');
		$query = $ci->db->select("a.*,IFNULL(b.fc_parent,'-') as parent,b.fv_menu,b.fc_link,b.fv_class1 as fv_class")
				 ->from('t_hakakses a')
				 ->join('t_menu b','b.fc_id=a.fc_idmenu')
				 ->where($where)
				 ->get();
		return $query;		
	}
	function getSubmenu(){ 
		$ci=& get_instance();
    	$ci->load->database();
		$where = array('a.fc_userid'=>$ci->session->userdata('userid'),'b.fc_hold'=>'0',"IFNULL(b.fc_parent,'-') != "=>'-');
		$query = $ci->db->select("a.*,IFNULL(b.fc_parent,'-') as parent,b.fv_menu,b.fc_link,b.fv_class1 as fv_class")
				 ->from('t_hakakses a')
				 ->join('t_menu b','b.fc_id=a.fc_idmenu')
				 ->where($where)
				 ->get();
		return $query;
	} 	
	function upload($data, $name='', $resize=false, $debug=false){
		$out = array('message' => '', 'is_upload' => 0, 'is_resize' => 0 );
		$ci=& get_instance();
				$config['upload_path']          = './assets/foto/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
				//$config['remove_space']		= true;
				$config['max_size']             = 9999; // 10mb
		if( $name != '' ) {
			$config['file_name']	= $name; 
		}		
		$ci->load->library('upload', $config);
		if( $ci->upload->do_upload($data) ){
			$out['is_upload'] = 1;
			if($resize == true) {
				$imagedata = $ci->upload->data();
				list($width, $height) = getimagesize($imagedata['full_path']);
				$config2['image_library'] = 'gd2';
				$config2['source_image'] = $imagedata['full_path']; 
				$config2['maintain_ratio'] = FALSE;
				$config2['width'] = 900;
				$config2['height'] = 900;
				$ci->load->library('image_lib');
				$ci->image_lib->initialize($config2);
				if ($ci->image_lib->resize()) {
					$out['is_resize'] = 1;
				} else {
					$out['message'] = $ci->image_lib->display_errors();
				}
				$ci->image_lib->clear();
			}
		} else {
			$out['message'] = $ci->upload->display_errors();
		}
		if($debug == true) {
			return json_encode($out);
		}		
	}
	function buat_form($data){  
		$inputan_data = "";
		  foreach ($data as $key => $value) {
		  	$input =  $value; 
		  	$readonly = "";
		  	if (!empty($input['readonly'])) {
		  		$readonly = 'readonly';
		  	}else{
		  		$readonly = "";
		  	}
		  	if ($input['type'] =="text" || $input['type']=='number' || $input['type']=='date') {
				$val = "";
				if($input['type'] == 'text' || $input['type']=='number') {
					($input['defaultValue'] != '') ? $val = $input['defaultValue'] : $val = "";
				} else
		  		if ($input['type'] == 'date') {
		  			$val = date('Y-m-d');
		  		}
		  		$type = '<input type="'.$input['type'].'" class="'.$input['class'].'" id="'.$input['name'].'" name="'.$input['name'].'" '.$readonly.' value="'.$val.'">';
		  	}else
		  	if ($input['type'] =="file") {
		  		$val = ""; 
		  		$type = '<input type="'.$input['type'].'" class="'.$input['class'].'" id="'.$input['name'].'" name="'.$input['name'].'" '.$readonly.' value="'.$val.'">
					<img src="" id="pict_detail_img" width="400px" style="display: none;">
		  		';

		  	}else if($input['type'] == 'hidden'){
		  		$type = '<input type="'.$input['type'].'" id="'.$input['name'].'" name="'.$input['name'].'">';
		  	}else if($input['type'] == 'option'){
		  		$isian = "";
		  			$total_arr = count($input['option']); 
		  				foreach ($input['option'] as $key => $value) {
		  					$isian .= '<option value="'.$key.'">'.$value.'</option>';
		  				 }  
		  			$type = '<select class="'.$input['class'].'" name="'.$input['name'].'" id="'.$input['name'].'" '.$readonly.'>'.$isian.'</select>';
		  		}else{
		  			$type = "";
		  		}

		  	if($input['type'] == 'hidden'){
		  		$inputan_data .= $type;
		  	}else{
			  	$inputan_data .= '
				<div class="form-group">
		            <label class="control-label col-sm-2" for="'.$input['name'].'">'.$input['label'].'</label>
		            <div class="'.$input['col'].'">
		              	'.$type.'
		            </div>
		        </div>
			  	';
			}
		  }
		  $button = '<div class="ln_solid"></div>
                      <div class="form-group" id="button_action">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <button type="reset" class="btn btn-danger">Reset</button> 
                          <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                      </div>';
		  echo $inputan_data.$button;
	} 
	function buat_table($kolom,$id){
		$kode_table = "";
		if (!empty($id)) {
			$kode_table = $id;
		}else{
			$kode_table = "datatable";
		}
		$kolomnya = "";
		for ($i=0; $i < count($kolom) ; $i++) { 
			$kolomnya .= "<th>".$kolom[$i]."</th>";
		}
		$table = '
			<table id="'.$kode_table.'" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
				<tr>
				    '.$kolomnya.'
				</tr>
				</thead> 
				<tfoot>
					<tr>
					    '.$kolomnya.'
					</tr>
				</tfoot>  
			</table>
		';
		echo $table;
	} 
	function getAkses($link){
		$input = "";$update="";$delete="";$view="";
		$ci=& get_instance();
		$ci->load->database();
		$where = array('a.fc_userid'=>$ci->session->userdata('userid'),'trim(b.fc_link)'=>str_replace(' ','',$link));
		$query = $ci->db->select('a.fc_input,a.fc_update,a.fc_delete,a.fc_view')
				->from('t_hakakses a')
				->join('t_menu b','b.fc_id=a.fc_idmenu','left')
				->where($where)
				->get();
		foreach ($query->result() as $key) {
			$input = $key->fc_input;
			$update = $key->fc_update;
			$delete = $key->fc_delete;
			$view   = $key->fc_view;
		}
		$data = array($input,$update,$delete,$view);
		return $data;
	}
	function rupiah($angka){
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	} 
	function getNomor($document){ 
		$ci =& get_instance();
		$ci->load->database();
		$nomor = "";
        $query = $ci->db->where("fc_param",$document)->get('t_nomor');
        if($query->num_rows()>0)
        { 
           foreach ($query->result() as $row) {
            $nomor_urut = $row->fc_prefix.str_pad($row->fn_nomor, $row->fn_long, "0", STR_PAD_LEFT);
           }
           $nomor = $nomor_urut;
        }
        else{$nomor = "";} 
        return $nomor;
	}
	function updateNomor($document){
		$ci =& get_instance();
		$ci->load->database();
		$query = $ci->db->query("update t_nomor set fn_nomor=fn_nomor+1 where fc_param='".$document."'");
	}

	function getPrice(){
		$hasil = "";
		$ci =& get_instance();
		$ci->load->database();
		$query = $ci->db->where(array('fc_status'=>'Y'))->get('tm_pricelist');
		foreach ($query->result() as $row) {
			$hasil = $row->fn_price;
		}
		return $hasil;
	}
	/*
	 * mengecek login atau belum
	 */
	function is_logged(){
		$ci =& get_instance();
		if($ci->session->userdata('userid') == ''){	
			// jika tidak ada session dan membuka halaman selain Login akan diarahkan ke  Login		
			if($ci->uri->segment(1) != 'Login'){
				redirect(site_url('Login'));
			} 						
		} else {
			// jika masih ada session dan membuka halaman login akan diarahkan ke home
			if($ci->uri->segment(1) == '' || $ci->uri->segment(1) == 'Login'){
				redirect(site_url('Home'));
			} 
		}
	}
	/*
	 * mempersingkat script load view
	 * @page = lokasi halaman yang mau di load
	 * @data = data yang mau dilewatkan ke view
	 * @opt  = opsional, untuk menampilkan datatable, atau yang lain
	 */
	function loadView($pages='v_view', $data=null, $opt){
		$ci =& get_instance();
		$ci->load->view('Template/v_header',$data);
		if($opt==0){ $ci->load->view('Template/v_datatable',$data); } 
		$ci->load->view('Template/v_sidemenu',$data);
		if(is_array($pages)){
			foreach ($pages as $page) {
				$ci->load->view( $page , $data );		
			}
		} else {
			$ci->load->view( $pages , $data );
		}		
		$ci->load->view('Template/v_footer',$data);
	}
	/*
	 * fungsi ini harus panggil setelah proses userid dimasukan kesession
	 */
	function resetMenuSession($data = array('menu','submenu')){
		$ci=& get_instance();
		$ci->load->library('session');
		$ci->session->unset_userdata($data);
		$menu = getMenu(); $submenu = getSubmenu();
		$data_menu = array(
			'menu'		=> $menu->result(),
			'submenu'	=> $submenu->result()
		);
		$ci->session->set_userdata($data_menu);		
	}
	function encryptPass($pass){
		$ci =& get_instance();
		$ci->load->database();
		$query = $ci->db->select("SUBSTR(MD5(CONCAT(SUBSTR(MD5('".$pass."'),1,16),(select fv_value from t_setup where fc_param = 'KEY_SA'))),1,15) COLLATE utf8_general_ci as data")->get();
		foreach ($query->result() as $row) {
			$hasil = $row->data;
		}
		return $hasil;
	}
