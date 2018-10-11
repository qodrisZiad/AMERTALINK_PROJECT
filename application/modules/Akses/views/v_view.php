            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pengaturan User</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                      <li><a><i class=""></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
                    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    	Transaksi berhasil 
					  </div>
					<form id="formAksi" name="formAksi" data-parsley-validate="" novalidate="">
							<input type="hidden" name="aksi" value="tambah">
							<label for="heard">Pilih User *:</label>
							<select id="b0" name="b0" class="form-control" required>
								<option value="">Choose option</option>
								<?= $listuser; ?>
							</select>							
							<div class="divider-dashed"></div>
							<div class="form-group">
								<label class="control-label">Pilih Menu :</label>
								<select id="b1" name="b1[]" class="select2_multiple form-control" multiple="multiple" required>                            
								</select>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<label class="control-label">Tentukan Aksesnya :</label>
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
			  <div class="col-md-8 col-sm-8 col-xs-12" id="tabelMenu">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Akses <span id="nama_user"></span></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                      <li><a><i class=""></i></a></li>                      
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
            		$('#tabelMenu').hide();
            	});
            	function datatable(user){
					(user!='')? $('#tabelMenu').fadeIn() : $('#tabelMenu').fadeOut();					
            		table = $('#datatable2').DataTable({
			        	'processing'	: true, //ini untuk menampilkan processing
			        	'serverSide'	: false, //iini untuk serversidenya
			        	'deferRender'	: true,
						'destroy'		: true,
			        	'order'				: [], //ini jika menginginkan diorder
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
				<?php if($delete=='1' || $update =='1'){ ?>
					,{'mRender': function ( data, type, row ) {
									return "<?php if($delete =='1'){ ?><button class='btn btn-danger' onclick=hapus('"+row['fc_idmenu']+"')><i class='fa fa-close'></i></button><?php } ?>";
						},width:10
						} <?php  }else { ?>
							,{'mRender': function ( data, type, row ) {	return "Akses ditutup";	},width:10	}	
						<?php } ?>
						]  
					}); 
            	}
				function reload_table(){
					table.ajax.reload(null,false);
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
				function hapus(kode){
					if(confirm("Apakah anda Yakin? "+kode)){ 
						$.get(link+"/Hapus/"+kode, $(this).serialize())
									.done(function(data) { 
										display_message(data);
										reload_table();
									});												
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
							if (data.includes("Berhasil") == true ) {
								document.getElementById('formAksi').reset();											 
								display_message(data);
								reload_table();
							}
						}           
					});
					return false;  
				}); 
				$(document).on('change','#b0',function(e){
					var pilihan = this.value;
					$.get(link+"/listmenu/"+pilihan, $(this).serialize())
						.done(function(data) { 													
							$('#b1').html(data);
							datatable(pilihan);
							$('#nama_user').html(pilihan);							
							var listmenu_to_select = document.getElementById('b1'); 
							listmenu_to_select.size = listmenu_to_select.length; 
						});
				});				
            </script>   