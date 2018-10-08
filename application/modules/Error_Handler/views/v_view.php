<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title> 
    <link href="<?php echo site_url()?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="<?php echo site_url()?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> 
    <link href="<?php echo site_url()?>vendors/nprogress/nprogress.css" rel="stylesheet"> 
    <link href="<?php echo site_url()?>build/css/custom.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo site_url()?>assets/favicon.png">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
              <h1 class="error-number">404</h1>
              <h2>Sorry but we couldn't find this page</h2>
              <p>This page you are looking for does not exist.<a href="<?php echo site_url()?>">Back to Home</a>
              </p> 
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo site_url()?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo site_url()?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo site_url()?>vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo site_url()?>build/js/custom.min.js"></script>
  </body>
</html>
