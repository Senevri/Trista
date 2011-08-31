<?php
class Page extends Model {
	public $id;
	public $template; /* tpl */
	public $contents = array(); /* array or not? */
	
	function __construct($id=""){
		$this->template="leiska.html";
		if(!empty($id)){
			$this->load($id);			
		}
	}

	function load($id){
		$db = new DBConnection();
		$page = $db->fetchRow("pages", "name=\"".$id . "\"");
		$this->id=$id;
		
		//var_dump($page);
		$this->template = $page['template'];	
		$ctable = $db->fetchTable("contents", "page=".$page['id']);
		foreach($ctable as $row) {
			$this->contents[$row['name']] = $row['data'];													
		}		
	}
	
	function get_all(){
		$db = new DBConnection();
		return $db->fetchTable("pages");
	}
	
	function save(){
		
		
	}		
}
?>
