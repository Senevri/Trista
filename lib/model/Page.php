<?php
class Page extends Model {
	public $id;
	public $template; /* tpl */
	public $contents = array(); /* array or not? */
	
	function __construct($name=""){
		$this->template="leiska.html";
		if(!empty($name)){
			if (is_numeric($name)) {
				$this->load_by_id($name);
			} else {
				$this->load($name);			
			}
		}
	}

	/* copypaste function from load */
	function load_by_id($id){
		$db = new DBConnection();
		$page = $db->fetchRow("pages", "id=\"".$id . "\"");
		$this->id=$page['id'];
		var_dump($id);	
		//var_dump($page);
		$this->template = $page['template'];	
		$ctable = $db->fetchTable("contents", "page=".$id);
		foreach($ctable as $row) {
			//$this->contents['id'] = $row['id'];
			$this->contents[$row['name']] = $row['data'];													
		}		
	}

	function load($name){
		$db = new DBConnection();
		$page = $db->fetchRow("pages", "name=\"".$name . "\"");
		$this->id=$page['id'];
		
		//var_dump($page);
		$this->template = $page['template'];	
		$ctable = $db->fetchTable("contents", "page=".$page['id']);
		foreach($ctable as $row) {
			//$this->contents['id'] = $row['id'];
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
