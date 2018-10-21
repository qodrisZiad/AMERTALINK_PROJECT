            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Master <?php echo str_replace('/',' ',$sub_bread);?></h2>
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
								'a1'   => array('name'=>'a1','label' => 'Nik','type' => 'text','class' => 'form-control','col' => 'col-sm-2','readonly'=>'true'),
								'a16'   => array('name'=>'a16','label' => 'Cabang','type' => 'option','class' => 'form-control','col' => 'col-sm-2','option'=>$cabang),
								'a2'   => array('name'=>'a2','label' => 'Nama Depan','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a3'   => array('name'=>'a3','label' => 'Nama Belakang','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a4'   => array('name'=>'a4','label' => 'Jenis Kelamin','type' => 'option','class' => 'form-control','col' => 'col-sm-2','option'=>array('L'=>'Laki-Laki','P'=>'Perempuan')),
								'a5'   => array('name'=>'a5','label' => 'No.Ktp','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a6'   => array('name'=>'a6','label' => 'Tempat Lahir','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a7'   => array('name'=>'a7','label' => 'Tanggal Lahir','type' => 'date','class' => 'form-control','col' => 'col-sm-2'),
								'a8'   => array('name'=>'a8','label' => 'No.Hp','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a9'   => array('name'=>'a9','label' => 'No.Hp 2','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a10'   => array('name'=>'a10','label' => 'Alamat','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a11'   => array('name'=>'a11','label' => 'Alamat KTP','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a11'   => array('name'=>'a11','label' => 'Alamat KTP','type' => 'text','class' => 'form-control','col' => 'col-sm-4'),
								'a12'   => array('name'=>'a12','label' => 'Jabatan','type' => 'option','class' => 'form-control','col' => 'col-sm-2','option'=>$jabatan),
								'a13'   => array('name'=>'a13','label' => 'Tanggal Masuk','type' => 'date','class' => 'form-control','col' => 'col-sm-2'),
								'a14'   => array('name'=>'a14','label' => 'Foto','type' => 'file','class' => 'form-control','col' => 'col-sm-2'),
								'a15'   => array('name'=>'a15','label' => 'Status','type' => 'option','class' => 'form-control','col' => 'col-sm-2','option' => array('1'=>'Aktif','0' => 'Non Aktif')),
                     	);
                     	buat_form($data);  
                     	?>
                     	<div class="col-sm-4"><img src="" class="img-responsive avatar-view" id="avatar"></div>
                    </form> 
                    <form class="form-horizontal form-label-left" id="formUser" style="display: none;" method="post">
                    	<?php 
                    		$data_user = array(
                    			'aksi_user' => array('name' => 'aksi_user','type' => 'hidden'),
								'kode_user' => array('name'=>'kode_user','type' => 'hidden'),
								'branch_user' => array('name'=>'branch_user','type' => 'hidden'),
								'b1'   => array('name'=>'b1','label' => 'Username','type' => 'text','class' => 'form-control','col' => 'col-sm-2'),
								'b2'   => array('name'=>'b2','label' => 'Password','type' => 'text','class' => 'form-control','col' => 'col-sm-4')
                    		);
                    		buat_form($data_user);
                    	?>
                    	<p><span style="color:red">*</span>Kosongkan password jika tidak ingin dihapus</p>
                    </form>
					<div id="laporan" style="overflow: scroll;">
						<?php 
							$kolom = array("No.","AKSI","NIK","NAMA PANJANG","SEX","KTP","TP LAHIR","TGL LAHIR","HP","HP2","ALAMAT KTP","ALAMAT","TGL MASUK","JABATAN","STATUS");
							buat_table($kolom,"datatable");   
						?>
					</div> 
                  </div>
                </div>
              </div> 
            </div> 

            <script type="text/javascript">
            	var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
            	var table,tableIn,tableOut;
            	$(document).ready(function(){
            		datatable();
            	});
            	//untuk data karyawan tablenya
            	function datatable(){
            		table = $('#datatable').DataTable({
			        	'processing': true, //ini untuk menampilkan processing
			        	'serverSide': true, //iini untuk serversidenya
			        	'order'		: [], //ini jika menginginkan diorder
			        	'language'  :{
			        		'searchPlaceholder' : "Cari nama karyawan"
			        	},
			        	'ajax':{
			        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data');?>",
			        		"dataType": "json",
			        		'type'	: 'POST' 
			        	},//pasangkan hasil dari ajax ke datatablesnya
			        	'columns'	:[
			        		{'data' : 'no',width:20},   
			        		<?php if($delete=='1' || $update =='1'){ ?>{'mRender': function ( data, type, row ) { 
	                       		return "<div class='x_content'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-primary dropdown-toggle btn-sm' type='button' aria-expanded='false'>Aksi<span class='caret'></span></button><ul role='menu' class='dropdown-menu'><?php if($update =='1'){?><li><a href='#' onclick=edit('"+row['fc_nik']+"')>Ubah</a></li> <?php } ?> <?php if($delete =='1'){ ?><li><a href='#' onclick=hapus('"+row['fc_nik']+"')>Hapus</a></li> <?php } ?> <li class='divider'></li><li><a href='#' onclick=setUser('"+row['fc_nik']+"','"+row['fc_branch']+"')>Set User</a></li></ul></div></div>";
	                    		}
                			} <?php  }else{ ?>
                				{'mRender': function ( data, type, row ) {
	                       		return "Akses ditutup";
	                    		}
                			}	
                			<?php } ?>,
			        		{'data' : 'fc_nik'},  
			        		{'mRender':function(data,type,row){
			        				return row['fv_sname']+" "+row['fv_lname'];
			        			}
			        		},  
			        		{'data' : 'sex'},  
			        		{'data' : 'fc_ktp'},  
			        		{'data' : 'fv_tmp_lahir'},  
			        		{'data' : 'fd_lahir'},  
			        		{'data' : 'fc_hp'},  
			        		{'data' : 'fc_hp2'},  
			        		{'data' : 'fv_addr_ktp'},  
			        		{'data' : 'fv_addr'},  
			        		{'data' : 'fd_masuk'},  
			        		{'data' : 'fv_jabatan'},  
			        		{'mRender' : function (data,type,row) {
			        			var hasil = "";
			        				if (row['fc_status'] == '1') {
			        					hasil = "Aktif";
			        				}else if (row['fc_status'] == '0'){
			        					hasil = "Non Aktif";
			        				}else{
			        					hasil = "-";
			        				}

			        				return hasil;
			        			}
			        		}
			        	]  
			        }); 
            	}
            	function reload_table(){
			    	table.ajax.reload(null,false);
			    } 
			    // 
				function tambah(){
					document.getElementById('formAksi').reset();
					document.getElementById('avatar').src="";
					$('#a1').val(getNomor('NIK'));
					$('#laporan').slideUp('slow');
					$('#formAksi').slideDown('slow');
					$('#close_form').fadeIn('slow');
					$('#add_form').fadeOut('slow');
					$('#aksi').val('tambah');
				}
				function tutup(){
					document.getElementById('avatar').src="";
					$('#formAksi').slideUp('slow');
					$('#formUser').slideUp('slow');
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
			            	$('#laporan').slideUp('slow');
							$('#formAksi').slideDown('slow');
							$('#close_form').fadeIn('slow');
							$('#add_form').fadeOut('slow'); 
			              	$('#aksi').val('update');
							$('#kode').val(responseText.fc_nik);    
			                $('#a1').val(responseText.fc_nik); 
			                $('#a2').val(responseText.fv_sname);           
			                $('#a3').val(responseText.fv_lname);           
			                $('#a4').val(responseText.fc_sex);           
			                $('#a5').val(responseText.fc_ktp);           
			                $('#a6').val(responseText.fv_tmp_lahir);
			                $('#a7').val(responseText.fd_lahir);
			                $('#a8').val(responseText.fc_hp);
			                $('#a9').val(responseText.fc_hp2);
			                $('#a10').val(responseText.fv_addr);
			                $('#a11').val(responseText.fv_addr_ktp);
			                $('#a12').val(responseText.fc_jabatan);
			                $('#a13').val(responseText.fd_masuk);
			                $('#a15').val(responseText.fc_status);
			                $('#a16').val(responseText.fc_branch);
			                document.getElementById('avatar').src = "<?= base_url();?>assets/foto/"+responseText.fv_pict;
			            }
			        });
				}
				function setUser(kode,branch){ 
					$.ajax({
			            type: 'GET',
			            dataType:'JSON',
			            url: link+"/getUser/"+branch+"/"+kode,
			            success:function(responseText){
			            	document.getElementById("formUser").reset();
			            if (responseText == null) {
			              	$('#aksi_user').val('tambah');
			            } else{
			              	$('#aksi_user').val('update');
			              	$('#b1').val(responseText.fc_userid);
			            }
			            	$('#laporan').slideUp('slow');
							$('#formUser').slideDown('slow');
							$('#close_form').fadeIn('slow');
							$('#add_form').fadeOut('slow'); 
							$('#kode_user').val(kode);    
							$('#branch_user').val(branch);   
			            }
			        });
				}
				function getNomor(document){ 
					$.get(link+"/getNomor/"+document, $(this).serialize())
			            .done(function(data) { 
			            	$('#a1').val(data);
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
			            	if ($("#aksi").val() == "tambah") {
			            		tambah();
			            	}else if ($("#aksi").val() == "update"){
			            		tutup();
			            	}
			            	display_message(data);
			            }           
			        });
			        return false;  
				});

				$(document).on('submit','#formUser',function(e){
					e.preventDefault();
					$.ajax({
						url:link+"/SimpanUser",
						type:"POST",
						data : new FormData(this),
						contentType:false,
						cache:false,
						processData:false,
						success:function(data){
							tutup();
							display_message(data);
						}
					});
					return false;
				});  
				
            </script>   