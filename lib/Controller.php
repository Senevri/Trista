<?php
class Controller{

	private static $template = 'pre_content';

 	public function display($tpl){
 		$renderer = new Template();
 		$renderer->setData(get_object_vars($this));
 		//var_dump($renderer->Data);
		$renderer->display($tpl);
 	}

	function index(){
		echo "works";
	}
}


?>
