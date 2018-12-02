            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Penerimaan Barang</h2>
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
                    <form class="form-horizontal form-label-left" id="formMaster" style="display: none;" method="post">
						 <?php 
                     	$data = array(
                     		'aksi' => array('name' => 'aksi','type' => 'hidden'),
                     		'wh' => array('name'=>'wh','type' => 'hidden'),
                     		'a1' => array('name'=>'a1','label' => 'No.BPB','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly' => 'true','defaultValue' => $userid),
                     		'a2' => array('name'=>'a2','label' => 'Tgl Terima','type' => 'date','class' => 'form-control','col' => 'col-sm-2','defaultValue' => date('Y-m-d')),
                     		'a3' => array('name'=>'a3','label' => 'Supplier','type' => 'option','class' => 'form-control','option' => getSupplier(),'col' => 'col-sm-4'),
                     		'a4' => array('name'=>'a4','label' => 'Cabang','type' => 'text','class' => 'form-control','col' => 'col-sm-4', 'defaultValue'=> $branch, 'readonly'=>'true'),
                     		'a5' => array('name'=>'a5','label' => 'Gudang','type' => 'option','class' => 'form-control','option' => getWareHouse($branch,1),'col' => 'col-sm-4'),
                     		'a7' => array('name'=>'a7','label' => 'Total item','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly' => 'true','defaultValue'=>'0'),
                     		'a8' => array('name'=>'a8','label' => 'Catatan','type' => 'text','class' => 'form-control','col' => 'col-sm-6'),
                     		'a9' => array('name'=>'a9','label' => 'Userid','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly'=>'true','defaultValue'=>$userid)
                     	);						 
						 buat_form($data); 	 
                     	?>
						<div class="ln_solid"></div>
                    </form>					
                    <div id="detail" style="display: none;">
                    	<form class="form-horizontal form-label-left" id="formDetail" method="post">
	                     	<?php 
		                     	$dataDetil = array(
									'aksiDetail' => array('name' => 'aksiDetail','type' => 'hidden'),
									'kodeDetail' => array('name'=>'kode','type' => 'hidden'),
									'nobpb'       => array('name'=>'nobpb','type' => 'hidden'),
									'kode_varian'=> array('name'=>'kode_varian', 'type'=>'hidden'),
									'b1'         => array('name'=>'b1','label' => 'Kode Item','type' => 'text','class' => 'form-control','col' => 'col-sm-3','input_search' => true),
									'item'       => array('name'=>'item','label' => 'Nama Item','type' => 'text','class' => 'form-control','col' => 'col-sm-3',"readonly" => true),
									'b2'         => array('name'=>'b2','label' => 'Ukuran','type' => 'option','class' => 'form-control','col' => 'col-sm-3','option' => ''), 
									'b3'         => array('name'=>'b3','label' => 'Warna','type' => 'option','class' => 'form-control','col' => 'col-sm-3','option' => ''),
									'item_harga' => array('name'=>'item_harga','label' => 'Harga Beli','type' => 'text','class' => 'form-control','col' => 'col-sm-3','readonly' => 'true'), 
									'b4'         => array('name'=>'b4','label' => 'Satuan','type' => 'option','class' => 'form-control','col' => 'col-sm-3','option' => ''), 
									'b5'         => array('name'=>'b5','label' => 'Qty','type' => 'number','class' => 'form-control','col' => 'col-sm-2','defaultValue' => '0'), 
									'total_harga' => array('name'=>'total_harga','label' => 'Nominal','type' => 'text','class' => 'form-control','col' => 'col-sm-3','readonly' => 'true'), 
									'b6'         => array('name'=>'b6','label' => 'Keterangan','type' => 'text','class' => 'form-control','col' => 'col-sm-4')
		                     	);
		                     	buat_form($dataDetil);  
	                     	?>
                    	</form>
                    	<?php 
							$kolom = array("No.","Kode Item","Item","Ukuran|Warna","Satuan","Qty","Harga Beli","Opsi");
							buat_table($kolom,"datatable2");   
						?>
                    </div> 
					<div id="laporan"> 
						<?php 
							$kolom2 = array("No.","NO BPB","Kode Supplier","Gudang","Jenis","Jumlah","Total","Status","Opsi");
							buat_table($kolom2,"datatable");   
						?>
					</div>

                  </div>
                </div>
              </div> 
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
							$kolom3 = array("No.","Kategori","Kode Item","Item","Opsi");
							buat_table($kolom3,"datatable3");   
						?>
                    </div> 

                  </div>
                </div>
              </div>
            <script type="text/javascript">
            	var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
            	var table,table2;
            	$(document).ready(function(){
            		datatable();
            	});
