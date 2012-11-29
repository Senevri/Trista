<?php
class TestController extends Controller{

	private $has_user=false;
	function __construct(){
		$login = new LoginController();
		/*disabled for mansikkaranta layout work*/
		//$login->index();
		if(App::$user instanceof User) {
			$this->has_user=true;
		} else {
			$this->has_user=false;
		}
	}
	
	function template(){
		$this->testmsg = "<h1>hello world</h1>";
		$this->display('test.html');
		
	}
	
	function leiska(){
		$this->FOOTER = "<b>Hannu Mustaparta
<br>Pikkuseläntie 42
<br>86800 Pyhäsalmi
<br>Puh: 0400 587 502
<br>Sähköposti: <a href=\"mailto:info\@mansikkaranta.net\">info@mansikkaranta.net</a>
</b>";
		$this->display('Leiska.html');
		
	}

	function testsql(){
		$this->text = "hello, world!";
		//begin test
		//$handle = mysql_connect(CONFIG::$db_server, CONFIG::$db_user, 
		//	CONFIG::$db_password) or die("unable to connect");
		$db = new DBConnection();
		//$db->open();
		//mysql_select_db(CONFIG::$db_user, $handle) or die("no DB");
		$rows = $db->fetchTable('test');
		//$db->close();
		foreach ($rows as $hash) {			
			foreach ($hash as $k=>$v){
				if(!is_numeric($k))
					echo "$k => $v<br>";	
			}
		}
		// end test
		$this->display('pre_content');
	}
	
	function setupmanrantasql(){
		$this->text = "hello, world!";
		//begin test
		$handle = mysql_connect(CONFIG::$db_server, CONFIG::$db_user, 
		CONFIG::$db_password) or die("unable to connect");
		$query = "create table pages (id int, name varchar(255), template varchar(255), primary key (id))";
 		
		mysql_select_db(CONFIG::$db_user, $handle) or die("no DB");
		$res = mysql_query($query, $handle);
		$query = "create table contents (id int, page int, name varchar(255), data text, language char(2) default 'fi', primary key (id), foreign key (page) references pages(id))";		$res = mysql_query($query, $handle);
		$res = mysql_query($query, $handle);
		mysql_close($handle);
	
		while($hash = mysql_fetch_assoc($res)){
			foreach ($hash as $k=>$v){
				echo "$k => $v<br>";	
			}
		}
		// end test
		$this->display('pre_content');
	}
	
	function sqlquery($params) {
		//echo($params['p'] . '<br/>');
		
		$handle = mysql_connect(CONFIG::$db_server, CONFIG::$db_user,
		CONFIG::$db_password) or die("unable to connect");
		$query = $params['p'];
		$query = str_replace(
		array('\\'), array(''), $query);

		$this->query = $query;
		if(!empty($query)){
			mysql_select_db(CONFIG::$db_user, $handle) or die("no DB");
			$res = mysql_query(htmlspecialchars_decode($query), $handle);
		}
		mysql_close($handle);
		$this->output = array();
		//$this->output[] = "Output:";
		//$this->output[] = ($res);
		//var_dump($res);
		if(!empty($query)) {
			while($this->output[] = mysql_fetch_assoc($res)){};
		}
		$this->display("sqlquery");
		
	}
	
	/* This only works if the server has a mail client. */
	function mailtest(){
		$message = "Line 1\nLine 2\nLine 3";

		ini_set("SMTP", "smtp.gmail.com");
		ini_set("smtp_port", "587");
		$headers = 'From: no-reply@mansikkaranta.net' . "\r\n" .
			'Reply-to: no-reply@mansikkaranta.net' . "\r\n" . 
			'X-Mailer: PHP/' . phpversion();
			
		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70);

		// Send
		
		
		mail('admin@mansikkaranta.net', 'My Subject', $message, $headers);
	
	}
	
		
	
	function index(){
		if($this->has_user) {
			$this->display('load_dialog');
			echo"<pre>";
			echo"options: editfile, printfile\n";
			echo"</pre>";
		}
	}

	private function createfile($params) {
		$filename = $params['p'];
		$out = "Creating file";
		exec("touch " . Config::$data_dir . '/' . $filename);
		$this->text = $out;
		$this->display('pre_content');
	}

	function printfile($params) {
		$filename = $params['p'];
		$this->text = file_get_contents(Config::$data_dir . '/' .$filename);
		$this->display('pre_content');
	}

	function editfile($params){
		if($this->has_user) {
			$filename = Config::$data_dir . '/' .$params['p'];
			if (!file_exists($filename)) {
				$this->createfile($params);
			}
			$this->text = file_get_contents($filename);
			$this->filename = $params['p'];
			$this->display('editbox');
		}
	}


	function writefile($params)
	{
		if($this->has_user) {
			$filename = Config::$data_dir . '/' .$params['p'];
			//$this->text = file_get_contents($filename);
			$this->text = $params['text'];
			//var_dump($this->text);
			file_put_contents($filename, $this->text, FILE_TEXT);
			//$this->display('pre_content');
			$this->printfile($params);
		}
	}

}


?>
