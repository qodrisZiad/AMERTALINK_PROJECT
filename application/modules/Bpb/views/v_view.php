            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bukti Penerimaan Barang PO</h2> 
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
                  	<input type="hidden" id="no_nota"> 
                  	<h3 style="display:none;" class="StepTitle">Mengambil informasi server...</h3>
                  	<div id="wizard" class="form_wizard wizard_horizontal" style="height: auto;">
                      <ul class="wizard_steps" style="height: auto;">
                        <li>
                          <a href="#step-1" id="step1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                              Step 1<br />
                              <small>Input Data Master</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                              Step 2<br />
                              <small>Input Data Detail</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                              Step 3<br />
                              <small>Finalisasi</small>
                            </span>
                          </a>
                        </li> 
                      </ul> 
                      <!-- Input data master -->
                      <div id="step-1"> 
                          <form class="form-horizontal form-label-left" id="formMaster" name="formMaster" method="POST" style="overflow: hidden;">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="bpb_no">No.BPB 
                                  </label>
                                  <div class="col-md-6">
                                    <input type="text" id="bpb_no" name="bpb_no"  class="form-control" value="admin" readonly>
                                  </div>
                                </div>
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
                                      <input type='text' class="form-control" id="a2" name="a2" readonly/>
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
                                  <input type="text" id="a3" name="a3"  class="form-control" readonly>
                                </div>
                                </div> 
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a4">Untuk Cabang   
                                  </label>
                                  <div class="col-md-6" >
                                    <input type="text" id="a4" name="a4"  class="form-control" value="admin" readonly>
                                  </div>
                                </div>
                                <input type="hidden" id="temp_gudang">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a5">Gudang   
                                  </label>
                                  <div class="col-md-6" >
                                    <input type="text" id="a5" name="a5"  class="form-control" value="admin" readonly>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a6">Tanggal Terima 
                                  </label>
                                  <div class="col-md-6" >
                                    <div class='input-group date' id='tanggal'>
                                      <input type='text' class="form-control" name="a6" value="<?= date("d-m-Y"); ?>" />
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
                                <label class="control-label col-md-3" for="a12">Ongkos Kirim 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a12" name="a12"  class="form-control" value="0" onblur=" hitungTotal()">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a8">SubTotal 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a8" name="a8"  class="form-control" value="0" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a13">Total 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a13" name="a13"  class="form-control" value="0" readonly>
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
                                  <input type="text" id="a10" name="a10"  class="form-control" value="<?= date('d-m-Y');?>" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a11">User Input 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a11" name="a11"  class="form-control" value="<?= $this->session->userdata('userid');?>" readonly>
                                </div>
                              </div>
                              <div class="form-group"><label class="control-label col-md-3" for="a1"> 
                              </label>
                              <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-danger" onclick="batalkan('<?php echo $this->session->userdata("userid");?>')">Batalkan</button>
                              </div>
                            </div> 
                            </div> 
                          </form> 
                      </div>
                      <div id="step-2">
                      	<div id="detailBPB">
                      		<div class="row">
								<div class="col-md-4 col-xs-4">
									<div class="x_panel">
									  <div class="x_title">
									    <h2>Form Penerimaan Barang</h2> 
									    <div class="clearfix"></div>
									  </div>
									  <div class="x_content">
									    <br />
									    <form class="form-horizontal form-label-left input_mask" id="formDtl" method="post">
									      <input type="hidden" name="kode">  
									      <input type="hidden" name="kdvar">  
									      <input type="hidden" name="kdsat">  
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sku</label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input type="text" class="form-control" id="d1" name="d1" readonly>
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Stock</label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input type="text" class="form-control" id="d2" name="d2" readonly>
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Variant</label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input type="text" class="form-control" id="d3" name="d3" readonly>
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Satuan 
									        </label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input class="date-picker form-control col-md-7 col-xs-12" id="d4" name="d4" readonly type="text">
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga 
									        </label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input class="form-control col-md-7 col-xs-12" id="d5" name="d5" type="text" required onblur="hitungsubtotal()">
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qty PO 
									        </label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input class="form-control col-md-7 col-xs-12" id="d6" name="d6" type="text" readonly>
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qty Terima 
									        </label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input class="form-control col-md-7 col-xs-12" id="d7" name="d7" type="text" required onblur="hitungsubtotal()">
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Subtotal 
									        </label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <input class="form-control col-md-7 col-xs-12" id="d8" name="d8" type="text" readonly>
									        </div>
									      </div>
									      <div class="form-group">
									        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan 
									        </label>
									        <div class="col-md-9 col-sm-9 col-xs-12">
									          <textarea class="form-control col-md-7 col-xs-12" id="d9" name="d9"></textarea>
									        </div>
									      </div>
									      <div class="ln_solid"></div>
									      <div class="form-group">
									        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3"> 
											   <button class="btn btn-primary" type="reset">Reset</button>
									          <button type="submit" class="btn btn-success">Submit</button>
									        </div>
									      </div>
									    </form>
									  </div>
									</div>
								</div>
								<div class="col-md-8 col-xs-8" style="overflow: auto;">
									<?php 
										$kolom2 = array("No.","Aksi","SKU","Nama Stock","Variant","Satuan","Harga","Qty PO","Qty Terima","SUbtotal","Catatan");
										buat_table($kolom2,"datatable2");   
									?>
								</div>
                      		</div> 
                      	</div> 
                      </div>
                      <div id="step-3">
                        <div class="col-md-2"></div>
                        <div class="col-md-9">
                          <section class="content invoice">
                            <!-- title row -->
                            <!-- info row -->
                            <div class="row invoice-info" id="hasilMstINfo"> 
                              
                            </div> 
                            <div class="row">
                              <div class="col-xs-6 table" id="hasilDtlInfo">  
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->   
                            <div class="row no-print">
                              <div class="col-xs-12"> 
                                <button class="btn btn-success pull-right" onclick="finalisasi()">Finalisasi</button>
                                <button class="btn btn-danger pull-right" onclick="batalkan('<?php echo $this->session->userdata("userid");?>')" style="margin-right: 5px;">Batalkan</button>
                              </div>
                            </div>
                          </section>
                        </div>
                      </div>  
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
            		 tutup(); 
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
            	function datatable2(){
            		table = $('#datatable2').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'destroy'	: true,
			        	'language'  : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/dataDetail');?>/"+$("#no_nota").val(),
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		<?php if($delete=='1' || $update =='1'){ ?>
			        			{'mRender': function ( data, type, row ) {
			        				return "<button type='button' class='btn btn-success' onclick=update('"+row['fc_id']+"')>Input</button><button type='button' class='btn btn-danger' onclick=hapus('"+row['fc_id']+"')>Hapus</button>"; 
                					}
                				}	
                			<?php } ?>, 
			        		{'data' : 'fc_stock'},
			        		{'data' : 'fv_stock'},  
			        		{'data' : 'variant'},  
			        		{'data' : 'fv_satuan'},  
			        		{'data' : 'fn_price'},  
			        		{'data' : 'fn_qty'},  
			        		{'data' : 'fn_terima'},  
			        		{'data' : 'fn_total'},  
			        		{'data' : 'fv_ket'}  
			        	]   
			        }); 
            	}  
            	function tutup(){
            		$('#close_form').fadeOut('slow');
            		$('#no_nota').val("");
            		$('#wizard').slideUp('slow');
            		$('#laporan').slideDown('slow');
            		datatable();
            	}
            	function detail(kode){
					$('.StepTitle').fadeIn('fast');
					$('#no_nota').val(kode);
            		$('#close_form').fadeIn('slow');
            		$('#laporan').slideUp('slow');
            		$('#wizard').slideDown('slow'); 
					$.ajax({
					  type: 'GET',
					  dataType:'JSON',
					  url: link+"/getMSTINFO/"+kode,
					  success:function(responseText){ 
					  	$('.StepTitle').fadeOut('fast');
					    $("#a1").val(responseText.fc_nopo); 
					    $("#a2").val(responseText.fd_po); 
					    $("#a3").val(responseText.fv_supplier); 
					    $("#a4").val(responseText.untuk_cabang); 
					    $("#a5").val(responseText.warehouse); 
					    $("#a7").val(responseText.fn_qty); 
					    $("#a8").val(responseText.total); 
					    $("#a9").val(responseText.fv_note);  
					    $("#a12").val(responseText.ongkir);
					    hitungTotal(); 
					    actionButton(); 
					  }
					});
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
			    $(document).on('submit','#formMaster',function(e){
			    	$('.StepTitle').fadeIn('fast');
					e.preventDefault();
					$.ajax({
			            url: link+"/SimpanMst",
			            type: "POST",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){  
			            	$('.StepTitle').fadeOut('fast');       
			            	display_message(data);
			            	if (data.includes("Berhasil") == true) {
			            		actionButton();
			            		$('.buttonNext').click();  
			            	}
			            }
			        	});
			        return false;  
				});
				$(document).on('submit','#formDtl',function(e){
			    	$('.StepTitle').fadeIn('fast');
					e.preventDefault();
					$.ajax({
			            url: link+"/SimpanDtl",
			            type: "POST",
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){  
			            	$('.StepTitle').fadeOut('fast');       
			            	display_message(data);
			            	if (data.includes("Berhasil") == true) {
			            		datatable2();  
			            	}
			            	document.getElementById("formDtl").reset();
			            }
			        	});
			        return false;  
				});   
				function hitungTotal(){
					var subtotal = parseInt(decimal($('#a8').val()));
					var ongkir = parseInt(decimal($('#a12').val()));
					hasil = subtotal + ongkir;
					$('#a13').val("Rp."+rupiah(hasil));
				}  
			    function update(kode){
			    	$.ajax({
					  type: 'GET',
					  dataType:'JSON',
					  url: link+"/getDataPO/"+kode,
					  success:function(responseText){ 
					  	$('.StepTitle').fadeOut('fast');
					  	$('[name="kode"]').val(responseText.fc_id);
					  	$('[name="kdvar"]').val(responseText.fc_variant);
					  	$('[name="kdsat"]').val(responseText.fc_satuan);
					  	$("#d1").val(responseText.fc_stock);
					  	$("#d2").val(responseText.fv_stock);
					  	$("#d3").val(responseText.variant);
					  	$("#d4").val(responseText.fv_satuan);
					  	$("#d5").val(decimal(responseText.fn_price));
					  	$("#d6").val(responseText.fn_qty);
					  	$("#d7").val(responseText.fn_terima);
					  	$("#d8").val(responseText.fn_total);
					  	$("#d9").val(responseText.fv_ket);
					  }
					});
			    }
			    function hitungsubtotal(){
					var harga = parseInt(decimal($('#d5').val()));
					var qty   = parseInt(decimal($('#d7').val()));
					var total = harga * qty;
					$("#d8").val("Rp."+rupiah(total));
			    }
			    function hapus(kode){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/HapusDtl/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	display_message(data);
			            	datatable2();
			            });
			            //--------------------------------
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
				function actionButton(){
					$('.buttonNext').click(function(){
						detail($('#no_nota').val());  
			            datatable2();
			            getMSTINFO($('#no_nota').val()); 
			            getDTLINFO($('#no_nota').val()); 
					});
					$('.buttonPrevious').click(function(){
						detail($('#no_nota').val());  
			            datatable2();
			            getMSTINFO($('#no_nota').val()); 
			            getDTLINFO($('#no_nota').val()); 
					});
					$('.buttonFinish').click(function(){
						detail($('#no_nota').val());  
			            datatable2();
			            getMSTINFO($('#no_nota').val()); 
			            getDTLINFO($('#no_nota').val()); 
					});
				}
				function getMSTINFO(kode){
		          $('.StepTitle').fadeIn('fast');
		          $.ajax({
		              type: 'GET',
		              dataType:'JSON',
		              url: link+"/getMaster/"+kode,
		              success:function(responseText){ 
		                 var hasilInfo = '<div class="col-sm-4 invoice-col"> Supplier: <address> <strong>'+responseText.fv_supplier+'</strong> <br>'+responseText.fv_addr+'<br>'+responseText.fc_telp+' / '+responseText.fc_telp2+'  </address> </div>  <div class="col-sm-4"></div> <div class="col-sm-4 invoice-col"> <b>No.PO #'+responseText.fc_nopo+'</b> <br>  <table>  <tr> <td><b>Tanggal PO</b></td>  <td> : </td> <td>'+responseText.fd_po+'</td> </tr>  <tr> <td><b>Tgl Terima</b></td> <td> : </td> <td>'+responseText.fd_tglterima+'</td> </tr> <tr> <td><b>Qty PO</b></td> <td> : </td> <td>'+responseText.qty_po+'</td> </tr> <tr> <td><b>Qty Terima</b></td> <td> : </td> <td>'+responseText.terima+'</td> </tr><tr> <td><b>Qty Sisa</b></td> <td> : </td> <td>'+responseText.sisa+'</td> </tr><tr> <td><b>Ongkir</b></td> <td> : </td> <td>Rp.'+rupiah(responseText.fn_ongkir)+'</td> </tr><tr> <td><b>Total</b></td> <td> : </td> <td>Rp.'+rupiah(responseText.fm_total)+'</td> </tr> <tr> <td><b>Catatan</b></td> <td> : </td> <td>'+responseText.fv_note+'</td> </tr> <tr> <td><b>User</b></td> <td> : </td> <td>'+responseText.fc_userid+'</td> </tr> </table></div>';
		                 document.getElementById('hasilMstINfo').innerHTML = "";
		                 document.getElementById('hasilMstINfo').innerHTML = hasilInfo;
		              }
		          });
		       	}
		       	function getDTLINFO(kode){
		          $('.StepTitle').fadeIn('fast'); 
		          $.get(link+"/getDetail/"+kode, $(this).serialize())
		                  .done(function(data) {
		                    $('.StepTitle').fadeOut('fast');
		                   document.getElementById('hasilDtlInfo').innerHTML = "";
		                   document.getElementById('hasilDtlInfo').innerHTML = data;
		                  }); 
		              
		       }   
            </script>   
            <script src="<?= site_url()?>vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script> 