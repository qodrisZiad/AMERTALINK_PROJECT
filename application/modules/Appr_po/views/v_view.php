            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Approval PO</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                      <li><a><i class=""></i></a></li> 
                      <li id="close_form" style="display: none"><a><i class="fa fa-close" onclick="tutup()"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
                    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    	Transaksi berhasil 
                  	</div>
                  	<div id="formDetail" style="display: none;">
                  		<form class="form-horizontal form-label-left" id="formMaster" name="formMaster" method="POST" style="overflow: hidden;">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a1">No.PO 
                                  </label>
                                  <div class="col-md-6">
                                    <input type="text" id="a1" name="a1"  class="form-control" value="admin" readonly>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a2">Tgl.PO 
                                  </label>
                                  <div class="col-md-6" >
                                    <div class='input-group date'>
                                      <input type='text' class="form-control" name="a2" id="a2" readonly />
                                      <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                   </div>
                                 </div>
                                </div>
                                <div class="form-group">
                                <label class="control-label col-md-6" for="a3">Supplier 
                                </label>
                                <div class="col-md-6" >
                                  <div class='input-group date'>
                                      <input type='text' class="form-control" id="a3" name="a3" readonly/> 
                                   </div>
                                </div>
                                </div> 
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a4">Untuk Cabang 
                                  </label>
                                  <div class="col-md-6" > 
	                                  <div class='input-group date'>
	                                      <input type='text' class="form-control" id="a4" name="a4" readonly/> 
	                                   </div> 
                                  </div>
                                </div>
                                <input type="hidden" id="temp_gudang">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a5">Gudang 
                                  </label>
                                 	<div class="col-md-6" >
                                  		<div class='input-group date'>
                                      	<input type='text' class="form-control" id="a5" name="a5" readonly/> 
                                   		</div>
                                	</div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a6">Perkiraan Datang 
                                  </label>
                                  <div class="col-md-6" >
                                    <div class='input-group date'>
                                      <input type='text' class="form-control" name="a6" id="a6" readonly/>
                                      <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                   </div>
                                 </div>
                               </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a7">Qty Item 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a7" name="a7"  class="form-control" value="0" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a8">Total 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a8" name="a8"  class="form-control" value="0" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a9">Catatan 
                                </label>
                                <div class="col-md-6">
                                  <textarea class="form-control" name="a9" id="a9" readonly></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a10">Tgl Input 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a10" name="a10"  class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a11">User Input 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a11" name="a11"  class="form-control" readonly>
                                </div>
                              </div> 
                              <div class="form-group"><label class="control-label col-md-3" for="a1"> 
                              </label>
                              <div class="col-md-6">
                                <button type="button" class="btn btn-success" onclick="Approve()">Approve</button>
                                <button type="button" class="btn btn-danger" onclick="batalkan()">Batalkan PO</button>
                              </div>
                            	</div> 
                            	</div>  
                        </form> 
	                    <input type="hidden" name="nota" id="nota">
                        <form class="form-horizontal form-label-left" id="actionDetail" name="actionDetail" method="POST" style="overflow: hidden;display: none;">
	                            <div class="col-xs-6">
	                                <div class="form-group">
	                                  <label class="control-label col-md-6" for="d1">SKU 
	                                  </label>
	                                  <div class="col-md-6" >
	                                    <div class='input-group'>
	                                    	<input type="hidden" name="kode" id="kode">
	                                      <input type='text' class="form-control" id="d1" name="d1" onchange="getSku($('#d1').val())" readonly /> 
	                                   </div>
	                                 </div> 
	                                </div>
	                                <div class="form-group">
	                                  <label class="control-label col-md-6" for="d2">Nama Stock
	                                  </label>
	                                  <div class="col-md-6">
	                                    <input type="text" id="d2"  class="form-control" readonly>
	                                  </div>
	                                </div>
	                                <div class="form-group">
	                                  <label class="control-label col-md-6" for="d3">Harga Terakhir(@default)
	                                  </label>
	                                  <div class="col-md-6">
	                                    <input type="text" id="d3" name="d3" class="form-control" readonly>
	                                  </div>
	                                </div>
	                                <div class="form-group"> 
	                                  <label class="control-label col-md-6" for="d4">Variant 
	                                  </label>
	                                  <div class="col-md-6" >
	                                  	<input type="hidden" id="dum_variant">
	                                    <select id="d4" name="d4" class="form-control"> 
	                                    </select>
	                                  </div>
	                                </div> 
	                                <div class="form-group"> 
	                                  <label class="control-label col-md-6" for="d5">Satuan 
	                                  </label>
	                                  <div class="col-md-6" > 
	                                  	<input type="hidden" id="dum_satuan">
	                                    <select id="d5" name="d5" class="form-control" onchange="isi_Uom()"> 
	                                    </select>
	                                  </div>
	                              </div>
	                            </div>
	                            <div class="col-xs-6"> 
	                              <div class="form-group">
	                                <label class="control-label col-md-3" for="d6">Konversi UOM
	                                </label>
	                                <div class="col-md-6">
	                                  <input type="text" id="tmp_uom" class="form-control" readonly>
	                                </div>
	                              </div>
	                              <div class="form-group">
	                                <label class="control-label col-md-3" for="d6">Qty
	                                </label>
	                                <div class="col-md-6">
	                                  <input type="text" id="d6" name="d6" class="form-control" onchange="hitung()">
	                                </div>
	                              </div>
	                              <div class="form-group">
	                                  <label class="control-label col-md-3" for="d7">SubTotal
	                                  </label>
	                                  <div class="col-md-6">
	                                    <input type="text" id="d7" name="d7" class="form-control" readonly>
	                                  </div>
	                                </div>
	                              <div class="form-group">
	                                  <label class="control-label col-md-3" for="d8">Catatan 
	                                  </label>
	                                  <div class="col-md-6" >
	                                    <textarea class="form-control" id="d8" name="d8"></textarea>
	                                  </div>
	                              </div>
	                              <div class="form-group">
	                                  <label class="control-label col-md-3"> 
	                                  </label>
	                                  <div class="col-md-6">
	                                    <input type="submit" class="btn btn-success" value="Simpan" />
	                                    <button type="button" class="btn btn-danger" onclick="resetDetail()">Reset</button>
	                                  </div>
	                              </div> 
	                            </div>
	                   	</form>
                          <?php 
                            $kolom_detail = array("No.","SKU","Nama Item","Variant","Satuan","Harga","QTY","Qty Uom","Konversi","Total","Opsi");
                            buat_table($kolom_detail,"datatable2");   
                          ?> 
                  	</div> 
					<div id="laporan"> 
						<?php 
							$kolom = array("No.","Aksi","NO.PO","Tgl.PO","Supplier","Alamat","Telp","Perkiraan Kirim","Untuk Cabang","Warhouse","Qty","Total","Catatan","User Id");
							buat_table($kolom,"datatable");   
						?>
					</div>

                  </div>
                </div>
              </div> 
            </div> 

            <script type="text/javascript">
            	var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
            	var table;
            	$(document).ready(function(){
            		datatable();
            	});
            	function datatable(){
            		table = $('#datatable').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'destroy'	: true,
			        	'language'  : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data');?>",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		<?php if($delete=='1' || $update =='1'){ ?>
			        			{'mRender': function ( data, type, row ) {
			        				return "<button type='button' class='btn btn-success' onclick=detail('"+row['fc_nopo']+"')>Detail</button>"; 
                					}
                				}	
                			<?php } ?>, 
			        		{'data' : 'fc_nopo'},
			        		{'data' : 'fd_po'},
			        		{'data' : 'fv_supplier'}, 
			        		{'data' : 'fv_addr'}, 
			        		{'mRender': function ( data, type, row ) {
		                       		return row['fc_telp']+" / "+row['fc_telp2'];
		                    		},width:130
                			}, 
                			{'data' : 'fd_estdatang'},
                			{'data' : 'untuk_cabang'},
                			{'data' : 'warehouse'},
                			{'data' : 'fn_qty'}, 
                			{'data' : 'total'}, 
                			{'data' : 'fv_note'},  
                			{'data' : 'fc_userid'}  
			        	]   
			        }); 
            	}
            	function reload_table(){
			    	table.ajax.reload(null,false);
			    }
				function tambah(){
					$('#laporan').slideUp('slow');
					$('#formDetail').slideDown('slow');
					$('#close_form').fadeIn('slow'); 
				}
				function tutup(){
					$('#formDetail').slideUp('slow');
					$('#laporan').slideDown('slow');
					$('#close_form').fadeOut('slow'); 
					datatable();
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
			            url: link+"/EditDtl/"+kode,
			            success:function(responseText){ 
			            	$("#formMaster").slideUp("slow");       
			            	$("#actionDetail").slideDown("slow");
			            	getSku(responseText.fc_stock); 
			            	$('#dum_variant').val(responseText.fc_variant);
			            	$('#dum_satuan').val(responseText.fc_satuan+"#"+responseText.fn_uom);
			            	$("#tmp_uom").val(responseText.fn_uom); 
			            	$("#d6").val(responseText.fn_qty);  
			            	$("#d8").val(responseText.fv_ket); 
			            	$("#d6").blur();  
			            	$("#kode").val(responseText.fc_id); 
			            }
			        });
				}
				function detail(kode){ 
					$.ajax({
			            type: 'GET',
			            dataType:'JSON',
			            url: link+"/Edit/"+kode,
			            success:function(responseText){ 
			            	tambah();           
			            	$("#actionDetail").slideUp('slow');
		       				$("#formMaster").slideDown('slow');
			            	$("#a1").val(responseText.fc_nopo);           
			            	$("#nota").val(responseText.fc_nopo);           
			            	$("#a2").val(responseText.fd_po);           
			            	$("#a3").val(responseText.fv_supplier);           
			            	$("#a4").val(responseText.untuk_cabang);           
			            	$("#a5").val(responseText.warehouse);           
			            	$("#a6").val(responseText.fd_estdatang);           
			            	$("#a7").val(responseText.fn_qty);           
			            	$("#a8").val(responseText.total);           
			            	$("#a9").val(responseText.fv_note);           
			            	$("#a10").val(responseText.fd_input);           
			            	$("#a11").val(responseText.fc_userid);  
			            	datatable2(kode); 
			            	datatable3();        
			            }
			        });
				}
				function hapusDetail(nopo,kode){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/Hapus/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	display_message(data);
			            	detail(nopo);
			            });
			            //--------------------------------
			        }
				}
				function Approve(){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/Approve/"+$("#a1").val(), $(this).serialize())
			            .done(function(data) { 
			            	tutup();
			            });
			            //--------------------------------
			        }
				}
				function batalkan(){
					if(confirm("Apakah anda Yakin ingin membatalkan?")){ 
						$.get(link+"/Cancel/"+$("#a1").val(), $(this).serialize())
			            .done(function(data) { 
			            	tutup();
			            });
			            //--------------------------------
			        }
				}
				$(document).on('submit','#actionDetail',function(e){
					e.preventDefault();
					$.ajax({
			            url: link+"/simpanDtl",
			            type: "POST",
						dataType: "JSON",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(responseText){ 
			            	resetDetail();
			            	alert(responseText);      
			            }           
			        });
			        return false;  
				});
				 
				function datatable2(kode){
	                table = $('#datatable2').DataTable({
		                'processing': true, //ini untuk menampilkan processing
		                'serverSide': true, //iini untuk serversidenya
		                'deferRender' : true,
		                'destroy' :true,
		                'order'   : [], //ini jika menginginkan diorder
		                'language'  : {
		                  'searchPlaceholder': "Cari"
		                },
		                'ajax':{
		                  'url' : "<?php echo site_url($this->uri->segment(1).'/dataDetail/');?>"+kode,
		                  "dataType": "json",
		                  'type'  : 'POST' 
		                },//pasangkan hasil dari ajax ke datatablesnya
		                'columns' :[
			                  {'data' : 'no',width:20}, 
			                  {'data' : 'fc_stock'},
			                  {'data' : 'fv_stock'},
			                  {'data' : 'variant'}, 
			                  {'data' : 'fv_satuan'}, 
			                  {'data' : 'price'}, 
			                  {'data' : 'fn_qty'}, 
			                  {'data' : 'fn_uom'}, 
			                  {'data' : 'konversi'}, 
			                  {'data' : 'total'}, 
			                  {'mRender': function ( data, type, row ) {
			                        return "<button type='button' class='btn btn-success' onclick=edit('"+row['fc_id']+"')>Edit</button><button type='button' class='btn btn-danger' onclick=hapusDetail('"+row['fc_nopo']+"','"+row['fc_id']+"')>Hapus</button>";
			                      },width:130
			                  }
	                	]  
			        }); 
			    } 
			    function datatable3(){
	                table = $('#datatable3').DataTable({
		                'processing': true, //ini untuk menampilkan processing
		                'serverSide': true, //iini untuk serversidenya
		                'deferRender' : true,
		                'destroy' :true,
		                'order'   : [], //ini jika menginginkan diorder
		                'language'  : {
		                  'searchPlaceholder': "Cari"
		                },
		                'ajax':{
		                  'url' : "<?php echo site_url($this->uri->segment(1).'/dataItem');?>",
		                  "dataType": "json",
		                  'type'  : 'POST' 
		                },//pasangkan hasil dari ajax ke datatablesnya
		                'columns' :[
		                  {'data' : 'no',width:20}, 
		                  {'data' : 'kategori'},
		                  {'data' : 'fc_stock'},
		                  {'data' : 'fv_stock'}, 
		                  {'data' : 'fn_onhand'}, 
		                  {'mRender': function ( data, type, row ) {
		                        return "<button type='button' class='btn btn-success' onclick=pilih('"+row['fc_stock']+"')>Pilih</button>";
		                      },width:130
		                  }
		                ]  
		        	}); 
	      		}
		      	function pilih(kode){
			        $('.close').click();
			        getSku(kode);
			    }
			    function getVariant(sku){
			        $('.StepTitle').fadeIn('fast');
			        $.get(link+"/getVariant/"+sku, $(this).serialize())
			          .done(function(data) { 
			            $('.StepTitle').fadeOut('fast');
			            $("select#d4").html(data);
			            $('#d4').val($("#dum_variant").val());   
			          });
			    }
			    function getSatuan(sku){
			        $('.StepTitle').fadeIn('fast');
			        $.get(link+"/getSatuan/"+sku, $(this).serialize())
			          .done(function(data) { 
			            $('.StepTitle').fadeOut('fast');
			            $("select#d5").html(data); 
			            $('#d5').val($("#dum_satuan").val());  
			          });
			    } 
			    function isi_Uom(){
			        var uom = $("#d5").val();
			        var split_uom = uom.split("#");
			        $("#tmp_uom").val(split_uom[1]);
			    }
			    function hitung(){
			        var uom = $('#tmp_uom').val();
			        var qty = $('#d6').val();
			        var price = $('#d3').val();
			        var total = (qty * uom) * price;
			        $('#d7').val(total);
			    }
		      	function getSku(kode){
		          $('.StepTitle').fadeIn('fast');
		          $.ajax({
		              type: 'GET',
		              dataType:'JSON',
		              url: link+"/getStock/"+kode,
		              success:function(responseText){ 
		                $('.StepTitle').fadeOut('fast'); 
		                  $("#d1").val(responseText.fc_stock); 
		                  $("#d2").val(responseText.fv_stock); 
		                  $("#d3").val(responseText.fn_beli); 
		                  getVariant(responseText.fc_stock);
		                  getSatuan(responseText.fc_stock);
		              }
		          });
		       	}
		       	function resetDetail(){
		       		$("#actionDetail").slideUp('slow');
		       		$("#formMaster").slideDown('slow');
		       	}
            </script>   