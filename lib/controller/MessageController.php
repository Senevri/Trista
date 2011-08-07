<?php
class MessageController extends Controller{

	private $has_user=false;
	public $messages;
	
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
	//		$this->display('load_dialog');
	//		echo"<pre>";
	//		echo"options: editfile, printfile, message, listmessage\n";
			//		echo"</pre>";
			//
		}
		$this->list_all();
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

	private function editfile($params){
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
			/*	$filename = Config::$data_dir . '/posts/' .$params['id'];
				$this->text = file_get_contents($filename);
				$json=json_decode($this->text);
				foreach($json as $k=>$v){
					$this->$k = $v;
				}
			 */
				$this->post= new Post();
				$this->post->load($params['id']);
			}
			if (empty($this->post->user) || (App::$user->username == $this->post->user)&& isset($params['edit']) ) {
				$this->display('postmessage');
				//	$this->display('pre_content');
			} else if ($this->has_user && isset($params['reply'])){
				$this->post->posted="";
				$this->post->topic = $this->post->id;
				unset($this->post->id); 
				//$this->post->id = $this->post->getUniqueId();
				$this->post->user = App::$user->username;
				$this->display('postmessage');
			} else {
				$this->view($params);
			}
		} elseif(isset($params['id'])){
			//$this->display('pre_content');
			$this->view($params);
		} else {
			$this->list_all();
		}
	}

	function view($params){
		$this->post= new Post();
		$this->post->load($params['id']);
//		if isset($params['edit']) {
			$this->display('viewsinglemsg');
//		} else {
//			$this->display('');
//		}
	}

	private function cmp_posted($a, $b){
		if($a['posted'] == $b['posted']){
			return 0;
		} else {
			return $a['posted'] < $b['posted'] ? 1 : -1; // reverse order
		}

	}

	function list_all($params=''){
		//read all data from data dir / posts
		//print all contents from newest to oldest.
		
		$dir = Config::$data_dir . '/posts/'; //FIXME file handling is not controllers duty!
		$this->text=""; //FIXME ennen kuin tän korjaan ei saa posteja näkymään viimeksi kommentoitu-järjsksä
		$this->messages=array();
		$this->post = new Post("", "");
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				//	$this->text .= "filename: $file : filetype: " . filetype($dir . $file) . "\n";
				if (substr($file, -4)=="json"){
					$this->post->load($file);
					if($this->addThisMessage($params, $this->post)) {
						$this->messages[] = array(
							'index'=>$this->post->id, 
							'id'=>$file, 
							'user'=>$this->post->user, 
							'body'=>$this->post->body,
							'title'=>$this->post->title,
							'posted'=>$this->post->posted);
					}
				}
			}
			uasort($this->messages, array( $this, 'cmp_posted'));
			if (!empty($params['p']) || 
				isset($params['long']) || 
				isset($params['topic'])) {
				$p = explode('&', $params['p']);
				if (isset($params['topic']) || in_array("topic", $p)) {
					$this->topic = $params['topic']; 
					sort($this->messages);
				}
				$this->display('threadview');
			} else {
				$this->display('messagelist');
			}
			closedir($dh);
		}
	}


	private function addThisMessage($params, $post) {
		if (isset($params['topic'])){
			if($post->id == $params['topic'] || $post->topic == $params['topic']) return true;
			return false;	

		} else if (empty($post->topic)){
			return true;
		} else {
			return false; 
		}
	}

	function postfile($params){
		if($this->has_user) {
			$post = new Post(app::$user->username, $this->sanitize($params['body']));
			//if(!empty($params['posted'])){
			foreach($params as $k=>$v){
				$post->$k=$this->sanitize($v);
			}
			//}
			if(!empty($params['title'])) {
				$post->setTitle($this->sanitize($params['title']));
			}
			if (!empty($params['body'])) $post->save();
			$this->list_all();
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
		$alist=array('ö', 'ä', 'å', 'Ö', 'Ä', 'Å', chr(128), "\t");
		$blist=array('&ouml;', '&auml;', '&aring;', '&Ouml;', '&Auml;', '&Aring;', '&euro;', '&nbsp;');
		$output=str_replace($alist, $blist, $input);
		return $output;
	}


}


?>
