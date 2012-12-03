<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
if(isset($root)) $oldroot = $root;
$root = $_SERVER['DOCUMENT_ROOT'];
 
// require_once $root."/adodb/adodb-exceptions.inc.php";
//require_once $root."/adodb/adodb.inc.php";
//

#using newer ADODb
require_once __DIR__."/../admin/common/adodb5/adodb-exceptions.inc.php";
require_once __DIR__."/../admin/common/adodb5/adodb.inc.php";

if(isset($oldroot)) $root = $oldroot;


# singleton pattern
class DBConnection
{
	static $db = NULL;

	private $config = NULL;
	private $connection = NULL;

	private function __construct()
	{
		//make it work, make it right, make it fast.
		$config = parse_ini_file('/etc/susinet.ini');
		$this->config = $config;
		$this->connection = ADONewConnection($config['sqlengine']); 
		$this->connection->SetFetchMode(ADODB_FETCH_ASSOC);
	}
	public static function getInstance() 
	{
		if (self::$db == NULL) {
			self::$db = new DBConnection();
		}	
		return self::$db;				
	}

	public function StartTrans() {
		$this->connection->StartTrans();
    }

	public function CompleteTrans() {
		$this->connection->CompleteTrans();
    }

    public function timestamp() {
        $date = new DateTime();
        return $this->qstr(strval($date->getTimestamp()));
    }

	public function GenID($table) {
		try {
			$c = (object) $this->config; // spoonful of syntactic sugar
			$conn = $this->connection;
			$conn->Connect($c->sqlhost, $c->sqluser, $c->sqlpass, $c->sqlbase);
			return $conn->GenID($table);
		} catch (exception $e) {
			print_r("EXCEPTION!!:");
			var_dump($e);
		}
	}
	public function ColumnNames($table) {
		try {
			$out = array();
			$c = (object) $this->config; // spoonful of syntactic sugar
			$conn = $this->connection;
			$conn->Connect($c->sqlhost, $c->sqluser, $c->sqlpass, $c->sqlbase);
			$sql = "select column_name, column_key,  column_default, data_type, table_name, table_schema from information_schema.columns";
			$sql .= ' where table_name="'.$table.'" and table_schema="'.$c->sqlbase.'"';
			$result = $conn->Execute($sql);
			while($row = $result->fetchRow()) {
				$out[] = strToUpper($row['column_name']);
			}
			return $out;
			//return $conn->MetaColumnNames($table);
		} catch (exception $e) {
			print_r("EXCEPTION!!:");
			var_dump($e);
			throw $e;
		}
	}

	public function Execute($sql) 
	{
		$out = NULL;
		try {
			$c = (object) $this->config; // spoonful of syntactic sugar
			$conn = $this->connection;
			$conn->Connect($c->sqlhost, $c->sqluser, $c->sqlpass, $c->sqlbase);
			$out = $conn->Execute($sql);
		} catch (exception $e) {
			print_r("EXCEPTION!!:");
			var_dump($e);
		}
		return $out;
	}

    // for compatibility
	public function qstr($string)
	{
		return $this->connection->qstr($string);
	}

	public function getConfig() 
	{
		return $this->config();
	}

	public function delete($tablename, $condition)
	{
		$sql = "DELETE FROM $tablename WHERE $condition;";
		return $this->Execute($sql);
	}

	public function update($tablename, $values, $condition)
	{
		$sql = "UPDATE $tablename SET $values WHERE $condition;";
		return $this->Execute($sql);

	}
	
	public function insert($tablename, $values, $keys=NULL)
	{
		if (NULL == $keys)
		{
			$sql = "INSERT INTO $tablename VALUES($values);";		
		} else {
			$sql = "INSERT INTO $tablename($keys) VALUES($values);";
		}
		return $this->Execute($sql);
	}
		
