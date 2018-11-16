       		<div id="gambar" style="display:none;">
       			<form class="form-horizontal form-label-left" id="formImg" method="post" enctype="multipart/form-data">
                 	<?php 
                 	$data = array(
                 		'aksi_img' => array('name' => 'aksi_img','type' => 'hidden'),  
                 		'sku_img' => array('name'=>'sku_img','type' => 'hidden'),  
                 		'e1' => array('name'=>'e1','label' => 'Warna','type' => 'option','class' => 'form-control','option' => '','col' => 'col-sm-4'),
                 		'e2' => array('name'=>'e2','label' => 'Gambar','type' => 'file','class' => 'form-control','col' => 'col-sm-2')
                 	);
                 	buat_form($data);  
                 	?>
                </form>
       		</div>
          </div>
        </div>
      </div> 
    </div> 
			    <div id="laporan_gambar"></div>
	<script type="Text/Javascript">
		function setFoto(kode){
			$('[name="aksi_img"]').val("tambah");
			$('[name="sku_img"]').val(kode);
			$('#laporan').slideUp('slow');
			$('#gambar').slideDown('slow');
			$('#close_form').fadeIn('slow');
			$('#add_form').fadeOut('slow');
			document.getElementById('bread').innerHTML = 'Master Gambar';
			buatThumbnail(kode); 
			getWarnaProduk(kode);
		}
		function buatThumbnail(kode){
				var data = "";
				$.ajax({
					type: 'GET',
					dataType:'JSON',
					url: link+"/getImage/"+kode,
					success:function(obj){  
						for(var i = 0;i < obj.length ;i++){ 
							data +=  '<div class="col-md-3 col-xs-12 widget widget_tally_box"><div clsas="x_panel"><div class="col-md-12">'+
										'<div class="thumbnail" style="min-height: 251px !important;">'+
											'<div class="image view view-first" style="height:240px !important">'+
												'<img style="width: 100%;height:118%;display: block;" src="<?= site_url() ?>assets/foto/'+obj[i].fv_img+'" alt="image" />'+
												'<div class="mask" style="height:240px !important">'+
													'<p>Kode Variant : '+obj[i].fv_warna+'</p>'+
													'<div class="tools tools-bottom">'+ 
														"<a style='cursor:pointer;' onclick=hapus_img('"+obj[i].fc_id+"','"+obj[i].fv_img+"')><i class='fa fa-times'></i></a>"+
													'</div>'+
												'</div>'+
											'</div>'+  
										'</div>'+
									'</div></div></div>';
						}  
						document.getElementById('laporan_gambar').innerHTML = data;
					}
				});  
		}
		function getWarnaProduk(kode){
			$.get(link+"/warnaProduk/"+kode, $(this).serialize())
			.done(function(data) { 
				$("select#e1").html(data);
			});
		}
		function hapus_img(kode,gambar){
			if(confirm("Apakah anda Yakin?")){ 
				$.get(link+"/HapusImg/"+kode+"/"+gambar, $(this).serialize())
	            .done(function(data) { 
	            	display_message(data);
	            	buatThumbnail($('[name="sku_img"]').val());
	            	getWarnaProduk($('[name="sku_img"]').val());
	            });
	            //--------------------------------
	        }
		}
		$(document).on("submit","#formImg",function(e){
			e.preventDefault(); 
			$.ajax({
	            url: link+"/SimpanImg",
	            type: "POST",
	            data:  new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(data){  
	            	display_message(data);
	            	buatThumbnail($('[name="sku_img"]').val());
	            	getWarnaProduk($('[name="sku_img"]').val());
	            }           
	        });
			return false;
		});
	</script>

       