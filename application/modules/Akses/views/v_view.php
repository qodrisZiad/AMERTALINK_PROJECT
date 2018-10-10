            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar User</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                      <li><a><i class=""></i></a></li>
                      <?php if($input=='1'){?><li id="add_form"><a><i class="fa fa-plus" onclick="tambah()"></i></a></li><?php }?>
                      <li id="close_form" style="display: none"><a><i class="fa fa-close" onclick="tutup()"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
                    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    	Transaksi berhasil 
					  </div>
					  <form id="form1" name="form1" data-parsley-validate="" novalidate="">
                        <input type="hidden" name="aksi" value="tambah">
                              <label for="heard">Pilih User *:</label>
                              <select id="b0" name="b0" class="form-control" required>
                                <option value="">Choose option</option>
                                <?php echo $listuser;?>
                              </select>
                        <!-- end form for validations -->
                        <div class="divider-dashed"></div>
                        <div class="form-group">
                          <label class="control-label">Pilih Menu :</label>
                            <select id="b1" name="b1[]" class="select2_multiple form-control" multiple="multiple" required>                            
                            </select>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <label class="control-label">Select Authorization :</label>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2a" value="1"> Input
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2b" value="1"> Update
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2c" value="1"> Delete
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2d" value="1"> View Report
                                </label>
                              </div>
                        </div>
                        <div class="ln_solid"></div>
                          <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button type="reset" class="btn btn-danger">Reset</button>
                              <button id="b_simpan" type="submit" class="btn btn-success">Simpan</button>
                            </div>
                          </div>
                      </form>
					
                  </div>
                </div>
			  </div> 
			  <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                      <li><a><i class=""></i></a></li>
                      <?php if($input=='1'){?><li id="add_form"><a><i class="fa fa-plus" onclick="tambah()"></i></a></li><?php }?>
                      <li id="close_form" style="display: none"><a><i class="fa fa-close" onclick="tutup()"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
                    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    	Transaksi berhasil 
										</div>										
										<?php 
											$kolom = array("Menu","Input","Update","Delete","View","Aksi");
											buat_table($kolom,"datatable2");   
										?>										
                  </div>
                </div>
			  </div> 
			  <div class="clearfix"></div>
			  
            </div> 

            <script type="text/javascript">
            	var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
            	var table;
            	$(document).ready(function(){
            		datatable(); 
            	});
            	function datatable(){
            		table = $('#datatable2').DataTable({
			        	'processing'	: true, //ini untuk menampilkan processing
			        	'serverSide'	: false, //iini untuk serversidenya
			        	'deferRender' 	: true,
			        	'order'			: [], //ini jika menginginkan diorder
			        	'language'  	: {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data');?>",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[			        		
			        		{'data' : 'fv_menu',width:100},
			        		{'mRender': function ( data, type, row ) {
											if (row['fc_input'] == '1') {
												return "<input type='checkbox' checked='true' disabled>";
											}else{
												return "<input type='checkbox' checked='false' disabled>";
											}
	                  },width:10
                	},
									{'mRender': function ( data, type, row ) {
											if (row['fc_update'] == '1') {
												return "<input type='checkbox' checked='true' disabled>";
											}else{
												return "<input type='checkbox' checked='false' disabled>";
											}
															},width:10
													},
									{'mRender': function ( data, type, row ) {
											if (row['fc_delete'] == '1') {
												return "<input type='checkbox' checked='true' disabled>";
											}else{
												return "<input type='checkbox' checked='false' disabled>";
											}
															},width:10
													},
									{'mRender': function ( data, type, row ) {
											if (row['fc_view'] == '1') {
												return "<input type='checkbox' checked='true' disabled>";
											}else{
												return "<input type='checkbox' checked='false' disabled>";
											}
															},width:10
													}
											<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
																return "<?php if($delete =='1'){ ?><button class='btn btn-danger' onclick=hapus('"+row['fc_idmenu']+"')><i class='fa fa-close'></i></button><?php } ?>";
															},width:10
													} <?php  }else{ ?>
														,{'mRender': function ( data, type, row ) {
																return "Akses ditutup";
															},width:10
													}	
													<?php } ?>
										]  
									}); 
            	}
				function reload_table(){
					table.ajax.reload(null,false);
				}
				function tambah(){
					document.getElementById('formAksi').reset();
					$('#laporan').slideUp('slow');
					$('#formAksi').slideDown('slow');
					$('#close_form').fadeIn('slow');
					$('#add_form').fadeOut('slow');
					$('#aksi').val('tambah'); 
				}
				function tutup(){
					$('#pict_detail_img').hide();
					$('#formAksi').slideUp('slow');
					$('#laporan').slideDown('slow');
					$('#close_form').fadeOut('slow');
					$('#add_form').fadeIn('slow');
					$('#aksi').val('');
					reload_table();
				}
				function display_message(isi){
					$('#alert_trans').slideDown('slow').fadeOut(3000);
					if (isi.includes('Berhasil')==true) { 
						$('#alert_trans').removeClass("alert-danger");
						$('#alert_trans').addClass('alert-primary');
						$('#alert_trans').text(isi);
					}else if(isi.includes('Gagal') == true){
						$('#alert_trans').removeClass("alert-primary");
						$('#alert_trans').addClass('alert-danger');
						$('#alert_trans').text(isi);
					}
				}
				function edit(kode){ 
					$.ajax({
			            type: 'GET',
			            dataType:'JSON',
			            url: link+"/Edit/"+kode,
			            success:function(responseText){ 
			            	tambah(); 
			              	$('#aksi').val('update');
							$('#kode').val(kode);    
			                $('#a1').val(responseText.fc_kat);           
			                $('#a2').val(responseText.fv_subkat);           
			                $('#a4').val(responseText.fc_status);           
			                $('#pict_detail_img').show();
			                document.getElementById('pict_detail_img').src="./assets/foto/"+responseText.fv_pict;
			            }
			        });
				}
				function hapus(kode){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/Hapus/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	display_message(data);
			            	reload_table();
			            });
			            //--------------------------------
			        }
				}
				$(document).on('submit','#formAksi',function(e){
					e.preventDefault();
					$.ajax({
			            url: link+"/Simpan",
			            type: "POST",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){ 
			            if (data.includes("Berhasil") == true && $('#aksi').val()=='tambah') {
			            	document.getElementById('formAksi').reset();
			            } 
			            	display_message(data);
			            }           
			        });
			        return false;  
				}); 
				$(document).on('change','#a3',function(e){
					$('#pict_detail_img').show();
					PreviewImage('pict_detail_img','a3');
				});
				function PreviewImage(hasil,dari) {
					var oFReader = new FileReader();
					oFReader.readAsDataURL(document.getElementById(dari).files[0]);
					oFReader.onload = function (oFREvent)
					 {
					 	$('#'+hasil).fadeOut('fast');
					 	$('#'+hasil).fadeIn('fast');
					    document.getElementById(hasil).src = oFREvent.target.result;
					    
					};
				};
            </script>   