<?php
/**
 *	Copying Yhteiso a bit...
 */
class App{
	static public $template;
	static public $config;
	static public $user;
	static public $ctrl;

	function __construct(){
		// this takes care we're logged in everywhere on site
		$this->ctrl = new LoginController(); 
	}

	function display($template){
		$fileloc = Config::$local_dir . "/tpl/" . $template . ".tpl.php";
		include($fileloc);
	}

	function index(){
		//$ctrl=new LoginController();
		$this->ctrl->index();
		//$this->display('userinfo');
		$this->text = "Running application";
		$this->display('pre_content');

	}

	function run(){
		ob_start();
		$this->display('header');
		switch($_SERVER['REQUEST_METHOD']){
		case 'POST':
			$this->handleRequest($_POST);
			break;
		case 'GET':
			$this->handleRequest($_GET);
			break;
		default:
			break;
		}
		$this->display('footer');
		ob_end_flush();
		//$this->text = "running application";
		//self::$template = "pre_content";
		//$this->display( );
		//$menu = new Menu;
		//$menu->show();v
	}

	/**
	 *	Expected params: $c ontroller, $a ction $p arams
	 */
	function handleRequest($params){
		if(empty($params) ){
			$this->index();
		} else {
			extract($params);
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
					$this->display('pre_content');
				}
			} else {
				$this->text = "call to action!";
				$this->$a($p);
			}
		}
	}
}
//?>
