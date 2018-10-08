<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/<?php echo $icon_web;?>">
    <!-- Bootstrap -->
    <link href="<?php echo site_url()?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo site_url()?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo site_url()?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo site_url()?>vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo site_url()?>build/css/custom.min.css" rel="stylesheet">
    <script src="<?php echo site_url()?>assets/js/jquery-1.11.2.min.js"></script>
    <script src="<?php echo site_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="<?php echo site_url()?>assets/favicon.png">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="formAksi" method="post" action="#">
              <h1>Login Form
              </h1> 
              <div style="display: none;" id="hasil_login" class="alert alert-success alert-dismissible fade in" rele="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
                <strong>Login Sukses.</strong>Silahkan anda tunggu beberapa saat! 
              </div>
              <div>
                <input type="text" class="form-control" name="userid" placeholder="Username" required="harus disini" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="password" />
              </div>
              <div>
                <button type="submit" class="btn btn_default submit">Login</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator"> 
                <div>
                  <h1><?php echo $title; ?></h1>
                  <p><?php echo $footer; ?></p>
                </div>
              </div>
            </form>
          </section>
        </div> 
      </div>
      <script type="text/javascript">
        var delay = 1500;
        $(document).on('submit','#formAksi',function(e){
            e.preventDefault();
            $.ajax({
              url:"<?php site_url()?>Login/auth",
              type:'POST',
              data: new FormData(this),
              contentType:false,
              cache:false,
              processData:false,
              success:function(data){
                if (data == 1) {
                  $('#hasil_login').fadeIn('slow');
                  $('#hasil_login').removeClass('alert-success');
                  $('#hasil_login').removeClass('alert-danger');
                  $('#hasil_login').addClass('alert-success');
                  $('#hasil_login').text('berhasil login.Silahkan tunggu beberapa saat'); 
                  $('#formAksi').trigger('reset');
                  setTimeout(function(){window.location="<?php echo site_url()?>Home";},delay);
                }else{
                  $('#hasil_login').fadeIn('slow');
                  $('#hasil_login').removeClass('alert-danger');
                  $('#hasil_login').removeClass('alert-success');
                  $('#hasil_login').addClass('alert-danger');
                  $('#hasil_login').text("Gagal login.Periksa kembali")
                }
              }
            });
            return false;
        });
      </script>
    </div>
  </body>
</html>
