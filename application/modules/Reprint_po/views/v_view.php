  <style media="print">
	@page {
	  size: auto;
	  margin: 0;
	}
	.btn-default{
		display: none;
	}
	.no-print{
		display: none;
	} 
	.title_left{
		display: none;
	}
	.x_title{
		display: none;
	}
	.nav_menu{
		display: none;
	}
	.page-title{
		display: none;
	} 
	footer{
		display: none;
	}
</style>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Reprint PO</h2> 
                    <div class="clearfix"></div> 
                  </div>
                  <div class="x_content">
                  	<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
                    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    	Transaksi berhasil 
                  	</div>  
                  	<div class="area_print" style="display: none;">
                  		<input type="hidden" id="sup_code">
                  		<section class="content invoice"> 
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
                                <button class="btn btn-success pull-right" onclick="cetakData()">Print</button>
                                <button class="btn btn-warning pull-right" onclick="tutup()">Tutup</button> 
                              </div>
                            </div>
                          </section>
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
			        				return "<button type='button' class='btn btn-success' onclick=Cetak('"+row['fc_nopo']+"')>Cetak</button>"; 
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
            	function getMSTINFO(kode){ 
		          $.ajax({
		              type: 'GET',
		              dataType:'JSON',
		              url: link+"/getMSTINFO/"+kode,
		              success:function(responseText){ 
		                 var hasilInfo = '<div class="col-sm-4 invoice-col"> Supplier: <address> <strong>'+responseText.fv_supplier+'</strong> <br>'+responseText.fv_addr+'<br>'+responseText.fc_telp+' / '+responseText.fc_telp2+'  </address> </div>  <div class="col-sm-4"></div> <div class="col-sm-4 invoice-col"> <b>No.PO #'+responseText.fc_nopo+'</b> <br>  <table>  <tr> <td><b>Tanggal PO</b></td>  <td> : </td> <td>'+responseText.fd_po+'</td> </tr>  <tr> <td><b>Perkiraan Datang</b></td> <td> : </td> <td>'+responseText.fd_estdatang+'</td> </tr> <tr> <td><b>Qty Item</b></td> <td> : </td> <td>'+responseText.fn_qty+'</td> </tr> <tr> <td><b>Total</b></td> <td> : </td> <td>'+responseText.total+'</td> </tr> <tr> <td><b>Catatan</b></td> <td> : </td> <td>'+responseText.fv_note+'</td> </tr> <tr> <td><b>User</b></td> <td> : </td> <td>'+responseText.fc_userid+'</td> </tr> </table></div>';
		                 document.getElementById('hasilMstINfo').innerHTML = "";
		                 document.getElementById('hasilMstINfo').innerHTML = hasilInfo;
		              }
		          });
		       }
		       function getDTLINFO(kode){  
		          $.get(link+"/getDTLINFO/"+kode, $(this).serialize())
		                  .done(function(data) {
		                    $('.StepTitle').fadeOut('fast');
		                   document.getElementById('hasilDtlInfo').innerHTML = "";
		                   document.getElementById('hasilDtlInfo').innerHTML = data;
		                  }); 
		              
		       } 
		       function tutup(){
		       		$('#laporan').slideDown('slow'); 
		       		$('#close_form').fadeOut('slow');
		       		$('.area_print').slideUp('slow');
		       		document.getElementById('hasilMstINfo').innerHTML = ""; 
		       		document.getElementById('hasilDtlInfo').innerHTML = ""; 
		       }
		       function Cetak(kode){
		       		$('#laporan').slideUp('slow'); 
		       		$('.area_print').slideDown('slow'); 
		       		$('#close_form').fadeIn('slow'); 
		       		$('#sup_code').val(kode);
		       		getMSTINFO(kode);
		       		getDTLINFO(kode);
		       }
		       function cetakData(){
			       	window.print();
		       }

            </script>   