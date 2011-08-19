<?php
class Picture extends Model {
	public $name; /* tpl */
	public $category; /* array or not? */
	
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