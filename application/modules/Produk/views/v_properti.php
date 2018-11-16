       		<div id="Properti" style="display:none;">
       			<form class="form-horizontal form-label-left" id="formProperti" method="post">
                 	<?php 
                 	$data = array(
                 		'aksi_prop' => array('name' => 'aksi_prop','type' => 'hidden'), 
                 		'sku_prop' => array('name'=>'sku_prop','type' => 'hidden'), 
                 		'kode_sub_prop' => array('name'=>'kode_sub_prop','type' => 'hidden'), 
                 		'b1' => array('name'=>'b1','label' => 'Properti','type' => 'option','class' => 'form-control','option' => $Properti,'col' => 'col-sm-4'),
                 		'b2' => array('name'=>'b2','label' => 'Sub Properti','type' => 'option','class' => 'form-control','option' => "",'col' => 'col-sm-4')
                 	);
                 	buat_form($data);  
                 	?>
                </form>
                <?php 
					$kolom_Prop = array("No.","Properti","Sub Properti","User Input","Tgl Update","Aksi");
					buat_table($kolom_Prop,"datatable_Prop");   
				?> 
       		</div> 

    <script type="text/javascript">
    	var table2;  
       	function setProperti(kode){
       		document.getElementById('bread').innerHTML = 'Master Properti';
       		$('#laporan').slideUp('slow');  
       		$('#Properti').slideDown('slow');
			$('#close_form').fadeIn('slow');
			$('#add_form').fadeOut('slow');
			$('[name="sku_prop"]').val(kode);
			$('[name="aksi_prop"]').val("tambah");
			datatable_Prop();
       	}
       	$(document).on('change','#b1',function(e){
			$.get(link+"/getSubProp/"+$("[name='sku_prop']").val()+"/"+$("#b1").val(), $(this).serialize())
            .done(function(data) { 
            	$("select#b2").html(data); 
            });
		});
		$(document).on('submit','#formProperti',function(e){
			e.preventDefault();
			$.ajax({
	            url: link+"/SimpanProp",
	            type: "POST",
	            data:  new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(datane){ 
            		reload_tableProp();
            		$("#b1").val(""); 
            		$("#b2").val(""); 
            		display_message(datane); 
            	}      
	        });
	        return false;  
		}); 
		function delProp(kode){
			if(confirm("Apakah anda Yakin?")){ 
				$.get(link+"/HapusProp/"+kode, $(this).serialize())
	            .done(function(data) { 
	            	reload_tableProp();
	            	display_message(data);
	            });
	            //--------------------------------
	        }
		} 
		function datatable_Prop(){
			table2 = $('#datatable_Prop').DataTable({
	        	'processing': true, //ini untuk menampilkan processing
	        	'serverSide': true, //iini untuk serversidenya
	        	'order'		: [], //ini jika menginginkan diorder
	        	'destroy'	: true,
	        	'language'  : {
	        		'searchPlaceholder': "Cari"
	        	},
	        	'ajax':{
	        		'url'	: "<?php echo site_url($this->uri->segment(1).'/data_Prop/');?>"+$('[name="sku_prop"]').val(),
	        		"dataType": "json",
	        		'type'	: 'POST' 
	        	},//pasangkan hasil dari ajax ke datatablesnya
	        	'columns'	:[
	        		{'data' : 'no',width:20}, 
	        		{'data' : 'fv_prop'},
	        		{'data' : 'fv_subprop'},
	        		{'data' : 'fc_userid'}, 
	        		{'data' : 'fd_last_update'} 
	        		<?php if($delete=='1' || $update =='1'){ ?>,{'mRender': function ( data, type, row ) {
	               		return "<?php if($delete == '1'){?><button class='btn btn-danger' onclick=delProp('"+row['fc_id']+"')><i class='fa fa-close'></i></button><?php } ?>";
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
       function reload_tableProp(){table2.ajax.reload(null,false);}  
    </script>   