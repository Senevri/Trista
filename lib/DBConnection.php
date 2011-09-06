<?php
class DBConnection {
	
	// use SQL now, wrap later
	private $handle = null;	
	
	function __construct () {		
		$this->open();
	}

	
	function __destruct() {
		$this->close();

	}
	
	function do_query($query){
		if(!empty($query)){
			mysql_select_db(CONFIG::$db_user, $this->handle) or die("no DB");
			return mysql_query(htmlspecialchars_decode($query), $this->handle);
		}
		return false;
	}
	
	function fetchRow($table,$condition){	
		$query = "SELECT * FROM " . $table;
		if(!empty($condition)){
			$query .= " WHERE " . $condition;
		}
		$query .= " LIMIT 1";
		//echo("DEBUG: " . $query . '<br/>');
		
		return mysql_fetch_array($this->do_query($query), MYSQL_BOTH);		
	}
	
	function count($table) {
		$query = "SELECT count(id) FROM " . $table;
		//echo("DEBUG: " . $query . '<br/>');				
		$out = mysql_fetch_row($this->do_query($query));
		return $out[0];
	}
	
	function fetchTable($table, $condition=""){
		$out = array();
		$query = "SELECT * FROM " . $table;
		if(!empty($condition)){
			$query .= " WHERE " . $condition;
		}
		//$query .= " LIMIT 1";
		echo("DEBUG: " . $query . '<br/>');
		
		$res = $this->do_query($query);
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
		return $this->do_query($query);
		
	}
	
	
	/*
		condition uses sql syntax
	*/
	function update($table, $column, $value, $condition){
		$query = "UPDATE " . $table;		
		$query .= " SET " . $column . "=\"" . $value . "\"";
		if (!empty($condition)){
			$query .= " WHERE " . $condition;
		}
		//$query .= " LIMIT 1";
		echo("<code>DEBUG: " . $query . '</code><br/>');
		$this->do_query($query);
		return $this->do_query($query);
		
	}
	
	
	function delete($table, $id) {
		$query = "DELETE FROM  " . $table;
		$query .= " WHERE ID=" . $id . ""; 		
		echo("DEBUG: " . $query . '<br/>');
		return $this->do_query($query);
	}
	
	
	function open () {
		if (null == $this->handle) {
			$this->handle = mysql_connect(
				CONFIG::$db_server, 
				CONFIG::$db_user,
				CONFIG::$db_password
				) or die("unable to connect");
		}		
		
	}
	function close () {
		mysql_close($this->handle);		
		$this->handle = null;
	}
	
}
?>
