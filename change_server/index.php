<?php
session_start();
error_reporting(0);
include "../application/config/database.php";
//baca dari koneksi.php
$hostname =  $db['default']['hostname'];
$username =  $db['default']['username'];
$password =  $db['default']['password'];
$db       =  $db['default']['database'];

$host_baru = @$_POST['hostname'];
$user_baru = @$_POST['username'];
$pass_baru = @$_POST['password'];
$db_baru   = @$_POST['db'];

$file = "../application/config/database.php";
if(isset($_POST['simpan'])){
	$_SESSION['akses_setup'] = 'ok';
    $content = '<?php
    $active_group = \'default\';
    $query_builder = TRUE;
    $db[\'default\'] = array(
    \'dsn\' => \'\',
    \'hostname\' => \''.$host_baru.'\',
    \'username\' => \''.$user_baru.'\',
    \'password\' => \''.$pass_baru.'\',
    \'database\' => \''.$db_baru.'\',
    \'dbdriver\' => \'mysqli\',
    \'dbprefix\' => \'\',
    \'pconnect\' => FALSE,
    \'db_debug\' => (ENVIRONMENT !== \'production\'),
    \'cache_on\' => FALSE,
    \'cachedir\' => \'\',
    \'char_set\' => \'utf8\',
    \'dbcollat\' => \'utf8_general_ci\',
    \'swap_pre\' => \'\',
    \'encrypt\' => FALSE,
    \'compress\' => FALSE,
    \'stricton\' => FALSE,
    \'failover\' => array(),
    \'csaobve_queries\' => TRUE
    );';
        file_put_contents($file, $content);
        echo '<script type="text/javascript">window.location = "index.php";</script>';
}else if(isset($_POST['login'])){
	$key = md5('satuatap');
	$pass = md5(htmlspecialchars($_POST['pass']));
	if($pass == $key){
		$_SESSION['akses_setup'] = 'ok';
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/lockscreen-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 May 2017 08:06:31 GMT -->
<head>
    <style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
    </style>
    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>Change server</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../assets/images/icons/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="../assets/favicon.png">



    <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.css">


<!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="../assets/helpers/animate.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/colors.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="../assets/elements/badges.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/dashboard-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/forms.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/images.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/info-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/invoice.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/menus.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/response-messages.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/ribbon.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/social-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/tables.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/tile-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/timeline.css">



<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="../assets/icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="../assets/icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="../assets/icons/spinnericon/spinnericon.css">


<!-- WIDGETS -->

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="../assets/snippets/chat.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/todo.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/mobile-navigation.css">

<!-- APPLICATIONS -->

<link rel="stylesheet" type="text/css" href="../assets/applications/mailbox.css">

<!-- Admin theme -->

<link rel="stylesheet" type="text/css" href="../assets/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="../assets/themes/admin/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="../assets/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="../assets/themes/components/border-radius.css">
<script type="text/javascript" src="../assets/js-core/jquery-core.js"></script>
<script type="text/javascript">
    $(window).load(function(){
        setTimeout(function() {
            $('#loading').fadeOut( 400, "linear" );
        }, 300);
    });
</script>



</head>
<body>
<div id="loading">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<style>
    html,body {
        height: 100%;
    }
    body {
        overflow: hidden;
        background: #fafafa;
    }
</style>
<?php if($_SESSION['akses_setup'] <> 'ok'){ ?>
<!-- form untuk change servernya -->
<div class="center-vertical">
    <div class="center-content row">
        <div class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin">
            <div class="panel-layout wow bounceInDown">
                <div class="panel-content pad0A bg-white">
                    <div class="meta-box meta-box-offset">
                        <img src="../assets/favicon.png" style="width: 250px;" alt="" class="meta-image img-bordered img-circle">
                        <h3 class="meta-heading font-size-16">Login Change Server</h3>
                        <h4 class="meta-subheading font-size-13 font-gray">Ubah Server</h4>
                    </div>
                    <form action="index.php" class="form-inline" method="POST">
                        <div class="content-box-wrapper pad20A">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" name="pass" placeholder="password" class="form-control" value="<?php echo $password;?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button"><i class="glyph-icon icon-lock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <button type="submit" name="login" class="btn btn-alt btn-hover btn-primary">
                                    <span>Masuk</span>
                                    <i class="glyph-icon icon-arrow-right"></i>
                                </button>
                                <button type="button" onclick="window.location = '../index.php'" class="btn btn-alt btn-hover btn-danger">
                                    <span>Kembali</span>
                                    <i class="glyph-icon icon-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- form untuk change servernya -->
<?php if($_SESSION['akses_setup'] == 'ok'){ ?>
<div class="center-vertical">
    <div class="center-content row">
        <div class="col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin">
            <div class="panel-layout wow bounceInDown">
                <div class="panel-content pad0A bg-white">
                    <div class="meta-box meta-box-offset">
                        <img src="../assets/favicon.png" style="width: 250px;" alt="" class="meta-image img-bordered img-circle">
                        <h3 class="meta-heading font-size-16">Change Server</h3>
                        <h4 class="meta-subheading font-size-13 font-gray">Sethost</h4>
                    </div>
                    <form action="index.php" class="form-inline" method="POST">
                        <div class="content-box-wrapper pad20A">
                            <div class="form-group" style="margin-bottom: 2%;">
                                <div class="input-group">
                                    <input type="text" name="hostname" placeholder="Hostname" class="form-control" value="<?php echo $hostname;?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button"><i class="glyph-icon icon-signal"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 2%;">
                                <div class="input-group">
                                    <input type="text" name="db" placeholder="Database" class="form-control" value="<?php echo $db;?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button"><i class="glyph-icon icon-database"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 2%;">
                                <div class="input-group">
                                    <input type="text" name="username" placeholder="username" class="form-control" value="<?php echo $username;?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button"><i class="glyph-icon icon-user"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" name="password" placeholder="password" class="form-control" value="<?php echo $password;?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button"><i class="glyph-icon icon-lock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <button type="submit" name="simpan" class="btn btn-alt btn-hover btn-primary">
                                    <span>Simpan</span>
                                    <i class="glyph-icon icon-arrow-right"></i>
                                </button>
                                <button type="button" onclick="kembali()" class="btn btn-alt btn-hover btn-danger">
                                    <span>Kembali</span>
                                    <i class="glyph-icon icon-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	function kembali(){
		window.location = '../index.php';
		<?php session_destroy(); ?>
	}
</script>
<?php } ?>

<script type="text/javascript" src="../assets/bootstrap/js/bootstrap.js"></script>

<!-- Bootstrap Dropdown -->

<!-- <script type="text/javascript" src="../assets/widgets/dropdown/dropdown.js"></script> -->

<!-- Bootstrap Tooltip -->

<!-- <script type="text/javascript" src="../assets/widgets/tooltip/tooltip.js"></script> -->

<!-- Bootstrap Popover -->

<!-- <script type="text/javascript" src="../assets/widgets/popover/popover.js"></script> -->

<!-- Bootstrap Progress Bar -->

<script type="text/javascript" src="../assets/widgets/progressbar/progressbar.js"></script>

<!-- Bootstrap Buttons -->

<!-- <script type="text/javascript" src="../assets/widgets/button/button.js"></script> -->

<!-- Bootstrap Collapse -->

<!-- <script type="text/javascript" src="../assets/widgets/collapse/collapse.js"></script> -->

<!-- Superclick -->

<script type="text/javascript" src="../assets/widgets/superclick/superclick.js"></script>

<!-- Input switch alternate -->

<script type="text/javascript" src="../assets/widgets/input-switch/inputswitch-alt.js"></script>

<!-- Slim scroll -->

<script type="text/javascript" src="../assets/widgets/slimscroll/slimscroll.js"></script>

<!-- Slidebars -->

<script type="text/javascript" src="../assets/widgets/slidebars/slidebars.js"></script>
<script type="text/javascript" src="../assets/widgets/slidebars/slidebars-demo.js"></script>

<!-- PieGage -->

<script type="text/javascript" src="../assets/widgets/charts/piegage/piegage.js"></script>
<script type="text/javascript" src="../assets/widgets/charts/piegage/piegage-demo.js"></script>

<!-- Screenfull -->

<script type="text/javascript" src="../assets/widgets/screenfull/screenfull.js"></script>

<!-- Content box -->

<script type="text/javascript" src="../assets/widgets/content-box/contentbox.js"></script>

<!-- Overlay -->

<script type="text/javascript" src="../assets/widgets/overlay/overlay.js"></script>

<!-- Widgets init for demo -->

<script type="text/javascript" src="../assets/js-init/widgets-init.js"></script>

<!-- Theme layout -->

<script type="text/javascript" src="../assets/themes/admin/layout.js"></script>

<!-- Theme switcher -->

<script type="text/javascript" src="../assets/widgets/theme-switcher/themeswitcher.js"></script>

</body>

<!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/lockscreen-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 May 2017 08:06:31 GMT -->
</html>