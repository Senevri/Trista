<?php
/**
 *	Copying Yhteiso a bit...
 */
class App{
	static public $template;
	static public $config;
	static public $user;
	static public $ctrl;
	static public $lastrq;
	static public $post = false;
	
	public $renderer;

	function __construct(){
		// this takes care we're logged in everywhere on site
		$this->ctrl = new LoginController();
		$this->renderer = new Template(); 
	}

	function index(){
	/*login not yet necessary at manranta*/
		//$this->ctrl->index(); 
		$text = "Running application - Eclipse Edition";
		//$this->renderer->Data['text'] = "Running application - Eclipse Edition";
		$this->renderer->Data['text']=$text;
		$this->renderer->display('pre_content');
	}

	function run(){
		ob_start();
		$this->renderer->display('header');
		switch($_SERVER['REQUEST_METHOD']){
		case 'POST':
			App::$post = true;
			$this->handleRequest($_POST);
			break;
		case 'GET':
			$this->handleRequest($_GET);
			break;
		default:
			break;
		}
		$this->renderer->display('footer');
		ob_end_flush();
	}

	/**
	 *	Expected params: $c ontroller, $a ction $p arams
	 */
	function handleRequest($params){
		if(empty($params) ){
			$this->index();
		} else {
			extract($params);
			$this->lastrq = $params['c'];
			unset($params['c']);
			unset($params['a']);
			if(!empty($c)) {
				$c .= 'Controller';
				$controller = new $c;
				if(empty($a)) $a = 'index';
				try{
					$controller->$a($params);
				} catch (Exception $e) {
					$this->text = "Controller Error: ";
					var_dump($e);
					$this->renderer->display('pre_content');
				}
			} else {
				$this->text = "call to action!";
				$this->$a($p);
			}
		}
	}
}
//?>
