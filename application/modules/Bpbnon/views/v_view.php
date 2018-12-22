            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" id="wizardContainer">
                  <div class="x_title">
                    <h2>Penerimaan Barang Tanpa PO</h2> 
                  	<ul class="nav navbar-right panel_toolbox">
                  		<li id="close_form" style="display: none"><a><i class="fa fa-close" onclick="tutup()"></i></a></li>
                  	</ul>
                    <div class="clearfix"></div> 
                	</div>
					<div class="x_content">
						<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							Transaksi berhasil 
						</div>						
						<!-- Smart Wizard -->
						<div id="wizardCustom" class="form_wizard wizard_horizontal">
							<ul class="wizard_steps">
								<li>
									<a href="#step-1">
										<span class="step_no">1</span>
										<span class="step_descr">
												Step 1<br />
												<small>Form Data Master</small>
										</span>
									</a>
								</li>
								<li>
									<a href="#step-2">
										<span class="step_no">2</span>
										<span class="step_descr">
												Step 2<br />
												<small>Form Detil Barang</small>
										</span>
									</a>
								</li>
								<li>
									<a href="#step-3">
										<span class="step_no">3</span>
										<span class="step_descr">
												Step 3<br />
												<small>Finalisasi Data</small>
										</span>
									</a>
								</li>													
							</ul>
							<div id="step-1"> 
								<form class="form-horizontal form-label-left" id="formMaster" name="formMaster" method="POST" style="overflow: hidden;">
									<div class="col-md-6">
										<div class="form-group">
										<label class="control-label col-md-6" for="bpb_no">No.BPB 
										</label>
										<div class="col-md-6">
											<input type="text" id="bpb_no" name="bpb_no"  class="form-control" value="<?= $this->session->userdata('userid');?>" readonly>
										</div>
										</div>
										<div class="form-group">
										<label class="control-label col-md-6" for="a2">Supplier   
										</label>
										<div class="col-md-6" >
											<select name="a2" id="a2" class="form-control">
												<?= $listSupplier; ?>
											</select>
										</div>
										</div> 
										<div class="form-group">
										<label class="control-label col-md-6" for="a3">Diterima Di Cabang   
										</label>
										<div class="col-md-6" >
											<input type="text" class="form-control" name="a3" id="a3" value="<?= $this->session->userdata('branch'); ?>" readonly="true">
										</div>
										</div>
										<input type="hidden" id="temp_gudang">
										<div class="form-group">
											<label class="control-label col-md-6" for="a4">Gudang   
											</label>
										<div class="col-md-6" >
											<select name="a4" id="a4" class="form-control">
												<?= $listWarehouse; ?>	
											</select>
										</div>
										</div>
										<div class="form-group">
										<label class="control-label col-md-6" for="a5">Tanggal Terima 
										</label>
										<div class="col-md-6" >
											<div class='input-group date' id='tanggal'>
											<input type='text' class="form-control" name="a5" value="<?= date("d-m-Y"); ?>" />
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
										</div>
									</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3" for="a6">Total Jenis Barang 
											</label>
											<div class="col-md-6">
												<input type="text" id="a6" name="a6"  class="form-control" value="0" readonly="true">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a7">Total Qty Item 
											</label>
											<div class="col-md-6">
											<input type="text" id="a7" name="a7"  class="form-control" value="0" readonly="true">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a8">Catatan 
											</label>
											<div class="col-md-6">
												<textarea class="form-control" name="a8" id="a8"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a9">Tgl Input 
											</label>
											<div class="col-md-6">
											<input type="text" id="a9" name="a9"  class="form-control" value="<?= date('d-m-Y');?>" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a11">User Input 
											</label>
											<div class="col-md-6">
											<input type="text" id="a11" name="a11"  class="form-control" value="<?= $this->session->userdata('userid');?>" readonly>
											</div>
										</div>
										<div class="form-group"><label class="control-label col-md-3">&nbsp;</label>
									<div class="col-md-6">
										<button type="reset" class="btn btn-danger">Reset Form</button>
									</div>
									</div> 
									</div> 
								</form> 
							</div>
							<div id="step-2">
								<h2 class="StepTitle">Step 2 Content <small id="labelNota"></small></h2>
								<div class="ln-solid"></div>
								<form class="form-horizontal form-label-left" id="formDetail" method="post">
									<?php 
										$dataDetil = array(
											'aksiDetail' => array('name' => 'aksiDetail','type' => 'hidden'),
											'kodeDetail' => array('name'=>'kode','type' => 'hidden'),
											'nobpb'       => array('name'=>'nobpb','type' => 'hidden'),
											'kode_varian'=> array('name'=>'kode_varian', 'type'=>'hidden'),
											'b1'         => array('name'=>'b1','label' => 'Kode Item','type' => 'text','class' => 'form-control','col' => 'col-sm-3','input_search' => true),
											'item'       => array('name'=>'item','label' => 'Nama Item','type' => 'text','class' => 'form-control','col' => 'col-sm-3',"readonly" => true),
											'item_harga' => array('name'=>'item_harga','label' => 'Harga Beli','type' => 'text','class' => 'form-control','col' => 'col-sm-3'), 
											'b4'         => array('name'=>'b4','label' => 'Satuan','type' => 'option','class' => 'form-control','col' => 'col-sm-3','option' => ''), 
											'b5'         => array('name'=>'b5','label' => 'Qty','type' => 'number','class' => 'form-control','col' => 'col-sm-2','defaultValue' => '0'), 
											'total_harga' => array('name'=>'total_harga','label' => 'Nominal','type' => 'text','class' => 'form-control','col' => 'col-sm-3','readonly' => 'true'), 
											'b6'         => array('name'=>'b6','label' => 'Keterangan','type' => 'text','class' => 'form-control','col' => 'col-sm-4')
										);
										buat_form($dataDetil);  
									?>
								</form>
								<div class="ln_solid"></div>
								<div id="laporanContainer2"> 
								<?php 
									$kolomTableDetil = array('No','Kode Barang','Nama Barang','Satuan','Qty','Harga','Opsi');
									buat_table($kolomTableDetil,"tabel-detil");   
								?>
								</div>
								<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
										</button>
										<h4 class="modal-title" id="myModalLabel">Cari SKU</h4>
										</div>
										<div class="modal-body">
										<?php 
												$kolom3 = array("No.","Kategori","Kode Item","Nama Item","Opsi");
												buat_table($kolom3,"tabel-sku");   
											?>
										</div> 

									</div>
									</div>
								</div>	
							</div>
							<div id="step-3">
								<h2 class="StepTitle">Step 3 Content</h2>
								<p>
									Silahkan diteliti kembali barang-barang yang anda terima :
								</p>
								<div class="ln-solid"></div>
								<form class="form-horizontal form-label-left" id="formReview" name="formReview" style="overflow: hidden;">
									<div class="col-md-6">
										<div class="form-group">
										<label class="control-label col-md-6" for="bpb_no">No.BPB 
										</label>
										<div class="col-md-6">
											<input type="text" id="r1" name="r1"  class="form-control" readonly>
										</div>
										</div>
										<div class="form-group">
										<label class="control-label col-md-6" for="a2">Supplier   
										</label>
										<div class="col-md-6" >
											<input type="text" name="r2" id="r2" class="form-control" readonly>
										</div>
										</div> 
										<div class="form-group">
										<label class="control-label col-md-6" for="a3">Diterima Di Cabang   
										</label>
										<div class="col-md-6" >
										<input type="text" name="r3" id="r3" class="form-control" readonly>
										</div>
										</div>
										<input type="hidden" id="temp_gudang">
										<div class="form-group">
											<label class="control-label col-md-6" for="a4">Gudang   
											</label>
										<div class="col-md-6" >
											<input type="text" name="r4" id="r4" class="form-control" readonly>
										</div>
										</div>
										<div class="form-group">
										<label class="control-label col-md-6" for="a5">Tanggal Terima 
										</label>
										<div class="col-md-6" >
											<div class='input-group date' id='tanggal'>
											<input type='text' class="form-control" id="r5" name="r5" value="<?= date("d-m-Y"); ?>" readonly/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
										</div>
									</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3" for="a6">Total Jenis Barang 
											</label>
											<div class="col-md-6">
												<input type="text" id="r6" name="r6"  class="form-control" readonly="true">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a7">Total Qty Item 
											</label>
											<div class="col-md-6">
											<input type="text" id="r7" name="r7"  class="form-control" readonly="true">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a8">Catatan 
											</label>
											<div class="col-md-6">
												<textarea class="form-control" id="r8" name="a8" id="r8" readonly></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a9">Tgl Input 
											</label>
											<div class="col-md-6">
											<input type="text" id="r9" name="r9"  class="form-control" value="<?= date('d-m-Y');?>" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3" for="a11">User Input 
											</label>
											<div class="col-md-6">
											<input type="text" id="r10" name="r10"  class="form-control" value="" readonly>
											</div>
										</div>									 
									</div> 
								</form>
								<div class="ln-solid"></div>
								<?php 
									$kolomTableReview = array('No','Kode Barang','Nama Barang','Satuan','Qty','Harga');
									buat_table($kolomTableReview,"tabel-review");     
								?>
							</div>

						</div>
						<!-- End SmartWizard Content -->			
					</div>
                </div>
              </div> 
			  <!-- end form wizard -->
			  <!-- start form laporan -->	
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" id="panelReport">
                  <div class="x_title">
                    <h2>Data Penerimaan Barang</h2> 
                  	<ul class="nav navbar-right panel_toolbox">
                  		<li id="close_form" style="display: none"><a><i class="fa fa-close" onclick="tutup()"></i></a></li>
						  <li id="close_form"><a><i class="fa fa-plus" onclick="tambah('down')"></i></a></li>
                  	</ul>
                    <div class="clearfix"></div> 
                	</div>
					<div class="x_content">
						<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							Transaksi berhasil 
						</div>
						<div id="laporanContainer"> 
						<?php 
							$kolomTableLaporan = array('No','Gudang','Tanggal Terima','Supplier','Jenis','Qty','Nominal','User');
							buat_table($kolomTableLaporan,"tabel-laporan");   
						?>
						</div>					
					</div>
                </div>
              </div> <!-- end form laporan -->
            </div> 

			
				<script type="text/javascript">
				var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
				var table, table2, table3, table4;
				$(document).ready(function(){
					$('#wizardCustom').smartWizard({
						selected: 0,
						keyNavigation: false,
						labelNext:'Form Selanjutnya',
						labelPrevious: 'Form Sebelumnya',
						labelFinish: 'Selesai',
						hideButtonsOnDisabled: true,
						buttonOrder: ['prev','next','finish'],
						transitionEffect: 'slide',
						fixHeight: '330',
						onLeaveStep: function (obj,context) {
							if (context.fromStep == 2 && context.toStep == 1 ){
								$('#aksiDetail').val('update');
								$('#panelReport').show();
								return true;
							} else
							if (context.fromStep == 1){
								$('#formMaster').submit();
								datatableDetil();	
								datatableSKU();
								$('#panelReport').hide(); 							
								return true;
							} else 
							if (context.fromStep == 2){
								getReview();
								datatableReview();
								return true;
							} 
							return false;
						},
						onFinish: function(data){
							finalisasi();
							location.reload();
						} 
					});
					$('#wizardCustom').smartWizard({ selected: 1 });
					// load all table
					datatable();					
					
				}); 
				function datatable(){
            		table = $('#tabel-laporan').DataTable({
			        	'processing' : true, 	//ini untuk menampilkan processing
			        	'serverSide' : true, 	//ini untuk serversidenya
			        	'order'		 : [], 		//ini jika menginginkan diorder
						'deferRender': true,	//ini penting jika data 
						'searching'	 : true,
						'info'		 : false,
						'destroy'	 : true,
			        	'language'   : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/getTableData');?>",
			        		"type"	: 'POST'							
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	"columnDefs": [
							{ 
								"targets": [ 0 ], //first column / numbering column
								"orderable": false, //set not orderable
							},
						],   
			        }); 
            	}
				function datatableDetil(){
            		table2 = $('#tabel-detil').DataTable({
			        	'processing' : true, 	//ini untuk menampilkan processing
			        	'serverSide' : true, 	//ini untuk serversidenya
			        	'order'		 : [], 		//ini jika menginginkan diorder
						'deferRender': true,	//ini penting jika data 
						'searching'	 : true,
						'info'		 : false,
						'destroy'	 : true,
			        	'language'   : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/getTableDataDetil');?>",
			        		"type"	: 'POST',
							"data"	: function(data){
								data.f_bpbno = $('#nobpb').val();
							}							
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	"columnDefs": [
							{ 
								"targets": [ 0 ], //first column / numbering column
								"orderable": false, //set not orderable
							},
						],   
			        }); 
            	}
				function datatableSKU(){
            		table3 = $('#tabel-sku').DataTable({
			        	'processing' : true, 	//ini untuk menampilkan processing
			        	'serverSide' : true, 	//ini untuk serversidenya
			        	'order'		 : [], 		//ini jika menginginkan diorder
						'deferRender': true,	//ini penting jika data 
						'searching'	 : true,
						'info'		 : false,
						'destroy'	 : true,
			        	'language'   : {
			        		'searchPlaceholder': "Cari SKU"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/getTableDataSKU');?>",
			        		"type"	: 'POST'							
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	"columnDefs": [
							{ 
								"targets": [ 0 ], //first column / numbering column
								"orderable": false, //set not orderable
							},
						],   
			        }); 
            	}
				function datatableReview(){
            		table4 = $('#tabel-review').DataTable({
			        	'processing' : true, 	//ini untuk menampilkan processing
			        	'serverSide' : true, 	//ini untuk serversidenya
			        	'order'		 : [], 		//ini jika menginginkan diorder
						'deferRender': true,	//ini penting jika data 
						'searching'	 : false,
						'info'		 : false,
						'destroy'	 : true,
			        	'language'   : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/getTableDataReview');?>",
			        		"type"	: 'POST',
							"data"	: function(data){
								data.f_bpbno = $('#nobpb').val();
							}							
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	"columnDefs": [
							{ 
								"targets": [ 0 ], //first column / numbering column
								"orderable": false, //set not orderable
							},
						],   
			        }); 
            	}
				$(document).on('submit','#formMaster',function(e){
					e.preventDefault();
					$.ajax({
			            url: link+"/SimpanMst",
			            type: "POST",
						dataType: "JSON",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){  
							if (data.proses > 0) {
								table.ajax.reload();
								$('#aksiDetail').val('tambah');
								$('#labelNota').html('No-BPB : '+data.nobpb);
								$('#nobpb').val(data.nobpb);
								table2.ajax.reload();	// reload
							} else {
								$('#nobpb').val(); // empty
							}  	
							display_message(data.message);
			             }
			        });
			        return false;  
				});
				function display_message(isi){
					$('#alert_trans').slideDown('slow').fadeOut(5000);
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
				function pilih(stockcode){
            		$(".close").click();
            		getStock(stockcode);  
            	}
            	$(document).on('change','#b1',function(e){
            		sizeSatuan();
				});
				
				$(document).on('change','#b5', function(e){
					if( $('#item_harga').val() >= 1 ){
						$('#total_harga').val( $('#item_harga').val() * $('#b5').val() );
					}					
				});
				function sizeSatuan(){            
					$.get(link+"/getSatuan/"+$("#b1").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b4").html(data); 
		            });
				}
				function getStock(stockcode){ 
		            $.ajax({
				        type: 'GET',
				        dataType:'JSON',
				        url: link+"/getStock/"+stockcode,
				        success:function(responseText){
				        	$("#b1").val(responseText.fc_stock); 
				        	$("#item").val(responseText.fv_stock); 
				        	sizeSatuan(); 
				        }
				    });
				} 
