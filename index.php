<?php
//include_once('config.php');
//function showTemplate($template){
//	include(Config::$local_dir . '/tpl/' . $template . '.tpl.php');
//}

function __autoload($classname){
	if (0==strcmp($classname, 'Config')) {
		include_once('./config.php');
	} else if (strpos($classname, "Controller")>0){
		include_once(Config::$app_dir . '/lib/controller/' . ucfirst("$classname.php"));
	}  else {
		if(!@include_once(Config::$app_dir . '/lib/' . "$classname.php")){
			include_once(Config::$app_dir . '/lib/model/' . "$classname.php");
		}
	}
}


// test adodb_lite
echo "1";
$db = new DBConnection();
echo "2";
print_r($db);
$db->insert('pages','name, template', '"Frontpage", "<h1>Helloword</h1>"' );
echo "3";
print_r($db->fetchTable('pages'));
//do stuff here
//$app = new App();
//$app->config = new Config;
//$app->run();
//
?>
