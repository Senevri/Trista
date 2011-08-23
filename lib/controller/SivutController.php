<?php
class SivutController extends Controller {
	private $language = "fi";
	function __construct() {
		//this assures we load the footer for every page.
		$page = new Page('frontpage');
	
		if (is_array($page->contents)) {
			foreach($page->contents as $k => $v) {
			$this->$k = $v;
			}			
		}
		$this->template = $page->template;
		
	}
	
	function index(){				
		//$this->display("Leiska.html");
	
		//echo $this->body;
		$this->display($this->template);
	}
	
	// Mökit
	function cabins(){
		$page = new Page();
		$page->load('cabins');
		extract($page->content);
		$this->display($page->template);
		
	}
	function in_english(){
		$page = new Page();
		$page->load('cabins');
		extract($page->content);
		$this->display($page->template);
	}
	function in_finnish(){
		$page = new Page();
		$page->load('cabins');
		extract($page->content);
		$this->display($page->template);
	}
	//info
	function info(){
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
