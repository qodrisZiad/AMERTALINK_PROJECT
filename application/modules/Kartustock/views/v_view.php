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
                     <form class="form-horizontal form-label-left" id="form-filter">
						 <?php 
						$tombols = array(
							'b1' => array('id'=>'bf1','type'=>'button','label'=>'Reset','class'=>'btn btn-warning'),
							'b2' => array('id'=>'bf2','type'=>'button','label'=>'Filter','class'=>'btn btn-primary'),
						);                     	
						$dataH = array( 
							'aksi' => array('name' => 'aksi','type' => 'hidden'),
							'kode' => array('name'=>'kode','type' => 'hidden')
						);						
						$dataF = array(
                     		'f1' => array('name'=>'f_branch','label' => 'Cabang','type' => 'option', 'option'=> getBranch()), 
                     		'f2' => array('name'=>'f_wh','label' => 'Gudang','type' => 'option', 'option'=> array()), 
							'f3' => array('name'=>'f_namabrg','label' => 'Nama Barang','type' => 'text')
						);	
						custom_form($dataF, $dataH, $tombols);
                     	?>
                    </form> 
					<div class="ln_solid"></div> 
					<div id="laporan"> 
						<?php 
							$kolom = array("No.","Tanggal","Nama Barang","Variant","Keluar","Masuk","Sisa","Referensi","Keterangan","User");
							buat_table($kolom,"datatable");   
						?>
					</div>
					<div class="ln_solid"></div>
					
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
			        	'processing' : true, 	//ini untuk menampilkan processing
			        	'serverSide' : true, 	//ini untuk serversidenya
			        	'order'		 : [], 		//ini jika menginginkan diorder
						'deferRender': true,	//ini penting jika data 
						'searching'	 : false,
						'info'		 : false,
			        	'language'   : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: link+"/getTableData",
			        		"type"	: 'POST',
							"data"	: function ( data ) {
								data.f_branch 	= $('#f_branch').val();
								data.f_wh 		= $('#f_wh').val();
								data.f_namabrg 	= $('#f_namabrg').val();
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
					$.get(link+'/getListWH/'+$('#f_branch').val(), $(this).serialize())
						.done(function( data ){
							$('#f_wh').html( data );
						});
				});
				$('#bf2').click(function(){ //button filter event click
					table.ajax.reload();  //just reload table
				});
				$('#bf1').click(function(){ //button reset event click
					$('#form-filter')[0].reset();
					table.ajax.reload();  //just reload table
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