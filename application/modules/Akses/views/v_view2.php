	
	<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Form <?php echo $this->uri->segment(1);?></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">

                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            
	            <!-- tabel mulai darisini -->
                
              <div class="row">
                <div class="col-md-6 col-xs-12" id="container_form">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2> Pengaturan Hak Akses <small id="rolename">-</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>                       
                      </ul>
                      <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                      <!-- start form for validation -->
                      <form id="form1" name="form1" data-parsley-validate="" novalidate="">
                        <input type="hidden" name="aksi" value="tambah">
                              <label for="heard">Select Group Role *:</label>
                              <select id="b0" name="b0" class="form-control" required>
                                <option value="">Choose option</option>
                                <?php echo $listdata;?>
                              </select>
                        <!-- end form for validations -->
                        <div class="divider-dashed"></div>
                        <div class="form-group">
                          <label class="control-label">Select Submenu :</label>
                            <select id="b1" name="b1[]" class="select2_multiple form-control" multiple="multiple" required>                            
                            </select>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <label class="control-label">Select Authorization :</label>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2a" value="Y"> View
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2b" value="Y"> Edit
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2c" value="Y"> Add
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="b2d" value="Y"> Delete
                                </label>
                              </div>
                        </div>
                        <div class="ln_solid"></div>
                          <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button type="reset" class="btn btn-primary">Reset</button>
                              <button id="b_simpan" type="submit" class="btn btn-success">Simpan</button>
                            </div>
                          </div>
                      </form>
                    </div>                    
                  </div>
                  <div class="content-box alert alert-info">
                      <div class="content-box-wrapper">
                        <p>
                          <ul>
                            <li>Tidak ada fitur edit, jadi apabila anda ingin mengubah hak akses view/add/edit/delete, 
                              maka data yang lama dihapus terlebih dahulu, kemudian ditambahkan lagi.</li>
                          </ul>
                        </p>
                      </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12" id="container_table">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Daftar Hak Akses <small></small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>                        
                      </ul>
                      <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                      <br>
                      <table id="datatable1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>                         
                              <th>Sub Menu</th>
                              <th>View</th>  
                              <th>Edit</th>                        
                              <th>Add</th>
                              <th>Delete</th> 
                              <?php if($aksesdata['delete'] == 'Y' || $aksesdata['edit'] == 'Y'){?>
                              <th>Aksi</th>
                              <?php } ?>                         
                            </tr>
                          </thead>                      
                      </table>
                    </div>
                  </div>
                </div>

              </div>  
              
            </div>
            <!-- untuk alertnya -->
            <div class="content-box alert-info" id="alert" style="display: none; width: 200px; height:70px; position:fixed; bottom:30px; right:30px; text-align:center; line-height: 400%;">
                <div class="content-box-wrapper">
                    <p id="msg"></p>
                </div>
            </div>

            <!-- table scripting -->
            <script type="text/javascript">   
                var link = '<?php echo site_url().'/'.$this->uri->segment(1); ?>'; 
                var drop = document.getElementById('b0'); 
                var table;            
                function init_DataTables( kode = '' ) {
                    (kode == '') ? $('#container_table').hide('fast') : $('#container_table').show('slow');

                    if (console.log("run-datatables-instance "+kode), "undefined" != typeof $.fn.DataTable) 
                    {
                        table = $("#datatable1").DataTable({
                            "processing": true,
                            "deferRender": true,
                            "ajax": 
                              {
                                "url": "<?php echo site_url($this->uri->segment(1).'/loaddata/"+kode+"');?>",
                                "dataType": "json",
                                "type": "POST"
                              },  
                            "columns" :
                            [                                 
                                {'data' : 'fv_submenu', width: 100 },                                
                                {'mRender': function ( data, type, row ) 
                                  { if ( row['fc_view'] == 'Y' ) { return "<input type='checkbox' name='bview' checked> "; } else { return "<input type='checkbox' name='bview'> "; }; }, width: 30
                                },
                                {'mRender': function ( data, type, row ) 
                                  { if ( row['fc_edit'] == 'Y' ) { return "<input type='checkbox' name='bedit' checked> "; } else { return "<input type='checkbox' name='bedit'> "; }; }, width: 30
                                },
                                {'mRender': function ( data, type, row ) 
                                  { if ( row['fc_add'] == 'Y' ) { return "<input type='checkbox' name='badd' checked> "; } else { return "<input type='checkbox' name='badd'> "; }; }, width: 30
                                },
                                {'mRender': function ( data, type, row ) 
                                  { if ( row['fc_delete'] == 'Y' ) { return "<input type='checkbox' name='bdelete' checked> "; } else { return "<input type='checkbox' name='bdelete'> "; }; }, width: 30
                                }
                                <?php if($aksesdata['delete'] == 'Y' || $aksesdata['edit'] == 'Y' ){ ?>
                                ,{'mRender': function ( data, type, row ) {
                                            return "<?php if($aksesdata['delete'] == 'Y'){?><button class='btn btn-round btn-danger btn-xs' onclick=hapus('"+row['fn_id']+"') title='hapus'><i class='fa fa-close'></i></button><?php } ?>&nbsp;";
                                },width:100 } 
                                <?php } ?>
                            ],
                            "destroy" : true 
                        }); 
                    }
                    //$('#rolename').innerHTML = "aku";
                    
                }
                function reload_table(){
                    table.ajax.reload( null,false );
                }
                function reload_list(){
                  var key = drop.options[ drop.selectedIndex ].text;                 
                    $.get(link+"/submenulist/"+key)
                          .done(function(datane) { 
                              $('#b1').html(datane);
                              var listmenu_to_select = document.getElementById('b1'); 
                              listmenu_to_select.size = listmenu_to_select.length; 
                              
                              init_DataTables( key ); 

                              (datane =='') ? $('#b_simpan').prop('disabled', true) : $('#b_simpan').prop('disabled', false);
                          });
                }
                function getsubmenulist(){
                  var key = drop.options[ drop.selectedIndex ].text;
                  $('#b0').change(function(){      
                     console.log(key);              
                     reload_list();                    
                  });                                   
                } 

                //ini untuk beberapa functionnya.                
                function alert(msg){
                  document.getElementById('msg').innerHTML = msg;
                  $('#alert').show('slow');
                  $('#alert').hide('slow');                  
                }                
                function hapus(kode){                  
                  if(confirm("["+kode+"] Apakah anda Yakin?? ")){
                    //hapus detailnya
                    $.get(link+"/Hapus/"+kode, $(this).serialize())
                          .done(function(data) { 
                            alert(data);                            
                            reload_table();
                            reload_list();
                          });
                          //--------------------------------
                      }
                }
                //ini untuk form on submitnya
                $(document).on('submit','#form1', function(e) { 
                    var key = drop.options[ drop.selectedIndex ].text; 
                    e.preventDefault(); 
                        $.ajax({
                            url: link+"/Simpan/"+key,
                            type: "POST",
                            data:  new FormData(this),
                            contentType: false,
                            cache: false,
                            processData:false,
                            success: function(data){   
                              alert(data);
                              reload_list();
                              reload_table();
                              
                            }           
                        });
                        return false; 
                }); 
                $( document ).ready( getsubmenulist );
            </script>
            <!-- /table scripting -->
        </div>

