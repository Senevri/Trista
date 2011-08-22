<?php
class Page extends Model {
	public $template; /* tpl */
	public $contents = array(); /* array or not? */
	
	function __construct($id){
		$this->template="leiska.html";
		if(!empty($id)){
			$this->load($id);			
		}
	}

	function load($id){
		$db = new DBConnection();
		$page = $db->fetchRow("pages", "name=\"".$id . "\"");
		$template = $page['template'];	
		$ctable = $db->fetchTable("contents", "page=".$page['id']);
		foreach($ctable as $row) {
			$this->contents[$row['name']] = $row['data'];													
		}		
	}
	
	function save($id){
		
		
	}		
}
?>
