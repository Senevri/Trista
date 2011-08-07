<?php
class TestController extends Controller{

	private $has_user=false;
	function __construct(){
		$login = new LoginController();
		$login->index();
		if(App::$user instanceof User) {
			$this->has_user=true;
		} else {
			$this->has_user=false;
		}
	}

	function testsql(){
		$this->text = "hello, world!";
		$this->display('pre_content');
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
