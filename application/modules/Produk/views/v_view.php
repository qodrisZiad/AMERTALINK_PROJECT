            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 id="bread">Master <?= $bread;?></h2>
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
                  	</div>
                  	<!-----------------------------------INI UNTUK MASTER PRODUKNYA ---------------------------------------------------->
                    <form class="form-horizontal form-label-left" id="formAksi" style="display: none;" method="post">
                     	<?php 
                     	$data = array(
                     		'aksi' => array('name' => 'aksi','type' => 'hidden'), 
                     		'kode_sub' => array('name'=>'kode_sub','type' => 'hidden'),
                     		'kode_sub_sub' => array('name'=>'kode_sub_sub','type' => 'hidden'),
                     		'a1' => array('name'=>'a1','label' => 'SKU','type' => 'text','class' => 'form-control','col' => 'col-sm-4','readonly' => 'true'),
                     		'a2' => array('name'=>'a2','label' => 'Kategori','type' => 'option','class' => 'form-control','option' => $kategori,'col' => 'col-sm-4'),
                     		'a3' => array('name'=>'a3','label' => 'Sub Kategori','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-4'),
                     		'a4' => array('name'=>'a4','label' => 'Sub Sub Kategori','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-4'), 
                     		'a5' => array('name'=>'a5','label' => 'Nama Stock','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a6' => array('name'=>'a6','label' => 'Keterangan','type' => 'text','class' => 'form-control','col' => 'col-sm-6'), 
                     		'a7' => array('name'=>'a7','label' => 'Min Qty','type' => 'number','class' => 'form-control','col' => 'col-sm-2'), 
                     		'a8' => array('name'=>'a8','label' => 'Aktif','type' => 'option','class' => 'form-control','option' => array('1'=>'Aktif','0'=>'Non Aktif'),'col' => 'col-sm-2')
                     	);
                     	buat_form($data);  
                     	?>
                    </form> 
					<div id="laporan"> 
						<?php 
							$kolom = array("No.","Aksi","SKU","Kategori","Nama Stock","Ket","Min Stock","Set Properti","Set Variant","Set Uom","Status","User Input");
							buat_table($kolom,"datatable");   
						?>
					</div>
					<!-------------------------------------- TUTUP MASTER PRODUKNYA ----------------------------------------------------> 

            <script type="text/javascript">
            	var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
            	var table;
            	// ----------------- AWAL MASTER PRODUK -----------------------------
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
				        		{'data' : 'no',width:20} 
				        		<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
		                       		return "<div class='x_content'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-primary dropdown-toggle btn-sm' type='button' aria-expanded='false'>Aksi<span class='caret'></span></button><ul role='menu' class='dropdown-menu'><?php if($update =='1'){?><li><a href='#' onclick=edit('"+row['fc_stock']+"')>Ubah</a></li> <?php } ?> <?php if($delete =='1'){ ?><li><a href='#' onclick=hapus('"+row['fc_stock']+"')>Hapus</a></li> <?php } ?> <li class='divider'></li><li><a href='#' onclick=setProperti('"+row['fc_stock']+"')>Set Properti</a></li><li><a href='#' onclick=setVariant('"+row['fc_stock']+"')>Set Variant</a></li><li><a href='#' onclick=setUom('"+row['fc_stock']+"')>Set Uom</a></li><li><a href='#' onclick=setFoto('"+row['fc_stock']+"')>Set Foto</a></li></ul></div></div>";
		                    		},width:50
	                			} <?php  }else{ ?>
	                				,{'mRender': function ( data, type, row ) {
			                       		return "Akses ditutup";
			                    		},width:80
	                				}	
	                			<?php } ?>,
				        		{'data' : 'fc_stock'},
				        		{'data' : 'kategori'},
				        		{'data' : 'fv_stock'}, 
				        		{'data' : 'fv_ket'}, 
				        		{'data' : 'fn_min'},
				        		{'mRender': function ( data, type, row ) {
		                       		if (row['master_Properti'] > 0) {
		                       			return "<span style='color:green'>Sudah</span>";
		                       		}else{
		                       			return "<span style='color:red;'>Belum</span>";
		                       		}
		                    		},width:30
	                			}, 
	                			{'mRender': function ( data, type, row ) {
		                       		if (row['master_Variant'] > 0) {
		                       			return "<span style='color:green'>Sudah</span>";
		                       		}else{
		                       			return "<span style='color:red;'>Belum</span>";
		                       		}
		                    		},width:30
	                			},
	                			{'mRender': function ( data, type, row ) {
		                       		if (row['master_Uom'] > 0) {
		                       			return "<span style='color:green'>Sudah</span>";
		                       		}else{
		                       			return "<span style='color:red;'>Belum</span>";
		                       		}
		                    		},width:30
	                			},   
	                			{'mRender': function ( data, type, row ) {
		                       		if (row['fc_status'] == '1') {
		                       			return "Aktif";
		                       		}else{
		                       			return "Non Aktif";
		                       		}
		                    		},width:30
	                			},  
	                			{'data' : 'fc_userid'}  
				        	]   
				        }); 
	            	}
	            	function reload_table(){table.ajax.reload(null,false);}
					function tambah(){
						$('#laporan').slideUp('slow');
						$('#formAksi').slideDown('slow');
						$('#close_form').fadeIn('slow');
						$('#add_form').fadeOut('slow');
						document.getElementById('bread').innerHTML = 'Master Produk';
						document.getElementById('formAksi').reset();
						$('#aksi').val('tambah');
						getNomor("SKU");
					}
					function tutup(){
						document.getElementById('bread').innerHTML = 'Master Produk';
						$('#formAksi').slideUp('slow');
						$('#Properti').slideUp('slow');
						$('#Variant').slideUp('slow');
						$('#Uom').slideUp('slow');
						$("#gambar").slideUp("slow");
						$('#laporan').slideDown('slow');
						$('#close_form').fadeOut('slow');
						$('#add_form').fadeIn('slow');
						$('#aksi').val('');
						reload_table();
						document.getElementById('laporan_gambar').innerHTML = "";
					}
					function display_message(isi){
						$('#alert_trans').slideDown('slow').fadeOut(3000);
						if (isi.includes('Berhasil')) { 
							$('#alert_trans').removeClass("alert-danger");
							$('#alert_trans').addClass('alert-primary');
							$('#alert_trans').text(isi);
						}else if(isi.includes('Gagal')){
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
				            	$('#laporan').slideUp('slow');
								$('#formAksi').slideDown('slow');
								$('#close_form').fadeIn('slow');
								$('#add_form').fadeOut('slow');
								document.getElementById('bread').innerHTML = 'Master Produk';
								document.getElementById('formAksi').reset();
								$('#aksi').val('tambah');
				              	$('#aksi').val('update');   
				                $('input[name="a1"]').val(responseText.fc_stock);           
				                $('input[name="kode_sub"]').val(responseText.fc_subkat); 
				                $('input[name="kode_sub_sub"]').val(responseText.fc_subsubkat); 
				                $('#a2').val(responseText.fc_kat); 
				                $("select#a2").change();
				                $('input[name="a5"]').val(responseText.fv_stock);
				                $('input[name="a6"]').val(responseText.fv_ket);
				                $('input[name="a7"]').val(responseText.fn_min); 
				                $('#a8').val(responseText.fc_status);
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
				            dataType: "JSON",
							data:  new FormData(this),
				            contentType: false,							
				            cache: false,
				            processData:false,
				            success: function(data){ 
					            if (data.proses != 0 && $('#aksi').val()=='tambah') {
									document.getElementById('formAksi').reset();
									getNomor("SKU");
								}else{
									tutup();
								}
			            		display_message(data.message);    
			            	}      
				        });
				        return false;  
					}); 
					function rupiah(bilangan){
						var	number_string = bilangan.toString(),
						sisa 	= number_string.length % 3,
						rupiah 	= number_string.substr(0, sisa),
						ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
							
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						return rupiah;
					}
					$(document).on('change','#a2',function(e){
						$.get(link+"/getSubkategories/"+$("#a2").val(), $(this).serialize())
			            .done(function(data) { 
			            	$("select#a3").html(data); 
			            	if ($("#aksi").val() == "update") {
			            		$("#a3").val($("[name='kode_sub']").val());
			            		$("select#a3").change();
			            	}
			            });
					});
					$(document).on('change','#a3',function(e){
						$.get(link+"/getSubSubkategories/"+$("#a2").val()+"/"+$("#a3").val(), $(this).serialize())
			            .done(function(data) { 
			            	$("select#a4").html(data); 
			            	if ($("#aksi").val() == "update") {
			            		$("#a4").val($("[name='kode_sub_sub']").val());
			            	}
			            });
					});
					function getNomor(document){ 
						$.get(link+"/getNomor/"+document, $(this).serialize())
				            .done(function(data) { 
				            	$('#a1').val(data);
				            });
					}
				// --------------- AKHIR MASTER PRODUK ----------------------------- 
            </script>   