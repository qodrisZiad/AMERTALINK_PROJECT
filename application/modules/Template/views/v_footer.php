		</div>
    </div> 
		 <footer>
          <div class="pull-right">
            <?= SITE_FOOTER;?>
          </div>
          <div class="clearfix"></div>
        </footer>
		</div>
	</div>  
  <!-- bootstrap-daterangepicker -->
    <script src="<?php echo site_url(); ?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo site_url(); ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo site_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo site_url(); ?>vendors/fastclick/lib/fastclick.js"></script>
    <script src="<?php echo site_url(); ?>vendors/nprogress/nprogress.js"></script> 
    <script src="<?php echo site_url(); ?>build/js/custom.min.js"></script>
    <script type="text/javascript">
      $('#tanggal').datetimepicker({
        format: 'DD-MM-YYYY'
<<<<<<< HEAD
    });
      function rupiah(bilangan = "0"){
        var rupiah = ""; 
        if (bilangan == null) {
          rupiah = "0";
        }else{
          var number_string = bilangan.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }
        }
        return rupiah;
      }
      function decimal(angka){
          var hasil = (angka.split('.').join('')).split('Rp').join('');
          return hasil;
        }
=======
      });
      function rupiah(bilangan){
                var number_string = bilangan.toString(),
                sisa  = number_string.length % 3,
                rupiah  = number_string.substr(0, sisa),
                ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                  
                if (ribuan) {
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
                }
                return rupiah;
              }
>>>>>>> cf614395e535c5dd75b2adbdfd726a98eca48cac
    </script>
  </body>
</html>
