            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Master Supplier</h2>
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
                     <form class="form-horizontal form-label-left" id="formAksi" style="display: none;" method="post">
                     	<?php 
                     	$data = array(
                     		'aksi' => array('name' => 'aksi','type' => 'hidden'), 
                     		'a1' => array('name'=>'a1','label' => 'Kode Supplier','type' => 'text','class' => 'form-control','col' => 'col-sm-4','readonly' => 'true'), 
                     		'a2' => array('name'=>'a2','label' => 'Supplier','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a3' => array('name'=>'a3','label' => 'Alamat','type' => 'text','class' => 'form-control','col' => 'col-sm-6'), 
                     		'a4' => array('name'=>'a4','label' => 'Telp 1','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a5' => array('name'=>'a5','label' => 'Telp 2','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a6' => array('name'=>'a6','label' => 'Owner','type' => 'text','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a7' => array('name'=>'a7','label' => 'Tanggal Kunjungan','type' => 'date','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a8' => array('name'=>'a8','label' => 'Tanggal Join','type' => 'date','class' => 'form-control','col' => 'col-sm-4'), 
                     		'a9' => array('name'=>'a9','label' => 'Aktif','type' => 'option','class' => 'form-control','option' => array('1'=>'Aktif','0'=>'Non Aktif'),'col' => 'col-sm-2')
                     	);
                     	buat_form($data);  
                     	?>
                    </form> 
					<div id="laporan"> 
						<?php 
							$kolom = array("No.","Aksi","Kode","Supplier","Alamat","Telp","Owner","Tgl Join","Tgl Kunjungan","Hutang","Terakhir Transaksi","User Input","Status");
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
			        		<?php if($delete=='1' || $update =='1'){ ?>{'mRender': function ( data, type, row ) {
	                       		return "<div class='x_content'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-primary dropdown-toggle btn-sm' type='button' aria-expanded='false'>Aksi<span class='caret'></span></button><ul role='menu' class='dropdown-menu'><?php if($update =='1'){?><li><a href='#' onclick=edit('"+row['fc_kdsupplier']+"')>Ubah</a></li> <?php } ?> <?php if($delete =='1'){ ?><li><a href='#' onclick=hapus('"+row['fc_kdsupplier']+"')>Hapus</a></li> <?php } ?> <li class='divider'></li></ul></div></div>";
	                    		},width:120
                			} <?php  }else{ ?>
                				,{'mRender': function ( data, type, row ) {
		                       		return "Akses ditutup";
		                    		},width:130
                				}	
                			<?php } ?>,
			        		{'data' : 'fc_kdsupplier'},
			        		{'data' : 'fv_supplier'},
			        		{'data' : 'fv_addr'}, 
			        		{'mRender': function ( data, type, row ) {
		                       		return row['fc_telp']+" / "+row['fc_telp2'];
		                    		},width:130
                			}, 
                			{'data' : 'fv_owner'},
                			{'data' : 'fd_join'},
                			{'data' : 'fd_kunjungan'},
                			{'mRender': function ( data, type, row ) {
		                       		return "Rp."+rupiah(row['fn_hutang']);
		                    		},width:130
                			},
                			{'data' : 'fd_last_trans'},
                			{'data' : 'fc_userid'},  
                			{'mRender': function ( data, type, row ) {
	                       		if (row['fc_status'] == '1') {
	                       			return "Aktif";
	                       		}else{
	                       			return "Non Aktif";
	                       		}
	                    		},width:130
                			},  
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
					document.getElementById('formAksi').reset();
					$('#aksi').val('tambah');
					$('#a1').val('<?php echo getNomor("SUPL"); ?>');
				}
				function tutup(){
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
			                $('input[name="a1"]').val(responseText.fc_kdsupplier);           
			                $('input[name="a2"]').val(responseText.fv_supplier);           
			                $('input[name="a3"]').val(responseText.fv_addr);           
			                $('input[name="a4"]').val(responseText.fc_telp);
			                $('input[name="a5"]').val(responseText.fc_telp2);
			                $('input[name="a6"]').val(responseText.fv_owner);
			                $('input[name="a7"]').val(responseText.fd_kunjungan);
			                $('input[name="a8"]').val(responseText.fd_join);
			                $('#a9').val(responseText.fc_status);
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
            </script>   