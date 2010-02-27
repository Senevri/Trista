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

	function index(){
		if($this->has_user) {
			$this->display('load_dialog');
			echo"<pre>";
			echo"options: editfile, printfile, message, listmessage\n";
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

	function message($params){
		if($this->has_user) {
			if(isset($params['id'])){
				/*get existing post*/
				$filename = Config::$data_dir . '/posts/' .$params['id'];
				$this->text = file_get_contents($filename);
				$json=json_decode($this->text);
				foreach($json as $k=>$v){
				$this->$k = $v;
				}
			}
			if (empty($this->user) || App::$user->username == $this->user ){
				$this->display('postmessage');
			//	$this->display('pre_content');
			} else {
				$this->viewmessage($params);
			}
		} elseif(isset($params['id'])){
			//$this->display('pre_content');
			$this->viewmessage($params);
		} else {
			$this->listmessages();
		}
	}

	function viewmessage($params){
		$this->post= new Post("", "");
		$this->post->load($params['id']);
		$this->display('viewmessage');
	}

	function listmessages($params=''){
		//read all data from data dir / posts
		//print all contents from newest to oldest.
		
		$dir = Config::$data_dir . '/posts/';
		$this->text="";
		$this->messages=array();
		$this->post = new Post("", "");
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				//	$this->text .= "filename: $file : filetype: " . filetype($dir . $file) . "\n";
				if (substr($file, -4)=="json"){
					$this->post->load($file);
					$this->messages[] = array(
						'index'=>$this->post->id, 
						'id'=>$file, 
						'user'=>$this->post->user, 
						'body'=>$this->post->body,
						'title'=>$this->post->title);
						
				}
			}
			rsort($this->messages);
			if (isset($params['long'])) {
				$this->display('threadview');
			} else {
				$this->display('messagelist');
			}
			closedir($dh);
		}
	}
	function postfile($params){
		if($this->has_user) {
			$post = new Post(app::$user->username, $this->sanitize($params['body']));
			if(!empty($params['posted'])){
				foreach($params as $k=>$v){
					$post->$k=$this->sanitize($v);
				}
			}
			if(!empty($params['title'])) {
				$post->setTitle($this->sanitize($params['title']));
			}
			if (!empty($params['body'])) $post->save();
			$this->listmessages();
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

	function sanitize($input){
		$output="";
		$alist=array('ö', 'ä', 'å', 'Ö', 'Ä', 'Å', chr(128));
		$blist=array('&ouml;', '&auml;', '&aring;', '&Ouml;', '&Auml;', '&Aring;', '&euro;');
		$output=str_replace($alist, $blist, $input);
		return $output;
	}


}


?>
