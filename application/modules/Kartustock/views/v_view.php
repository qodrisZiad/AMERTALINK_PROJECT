            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Kartustock</h2>
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
                     <form class="form-horizontal form-label-left" id="formAksi" style="display: none;" method="post" enctype="multipart/form-data">
                     	<?php 
                     	$data = array(
                     		'aksi' => array('name' => 'aksi','type' => 'hidden'),
                     		'kode' => array('name'=>'kode','type' => 'hidden'),
                     		'a1' => array('name'=>'a1','label' => 'Kategori','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a2' => array('name'=>'a2','label' => 'Gambar','type' => 'file','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a3' => array('name'=>'a3','label' => 'Aktif','type' => 'option','class' => 'form-control','option' => array('1'=>'Aktif','0'=>'Non Aktif'),'col' => 'col-sm-2')
                     	);
                     	buat_form($data);  
                     	?> 
                    </form> 
					<div id="laporan"> 
					<form id="form-filter" class="form-horizontal">
					<?php
						$filterField = array(
							'f1'	=> array('name' => 'f_branch', 'label' => 'Cabang', 'type' => 'option', 'option' => $listBranch, 'class' => 'form-control','col' => 'col-sm-4'),
							'f2'	=> array('name' => 'f_wh', 'label' => 'Gudang', 'type' => 'option', 'option' => array(), 'class' => 'form-control','col' => 'col-sm-4'),
							'f3'	=> array('name' => 'f_nmbrg', 'label' => 'Nama Barang', 'type' => 'text', 'class' => 'form-control', 'col' => 'col-sm-4', 'defaultValue'=> '')
						);
						$btnData = array(
							'b1' => array('id' => 'btn-reset', 'type'=>'reset','class'=>'btn btn-danger','label'=>'Reset'),
							'b2' => array('id' => 'btn-filter', 'type'=>'button','class'=>'btn btn-success','label'=>'Filter') 
						);
						buat_form($filterField, $btnData);
					?>
					</form>
						<?php 
							$kolom = array("No.","Tanggal","Kode","Nama Barang","Variant","Referensi","Keterangan","User");
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
			        	'language'  : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: link + "/tabledata",
			        		"dataType": "JSON",
			        		'type'	: 'POST',
							'data'	: function( data ){
								data.f_branch = $('#f_branch').val();
								data.f_wh = $('#f_wh').val();
								data.f_namabrg = $('#f_nmbrg').val();
							} 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	"columnDefs": [
							{ 
								"targets": [ 0 ], //first column / numbering column
								"orderable": false, //set not orderable
							},
						],
						'searching': false,
						'deferRender': true
   
			        }); 
            	}
            	function reload_table(){
			    	table.ajax.reload(null,false);
			    }
				function tambah(){
					$('#laporan').slideUp('slow');
					$('#formAksi').slideDown('slow');
					$('#close_form').fadeIn('slow');
					$('#add_form').fadeOut('slow');
					$('#aksi').val('tambah'); 
				}
				function tutup(){
					$('#pict_detail_img').hide();
					$('#formAksi').slideUp('slow');
					$('#laporan').slideDown('slow');
					$('#close_form').fadeOut('slow');
					$('#add_form').fadeIn('slow');
					$('#aksi').val('');
					reload_table();
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
			            url: link+"/Edit/"+kode,
			            success:function(responseText){ 
			            	tambah(); 
			              	$('#aksi').val('update');
							$('#kode').val(kode);    
			                $('input[name="a1"]').val(responseText.fv_kat);
			                $('#pict_detail_img').show();
			                document.getElementById('pict_detail_img').src = "./assets/foto/"+responseText.fv_pict;
			                $('#a3').val(responseText.fc_status);           
			            }
			        });
				}
				function hapus(kode,img){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/Hapus/"+kode+"/"+img, $(this).serialize())
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
			            data:  new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            success: function(data){ 
			            if (data.includes("Berhasil") == true && $('#aksi').val()=='tambah') {
			            	document.getElementById('formAksi').reset();
			            } 
			            	display_message(data);
			            }           
			        });
			        return false;  
				}); 
				$(document).on('change','#f_branch',function(e){
					$.ajax({
						url		  : link + '/getListWH/' + $('#f_branch').val(),
						type	  : "GET",
						data	  : $('#f_branch').val(),
						success	  : function (e){
							$('#f_wh').html(e);
						}
					});
				});
				$('#btn-filter').click( function (){
					table.ajax.reload();
				});
				$('#btn-reset').click( function (){
					$('#form-filter')[0].reset();
					table.ajax.reload();
				});
				function PreviewImage(hasil,dari) {
					var oFReader = new FileReader();
					oFReader.readAsDataURL(document.getElementById(dari).files[0]);
					oFReader.onload = function (oFREvent)
					 {
					 	$('#'+hasil).fadeOut('fast');
					 	$('#'+hasil).fadeIn('fast');
					    document.getElementById(hasil).src = oFREvent.target.result;
					    
					};
				};
            </script>   