<?php

function printrow($str) {
	print_r($str . "\n");
}
 

require_once("../config.php");
print_r(Config::$http_location . "\n");

require_once("../lib/DBConnection.php");
try 
{
	echo ("trying...\n");
$db = new DBConnection();
	echo ("open...\n");
$db->open();
	echo ("implode...\n");
	printrow(implode(get_object_vars($db)));
	$res = $db->insert('pages','name, template', '"Frontpage", "<h1>Helloword</h1>"' );
	print_r($res);
	$table = $db->fetchTable('pages');
	print_r($table);
	
} catch (Exception $ex) {
	echo ("exception...");
print_r($ex);
}
?>
