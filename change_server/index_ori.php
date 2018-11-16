<?php 
//error_reporting(0);
include "../application/config/database.php"; 
//baca dari koneksi.php
$hostname =  $db['default']['hostname'];
$username =  $db['default']['username'];
$password =  $db['default']['password'];

$host_baru = @$_POST['hostname'];
$user_baru = @$_POST['username'];
$pass_baru = @$_POST['password'];

$file = "../application/config/database.php"; 
	if(isset($_POST['simpan'])){
	$content = '<?php
	$active_group = \'default\';
	$query_builder = TRUE;
	$db[\'default\'] = array(
	\'dsn\'	=> \'\',
	\'hostname\' => \''.$host_baru.'\',
	\'username\' => \''.$user_baru.'\',
	\'password\' => \''.$pass_baru.'\',
	\'database\' => \'\',
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
	}

?>
<form action="" method="POST"> 
	<input type="text" name="hostname" placeholder="hostname" value="<?php echo $hostname;?>">
	<input type="text" name="username" placeholder="username" value="<?php echo $username;?>">
	<input type="text" name="password" placeholder="password" value="<?php echo $password;?>">
	<input type="submit" name="simpan">
</form>