<?php
class Thread extends Model{
	public $user; /* who started this */
	public $firstpost /*Id of first post.*/
	public $id;  /* unique ID */
	public $posts; /* message body */
	public $posted; /* timestamp of last post in thread */

	private $post_list;
	private $threadcount; 	
	function __construct($post){
		$this->threadcount = Config::$data_dir . '/threads/count';
		$this->user = $post->user;
		$this->firstpost = $post->id;
		$this->posts = array();
		$this->post_list = array();
		$this->addPost($post);
	}
	//Load all posts in thread
	function load($id){
		$json = file_get_contents(Config::$data_dir . '/threads/' . $id);
		$data = json_decode($json);
		foreach($data as $k=>$v) {
			$this->$k = $v;
		}
		foreach($this->post_list as $pid) {
			$post = new Post();
			$post->loadByID($pid);
			$this->posts[] = $post;
			$this->posted = $post->posted;
		}

	}

	function addPost($post){
		$this->posts[] = $post;
		$this->post_list[] = $post->id;
		$this->posted = $post->posted;
	}

	function save(){
		foreach()

		if(!isset($this->id)||empty($this->id)){
			$this->id = $this->getUniqueId();
		}
		$thread = array(
			'id'=>$this->id, 
			'user'=>$this->user, 
			'firstpost'=>$this->firstpost, 
			'post_list'=>$this->post_list, 
			'last_post'=>$this->posted, 
		);
		$out = json_encode($thread);
		$filename=$this->id . '_thread.json';
		file_put_contents(Config::$data_dir . '/threads/' . $filename, $out, FILE_TEXT);

	}

	function getUniqueId() {
		$uid = file_get_contents($this->threadcount);
		if (empty ( $uid ) ) $uid=0;
		file_put_contents($this->threadcount, ($uid + 1), FILE_TEXT);	
		return trim($uid);
	}
}
?>
