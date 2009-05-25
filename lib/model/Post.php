<?php
class Post extends Model{
	public $user; /* who posted this */
	public $posted; /* when was this first posted? */
	public $edited; /* when was this edited?  */
	public $title; /* what is the title of this post? */
	public $topic; /* under what topic does this one go? */
	public $id;  /* unique ID */
	public $body; /* message body */

	private $postcount; 	
	function __construct($user, $body ){
		$this->postcount = Config::$data_dir . '/posts/postcount';
		$this->user = $user;
		$this->body = $body;
		$this->id = $this->getUniqueId();
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
		$filename=$this->id . '_' . $this->posted . '_' . $this->user . '.json';
		file_put_contents(Config::$data_dir . '/posts/' . $filename, $out, FILE_TEXT);

	}

	function getUniqueId() {
		$uid = file_get_contents($this->postcount);
		file_put_contents($this->postcount, ($uid + 1), FILE_TEXT);	
		return trim($uid);
	}
}
?>>
