            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Master Properti</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                      <li><a><i class=""></i></a></li>
                      <?php if($input=='Y'){?><li id="add_form"><a><i class="fa fa-plus" onclick="tambah()"></i></a></li><?php }?>
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
                     		'a1' => array('name'=>'a1','label' => 'Properti','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a2' => array('name'=>'a2','label' => 'Aktif','type' => 'option','class' => 'form-control','option' => array('1'=>'Aktif','0'=>'Non Aktif'),'col' => 'col-sm-2')
                     	);
                     	buat_form($data);  
                     	?> 
                    </form>  
                    <form class="form-horizontal form-label-left" id="formDetail" style="display: none;" method="post" enctype="multipart/form-data">
                     	<?php 
                     	$data = array(
                     		'aksiDetail' => array('name' => 'aksiDetail','type' => 'hidden'),
                     		'kodeMaster' => array('name'=>'kodeMaster','type' => 'hidden'),
                     		'kodeDetail' => array('name'=>'kodeDetail','type' => 'hidden'),
                     		'kode_sub' => array('name'=>'kode_sub','type' => 'hidden'),
                     		'kode_sub_sub' => array('name'=>'kode_sub_sub','type' => 'hidden'),
                     		'b1' => array('name'=>'b1','label' => 'Kategori','type' => 'option','class' => 'form-control','option' => $kategori,'col' => 'col-sm-4'),
                     		'b2' => array('name'=>'b2','label' => 'Sub Kategori','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-4'),
                     		'b3' => array('name'=>'b3','label' => 'Sub Sub Kategori','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-4'),
                     		'b4' => array('name'=>'b4','label' => 'Sub Properti','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'b5' => array('name'=>'b5','label' => 'Aktif','type' => 'option','class' => 'form-control','option' => array('1'=>'Aktif','0'=>'Non Aktif'),'col' => 'col-sm-2')
                     	);
                     	buat_form($data);  
                     	?> 
                    </form> 
                    <div id="lapDetail">
                    	<?php 
							$kolomDetail = array("No.","Aksi","Kategori","Sub Kategori","Sub Sub Kategori","Sub Properti","Status");
							buat_table($kolomDetail,"datatable2");   
						?>
                    </div> 
					<div id="laporan">  
						<?php 
							$kolom = array("No.","Aksi","Properti","Status");
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
            		$('#lapDetail').fadeOut('slow'); 
            	});
            	function datatable(){
            		$('#laporan').fadeIn('slow'); 
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
			        		<?php if($delete=='Y' || $update =='Y'){ ?>{'mRender': function ( data, type, row ) {
	                       		return "<div class='x_content'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-primary dropdown-toggle btn-sm' type='button' aria-expanded='false'>Aksi<span class='caret'></span></button><ul role='menu' class='dropdown-menu'><?php if($update == 'Y'){?><li><a href='#' onclick=edit('"+row['fc_kdprop']+"')>Ubah</a></li> <?php } ?> <?php if($delete =='Y'){ ?><li><a href='#' onclick=hapus('"+row['fc_kdprop']+"')>Hapus</a></li> <?php } ?> <li class='divider'></li>  <li><a href='#' onclick=setDetail('"+row['fc_kdprop']+"')>Set Detail</a></li></ul></div></div>";
	                    		},width:120
                			} <?php  }else{ ?>
                				,{'mRender': function ( data, type, row ) {
	                       		return "Akses ditutup";
	                    		},width:130
                			}	
                			<?php } ?>,
			        		{'data' : 'fv_prop'},
			        		{'mRender': function ( data, type, row ) {
	                       		if (row['fc_status'] == '1') {
	                       			return "Aktif";
	                       		}else{
	                       			return "Non Aktif";
	                       		}
	                    		},width:130
                			} 
			        	]  
			        }); 
            	}
            	function datatable2(){
            		$('#lapDetail').slideDown('slow');
            		table = $('#datatable2').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'destroy'	: true,
			        	'language'  : {
			        		'searchPlaceholder': "Cari"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/dataDetail/');?>"+$('[name="kodeMaster"]').val(),
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20}, 
			        		<?php if($delete=='Y' || $update =='Y'){ ?>{'mRender': function ( data, type, row ) {
	                       		return "<div class='x_content'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-primary dropdown-toggle btn-sm' type='button' aria-expanded='false'>Aksi<span class='caret'></span></button><ul role='menu' class='dropdown-menu'><?php if($update == 'Y'){?><li><a href='#' onclick=editDetail('"+row['fc_kdsubprop']+"')>Ubah</a></li> <?php } ?> <?php if($delete =='Y'){ ?><li><a href='#' onclick=hapusDetail('"+row['fc_kdsubprop']+"')>Hapus</a></li> <?php } ?> </ul></div></div>";
	                    		},width:120
                			} <?php  }else{ ?>
                				,{'mRender': function ( data, type, row ) {
	                       		return "Akses ditutup";
	                    		},width:130
                			}	
                			<?php } ?>,
			        		{'data' : 'fv_kat'},
			        		{'data' : 'fv_subkat'},
			        		{'data' : 'fv_subsubkat'},
			        		{'data' : 'fv_subprop'},
			        		{'mRender': function ( data, type, row ) {
	                       		if (row['fc_status'] == '1') {
	                       			return "Aktif";
	                       		}else{
	                       			return "Non Aktif";
	                       		}
	                    		},width:130
                			} 
			        	]  
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
					document.getElementById("formAksi").reset();
				}
				function tutup(){
					$('#pict_detail_img').hide();
					$('#formAksi').slideUp('slow');
					$('#formDetail').slideUp('slow');
					$('#laporan').slideDown('slow');
					$('#lapDetail').slideUp('slow');
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
			                $('input[name="a1"]').val(responseText.fv_prop);
			                $('#a2').val(responseText.fc_status);           
			            }
			        });
				}
				function editDetail(kode){ 
					$.ajax({
			            type: 'GET',
			            dataType:'JSON',
			            url: link+"/EditDetail/"+kode,
			            success:function(responseText){ 
			              	$('#aksiDetail').val('update');
							$('#kodeDetail').val(kode);    
			                $('#b1').val(responseText.fc_kat);           
			                $("select#b1").change();  
			                $('[name="kode_sub"]').val(responseText.fc_subkat); 
			                $('[name="kode_sub_sub"]').val(responseText.fc_subsubkat); 
			                $("#b4").val(responseText.fv_subprop);
			                $("#b5").val(responseText.fc_status);
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
				function hapusDetail(kode){
					if(confirm("Apakah anda Yakin?")){ 
						$.get(link+"/HapusDetail/"+kode, $(this).serialize())
			            .done(function(data) { 
			            	display_message(data);
			            	datatable2();
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
				$(document).on('submit','#formDetail',function(e){
					e.preventDefault();
					$.ajax({
			            url: link+"/SimpanDetail",
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
			            	datatable2();
			            }           
			        });
			        return false;  
				});
				$(document).on('change','#a2',function(e){
					PreviewImage('pict_detail_img','a2');
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
				function setDetail(kode){
					$('#laporan').slideUp('slow');
					$('#formDetail').slideDown('slow');
					$('#close_form').fadeIn('slow');
					$('#add_form').fadeOut('slow');
					document.getElementById("formDetail").reset();
					$('#aksiDetail').val('tambah'); 
					$('[name="kodeMaster"]').val(kode);
					$("#b2").html("");
					$("#b3").html("");
					datatable2();
				}
				$(document).on('change','#b1',function(e){
					$.get(link+"/getSubkategories/"+$("#b1").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b2").html(data); 
		            	if ($("#aksiDetail").val() == "update") {
		            		$("#b2").val($("[name='kode_sub']").val());
		            		$("select#b2").change();
		            	}
		            });
				});
				$(document).on('change','#b2',function(e){
					$.get(link+"/getSubSubkategories/"+$("#b1").val()+"/"+$("#b2").val(), $(this).serialize())
		            .done(function(data) { 
		            	$("select#b3").html(data); 
		            	if ($("#aksiDetail").val() == "update") {
		            		$("#b3").val($("[name='kode_sub_sub']").val());
		            	}
		            });
				});
            </script>   