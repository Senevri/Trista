<?php
class SivutController extends Controller {
	public $language = "fi";
	function __construct() {
		//this assures we load the footer for every page.
		//$page = new Page('frontpage');
		//if (empty($page)) {
			$page = new Page('etusivu');
		//}
		if (is_array($page->contents)) {
			foreach($page->contents as $k => $v) {
			$this->$k = $v;
			}			
		}
		$this->template = $page->template;		
		
		
	}
	
	function init($params){
		if(isset($params['p']) && !empty($params['p'])){
		$vars = explode("&", $params['p']);
		
		}
		if (!empty($vars) && in_array("en", $vars)){
			$this->language = "en";
		}
		$i = 0;		
		/*
		for($i = 0; $i<sizeof($vars); i++){
			if (($vars) != "en") {
				
			}
		}
		*/
	}
	
	function index($params){	
		$this->init($params);
		//$this->display("Leiska.html");
	
		//echo $this->body;
		$this->display($this->template);
	}
	
	// Mökit
	
	function kuvat($params) {

		$this->init($params);
		var_dump($params);
		$this->display('menu');
		$page = new Page();
		$index = trim($params['p']);		
		if (isset($index) && !empty($index)):
			//$page->load('kuvankatselu');
			//extract($page->contents);
			
			$picture = new Picture($index);
			$this->picture = $picture->getData();
			$page->template = 'kuvankatselu';
			
		else:
			$page->load('galleria');
			extract($page->contents);
			$this->pictures = array();
			// FIXME: copypaste from sivut, bad sign.
			$count = Picture::count();
			$index = 1;
			while($index <= $count) {
				$p = new Picture($index);	
				//if (true == $p->found) {
					$this->pictures[] = $p->getData();				
				//}
				$index = $index + 1;
			}
			//var_dump($this->pictures);
			//echo($page->template);
			/*if (is_array($page->contents)) {
				foreach($page->contents as $k => $v) {
				$this->$k = $v;
				}			
		}*/
		endif;
		$this->template = $page->template;
		
		$this->display($page->template);
	}
	
	function cabins($params){
		$this->init($params);		
	    $this->display('menu');
		$page = new Page();
		$page->load('cabins');
		extract($page->contents);
		//var_dump($page->contents);
		$this->body = $body;
		$this->display($page->template);
		
	}
	function english(){
		$this->init($params);		
		$this->language="en";
		$this->display('menu');
	}
	function finnish(){
		$this->init($params);		
		$this->language="fi";
	}
	//info
	function info($params){
		$this->init($params);		
	    $this->display('menu');
		$page = new Page();
		$page->load('cabins');
		extract($page->contents);
		$this->display($page->template);
		
	}	
	
}
?>
