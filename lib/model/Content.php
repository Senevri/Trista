<?php
class Content extends Model {
	public $id;
	public $page;
	public $name;
	public $data; /* array or not? */


	function __construct($name=""){
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
		$page = $db->fetchRow("contents", "id=\"".$id . "\"");
		$this->id=$page['id'];
		$this->name = $page['name'];
		$this->data = $page['data'];
	}

	function load($name){
		$db = new DBConnection();
		$page = $db->fetchRow("contents", "name=\"".$name . "\"");
		$this->id=$page['id'];
		$this->name = $name;
		$this->data = $page['data'];
		
		//var_dump($page);
	}
	
	
	function save(){
		$db = new DBConnection();
		$result = $db->update('contents', "data", $this->data, "id=".$this->id );
	}	
}
?>
