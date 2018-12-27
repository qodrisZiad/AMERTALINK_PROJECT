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
	/**
	 * 
	 */
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
	function format_tanggal_indo($tanggalan){
		return date("d-m-Y",strtotime($tanggalan));
	}
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
	 * fungsi ini membutuhkan form-helper module
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
				if ($inType == 'text' || $inType == 'number' || $inType == 'password') 
				{
					$result .= "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"$arr_data[name]\">$arr_data[label]</label>\n";
					$result .= "<div class=\"col-md-6 col-sm-6 col-xs-12\">\n";
					$result .= "<input type=\"$inType\" id=\"$arr_data[name]\" name=\"$arr_data[name]\" class=\"form-control col-md-6 col-sm-6 col-xs-12\" value=\"$defaultValue\" $isPlaceholder $readonly $isRequired>";
					$result .= "</div>\n";
				} else 
				if ($inType == 'date') 
				{
					$defaultDate = (array_key_exists('value',$arr_data)) ? $arr_data['value'] : date('Y-m-d');
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
