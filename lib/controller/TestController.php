<?php
class TestController extends Controller{
	function index(){
		if(App::$user instanceof User) {
			$this->display('load_dialog');
			echo"<pre>";
			var_dump($_GET);
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

	private function printfile($params) {
		$filename = $params['p'];
		$this->text = file_get_contents(Config::$data_dir . '/' .$filename);
		$this->display('pre_content');
	}

	function editfile($params){
		if(App::$user instanceof User) {
			$filename = Config::$data_dir . '/' .$params['p'];
			if (!file_exists($filename)) {
				$this->createfile($params);
			}
			$this->text = file_get_contents($filename);
			$this->filename = $params['p'];
			$this->display('editbox');
		}
	}

	function message($params){
		if(app::$user instanceof user) {
			if(isset($params['id'])){
				/*get existing post*/
				$filename = Config::$data_dir . '/posts/' .$params['id'];
				$this->text = file_get_contents($filename);
				$json=json_decode($this->text);
				$this->post=$json->body;
				$this->topic=$json->topic;
			}
			$this->display('userinfo');
			$this->display('postmessage');
			$this->display('pre_content');
			var_dump($json);
		} else {
			$this->text="not logged in";
			$this->display('pre_content');

		}
	}

	function postfile($params){
		if(app::$user instanceof user) {
			$post = new Post(app::$user->username, $params['post']);
			if(!empty($params['title'])) {
				$post->setTitle($params['title']);
			}
			$post->save();
			//$this->display('editbox');
			$this->index();
		}
	}

	function writefile($params)
	{
		if(App::$user instanceof User) {
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
