<?php
class SivutController extends Controller {
	function __construct() {
			
	}
	
	function index(){				
		//$this->display("Leiska.html");
		$page = new Page('frontpage');
		//$page->load('frontpage');
		if (is_array($page->contents)) {
			foreach($page->contents as $k => $v) {
			$this->$k = $v;
			}			
		}
		//echo $this->body;
		$this->display($page->template);
	}
	
	// Mökit
	function cabins(){
		$page = new Page();
		$page->load('cabins');
		extract($page->content);
		$this->display($page->template);
		
	}
	// Galleria
	function gallery () {
		$page = new Page();
		$page->load('gallery');
		extract($page->content);
		$this->display($page->template);
	
	}
	
	
}
?>