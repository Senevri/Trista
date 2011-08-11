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
		/// get all keys from template file to replace
		//// find tag start position, find tag end position, add the 
		$keys = array();
		$offset = 0;
		foreach($this->Data as $k=>$v){
				$offset = strpos($contents, "<!-- $k -->", $offset);
				if($offset>0){
					$contents = str_replace("<!-- $k -->", $v, $contents);
				}
		} 
		
		$ret = 0;
		
		echo $contents;
	}
	
	function test(){
		echo "foo!";
		
	}
}

?>