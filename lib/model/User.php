<?php
class User extends Model{
	public $username;
	public $password;
	private $datasource;

	function __construct($username, $password){
		$this->username = $username;
		$this->password = $password;
		$this->datasource = Config::$data_dir . '/users.json';
	}

	function register(){
		$md5_pass = md5($this->password);
		$account = array("username"=>$this->username, "password"=>$md5_pass);
		if (!file_exists($this->datasource)) {
			$this->createfile(array('p'=>"users.json"));
			$this->users = array($account);
		} else {
			$this->users = json_decode(file_get_contents($this->datasource));
			if (empty($this->users)) 
				$this->users = array($account);
			if ($this->user_exists($username, $this->users)) {
				//return $this->login();
				return false;
			} // if here account not found
			$this->users[] = $account;
		}
		$this->writefile(json_encode($this->users));	
		$this->login();
		return true;
	}
	function user_exists($user, $users){
		foreach($users as $account){
			if ($account->username== $user) return true;
		}
		return false;
	}
	/*FIXME: This is so stupid...*/
	function check_user(){
		$users =
			json_decode(file_get_contents($this->datasource));
		foreach($users as $account){
			if ($account->username== $this->username) return true;
		}
		return false;
	}

	function login(){
		$this->users = json_decode(file_get_contents($this->datasource));
		$canhas=false;
		if(32==strlen($this->password)){
			$md5_password = $this->password;
		} else {
			$md5_password = md5($this->password);
		}
		foreach($this->users as $account){
			if ( ($account->username==$this->username) &&
				($account->password==$md5_password)){
					$canhas=true;
				}
		}
		if (true==$canhas) {
			setcookie("trista_user", $this->username.':::'.md5($this->password), time()+3600);	
			return true;
		}
		return false;
	}

	function logout(){
		setCookie("trista_user", "", time()-3600);
	}

	function writefile($json)
	{
		//FIXME: no error control
		$filename = Config::$data_dir . '/users.json';
		//file_put_contents($filename, $json, FILE_TEXT); //php6
		file_put_contents($filename, $json); //lighty2go
	}

}
?>
