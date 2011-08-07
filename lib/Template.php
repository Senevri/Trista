<?php
class Template{
	
	public $Data;
	
	function __construct(){
		
	}
	function setData($data){
		$this->Data = $data;
	}
	
	//duplicate functionality with showTemplate
	function display($template){
		if(is_array($this->Data)) {
			extract($this->Data);
		}
		
		if ( empty($template) ) $template = Controller::$template;
		$fileloc = Config::$app_dir . "/tpl/" . $template . ".tpl.php";
		if(file_exists($fileloc)) {
			include($fileloc); //this is probably bad.
		} else {
			$fileloc = Config::$app_dir . "/tpl/" . $template;
			$this->parse($fileloc);
		}
	}
	
	function parse($fileloc){
		//echo $fileloc . "<br>";
		$contents = file_get_contents($fileloc);
		// put templated stuff in
		$ret = 0;
		
		echo $contents;
	}
	
	function test(){
		echo "foo!";
		
	}
}

?>