//--------------- fungsi untuk form detil -----------------
				function hapusDetail(kode){
					if(confirm("Apakah anda Yakin? ["+kode+"]")){ 
						$.get(link+"/HapusDetail/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	display_message(data);
			            	table2.ajax.reload();
			            	hitungQty();
			            });
			            //--------------------------------
			        }
				}
				$(document).on('submit','#formDetail',function(e){
					e.preventDefault();
					$.ajax({
			            url: link+"/simpanDetail",
			            type: "POST",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){ 
							table2.ajax.reload();
							display_message(data);
							hitungQty();			             	
			             }
			        });
			        return false;  
				});
				function hitungQty(){ 
		            $.ajax({
				        type: 'GET',
				        dataType:'JSON',
				        url: link+"/total/"+$("#a1").val(),
				        success:function(data){
				        	$("#a6").val(data.total); 
				        }
				    });
				}
//----------- end form detil action ---------------------
				function tambah(cmd){
					if (cmd == 'up') {
						$('#wizardContainer').slideUp();
						$('#panelReport').slideDown();
					} else
					if (cmd == 'down'){
						$('#wizardContainer').slideDown();
					}
				}
				function batalkan(kode){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/batalkan/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	$("#step1").click();
			            	display_message(data);
			            	tutup();
			            	datatable();
			            });
			            //--------------------------------
			        }
				}
				function getReview(){
					$.ajax({
				        type: 'GET',
				        dataType:'JSON',
				        url: link+"/getReview/"+$("#nobpb").val(),
				        success:function(data){
				        	$('#r1').val(data.fc_nobpb);
							$('#r2').val(data.fv_supplier);
							$('#r3').val(data.fc_branch);
							$('#r4').val(data.fv_wh);
							$('#r5').val(data.fd_bpb);
							$('#r6').val(data.fn_jenis);
							$('#r7').val(data.fn_qty);
							$('#r8').val(data.fv_note);
							$('#r9').val(data.fd_tglinput);
							$('#r10').val(data.fc_userid);
				        }
				    });
				}
				
				function finalisasi(){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/finalisasi/"+$("#nobpb").val(), $(this).serialize())
							.done(function(data) { 
								if(data.includes("Berhasil") == true){
									tutup();
									table.ajax.reload();
									display_message(data);
								}else{
									display_message(data);	
								}
						}); 
					}
				}   
				</script>   

				<script src="<?= site_url()?>vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script> 