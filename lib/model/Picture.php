<?php
class Picture extends Model {
	public $name; /* tpl */
	public $identifier; 
	
	function __construct($id){
		if(!empty($id)){
			load($id);			
		}
	}

	function load($id){
		$db = new DBConnection();
		$db->fetchRow("pictures", "identifier=\"" . $id . "\"");
		$path = Config::$data_dir . "/images/" . $identifier;
		
		
	}
	
	function save($id){
		
		
	}		
}
?>