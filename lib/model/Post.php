<?php
class Post extends Model{
	public $user; /* who posted this */
	public $posted; /* when was this first posted? */
	public $edited; /* when was this edited?  */
	public $title; /* what is the title of this post? */
	public $topic; /* under what topic does this one go? refer to unique ID. */
	public $id;  /* unique ID */
	public $body; /* message body */

	private $postcount; 	
	function __construct($user="", $body="" ){
		$this->postcount = Config::$data_dir . '/posts/postcount';
		$this->user = $user;
		$this->body = $body;
	}
	function load($file){
		$json = file_get_contents(Config::$data_dir . '/posts/' . $file);
		$data = json_decode($json);
		foreach($data as $k=>$v) {
			$this->$k = $v;
		}
	}

	/* clunky yet somple loading solution*/
	function loadByID($id){
		$dir = Config::$data_dir . '/posts/';
		$post = new Post();
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				//	$this->text .= "filename: $file : filetype: " . filetype($dir . $file) . "\n";
				if (substr($file, -4)=="json"){
					$post->load($file);
					if ($post->id == $id){ 
						$this->load($file);
						closedir($dh);
						return true;
					}
				}
			}
			closedir($dh);
			return false;
		}
	}

	function setTitle($title){
		$this->title = $title;
	}
	function setTopic($topic){
		$this->topic = $topic;
	}

	function save(){
		if (empty($this->posted)) {
			$this->posted = time();
		} else {
			$this->edited = time();
		}
		if(!isset($this->id)||empty($this->id)){
			$this->id = $this->getUniqueId();
		}
		$post = array(
			'id'=>$this->id, 
			'user'=>$this->user, 
			'posted'=>$this->posted, 
			'edited'=>$this->edited, 
			'title'=>$this->title, 
			'topic'=>$this->topic, 
			'body'=>$this->body
		);
		$out = json_encode($post);
		$filename=$this->id . '_' . $this->user . '.json';
		file_put_contents(Config::$data_dir . '/posts/' . $filename, $out, FILE_TEXT);

	}

	function getUniqueId() {
		$uid = file_get_contents($this->postcount);
		if (empty ( $uid ) ) $uid=0;
		file_put_contents($this->postcount, ($uid + 1), FILE_TEXT);	
		return trim($uid);
	}
}
?>
