<?php
class Picture extends Model {
	public $name; /* real name */
	public $identifier; /* name in fs */
	public $path; 
	public $id;
	public $found; /**/
	
	function __construct($id=-1){
		$this->found = false;
		if(-1 !=$id){
			$this->load($id);			
		}
	}

	function load($id){
		$db = new DBConnection();
		$row = $db->fetchRow("pictures", "id=" . $id);
		$this->name = $row['name'];
		$this->id = $id;
		if (!empty($name)) {
			$this->found = true;
		}
		$this->identifier = $row['identifier'];
		$this->path = Config::$data_dir . "/images/" . $identifier;				
		
	}
	
	function save(){
		$db = new DBConnection();	
		$this->path = Config::$data_dir . "/images/" . $identifier;		
		$db->insert("pictures", 
			(1+$db->count('pictures')) . ', "'. $this->name . '", "' . $this->identifier . '"');
		
	}
	
	function count(){
		$db = new DBConnection();
		return $db->count('pictures');	
	}
	
	function delete($id="") {
		if (empty($id)) {
			$id = $this->id;
		}
		$db = new DBConnection();
		$db->delete('pictures', $this->id);
		
	}
	
	function getData(){
		 $out = array();
		 $out['id'] = $this->id;
		 $out['name'] = $this->name;
		 $out['identifier'] = $this->identifier;
		 $out['path'] = $this->path;
		 return $out;
	}
}
?>