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
			<h2><?php echo str_replace("/","",$sub_bread);?></h2>
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
			<div class="area_print" style="display: none;">
			<input type="hidden" id="nota">
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
					<button class="btn btn-success pull-right" onclick="cetakData($('#nota').val())">Print</button>
					<button class="btn btn-warning pull-right" onclick="tutup()">Tutup</button> 
					</div>
				</div>
				</section>
			</div>    
			<div id="laporan"> 
				<?php 
					$kolom = array("No.","Aksi","No.BPB","Ref.PO","Tgl BPB","Suppplier","Warehouse","Untuk Cabang","Total");
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
						'deferRender' : true,
						'info' : false,
				'language'  : {
					'searchPlaceholder': "Cari"
				},
				'ajax':{
					'url'	: link+"/getTableData",
					"dataType": "json",
					'type'	: 'POST'   
				},//pasangkan hasil dari ajax ke datatablesnya
				"columnDefs": [
					{ 
						"targets": [ 0 ], //first column / numbering column
						"orderable": false, //set not orderable
					},
				],

			}); 
		} 
		function tutup(){ 
			$('.area_print').slideUp('slow'); 
			$('#laporan').slideDown('slow'); 
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
		function getMSTINFO(kode){ 
			$.ajax({
				type: 'GET',
				dataType:'JSON',
				url: link+"/getMSTINFO/"+kode,
				success:function(responseText){ 
					var hasilInfo = '<div class="col-sm-4 invoice-col"> Supplier: <address> <strong>'+responseText.fv_supplier+'</strong> <br>'+responseText.fv_addr+'<br>'+responseText.fc_telp+' / '+responseText.fc_telp2+'  </address> </div>  <div class="col-sm-4"></div> <div class="col-sm-4 invoice-col"> <b>No.BPB #'+responseText.fc_nobpb+'</b> <br>  <table>  <tr> <td><b>Tanggal BPB</b></td>  <td> : </td> <td>'+responseText.fd_bpb+'</td> </tr>  <tr> <td><b>PO Ref.</b></td> <td> : </td> <td>'+responseText.fc_nopo+'</td> </tr> <tr> <td><b>Total Jenis</b></td> <td> : </td> <td>'+responseText.fn_jenis+'</td> </tr> <tr> <td><b>Qty</b></td> <td> : </td> <td>'+responseText.fn_qty+'</td> </tr><tr><td><b>Ongkir</b></td><td>:</td><td>Rp.'+responseText.fn_ongkir+'</td></tr> <tr> <td><b>Total</b></td> <td> : </td> <td>Rp.'+responseText.fm_total+'</td> </tr> <tr> <td><b>User</b></td> <td> : </td> <td>'+responseText.fc_userid+'</td> </tr> </table></div>';
					document.getElementById('hasilMstINfo').innerHTML = "";
					document.getElementById('hasilMstINfo').innerHTML = hasilInfo;
				}
			});
		}
		function getDTLINFO(kode){  
			$.get(link+"/getDTLINFO/"+kode, $(this).serialize())
			.done(function(data) { 
				document.getElementById('hasilDtlInfo').innerHTML = "";
				document.getElementById('hasilDtlInfo').innerHTML = data;
			}); 
				
		}  
		function detail(kode){
			$('#laporan').slideUp('slow'); 
			$('.area_print').slideDown('slow'); 
			$('#close_form').fadeIn('slow'); 
			getMSTINFO(kode);
			getDTLINFO(kode);
			$('#nota').val(kode);
		}
		function cetakData(nota){
			tutup();
			datatable();
			window.print();
		}
	</script>   
