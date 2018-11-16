            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Master Warna</h2>
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
                     		'a1' => array('name'=>'a1','label' => 'No.PO','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly' => 'true','defaultValue' => $userid),
                     		'a2' => array('name'=>'a2','label' => 'Tgl PO','type' => 'date','class' => 'form-control','col' => 'col-sm-2','readonly' => 'true','defaultValue' => date('Y-m-d')),
                     		'a3' => array('name'=>'a3','label' => 'Supplier','type' => 'option','class' => 'form-control','option' => getSupplier(),'col' => 'col-sm-4'),
                     		'a4' => array('name'=>'a4','label' => 'Cabang','type' => 'option','class' => 'form-control','option' => getBranch(),'col' => 'col-sm-4'),
                     		'a5' => array('name'=>'a5','label' => 'Gudang','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-4'),
                     		'a6' => array('name'=>'a6','label' => 'Perkiraan Datang','type' => 'date','class' => 'form-control','col' => 'col-sm-2'),
                     		'a7' => array('name'=>'a7','label' => 'Total item','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly' => 'true','defaultValue'=>'0'),
                     		'a8' => array('name'=>'a8','label' => 'Catatan','type' => 'text','class' => 'form-control','col' => 'col-sm-6'),
                     		'a9' => array('name'=>'a9','label' => 'Userid','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly'=>'true','defaultValue'=>$userid)
                     	);
                     	buat_form($data);  
                     	?>
                    </form>
                    <div id="detail" style="display: none;">
                    	<form class="form-horizontal form-label-left" id="formDetail" method="post">
	                     	<?php 
		                     	$dataDetil = array(
									'aksiDetail' => array('name' => 'aksiDetail','type' => 'hidden'),
									'kodeDetail' => array('name'=>'kode','type' => 'hidden'),
									'nopo'       => array('name'=>'nopo','type' => 'hidden'),
									'b1'         => array('name'=>'b1','label' => 'Kode Item','type' => 'text','class' => 'form-control','col' => 'col-sm-3','input_search' => true),
									'item'       => array('name'=>'item','label' => 'Nama Item','type' => 'text','class' => 'form-control','col' => 'col-sm-3',"readonly" => true),
									'b2'         => array('name'=>'b2','label' => 'Size','type' => 'option','class' => 'form-control','col' => 'col-sm-3','option' => ''), 
									'b3'         => array('name'=>'b3','label' => 'Satuan','type' => 'option','class' => 'form-control','col' => 'col-sm-3','option' => ''), 
									'b4'         => array('name'=>'b4','label' => 'Qty','type' => 'number','class' => 'form-control','col' => 'col-sm-2','defaultValue' => '0'), 
									'b5'         => array('name'=>'b5','label' => 'Keterangan','type' => 'text','class' => 'form-control','col' => 'col-sm-4')
		                     	);
		                     	buat_form($dataDetil);  
	                     	?>
                    	</form>
                    	<?php 
							$kolom = array("No.","Kode Item","Item","Size","Satuan","Qty","Qty Konversi","Opsi");
							buat_table($kolom,"datatable2");   
						?>
                    </div> 
					<div id="laporan"> 
						<?php 
							$kolom2 = array("No.","Kode Item","Item","Size","Satuan","Qty","Opsi");
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
            		//datatable();
            	});
// --------------------------- report data --------------------------------------            	
            	function datatable(){
            		table = $('#datatable').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'language'  : {
			        		'searchPlaceholder': "Cari No PO"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data');?>",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		{'data' : 'fv_warna'},  
			        		{'mRender': function ( data, type, row ) {
	                       		return "<div style='width: 20px;height: 20px;background:"+row['fc_hexacode']+";border-radius: 50%;float:left;margin-right:5px'></div>"+row['fc_hexacode'];
	                    		},width:130
                			},  
			        		{'mRender': function ( data, type, row ) {
	                       		if (row['fc_status'] == '1') {
	                       			return "Aktif";
	                       		}else{
	                       			return "Non Aktif";
	                       		}
	                    		},width:130
                			}
			        		<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
	                       		return "<?php if($update == '1'){?><button class='btn btn-danger' onclick=hapus('"+row['fc_warna']+"')><i class='fa fa-close'></i></button><?php } ?>&nbsp;<?php if($delete =='1'){ ?><button class='btn btn-info' onclick=edit('"+row['fc_warna']+"')><i class='fa fa-pencil'></i></button><?php } ?>";
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
				function checkMst(branch,nopo){ 
					disableForm(["btn_reset","btn_dtl","btn_simpan"],true);
					$.ajax({
				        type: 'GET',
				        dataType:'JSON',
				        url: link+"/EditMst/"+branch+"/"+nopo,
				        success:function(responseText){ 
				        	if (responseText != null) {
				        		$("#a3").val(responseText.fc_kdsupplier);
				           		$("#a4").val(responseText.fc_branch_to);
				           		$("#wh").val(responseText.fc_wh);
				           		$("select#a4").change(); 
				           		$("#a6").val(responseText.fd_estdatang);
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
			             	disableForm(["a3","a4","a5","a6","a8","btn_reset","btn_dtl","btn_simpan"],true);
			             	tambahDetail();
			             }
			        });
			        return false;  
				});
				$(document).on('change','#a4',function(e){
					$.get(link+"/getWareHouse/"+$("#a4").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#a5").html(data);
		            	$("#a5").val($("#wh").val());
		            });
				}); 
				function ganti_button(){
					document.getElementById("button_action").innerHTML = '<div class="col-md-9 col-sm-9 col-xs-12">'+
                          '<button type="button" id="btn_reset" onclick="cancel()" class="btn btn-danger">Batal</button> '+
                          '<button type="submit" id="btn_dtl" class="btn btn-success">detail</button>'+
                          '<button type="button" id="btn_simpan" onclick="finalisasi()" class="btn btn-info">Simpan</button>'+
                        '</div>';
                    disableForm(["a3","a4","a5","a6","a8"],false);
                    disableForm(["btn_simpan"],true);
				}
				function finalisasi(){
					if(confirm("Anda akan melakukan finalisasi data.\n Data tidak dapat diubah kembali.\n Anda yakin melanjutkan.?")){ 
						$.get(link+"/Finalisasi", $(this).serialize())
			            .done(function(data) { 
			            	alert(data);
			            });
			            //--------------------------------
			        }
				}
// --------------------------- end master data --------------------------------------
// ------------------------- untuk detail data ----------------------------------------
				function ganti_buttonDetail(){
					$('#detail #button_action').html("<div class='col-md-9 col-sm-9 col-xs-12'>"+ 
                          "<button type='submit' id='btn_dtlsimpan' class='btn btn-success'>Simpan</button>"+
                          "<button type='button' id='btn_dtlMst' class='btn btn-info' onclick='btnMaster()'>Master</button>"+
                        "</div>");
				}
				function btnMaster(){
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
					$('#nopo').val($("#a1").val());
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
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/dataPODetail');?>/"+$('#a1').val()+"",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		{'data' : 'fc_stock'},   
			        		{'data' : 'fv_stock'},   
			        		{'data' : 'fv_size'},   
			        		{'data' : 'fv_satuan'},   
			        		{'data' : 'fn_qty'},  
			        		{'data' : 'fn_konversi'}  
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
				function sizeSatuan(){
					$.get(link+"/getSize/"+$("#b1").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b2").html(data); 
		            });
		            $.get(link+"/getSatuan/"+$("#b1").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b3").html(data); 
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
					for (var i = 0; i < data.length; i++) {
						document.getElementById(data[i]).disabled = status;
					}
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