            <div class="clearfix"></div>
            <div class="row">
            	<!-- master -->
              <div class="col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Purchase Order</h2> 
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<div id="alert_trans" class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                     Transaksi berhasil 
                   </div>   
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps" style="height: auto;">
                        <li>
                          <a href="#step-1" id="step1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                              Step 1<br />
                              <small>Input Data Master</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                              Step 2<br />
                              <small>Input Data Detail</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                              Step 3<br />
                              <small>Finalisasi</small>
                            </span>
                          </a>
                        </li> 
                      </ul>
                      <h3 style="display:none;" class="StepTitle">Mengambil informasi server...</h3>
                      <!-- Input data master -->
                      <div id="step-1"> 
                          <form class="form-horizontal form-label-left" id="formMaster" name="formMaster" method="POST" style="overflow: hidden;">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a1">No.PO 
                                  </label>
                                  <div class="col-md-6">
                                    <input type="text" id="a1" name="a1"  class="form-control" value="admin" readonly>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a2">Tgl.PO 
                                  </label>
                                  <div class="col-md-6" >
                                    <div class='input-group date' id='tanggal'>
                                      <input type='text' class="form-control" name="a2" value="<?= date('d-m-Y');?>" />
                                      <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                   </div>
                                 </div>
                                </div>
                                <div class="form-group">
                                <label class="control-label col-md-6" for="a3">Supplier 
                                </label>
                                <div class="col-md-6" >
                                  <select id="a3" name="a3" class="form-control">
                                    <?php 
                                    foreach (getSupplier() as $key => $value) {
                                      echo "<option value='".$key."'>".$value."</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                                </div> 
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a4">Untuk Cabang 
                                  </label>
                                  <div class="col-md-6" >
                                    <select id="a4" name="a4" class="form-control">
                                      <?php 
                                      foreach (getBranch() as $key => $value) {
                                        echo "<option value='".$key."'>".$value."</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <input type="hidden" id="temp_gudang">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a5">Gudang 
                                  </label>
                                  <div class="col-md-6" >
                                    <select id="a5" name="a5" class="form-control"> 
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="a6">Perkiraan Datang 
                                  </label>
                                  <div class="col-md-6" >
                                    <div class='input-group date' id='tanggal'>
                                      <input type='text' class="form-control" name="a6" value="<?= date('d-m-Y');?>"/>
                                      <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                   </div>
                                 </div>
                               </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a7">Qty Item 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a7" name="a7"  class="form-control" value="0" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a8">Total 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a8" name="a8"  class="form-control" value="0" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a9">Catatan 
                                </label>
                                <div class="col-md-6">
                                  <textarea class="form-control" name="a9" id="a9"></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a10">Tgl Input 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a10" name="a10"  class="form-control" value="<?= date('d-m-Y');?>" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="a11">User Input 
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="a11" name="a11"  class="form-control" value="<?= $this->session->userdata('userid');?>" readonly>
                                </div>
                              </div>
                              <div class="form-group"><label class="control-label col-md-3" for="a1"> 
                              </label>
                              <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-danger" onclick="batalkan('<?php echo $this->session->userdata("userid");?>')">Batalkan</button>
                              </div>
                            </div> 
                            </div> 
                          </form> 
                      </div>
                      <div id="step-2"> 
                         <form class="form-horizontal form-label-left" id="actionDetail" name="actionDetail" method="POST" style="overflow: hidden;">
                            <div class="col-xs-6">
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="d1">SKU 
                                  </label>
                                  <div class="col-md-6" >
                                    <div class='input-group'>
                                      <input type='text' class="form-control" id="d1" name="d1" onchange="getSku($('#d1').val())"/>
                                      <span class="input-group-addon" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg">
                                       <span class="glyphicon glyphicon-search"></span>
                                     </span>
                                   </div>
                                 </div>
                                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">

                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                          </button>
                                          <h4 class="modal-title" id="myModalLabel2">Cari Stock</h4>
                                        </div>
                                        <div class="modal-body">
                                          <?php 
                                            $kolom = array("No.","Kategori","SKU","Nama Stock","Qty","Opsi");
                                            buat_table($kolom,"datatable");   
                                          ?>
                                        </div> 

                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="d2">Nama Stock
                                  </label>
                                  <div class="col-md-6">
                                    <input type="text" id="d2"  class="form-control" readonly>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-6" for="d3">Harga Terakhir(@default)
                                  </label>
                                  <div class="col-md-6">
                                    <input type="text" id="d3" name="d3" class="form-control" readonly>
                                  </div>
                                </div>
                                <div class="form-group"> 
                                  <label class="control-label col-md-6" for="d4">Variant 
                                  </label>
                                  <div class="col-md-6" >
                                    <select id="d4" name="d4" class="form-control" onchange="check"> 
                                    </select>
                                  </div>
                                </div> 
                                <div class="form-group"> 
                                  <label class="control-label col-md-6" for="d5">Satuan 
                                  </label>
                                  <div class="col-md-6" > 
                                    <select id="d5" name="d5" class="form-control" onchange="isi_Uom()"> 
                                    </select>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xs-6"> 
                              <div class="form-group">
                                <label class="control-label col-md-3" for="d6">Konversi UOM
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="tmp_uom" class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3" for="d6">Qty
                                </label>
                                <div class="col-md-6">
                                  <input type="text" id="d6" name="d6" class="form-control" onchange="hitung()">
                                </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3" for="d7">SubTotal
                                  </label>
                                  <div class="col-md-6">
                                    <input type="text" id="d7" name="d7" class="form-control" readonly>
                                  </div>
                                </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3" for="d8">Catatan 
                                  </label>
                                  <div class="col-md-6" >
                                    <textarea class="form-control" id="d8" name="d8"></textarea>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3"> 
                                  </label>
                                  <div class="col-md-6">
                                    <input type="button" onclick="$('#actionDetail').submit()" class="btn btn-success" value="Simpan" />
                                    <button type="button" class="btn btn-danger">Batalkan</button>
                                  </div>
                              </div> 
                            </div>
                         </form>
                         <?php 
                            $kolom_detail = array("No.","SKU","Nama Item","Variant","Satuan","Harga","QTY","Qty Uom","Konversi","Total","Opsi");
                            buat_table($kolom_detail,"datatable2");   
                          ?>
                      </div>
                      <div id="step-3">
                        <div class="col-md-2"></div>
                        <div class="col-md-9">
                          <section class="content invoice">
                            <!-- title row -->
                            <!-- info row -->
                            <div class="row invoice-info" id="hasilMstINfo"> 
                              
                            </div> 
                            <div class="row">
                              <div class="col-xs-6 table" id="hasilDtlInfo">  
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->   
                            <div class="row no-print">
                              <div class="col-xs-12"> 
                                <button class="btn btn-success pull-right" onclick="finalisasi()">Finalisasi</button>
                                <button class="btn btn-danger pull-right" onclick="batalkan('<?php echo $this->session->userdata("userid");?>')" style="margin-right: 5px;">Batalkan</button>
                              </div>
                            </div>
                          </section>
                        </div>
                      </div>  
              </div>   
          </div>
        </div>
      </div> 
      <script type="text/javascript">
       var link = "<?php echo site_url().$this->uri->segment(1);?>"; 
       //ini untuk masternya
      //------------------------------------------------------------------- 
        $(document).ready(function(){
            $("#temp_gudang").val(""); 
            getData();
        });

        $(document).on('change','#a4',function(e){
          $('.StepTitle').fadeIn('fast');
          $.get(link+"/getWareHouse/"+$("#a4").val(), $(this).serialize())
          .done(function(data) {
            $('.StepTitle').fadeOut('fast'); 
            $("select#a5").html(data); 
            $("#a5").val($("#temp_gudang").val()); 
          });
        }); 
        function display_message(isi){
          $('#alert_trans').slideDown('slow').fadeOut(5000);
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
        $(document).on('submit','#formMaster',function(e){
          $('.StepTitle').fadeIn('fast');
          e.preventDefault();
          $.ajax({
          url: link+"/SimpanMst",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){ 
          $('.StepTitle').fadeOut('fast'); 
            display_message(data);
            $('.buttonNext').click();
            datatable2();
          },
          error:function(){
            display_message(data);
          }           
          });
          return false;  
        }); 
        function getPO(branch,kode){
          $('.StepTitle').fadeIn('fast');
          $.ajax({
              type: 'GET',
              dataType:'JSON',
              url: link+"/getPO/"+branch+"/"+kode,
              success:function(responseText){ 
                  $('.StepTitle').fadeOut('fast'); 
                  $("#a3").val(responseText.fc_kdsupplier);
                  $("#temp_gudang").val(responseText.fc_wh);
                  $("#a4").val(responseText.fc_branch_to);
                  $("select#a4").change();          
                  $("#a6").val(responseText.fd_estdatang);
                  $("#a7").val(rupiah(responseText.fn_qty));
                  $("#a8").val(rupiah(responseText.fn_total));
                  $("#a9").val(responseText.fv_note); 
              }
          });
        } 
      //-------------------------------------------------------------------
      //ini untuk detailnya
      //------------------------------------------------------------------- 
      $(document).on('click','.input-group-addon',function(e){
          datatable(); 
          return false;  
      });
      $(document).on('click','.buttonNext',function(e){
          getData();
          return false;  
      });
      $(document).on('click','.buttonPrevious',function(e){
          getData();
          return false;  
      }); 
      function datatable(){
                table = $('#datatable').DataTable({
                'processing': true, //ini untuk menampilkan processing
                'serverSide': true, //iini untuk serversidenya
                'deferRender' : true,
                'destroy' :true,
                'order'   : [], //ini jika menginginkan diorder
                'language'  : {
                  'searchPlaceholder': "Cari"
                },
                'ajax':{
                  'url' : "<?php echo site_url($this->uri->segment(1).'/dataItem');?>",
                  "dataType": "json",
                  'type'  : 'POST' 
                },//pasangkan hasil dari ajax ke datatablesnya
                'columns' :[
                  {'data' : 'no',width:20}, 
                  {'data' : 'kategori'},
                  {'data' : 'fc_stock'},
                  {'data' : 'fv_stock'}, 
                  {'data' : 'fn_onhand'}, 
                  {'mRender': function ( data, type, row ) {
                        return "<button type='button' class='btn btn-success' onclick=pilih('"+row['fc_stock']+"')>Pilih</button>";
                      },width:130
                  }
                ]  
        }); 
      }
      function getSku(kode){
          $('.StepTitle').fadeIn('fast');
          $.ajax({
              type: 'GET',
              dataType:'JSON',
              url: link+"/getStock/"+kode,
              success:function(responseText){ 
                $('.StepTitle').fadeOut('fast'); 
                  $("#d1").val(responseText.fc_stock); 
                  $("#d2").val(responseText.fv_stock); 
                  $("#d3").val(responseText.fn_beli); 
                  getVariant(responseText.fc_stock);
                  getSatuan(responseText.fc_stock);
              }
          });
       }
       function getMSTINFO(kode){
          $('.StepTitle').fadeIn('fast');
          $.ajax({
              type: 'GET',
              dataType:'JSON',
              url: link+"/getMSTINFO/"+kode,
              success:function(responseText){ 
                 var hasilInfo = '<div class="col-sm-4 invoice-col"> Supplier: <address> <strong>'+responseText.fv_supplier+'</strong> <br>'+responseText.fv_addr+'<br>'+responseText.fc_telp+' / '+responseText.fc_telp2+'  </address> </div>  <div class="col-sm-4"></div> <div class="col-sm-4 invoice-col"> <b>No.PO #'+responseText.fc_nopo+'</b> <br>  <table>  <tr> <td><b>Tanggal PO</b></td>  <td> : </td> <td>'+responseText.fd_po+'</td> </tr>  <tr> <td><b>Perkiraan Datang</b></td> <td> : </td> <td>'+responseText.fd_estdatang+'</td> </tr> <tr> <td><b>Qty Item</b></td> <td> : </td> <td>'+responseText.fn_qty+'</td> </tr> <tr> <td><b>Total</b></td> <td> : </td> <td>'+responseText.total+'</td> </tr> <tr> <td><b>Catatan</b></td> <td> : </td> <td>'+responseText.fv_note+'</td> </tr> <tr> <td><b>User</b></td> <td> : </td> <td>'+responseText.fc_userid+'</td> </tr> </table></div>';
                 document.getElementById('hasilMstINfo').innerHTML = "";
                 document.getElementById('hasilMstINfo').innerHTML = hasilInfo;
              }
          });
       }
       function getDTLINFO(kode){
          $('.StepTitle').fadeIn('fast'); 
          $.get(link+"/getDTLINFO/"+kode, $(this).serialize())
                  .done(function(data) {
                    $('.StepTitle').fadeOut('fast');
                   document.getElementById('hasilDtlInfo').innerHTML = "";
                   document.getElementById('hasilDtlInfo').innerHTML = data;
                  }); 
              
       } 
      function pilih(kode){
        $('.close').click();
        getSku(kode);
      }
      function datatable2(){
                table = $('#datatable2').DataTable({
                'processing': true, //ini untuk menampilkan processing
                'serverSide': true, //iini untuk serversidenya
                'deferRender' : true,
                'destroy' :true,
                'order'   : [], //ini jika menginginkan diorder
                'language'  : {
                  'searchPlaceholder': "Cari"
                },
                'ajax':{
                  'url' : "<?php echo site_url($this->uri->segment(1).'/dataDetail');?>",
                  "dataType": "json",
                  'type'  : 'POST' 
                },//pasangkan hasil dari ajax ke datatablesnya
                'columns' :[
                  {'data' : 'no',width:20}, 
                  {'data' : 'fc_stock'},
                  {'data' : 'fv_stock'},
                  {'data' : 'variant'}, 
                  {'data' : 'fv_satuan'}, 
                  {'data' : 'price'}, 
                  {'data' : 'fn_qty'}, 
                  {'data' : 'fn_uom'}, 
                  {'data' : 'konversi'}, 
                  {'data' : 'total'}, 
                  {'mRender': function ( data, type, row ) {
                        return "<button type='button' class='btn btn-danger' onclick=hapusDetail('"+row['fc_id']+"')>Hapus</button>";
                      },width:130
                  }
                ]  
        }); 
      }
      $(document).on('submit','#actionDetail',function(e){
          $('.StepTitle').fadeIn('fast');
          e.preventDefault();
          $.ajax({
          url: link+"/simpanDtl",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){ 
            $('.StepTitle').fadeOut('fast'); 
              display_message(data);
              document.getElementById('actionDetail').reset();
              getData(); 
          }          
          });
          return false;  
        });
      function getVariant(sku){
        $('.StepTitle').fadeIn('fast');
        $.get(link+"/getVariant/"+sku, $(this).serialize())
          .done(function(data) { 
            $('.StepTitle').fadeOut('fast');
            $("select#d4").html(data);   
          });
      }
      function getSatuan(sku){
        $('.StepTitle').fadeIn('fast');
        $.get(link+"/getSatuan/"+sku, $(this).serialize())
          .done(function(data) { 
            $('.StepTitle').fadeOut('fast');
            $("select#d5").html(data);   
          });
      } 
      function isi_Uom(){
        var uom = $("#d5").val();
        var split_uom = uom.split("#");
        $("#tmp_uom").val(split_uom[1]);
      }
      function hitung(){
        var uom = $('#tmp_uom').val();
        var qty = $('#d6').val();
        var price = $('#d3').val();
        var total = (qty * uom) * price;
        $('#d7').val(total);
      } 
      function hapusDetail(kode){
          if(confirm("Apakah anda Yakin?")){ 
            $.get(link+"/HapusDetail/"+kode, $(this).serialize())
                  .done(function(data) {
                    display_message(data); 
                    getData();
                  });
                  //--------------------------------
              }
      } 
      function getData(){ 
        datatable2();
        getPO('<?php echo $this->session->userdata("branch");?>','<?php echo $this->session->userdata("userid");?>'); 
        getMSTINFO('<?php echo $this->session->userdata("userid");?>');
        getDTLINFO('<?php echo $this->session->userdata("userid");?>');
      }
      function finalisasi(kode){
          if(confirm("Apakah anda Yakin?")){ 
            $.get(link+"/Finalisasi/"+kode, $(this).serialize())
                  .done(function(data) {
                    display_message(data); 
                    getData();
                    clear();
                    $("#step1").click();
                  });
                  //--------------------------------
              }
      }
      function batalkan(kode){
          if(confirm("Apakah anda Yakin?")){ 
            $.get(link+"/batalkan/"+kode, $(this).serialize())
                  .done(function(data) {
                    display_message(data); 
                    getData();
                    clear();
                    $("#step1").click();
                  });
                  //--------------------------------
              }
      }
      function clear(){
        $("#a3").val("");
        $("#a4").val("");
        $("#a5").val("");
        $("#a7").val("0");
        $("#a8").val("0");
        $("#a9").val("");
      }
    </script> 
    <!-- jQuery Smart Wizard -->
    <script src="<?= site_url()?>vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>  