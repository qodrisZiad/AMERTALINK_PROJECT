            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Master Sub Sub Kategori</h2>
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
                     		'kode_sub' => array('name' => 'kode_sub','type' => 'hidden'),
                     		'kode' => array('name'=>'kode','type' => 'hidden'),
                     		'a1' => array('name'=>'a1','label' => 'Kategori','type' => 'option','class' => 'form-control','option' => $kategori,'col' => 'col-sm-3'),
                     		'a2' => array('name'=>'a2','label' => 'Sub Kategori','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-3'),
                     		'a3' => array('name'=>'a3','label' => 'Sub Sub Kategori','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a4' => array('name'=>'a4','label' => 'Foto','type' => 'file','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a5' => array('name'=>'a5','label' => 'Status','type' => 'option','class' => 'form-control','option'=>array('1' => 'Aktif','0'=>'Non Aktif'),'col' => 'col-sm-2'), 
                     	);
                     	buat_form($data);  
                     	?>
                     	<img src="" id="pict_detail_img" width="400px" style="display: none;">
                    </form> 
					<div id="laporan"> 
						<?php 
							$kolom = array("No.","Kategori","Sub Kategori","Sub Sub Kategori","Status","Aksi");
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
			        	'deferRender' : true,
			        	'order'		: [], //ini jika menginginkan diorder
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
			        		{'data' : 'fv_kat'},
			        		{'data' : 'fv_subkat'},
			        		{'data' : 'fv_subsubkat'},
			        		{'mRender': function ( data, type, row ) {
	                       		if (row['fc_status'] == '1') {
	                       			return "Aktif";
	                       		}else{
	                       			return "Non Aktif";
	                       		}
	                    		},width:130
                			}
			        		<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
	                       		return "<?php if($update == '1'){?><button class='btn btn-danger' onclick=hapus('"+row['fc_kdsubsubkat']+"','"+row['fv_pict']+"')><i class='fa fa-close'></i></button><?php } ?>&nbsp;<?php if($delete =='1'){ ?><button class='btn btn-info' onclick=edit('"+row['fc_kdsubsubkat']+"')><i class='fa fa-pencil'></i></button><?php } ?>";
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
				function tambah(){
					document.getElementById('formAksi').reset();
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
							$('#kode_sub').val(responseText.fc_kdsubkat);    
			                $('#a1').val(responseText.fc_kdkat);           
			                $("select#a1").change();
			                $('#a3').val(responseText.fv_subsubkat);           
			                $('#a5').val(responseText.fc_status);           
			                $('#pict_detail_img').show();
			                document.getElementById('pict_detail_img').src="./assets/foto/"+responseText.fv_pict;
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
				$(document).on('change','#a4',function(e){
					$('#pict_detail_img').show();
					PreviewImage('pict_detail_img','a4');
				});
				$(document).on('change','#a1',function(e){
					$.get(link+"/getSubkategories/"+$("#a1").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#a2").html(data); 
		            	if ($("#aksi").val() == "update") {
		            		$("#a2").val($("[name='kode_sub']").val());
		            	}
		            });
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