	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
			<h2><?php echo str_replace("/","",$sub_bread);?></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
				<?php if($input=='1'){?><li id="add_form"><a><i class="fa fa-plus" onclick="tambah()"></i></a></li><?php }?>
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
			<!-- tempat form -->
			<form class="form-horizontal form-label-left" id="formMaster" name="formMaster" method="POST" style="display:none;overflow: hidden;">
				<input type="hidden" name="aksi" id="aksi">
				<input type="hidden" name="kode" id="kode">
					<div class="col-md-9"> 
						<div class="form-group">
							<label class="control-label col-md-3" for="a1">Karyawan <span style="color: red">*</span> 
							</label>
							<div class="col-md-6" >
								<select id="a1" name="a1" class="form-control" required="required">
								<?php 
								foreach (getKaryawan() as $key => $value) {
									echo "<option value='".$key."'>".$value."</option>";
								}
								?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="a2">No BPB<span style="color: red">*</span> 
							</label>
							<div class="col-md-6" >
							<div class='input-group'>
								<input type='text' class="form-control" id="a2" name="a2" onchange="getSku($('#a2').val())" required="required" />
								<span class="input-group-addon" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg">
								<span class="glyphicon glyphicon-search"></span>
								</span>
							</div>
							</div>
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<h4 class="modal-title" id="myModalLabel2">Cari Stock</h4>
								</div>
								<div class="modal-body">
									<?php 
									$kolom = array("No.","Kategori","SKU","Nama Stock","Qty","Opsi");
									buat_table($kolom,"datatable2");   
									?>
								</div> 

								</div>
							</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="a3">SKU<span style="color: red">*</span> 
							</label>
							<div class="col-md-6" >
							<div class='input-group'>
								<input type='text' class="form-control" id="a3" name="a3" onchange="getSku($('#a3').val())" required="required" />
								<span class="input-group-addon" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg">
								<span class="glyphicon glyphicon-search"></span>
								</span>
							</div>
							</div>
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<h4 class="modal-title" id="myModalLabel2">Cari Stock</h4>
								</div>
								<div class="modal-body">
									<?php 
									$kolom = array("No.","Kategori","SKU","Nama Stock","Qty","Opsi");
									buat_table($kolom,"datatable2");   
									?>
								</div> 

								</div>
							</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="a4">Nama Stock
							</label>
							<div class="col-md-6">
							<input type="text" id="a4"  class="form-control" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="a5">Catatan
							</label>
							<div class="col-md-6">
							<textarea class="form-control" name="a5" id="a5"></textarea>
							</div>
						</div>		
					<div class="form-group">
						<label class="control-label col-md-3" for="a6">Tgl Input 
						</label>
						<div class="col-md-6">
							<input type="text" id="a6" name="a6"  class="form-control" value="<?= date('d-m-Y');?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3" for="a7">User Input 
						</label>
						<div class="col-md-6">
							<input type="text" id="a7" name="a7"  class="form-control" value="<?= $this->session->userdata('userid');?>" readonly>
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
			<!-- tempat report -->
			<div id="laporan"> 
				<?php 
					$kolom = array("No.","Aksi","No.BPB","Checker","KODE STOCK","STOCK","Catatan","Userinput","Tgl Input","Status");
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
		function tambah(){ 
			$("#aksi").val('tambah'); 
			$("#kode").val('');
			$('#close_form').fadeIn('slow');
			$('#add_form').fadeOut('slow'); 
			$('#formMaster').slideDown('slow'); 
		}
		function tutup(){ 
			$('#close_form').fadeOut('slow');
			$('#add_form').fadeIn('slow'); 
			$('#laporan').slideDown('slow');
			$('#formMaster').slideUp('slow'); 
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
		function detail(kode){
			$('#laporan').slideUp('slow'); 
			$('.area_print').slideDown('slow'); 
			$('#close_form').fadeIn('slow'); 
			getMSTINFO(kode);
			getDTLINFO(kode);
			$('#nota').val(kode);
		} 
		function getSku(kode){ 
          $.ajax({
              type: 'GET',
              dataType:'JSON',
              url: link+"/getStock/"+kode,
              success:function(responseText){  
                  $("#a3").val(responseText.fc_stock); 
                  $("#a4").val(responseText.fv_stock);   
              }
          });
       }
	   function hapus(kode){
			if(confirm("Apakah anda Yakin?")){ 
				$.get(link+"/Hapus/"+kode, $(this).serialize())
				.done(function(data) { 
					display_message(data);
					datatable();
				});
				//--------------------------------
			}
		}
	   $(document).on('submit','#formMaster',function(e){ 
          e.preventDefault();
          $.ajax({
          url: link+"/simpan",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){  
              display_message(data);
			  document.getElementById("formMaster").reset();
              tambah();
			  datatable();
          }          
          });
          return false;   
        });
	</script>   
