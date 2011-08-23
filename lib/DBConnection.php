<?php
class DBConnection {
	
	// use SQL now, wrap later
	private $handle=null;	
	function __construct () {
		$this->handle = mysql_connect(CONFIG::$db_server, CONFIG::$db_user,
		CONFIG::$db_password) or die("unable to connect");				
	}
	
	function __destruct() {
		mysql_close($this->handle);		
	}
	
	function fetchRow($table,$condition){
		// 
		$query = "SELECT * FROM " . $table;
		if(!empty($condition)){
			$query .= " WHERE " . $condition;			
		}
		$query .= " LIMIT 1";
		echo("DEBUG: " . $query . '<br/>');
		if(!empty($query)){
			mysql_select_db(CONFIG::$db_user, $this->handle) or die("no DB");
			$res = mysql_query(htmlspecialchars_decode($query), $this->handle);
		}
		return mysql_fetch_array($res, MYSQL_BOTH);		
	}
	
	
	function fetchTable($table, $condition=""){
		$out = array();
		$query = "SELECT * FROM " . $table;
		if(!empty($condition)){
			$query .= " WHERE " . $condition;
		}
		//$query .= " LIMIT 1";
		echo("DEBUG: " . $query . '<br/>');
		if(!empty($query)){
			mysql_select_db(CONFIG::$db_user, $this->handle) or die("no DB");
			$res = mysql_query($query, $this->handle);
		}
		 while ($row = mysql_fetch_array($res, MYSQL_BOTH)){
		 	$out[] = $row;
		 	
		 }
		 return $out;		
	}
	function initialize($table) {
		
	}
	
	function insert($table, $values){
		$query = "INSERT INTO  " . $table;
		$query .= " VALUES (" . $values . ")"; 		
		echo("DEBUG: " . $query . '<br/>');
		if(!empty($query)){
			mysql_select_db(CONFIG::$db_user, $this->handle) or die("no DB");
			return mysql_query($query, $this->handle);
		}
		return false;
		
	}
	function update($table, $column, $value, $condition){
		$query = "UPDATE TABLE " . $table;		
		$query .= " SET " . $column . "=\"" . $value;
		if (!empty($condition)){
			$query .= " WHERE " . $condition;
		}
		//$query .= " LIMIT 1";
		echo("DEBUG: " . $query . '<br/>');
		if(!empty($query)){
			mysql_select_db(CONFIG::$db_user, $this->handle) or die("no DB");
		 	return mysql_query($query, $this->handle);
		}
		return false;
		
	}
	
	function open () {
		
		
	}
	
	
}
?>