<?php
class Controller{

	private static $template = 'pre_content';

	public function display($template){
		//var_dump($template);
		if ( empty($template) ) $template = Controller::$template;
		$fileloc = Config::$app_dir . "/tpl/" . $template . ".tpl.php";
		include($fileloc);
	}

	function index(){
		echo "works";
	}
}


?>
