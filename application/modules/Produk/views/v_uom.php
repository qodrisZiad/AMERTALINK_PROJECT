       		<div id="Uom" style="display:none;">
       			<form class="form-horizontal form-label-left" id="formuom" method="post">
                 	<?php 
                 	$data = array(
                 		'aksi_uom' => array('name' => 'aksi_uom','type' => 'hidden'), 
                 		'kode_uom' => array('name' => 'kode_uom','type' => 'hidden'), 
                 		'sku_uom' => array('name'=>'sku_uom','type' => 'hidden'),  
                 		'd1' => array('name'=>'d1','label' => 'Satuan','type' => 'option','class' => 'form-control','option' => $Satuan,'col' => 'col-sm-2'),
                 		'd2' => array('name'=>'d2','label' => 'Nilai','type' => 'number','class' => 'form-control','col' => 'col-sm-2')
                 	);
                 	buat_form($data);  
                 	?>
                </form>
                <?php 
					$kolom_Prop = array("No.","Satuan","Nilai","Default","Userid","Aksi");
					buat_table($kolom_Prop,"datatable_uom");   
				?> 
       		</div> 

    <script type="text/javascript">
    	var table4;  
       	function setUom(kode){
       		document.getElementById('bread').innerHTML = 'Master Uom';
       		$('#laporan').slideUp('slow');  
       		$('#Uom').slideDown('slow');
			$('#close_form').fadeIn('slow');
			$('#add_form').fadeOut('slow');
			$('[name="sku_uom"]').val(kode);
			$('[name="aksi_uom"]').val("tambah");
			datatable_uom();
       	} 
		$(document).on('submit','#formuom',function(e){
			e.preventDefault();
			$.ajax({
	            url: link+"/SimpanUom",
	            type: "POST",
	            data:  new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(datane){ 
            		reload_tableUom();
            		$("#d1").val(""); 
            		$("#d2").val(""); 
            		display_message(datane); 
            	}      
	        });
	        return false;  
		}); 
		function delUom(kode){
			if(confirm("Apakah anda Yakin?")){ 
				$.get(link+"/HapusUom/"+kode, $(this).serialize())
	            .done(function(data) { 
	            	reload_tableUom();
	            	display_message(data);
	            });
	        }
		} 
		function datatable_uom(){
			table3 = $('#datatable_uom').DataTable({
	        	'processing': true, //ini untuk menampilkan processing
	        	'serverSide': true, //iini untuk serversidenya
	        	'order'		: [], //ini jika menginginkan diorder
	        	'destroy'	: true,
	        	'language'  : {
	        		'searchPlaceholder': "Cari"
	        	},
	        	'ajax':{
	        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data_Uom/');?>"+$('[name="sku_uom"]').val(),
	        		"dataType": "json",
	        		'type'	: 'POST' 
	        	},//pasangkan hasil dari ajax ke datatablesnya
	        	'columns'	:[
	        		{'data' : 'no',width:20}, 
	        		{'data' : 'fv_satuan'},
	        		{'data' : 'fn_uom'},
	        		{'mRender': function ( data, type, row ) {
                   		if (row['fc_default'] == '1') {
                   			return "Ya";
                   		}else{
                   			return "Tidak";
                   		}
                		},width:30
        			},
	        		{'data' : 'fc_userid'},  
	        		<?php if($delete=='1' || $update =='1'){ ?>{'mRender': function ( data, type, row ) {
	               		return "<?php if($delete == '1'){?><button class='btn btn-danger' onclick=delUom('"+row['fc_uom']+"')><i class='fa fa-close'></i></button><?php } ?>";
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
       function reload_tableUom(){table3.ajax.reload(null,false);}   
    </script>   