	/* 
	 * legacy function - 
	 * fetches a table
	 * @return array of objects containing column names as params.
	 */
	function fetch($tablename, $condition="", $lowercase=false) 
	{
		$out = array();
		$sql = "select * from ".$tablename;
		if (!empty($condition)) {
			$sql .= " ".trim($condition);
		
		}
		$result = self::Execute($sql);
		if ($result) {
			while ($o = $result->FetchNextObject()) {
				$out[] = clone $o;
			}
		}
		return $out;
	}
	
	/*
	 * fetch one value from db
	 */
	public function fetchOne($table, $column, $condition) {
		$result = $this->fetchRow($table, $condition, true, $column);
		return $result[strtolower($column)];	
    }

    public function fetchAssoc($table, $condition=""){
        $result = $this->Execute("SELECT * from $table $condition");
        return $result->GetAssoc();
    }

	public function fetchRow($table, $condition, $lowercase=false, $column="*") {
		$sql = "SELECT $column FROM $table WHERE $condition LIMIT 1";
        $result = $this->Execute($sql);
        $out = array();
        $arr = $result->FetchRow();
        if (null != $arr) 
        {
            foreach($arr as $k=>$v) {
                if ($lowercase) {
                    $out[strtolower($k)] = $v;
                } else {
                    $out[strtoupper($k)] = $v;
                }
            }
        }
		return $out;
    }
	public function getAutoQuotedArray($array) {
		foreach ($array as $item) {				
			if (!is_numeric($item)) {
				$item = "\"$item\"";
				$item = $this->qstr($item);				
			}
		}		
		return $array;
	}

	/* 
     * FIXME I wrote this and I can't tell at a glance what this does, exactly! 
     * @param string $table tablename
     * @param array $args values to insert or update, must contain every field in table in order. indexed. 
     * @param boolean $exact match exactly, if false, only uses id/pkey
     *
	 * @author	Esa Karjalainen <esa.karjalainen@haaveinc.com>
	 */
	public function insertOrUpdate($table, $args, $exact=false) {
		$keys = $this->ColumnNames($table);

		$setstring = "";
        $querystring = "";

        // generate SET string
		$separator = ", ";
		for ($i=1; $i<count($keys); $i++) {
			if ($i==(count($keys)-1)) {
				$separator = "";
				$logical_op = "";
			}
			if (is_numeric($args[$i])) {			
				$setstring .= "$keys[$i]=$args[$i]$separator";
			} else {
				$setstring .= "$keys[$i]=" . $this->qstr($args[$i]) . "$separator";
				$args[$i] = $this->qstr($args[$i]);
			}
        }

        // generate WHERE string
		$separator = " and ";
		for ($i=0; $i<count($keys); $i++) {
			if ($i==(count($keys)-1)) {
				$separator = "";
			}
			$querystring .= "$keys[$i]=$args[$i]$separator";
        }

        // This is probably only used for checking
		if ($exact) {
			$sql ="select $keys[0] from $table where $querystring";
        } else {
            // first is usually ID or otherwise primary key.
			$sql = "select $keys[0] from $table where $keys[0]=$args[0]";
		}

        $result = $this->Execute($sql);

        // If no results, we insert
		if (0 == $result->RecordCount()) { 
			if (count($keys) == count($args)) {
				$this->insert($table, implode(", ", $args));
			} else {
				throw new Exception('argument count mismatch');
			}
			return;
        }

		if (1 < $result->RecordCount()) {
			//var_dump($exact, $querystring, $keys, $args, $result->RecordCount());
			throw new Exception("not unique key: $keys[0]=$args[0]");	
		}

		//otherwise, update
		if ($exact) {
			$this->update($table, $setstring, $querystring);
		} else {			
			$this->update($table, $setstring, "$keys[0]=$args[0]");
		}
		
	}

	public function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}

	public function __wakeup()
	{
		trigger_error('Unserializing is not allowed.', E_USER_ERROR);
	}

}

?>
