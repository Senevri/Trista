<?php
class SivutController extends Controller {
	function __construct() {
			
	}
	
	function index(){				
		//$this->display("Leiska.html");
		$page = new Page();
		$page->load('frontpage');
		extract($page->content);		
		$this->display($page->template);
	}
	function cabins(){
		$page = new Page();
		$page->load('cabins');
		extract($page->content);
		$this->display($page->template);
		
	}
	
}
?>