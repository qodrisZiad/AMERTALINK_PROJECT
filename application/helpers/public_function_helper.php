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
	function getSupplier($out=1){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_status" => "1"))->get("tm_supplier");
		if ($out==0){
			return $data->result();
		} else 
		if ($out==1){
			$arr_data = array();
				$arr_data[""] = "Pilih Supplier";
				foreach ($data->result() as $supp) {
					$arr_data[$supp->fc_kdsupplier] = $supp->fc_kdsupplier." | ".$supp->fv_supplier;
				}
				return $arr_data;
		}
	}
	function getBranch(){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_status" => "1"))->get("tm_branch");
		$arr_data = array();
			$arr_data[""] = "Pilih Cabang";
			foreach ($data->result() as $branch) {
				$arr_data[$branch->fc_branch] = $branch->fv_branch;
			}
			return $arr_data;
	} 
	function getKaryawan(){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where("fc_branch",$ci->session->userdata("branch"))->get("v_user");
		$arr_data = array();
			$arr_data[""] = "Pilih Karyawan";
			foreach ($data->result() as $branch) {
				$arr_data[$branch->fc_userid] = $branch->fc_nik." | ".$branch->fv_nama;
			}
			return $arr_data;
	}
	function getWareHouse($branch, $out=0){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_branch" => $branch,"fc_status" => "1"))->get("tm_warehouse"); 
		if ($out==0){
			return $data->result();
		} else 
		if ($out==1){
			$arr_data = array();
			$arr_data[""] = "Pilih Warehouse";
			foreach ($data->result() as $wh) {
				$arr_data[$wh->fc_wh] = $wh->fc_wh." | ".$wh->fv_wh;
			}
			return $arr_data;
		} else
		if ($out==2){
			$result = "<option>-- Pilih Warehouse --</option>\n";
			foreach ($data->result() as $wh) {
				$result .= "<option value='$wh->fc_wh'>$wh->fv_wh</option>\n"; 
			}
			return $result;
		}
	}
	function getWarna($stockcode, $size){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_stock" => $stockcode,"fv_size" => $size))->group_by("fv_warna")->get("v_variant"); 
		return $data->result();
	}
	function getSize($stockcode){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_stock" => $stockcode))->group_by("fc_size")->get("v_variant"); 
		return $data->result();
	}
	function getSatuan($stockcode){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_stock" => $stockcode))->get("v_uom"); 
		return $data->result();
	}
	function getVariant($stockcode){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_stock" => $stockcode))->get("v_variant"); 
		return $data->result();
	}
	function getStock($stockcode){
		$ci =& get_instance();
		$ci->load->database();
		$data = $ci->db->where(array("fc_stock" => $stockcode))->get("v_stock"); 
		return $data->row();
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
	function buat_form($data, $buttons = array()){  
		$inputan_data = "";
		  foreach ($data as $key => $value) {
		  	$input =  $value; 
		  	$readonly = "";
		  	$input_grup = "";
		  	$class_data = "";
		  	if (!empty($input['readonly'])) {
		  		$readonly = 'readonly';
		  	}else{
		  		$readonly = "";
		  	}

		  	if (!empty($input['input_search'])) {
		  		$class_data = "input-group";
		  		$input_grup = '<span class="input-group-btn"> <button type="button" id="btn_cari" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-search"></i></button></span>';
		  	}else{
		  		$class_data = "";
		  		$input_grup = "";
		  	}

		  	if ($input['type'] =="text" || $input['type']=='number' || $input['type']=='date') {
				$val = "";
				if($input['type'] == 'text' || $input['type']=='number') {
					($input['defaultValue'] != '') ? $val = $input['defaultValue'] : $val = "";
				} else
		  		if ($input['type'] == 'date') {
		  			$val = date('Y-m-d');
		  		}
		  		$type = '<input type="'.$input['type'].'" class="'.$input['class'].'" id="'.$input['name'].'" name="'.$input['name'].'" '.$readonly.' value="'.$val.'">'.$input_grup;
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
		            <div class="'.$input['col'].' '.$class_data.'">
		              	'.$type.'
		            </div>
		        </div>
			  	';
			}
		  }
		  // make default if no input array button
		  if(count($buttons) == 0){
			  $button = '<div class="ln_solid"></div>
						  <div class="form-group" id="button_action">
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <button type="reset" class="btn btn-danger">Reset</button> 
							  <button type="submit" class="btn btn-success">Simpan</button>
							</div>
						  </div>';
		  } else {
			$button = "<div class=\"ln_solid\"></div>\n
							<div class=\"form-group\" id=\"button_action\">\n
								<div class=\"col-md-9 col-sm-9 col-xs-12\">\n";
			$idbtn = '';
			foreach ($buttons as $btn) {
				($btn['id'] != '') ? ($idbtn = "id=\"$btn[id]\"") : ($idbtn = "");
				$button .= "<button $idbtn type=\"".$btn['type']."\" class=\"".$btn['class']."\">".$btn['label']."</button>\n";
			} 
			$button .= "</div>\n
					</div>";
		  }
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
	function decimal($angka){
		$hasil = str_replace(".","",str_replace("Rp.","",$angka));
		return $hasil;
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
	function encryptPass($pass){
		$ci =& get_instance();
		$ci->load->database();
		$query = $ci->db->select("SUBSTR(MD5(CONCAT(SUBSTR(MD5('".$pass."'),1,16),(select fv_value from t_setup where fc_param = 'KEY_SA'))),1,15) COLLATE utf8_general_ci as data")->get();
		foreach ($query->result() as $row) {
			$hasil = $row->data;
		}
		return $hasil;
	}	
	function format_tanggal_indo($tanggalan){
		return date("d-m-Y",strtotime($tanggalan));
	}	
	function insertKartuStock($branch, $wh, $fc_stock, $fc_variant, $fc_uom, $fn_in=0, $fn_out=0, $referensi, $fc_ket, $userid){
		$ci =& get_instance();
		$ci->load->database();
		$data = array (
			'fc_branch'		=> $branch,
			'fc_wh'			=> $wh,
			'fc_stock'		=> $fc_stock,
			'fc_variant'	=> $fc_variant,
			'fc_uom'		=> $fc_uom,
			'fn_in'			=> $fn_in,
			'fn_out'		=> $fn_out,
			'fc_referensi'	=> $referensi,
			'fc_userid'		=> $userid,
			'fc_ket'		=> $fc_ket
		);
		$query = $ci->db->insert('t_kartustock', $data);
		return $ci->db->affected_rows();
	}
// START ETC METHOD ---------------------------------------------------------------------
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
	function loadView($pages='v_view', $data=null, $opt=1){
		$ci =& get_instance();
		$ci->load->view('Template/v_header',$data);
		if($opt==1){ $ci->load->view('Template/v_datatable',$data); } 
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
	/**
	 * membuat tombol action dinamis
	 */
	function getButtonAction($lists = array(),$options = array()){
		// make default parameter
		$btn_title		= (array_key_exists('title',$options)) ? $options['title'] : 'Aksi';
		$btn_class		= (array_key_exists('class',$options)) ? $options['class'] : 'btn-primary btn-sm';
		
		$result  = "<div class='x_content'>\n";
		$result .= "<div class='btn-group'>\n";
		$result .= "<button data-toggle='dropdown' class='btn dropdown-toggle $btn_class' type='button' aria-expanded='false'>$btn_title <span class='caret'></span></button>\n";
		$result .= "<ul role='menu' class='dropdown-menu'>\n";
		/**
		 * $lists = array(
		 * 	'key'	=> array('title' => 'button title','action'=>'button action','visible'=> 'how button should appear','type'=>'button or divider')
		 * );
		 */
		foreach ($lists as $key => $list_attr) {
			// make default parameter
			$list_title		= (array_key_exists('title',$list_attr)) ? $list_attr['title'] : 'tombol';
			$list_action	= (array_key_exists('action',$list_attr)) ? $list_attr['action'] : 'alert(\'hello world!\')';
			$list_visible	= (array_key_exists('visible',$list_attr)) ? $list_attr['visible'] : '0';
			$list_type		= (array_key_exists('type',$list_attr)) ? $list_attr['type'] : 'button';

			if($list_type == 'button')
			{
				if ($list_visible == '1') 
				{
					$result .= "<li><a href='#' onclick=$list_action title='' >$list_title</a></li>\n"; 	
				}
			} else
			{
				$result .= "<li class='divider'></li>\n";
			}
		}
		$result .= "</ul>\n";
		$result .= "</div>\n";
		$result .= "</div>\n";
		return $result;
	}
// END ETC METHOD ---------------------------------------------------------------------
// START FORM METHOD ---------------------------------------------------------------------
	/** memecah array menjadi beberapa bagian 
	 * $output = array multidimensi
	*/
	function array_split($array, $pieces=2) 
	{   
		if ($pieces < 2) return array($array); 		
		$newCount = ceil(count($array)/$pieces); 
		$a = array_slice($array, 0, $newCount); 
		$b = array_split(array_slice($array, $newCount), $pieces-1); 
		return array_merge(array($a),$b); 
	}
	/**
	 * fungsi ini untuk membuat form secara dinamis
	 * @field 		(array)		= berisi field (selain type hidden) yang ingin digenerate
	 * @hiddenField	(array)		= berisi field hidden
	 * @buttons		(array)		= berisi button
	 * @n_col		(integer)	= jumlah kolom
	 * result		(string)
	 */
	function custom_form($fields, $hiddenField, $buttons=array(), $n_col=1)
	{  
		$result 		= '';		 									// initialize output
		$n_field 		= count($fields);  								// cari tau jumlah item array						// jumlah kolom
		$n_items		= array_split($fields,$n_col);					// memecah array
		$n_width_max	= 12; 											// default max width based on bootstrap
		$n_width		= round( $n_width_max / $n_col );				// max width is 12, so divide by column
		$c_width		= "col-md-$n_width col-sm-$n_width col-xs-$n_width_max";
		$n_width_btn	= ($n_col == 1) ? $n_width_max-3 : $n_width_max;
		// loop hidden type
		foreach ($hiddenField as $arr_key => $arr_data) {
			$defaultValue = (array_key_exists('value',$arr_data)) ? $arr_data['value'] : '';			
			$result .= "<input type=\"hidden\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" value=\"$defaultValue\">\n";			
		}
		// loop column first
		for ($i=0; $i < $n_col ; $i++) { 
			// open container syntax
			$result .= "<div class=\"$c_width\">\n";				
			// loop normal type
			foreach ($n_items[$i] as $arr_key => $arr_data) {
				// make some global variable
				$inType 		= strtolower($arr_data['type']);		
				$defaultValue 	= (array_key_exists('value',$arr_data)) ? $arr_data['value'] : '';
				$readonly	 	= (array_key_exists('readonly',$arr_data)) ? 'readonly="readonly"' : '';
				$isRequired 	= (array_key_exists('required',$arr_data)) ? 'required="required"' : '';
				$isPlaceholder 	= (array_key_exists('placeholder',$arr_data)) ? "placeholder=\"$arr_data[placeholder]\"" : '';

				$result .= "<div class=\"form-group\">\n";
				if ($inType == 'text' || $inType == 'number' || $inType == 'password' || $inType == 'email' || $inType == 'color' || $inType == 'tel' || $inType == 'search' || $inType == 'time' || $inType == 'url') 
				{
					$result .= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result .= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result .= "<input type=\"$inType\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" value=\"$defaultValue\" $isPlaceholder $readonly $isRequired>";
					$result .= "</div>\n";
				} else 
				if ($inType == 'date' || $inType == 'datetime-local' || $inType == 'time') 
				{
					switch ($inType) {
						case 'date' 			:	$defValue = date('Y-m-d');	break;
						case 'datetime-local'	:	$defValue = date('Y-m-d H:m:s');	break;
						case 'time' 			:	$defValue = date('H:m:s');	break;
						default					: 	$defValue = date('Y-m-d');	break;
					}
					$defaultDate = (array_key_exists('value',$arr_data)) ? $arr_data['value'] : $defValue;
					$result .= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result .= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result .= "<input type=\"$inType\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" value=\"$defaultDate\" $readonly $isRequired>";
					$result .= "</div>\n";
				} else 
				if ($inType == 'option' || $inType == 'multiple') 
				{
					$result .= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result .= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					if($inType != 'multiple')
					{
						$result .= "<select id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control\" $readonly $isRequired >\n";
					} else 
					{
						$result .= "<select id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"select2_multiple form-control\" multiple=\"multiple\" $readonly $isRequired >\n";
					}
					foreach ($arr_data['option'] as $key => $value) 
					{
						$result .= "<option value=\"$key\">$value</option>\n";
					} 
					$result .="</select>\n";
					$result .= "</div>\n";
				} else
				if ($inType == 'file') 
				{
					$result .= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result .= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result .= "<input type=\"$inType\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" $readonly $isRequired>\n";
					$result .= "<img src=\"\" id=\"pict_detail_img\" width=\"400px\" style=\"display: none;\">"; 
					$result .= "</div>\n";
				} else 
				if ($inType == 'textarea')
				{
					$t_rows		 = (array_key_exists('rows',$arr_data)) ? "rows=\"$arr_data[rows]\"" : "rows=\"3\"";
					//$t_cols		 = (array_key_exists('cols',$arr_data)) ? "cols=\"$arr_data[cols]\"" : "";
					$result 	.= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result 	.= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result 	.= "<textarea id=\"$arr_data[name]\" name=\"$arr_data[name]\" $t_rows class=\"form-control col-md-6 col-sm-6 col-xs-12\" $isPlaceholder $readonly $isRequired>$defaultValue</textarea>";
					$result 	.= "</div>\n";
				} else 
				if ($inType == 'checkbox' || $inType == 'radio')
				{
					/**
					 * this is how you should define $option variable
					 * $options = array(
					 *	'Ops1'	=> array('name'=>'radio','desc'=>'ini keterangan label 1'),
					 *	'Ops2'	=> array('name'=>'radio','desc'=>'ini keterangan label 2','checked'=>true),
					 *	);
					 * -> Ops1 (key) will be value of checkbox
					 * -> Ops1 (key) will be name and value of radio
					 */
					$result 	.= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result 	.= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					foreach ($arr_data['option'] as $key => $value) 
					{
						$isCheckbox	 = ($inType == 'checkbox') ? "$value[name]"."[]" : "$value[name]";
						$isChecked	 = (array_key_exists('checked',$value)) ? "checked" : "";
						$result .= "<div class=\"$inType\">\n";
						$result .= "<label>\n";
						$result .= "<input type=\"$inType\" name=\"$isCheckbox\" value=\"$key\" $isChecked> $value[desc]\n";							
						$result .= "</label>\n";
						$result .= "</div>\n";
					} 
					$result 	.= "</div>\n";
				} else
				if ($inType == 'btn_addon') 
				{
					// default value 
					$btn_id	 	 = (array_key_exists('btn_id',$arr_data)) ? "$arr_data[btn_id]" : "btn_aksi";
					$btn_label	 = (array_key_exists('btn_label',$arr_data)) ? "$arr_data[btn_label]" : "Cari";
					$btn_icon	 = (array_key_exists('btn_icon',$arr_data)) ? "fa $arr_data[btn_icon]" : "fa fa-search";
					$btn_class	 = (array_key_exists('btn_class',$arr_data)) ? "$arr_data[btn_class]" : "btn-primary";
					
					$result 	.= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result 	.= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result 	.= "<div class=\"input-group\">";
					$result 	.= "<input type=\"text\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" value=\"$defaultValue\" $isPlaceholder $readonly $isRequired>";
					$result 	.= "<span class=\"input-group-btn\">";
					$result 	.= "<button type=\"button\" id=\"$btn_id\" class=\"btn $btn_class\"><i class=\"$btn_icon\"></i> $btn_label</button>";
					$result 	.= "</span>";
					$result 	.= "</div>\n";
					$result 	.= "</div>\n";
				} else
				if ($inType == 'btn_action') 
				{
					/**
					 * this sample how to define $option variable
					 * $options = array(
					 *	 'Ops1'	=> array('url'=>'home','label'=>'ini keterangan label 1'),
					 *	 'Ops2'	=> array('url'=>'mutasi','label'=>'ini keterangan label 2'),
					 *	 'Ops3'	=> array('url'=>'kartustock','label'=>'ini keterangan label 3'),
					 *	);
					 */
					$btn_id	 	 = (array_key_exists('btn_id',$arr_data)) ? "$arr_data[btn_id]" : "btn_aksi";
					$btn_label	 = (array_key_exists('btn_label',$arr_data)) ? "$arr_data[btn_label]" : "Action";
					$result 	.= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result 	.= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result 	.= "<div class=\"input-group\">";
					$result 	.= "<input type=\"text\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" aria-label=\"Text input with dropdown button\" value=\"$defaultValue\" $isPlaceholder $readonly $isRequired>";
					$result 	.= "<div class=\"input-group-btn\">";
					$result 	.= "<button type=\"button\" id=\"$btn_id\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">$btn_label <span class=\"caret\"></span></button>";
					$result 	.= "<ul class=\"dropdown-menu dropdown-menu-right\" role=\"menu\">\n";
					foreach ($arr_data['option'] as $key => $value) 
					{
						$result .= "<li><a href=\"$value[url]\">$value[label]</a></li>\n";	
					}
					$result 	.= "</ul>\n";
					$result 	.= "</div>\n";
					$result 	.= "</div>\n";
					$result 	.= "</div>\n";
				} else 
				if ($inType == 'search') 
				{
					// default value 
					$btn_id	 	 = (array_key_exists('btn_id',$arr_data)) ? "$arr_data[btn_id]" : "btn_cari";
					$btn_label	 = (array_key_exists('btn_label',$arr_data)) ? "$arr_data[btn_label]" : "Cari";
					$btn_icon	 = (array_key_exists('btn_icon',$arr_data)) ? "fa $arr_data[btn_icon]" : "fa fa-search";
					$btn_class	 = (array_key_exists('btn_class',$arr_data)) ? "$arr_data[btn_class]" : "btn-primary";
					$modal_class = (array_key_exists('modal_class',$arr_data)) ? ".$arr_data[modal_class]" : ".bs-example-modal-lg";
					
					$result 	.= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result 	.= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result 	.= "<div class=\"input-group\">";
					$result 	.= "<input type=\"text\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" value=\"$defaultValue\" $isPlaceholder $readonly $isRequired>";
					$result 	.= "<span class=\"input-group-btn\">";
					$result 	.= "<button type=\"button\" id=\"$btn_id\" class=\"btn $btn_class\" data-toggle=\"modal\" data-target=\"$modal_class\"><i class=\"$btn_icon\"></i> $btn_label</button>";
					$result 	.= "</span>";
					$result 	.= "</div>\n";
					$result 	.= "</div>\n";					
				}
				$result .="</div>\n";
			} 
			$result .= "</div>\n";
		}		
		// make default if no input array button
		if(count($buttons) == 0){
			$result .= "<div class=\"clearfix\"></div>\n
						<div class=\"ln_solid\"></div>\n
						<div class=\"form-group\" id=\"button_action\">\n
						<div class=\"$c_width\">\n
							<button type=\"submit\" class=\"btn btn-success pull-right\">Simpan</button>\n
							<button type=\"reset\" class=\"btn btn-danger pull-right\">Reset</button>\n 							
						</div>\n
						</div>\n";
		} else {
		$result .= "<div class=\"clearfix\"></div>\n
					<div class=\"ln_solid\"></div>\n
						<div class=\"form-group\" id=\"button_action\">\n
							<div class=\"col-md-$n_width_btn col-sm-$n_width_btn col-xs-$n_width_max\">\n";
		$idbtn = '';
		rsort($buttons);			// reverse array order bcoz pull-right make button placed reverse and this make all come to normal
		foreach ($buttons as $btn) {
			($btn['id'] != '') ? ($idbtn = "id=\"$btn[id]\"") : ($idbtn = "");
			$result .= "<button $idbtn type=\"".$btn['type']."\" class=\"".$btn['class']." pull-right\">".$btn['label']."</button>\n";
		} 
		$result .= "</div>\n
				</div>\n";
		}
		echo $result;
	}
	/**
	 * meng-generate script table dengan berbagai options
	 * sample $table_attr variable
	 * $table_attr = array(
	 *		'table_id'		 => 'tabel-karyawan',
	 *		'columns'		 => array("No.","AKSI","NAMA LENGKAP","SEX","TP LAHIR","TGL LAHIR","HP","ALAMAT","JABATAN","TGL MASUK"),
	 *		'header'		 => 'complex/simple',
	 *		'header_options' => array(
	 *			'row1'		 =>	array(
	 *							'col1'	=> array('label'=>'NO.','mRow'=>2),
	 *							'col2'	=> array('label'=>'AKSI','mRow'=>2),
	 *							'col3'	=> array('label'=>'DATA PRIBADI','mCol'=>6),
	 *							'col4'	=> array('label'=>'LAIN','mCol'=>2),
	 *			),
	 *			'row2'		 => array("NAMA LENGKAP","SEX","TP LAHIR","TGL LAHIR","HP","ALAMAT","JABATAN","TGL MASUK")
	 *		),
	 *		'footer'		 => false
	 *	);
	 */
	function custom_table( $table_attr = array() ){
		// make default 
		$table_id		= (array_key_exists('table_id',$table_attr)) ? $table_attr['table_id'] : "tabel-1";
		$table_head		= (array_key_exists('header',$table_attr)) ? $table_attr['header'] : "simple";	
		$table_foot		= (array_key_exists('footer',$table_attr)) ? $table_attr['footer'] : true;
		$table_class	= (array_key_exists('class',$table_attr)) ? $table_attr['class'] : "table-striped table-bordered";
		$table_style	= (array_key_exists('style',$table_attr)) ? $table_attr['style'] : "width:100%;";
		$header_options	= (array_key_exists('header_options',$table_attr)) ? $table_attr['header_options'] : "";
		
		$result = "<table id='$table_id' class='table $table_class' style='$table_style'>\n";
		if ($table_head == 'simple') {
			$result .= "<thead>\n";
			$result .= "<tr>\n";
			foreach ($table_attr['columns'] as $column) {
				$result .= "<th>$column</th>\n";
			}
			$result .= "</tr>\n";
			$result .= "</thead>\n";
		} else 
		if ($table_head == 'complex')
		{
			// header yang lebih kompleks with row+col span
			// maximum 2 column to merge for now 
			$result .= "<thead>\n";
			foreach ($header_options as $rowKey => $columns) {
				$result .= "<tr>\n";
				if ($rowKey=='row1')
				{	
					foreach ($columns as $colKey => $col_attr) {
						$mRow	= (array_key_exists('mRow',$col_attr)) ? "rowspan=\"$col_attr[mRow]\"" : "";
						$mCol	= (array_key_exists('mCol',$col_attr)) ? "colspan=\"$col_attr[mCol]\"" : "";
						$result .= "<th class=\"align-middle\" $mRow$mCol>$col_attr[label]</th>\n";
					}
				} else
				if($rowKey=='row2')
				{
					foreach ($columns as $colKey => $col_attr) {
						$mRow	= (array_key_exists('mRow',$col_attr)) ? "rowspan='\"$col_attr[mRow]\"" : "";
						$mCol	= (array_key_exists('mCol',$col_attr)) ? "colspan='\"$col_attr[mCol]\"" : "";
						$label	= (array_key_exists('label',$col_attr)) ? $col_attr['label'] : $col_attr;
						$result .= "<th class=\"align-middle\" $mRow$mCol>$label</th>\n";
					}
				}
				$result .= "</tr>\n"; 
			}
			$result .= "</thead>\n";
		}
		if ($table_foot){
			$result .= "<tfoot>\n";
			$result .= "<tr>\n";
			foreach ($table_attr['columns'] as $column) {
				$result .= "<th>$column</th>\n";
			}
			$result .= "</tr>\n";
			$result .= "</tfoot>\n";
		}		
		$result .= "</table>\n";
		echo $result;
	}
	function getModalDialog($modalAttr = array(), $tableAttr = array()){
		// make default 
		$modal_class		= (array_key_exists('modal_class',$modalAttr)) ? "$modalAttr[modal_class]" : "bs-example-modal-lg";
		$modal_title		= (array_key_exists('title',$modalAttr)) ? "$modalAttr[title]" : "Pencarian Data";
		$modal_title_id		= (array_key_exists('title_id',$modalAttr)) ? "$modalAttr[title_id]" : "title_id";
		
		$result .= "<div class=\"modal fade $modal_class\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">\n";
			$result .= "<div class=\"modal-dialog modal-lg\">\n";
				$result .= "<div class=\"modal-content\">\n";
					$result .= "<div class=\"modal-header\">\n";
						$result .= "<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">×</span></button>\n";
						$result .= "<h4 class=\"modal-title\" id=\"$modal_title_id\">$modal_title</h4>\n";
					$result .= "</div>\n";
					$result .= "<div class=\"modal-body\">\n";
						buat_table($tableAttr['column'],$tableAttr['table_id']);   
					$result .= "</div>\n"; 
				$result .= "</div>\n";
			$result .= "</div>\n";
		$result .= "</div>\n";
		
		echo $result;
	}
// END FORM METHOD ---------------------------------------------------------------------
// START DATATABLE METHOD ---------------------------------------------------------------------
	/**
	 * generate table query untuk dipakai banyak datatable dalam satu halaman 
	 * @table_name (string)   nama tabel 
	 * @columnOrder (array)   list kolom yang ingin bisa di urutkan (defaultOrder)
	 * @columnSearch (array)  list kolom yang ingin bisa di cari (searchable)
	 * @defaultOrder (array)  kolom yang dijadikan standar pengurutan (default order)
	*/
	function get_datatables_custom_table_query($table_name = '', $columnOrder = array(), $columnSearch = array(), $defaultOrder = array('fc_id' => 'asc'))
	{     
		$ci =& get_instance();
		$ci->load->database();

		// you can add custom filter here as many as needed but don't forget every table has different filter
		if($ci->input->post('f_bpbno'))
		{
			$ci->db->where('fc_nobpb', $ci->input->post('f_bpbno'));
		}
		
		$ci->db->from( $table_name ); 
		
		$i = 0;  // for table numbering
		foreach ($columnSearch as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{                
				if($i===0) // first loop
				{
					$ci->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$ci->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$ci->db->or_like($item, $_POST['search']['value']);
				}

				if(count($columnSearch) - 1 == $i) //last loop
					$ci->db->group_end(); //close bracket
			}
			$i++;
		}
		// here order processing
		if(isset($_POST['order'])) 
		{
			$ci->db->order_by($columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($defaultOrder))
		{
			$ci->db->order_by(key($defaultOrder), $defaultOrder[key($defaultOrder)]);
		}
	}	
	function get_datatables($tableName = '', $columnOrder = array(), $columnSearch = array(), $defaultOrder = array('fc_id' => 'asc'))
	{
		$ci =& get_instance();
		$ci->load->database();
		get_datatables_custom_table_query($tableName,$columnOrder,$columnSearch,$defaultOrder);
		if($_POST['length'] != -1)
			$ci->db->limit($_POST['length'], $_POST['start']);
		$query = $ci->db->get();
		return $query->result();
	}

	function count_filtered($tableName = '', $columnOrder = array(), $columnSearch = array(), $defaultOrder = array('fc_id' => 'asc'))
	{
		$ci =& get_instance();
		$ci->load->database();
		get_datatables_custom_table_query( $tableName, $columnOrder, $columnSearch, $defaultOrder);
		$query = $ci->db->get( $table_name ); 
		return $query->num_rows();
	}

	/**
	 * count_all
	 *
	 * @param  mixed $table_name
	 *
	 * @return void
	 */
	function count_all($table_name='')
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->from( $table_name ); 
		return $ci->db->count_all_results();
	}
// END DATATABLE METHOD ---------------------------------------------------------------------