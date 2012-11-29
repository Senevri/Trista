<?php
	$fileloc = Config::$app_dir . "/tpl/" . "upload_dialog.tpl.php";
	 ?> <div id = "main"> <?
	echo str_replace("<!-- action -->", Config::$http_location . "/?c=hallinta&a=lisaa_kuva", file_get_contents($fileloc));	
	?> </div> <?
		//$this->display("leiska.html");		
	
?>