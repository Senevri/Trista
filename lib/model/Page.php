<?php
class Page extends Model {
	public $template; /* tpl */
	public $contents; /* array or not? */
	
	function __construct($id){
		$this->template="leiska.html";
		if(!empty($id)){
			load($id);			
		}
	}

	function load($id){
		
		
	}
	
	function save($id){
		
		
	}		
}
?>