// --------------------------- report data --------------------------------------            	
            	function datatable(){
            		table = $('#datatable').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'language'  : {
			        		'searchPlaceholder': "Cari No BPB"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data');?>",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
							{'data' : 'fc_nobpb'}, 
							{'data' : 'fc_kdsupplier'},
							{'data' : 'fc_wh'},
							{'data' : 'fn_jenis'},
							{'data' : 'fn_qty'},			        		 
							{'data' : 'fm_total'},
							{'data' : 'fc_status'}
			        		<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
	                       		return "<?php if($delete == '1'){?><button class='btn btn-danger' onclick=hapus('"+row['fc_nobpb']+"')><i class='fa fa-close'></i></button><?php } ?>&nbsp;<?php if($delete =='1'){ ?><button class='btn btn-info' onclick=edit('"+row['fc_warna']+"')><i class='fa fa-pencil'></i></button><?php } ?>";
	                    		},width:130
                			} <?php  }else{ ?>
                				,{'mRender': function ( data, type, row ) {
	                       		return "Akses ditutup";
	                    		},width:130
                			}	
                			<?php } ?>
			        	]  
			        }); 
            	}
            	function reload_table(){
			    	table.ajax.reload(null,false);
			    }
// --------------------------- end report data --------------------------------------			    
// --------------------------- untuk master data --------------------------------------
				function tambah(){					
					$('#laporan').slideUp('slow');
					$('#formMaster').slideDown('slow');
					$('#close_form').fadeIn('slow');
					$('#add_form').fadeOut('slow');
					document.getElementById('formMaster').reset();
					$('#aksi').val('tambah');
					ganti_button();					
					disableForm(["a2","a3","a5","a8","btn_reset","btn_dtl","btn_simpan"],false);
					checkMst('<?= $this->session->userdata("branch");?>','<?= $this->session->userdata("userid");?>'); 
				}
				function tutup(){
					$('#formMaster').slideUp('slow');
					$('#laporan').slideDown('slow');
					$('#close_form').fadeOut('slow');
					$('#add_form').fadeIn('slow');
					$('#aksi').val('');
					reload_table();
				}
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
				function checkMst(branch,nobpb){ 
					disableForm(["btn_reset","btn_dtl","btn_simpan"],true);
					$.ajax({
				        type: 'GET',
				        dataType:'JSON',
				        url: link+"/EditMst/"+branch+"/"+nobpb,
				        success:function(responseText){ 
				        	if (responseText != null) {
								$("#a2").val(responseText.fd_bpb);
				        		$("#a3").val(responseText.fc_kdsupplier);
				           		$("#a4").val(responseText.fc_branch);
								$("#a5").val(responseText.fc_wh);
				           		$("#wh").val(responseText.fc_wh);
				           		//$("select#a4").change(); 
				           		$("#a8").val(responseText.fv_note);
				           		hitungQty();
				        	}
				        	disableForm(["btn_reset","btn_dtl"],false); 
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
				$(document).on('submit','#formMaster',function(e){
					e.preventDefault();
					$.ajax({
			            url: link+"/SimpanMst",
			            type: "POST",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){ 
			            	$('#close_form').fadeOut('slow');
			             	disableForm(["a2","a3","a4","a5","a8","btn_reset","btn_dtl","btn_simpan"],true);
			             	tambahDetail();
			             }
			        });
			        return false;  
				});
				
				function ganti_button(){
					document.getElementById("button_action").innerHTML = '<div class="col-md-9 col-sm-9 col-xs-12">'+
                          '<button type="button" id="btn_reset" onclick="tutup()" class="btn btn-danger">Batal</button> '+
                          '<button type="submit" id="btn_dtl" class="btn btn-warning">Tambah Item</button>'+
                          '<button type="button" id="btn_simpan" onclick="finalisasi()" class="btn btn-success">Finalisasi Data</button>'+
                        '</div>';
                    disableForm(["a3","a4","a5","a6","a8"],false);
                    disableForm(["btn_simpan"],true);
				}
				function finalisasi(){
					if(confirm("Anda akan melakukan finalisasi data.\n Data tidak dapat diubah kembali.\n Anda yakin melanjutkan.?")){ 
						$.get(link+"/Finalisasi", $(this).serialize())
			            .done(function(data) { 
							alert(data);
							tutup();
			            });
			            //--------------------------------
			        }
				}
// --------------------------- end master data --------------------------------------
// ------------------------- untuk detail data ----------------------------------------
				function ganti_buttonDetail(){
					$('#detail #button_action').html("<div class='col-md-9 col-sm-9 col-xs-12'>"+ 
					"<button type='button' id='btn_dtlMst' class='btn btn-warning' onclick='btnMaster()'>Batal</button>"+
                        "<button type='submit' id='btn_dtlsimpan' class='btn btn-success'>Simpan Item Detil</button>"+
                        "</div>");
				}
				function btnMaster(){
					$('#detail').slideUp("slow");
					disableForm(["b1","b2","b3","b4","b5"],true); 
					disableForm(["btn_dtlsimpan","btn_dtlMst"],true); 
					ganti_button();
					disableForm(["btn_simpan"],false);					
				}
				function tambahDetail(){
					$('#detail').slideDown("slow");
					document.getElementById("detail").focus();
					datatable_detail();
					ganti_buttonDetail();
					document.getElementById("formDetail").reset();
					$('#nobpb').val($("#a1").val());
					$('#aksiDetail').val("tambah");
					hitungQty();
					disableForm(["b1","b2","b3","b4","b5"],false); 
				}
				function datatable_detail(){
            		table2 = $('#datatable2').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'destroy'   : true,
			        	'language'  : {
			        		'searchPlaceholder': "Cari SKU"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/dataBPBDetail');?>/"+$('#a1').val()+"",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		{'data' : 'fc_stock'},   
			        		{'data' : 'fv_stock'},   
			        		{'data' : 'variant'},   
			        		{'data' : 'fv_satuan'},   
			        		{'data' : 'fn_qty'},  
			        		{'data' : 'price'}  
			        		<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
	                       		return "<?php if($delete == '1'){?><button class='btn btn-danger' onclick=hapusDetail('"+row['fc_id']+"')><i class='fa fa-close'></i></button><?php } ?>";
	                    		},width:130
                			} <?php  }else{ ?>
                				,{'mRender': function ( data, type, row ) {
	                       		return "Akses ditutup";
	                    		},width:130
                			}	
                			<?php } ?>
			        	]  
			        }); 
            	}
            	function hapusDetail(kode){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/HapusDetail/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	display_message(data);
			            	datatable_detail();
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
			            	tambahDetail(); 
			             	datatable_detail();
			             	hitungQty();
			             }
			        });
			        return false;  
				});
				function datatable_SKU(){
            		table2 = $('#datatable3').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'destroy'   : true,
			        	'language'  : {
			        		'searchPlaceholder': "Cari SKU"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/dataItem');?>",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		{'data' : 'kategori'},   
			        		{'data' : 'fc_stock'},   
			        		{'data' : 'fv_stock'}  
			        		,{'mRender': function ( data, type, row ) {
	                       		return "<button class='btn btn-info' onclick=pilih('"+row['fc_stock']+"')>Pilih</button>";
	                    		},width:130
                			}
			        	]  
			        }); 
            	}
            	$(document).on('click','#btn_cari',function(e){
            		datatable_SKU();
            	});
            	function pilih(stockcode){
            		$(".close").click();
            		getStock(stockcode);  
            	}
            	$(document).on('change','#b1',function(e){
            		sizeSatuan();
				});
				$(document).on('change','#b2', function(e){
					$.get(link+"/getWarna/"+$("#b1").val()+"/"+$("#b2 option:selected").text(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b3").html(data); 
					});
				});
				$(document).on('change','#b3', function(e){	
					$.ajax({
						type: 'GET',
						url: link+"/getHarga/"+$("#b3").val(), 
						data: $(this).serialize(),
						dataType: "JSON",
						success:function(data) { 													
							$("#item_harga").val(data.harga); 
							$("#kode_varian").val(data.varian);
						}						
					});	
				});
				$(document).on('change','#b5', function(e){
					if( $('#item_harga').val() >= 1 ){
						$('#total_harga').val( $('#item_harga').val() * $('#b5').val() );
					}					
				});
				function sizeSatuan(){
					$.get(link+"/getSize/"+$("#b1").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b2").html(data); 
		            });		            
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
// ------------------------- end detail data ----------------------------------------				
				function disableForm(data,status){
					$(document).ready(function(){
						for (var i = 0; i < data.length; i++) {
							//document.getElementById(data[i]).disabled = status;
							$("#"+data[i]).prop("disabled", status);
						}	
					});
				} 
				function hitungQty(){ 
		            $.ajax({
				        type: 'GET',
				        dataType:'JSON',
				        url: link+"/total/"+$("#a1").val(),
				        success:function(responseText){
				        	$("#a7").val(responseText.total); 
				        }
				    });
				}
            </script>   