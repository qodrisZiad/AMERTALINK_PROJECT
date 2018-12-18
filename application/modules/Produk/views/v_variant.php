       		<div id="Variant" style="display:none;">
       			<form class="form-horizontal form-label-left" id="formVariant" method="post">
                 	<?php 
                 	$data = array(
                 		'aksi_variant' => array('name' => 'aksi_variant','type' => 'hidden'), 
                 		'kode_variant' => array('name' => 'kode_variant','type' => 'hidden'), 
                 		'sku_variant' => array('name'=>'sku_variant','type' => 'hidden'),  
                 		'c1' => array('name'=>'c1','label' => 'Ukuran','type' => 'option','class' => 'form-control','option' => $ukuran,'col' => 'col-sm-2'),
						'c2' => array('name'=>'c2','label' => 'Warna','type' => 'option','class' => 'form-control','option' => $warna,'col' => 'col-sm-2'),
						'c3' => array('name'=>'c3','label' => 'Harga Beli','type' => 'text','class' => 'form-control','defaultValue' => '0','col' => 'col-sm-2'),
						'c4' => array('name'=>'c4','label' => 'Harga Jual','type' => 'text','class' => 'form-control','defaultValue' => '0','col' => 'col-sm-2'),
						 
                 	);
                 	buat_form($data);  
                 	?>
                </form>
                <?php 
					$kolom_Prop = array("No.","Ukuran","Warna","Harga Beli","Harga Jual","User Input","Aksi");
					buat_table($kolom_Prop,"datatable_Variant");   
				?> 
       		</div> 
    <script type="text/javascript">
    	var table3;  
       	function setVariant(kode){
       		document.getElementById('bread').innerHTML = 'Master Variant';
       		$('#laporan').slideUp('slow');  
       		$('#Variant').slideDown('slow');
			$('#close_form').fadeIn('slow');
			$('#add_form').fadeOut('slow');
			$('[name="sku_variant"]').val(kode);
			$('[name="aksi_variant"]').val("tambah");
			datatable_Variant();
       	} 
		$(document).on('submit','#formVariant',function(e){
			e.preventDefault();
			$.ajax({
	            url: link+"/SimpanVariant",
	            type: "POST",
	            data:  new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(datane){ 
            		reload_tableVariant();
            		$("#c1").val(""); $("#c3").val("");
            		$("#c2").val(""); $("#c4").val("");
            		display_message(datane); 
            	}      
	        });
	        return false;  
		}); 
		function delVariant(kode){
			if(confirm("Apakah anda Yakin?")){ 
				$.get(link+"/HapusVariant/"+kode, $(this).serialize())
	            .done(function(data) { 
	            	reload_tableVariant();
	            	display_message(data);
	            });
	        }
		} 
		function datatable_Variant(){
			table3 = $('#datatable_Variant').DataTable({
	        	'processing': true, //ini untuk menampilkan processing
	        	'serverSide': true, //iini untuk serversidenya
	        	'order'		: [], //ini jika menginginkan diorder
	        	'destroy'	: true,
	        	'language'  : {
	        		'searchPlaceholder': "Cari"
	        	},
	        	'ajax':{
	        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data_Variant/');?>"+$('[name="sku_variant"]').val(),
	        		"dataType": "json",
	        		'type'	: 'POST' 
	        	},//pasangkan hasil dari ajax ke datatablesnya
	        	'columns'	:[
	        		{'data' : 'no',width:20}, 
	        		{'data' : 'fv_size'},
	        		{'data' : 'fv_warna'},
					{'data' : 'fn_hargabeli'},
					{'data' : 'fn_hargajual'},
	        		{'data' : 'fc_userid'},  
	        		<?php if($delete=='1' || $update =='1'){ ?>{'mRender': function ( data, type, row ) {
	               		return "<?php if($delete == '1'){?><button class='btn btn-danger' onclick=delVariant('"+row['fc_variant']+"')><i class='fa fa-close'></i></button><?php } ?>";
	            		},width:130
	    			} <?php  }else{ ?>
	    				{'mRender': function ( data, type, row ) {
	               		return "Akses ditutup";
	            		},width:130
	    			}	
	    			<?php } ?> 
	        	]   
	        });
		}
       function reload_tableVariant(){table3.ajax.reload(null,false);}  
    </script>   