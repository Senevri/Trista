<?php
class LoginController extends Controller{
	function index(){
		if (isset($_COOKIE['trista_user'])){
			if($this->cookieLogin()) {
				$this->display('userinfo');
			} else {
				$this->display('login_dialog');
			}
		}else {
			$this->display('login_dialog');
		}
	}
	private function cookieLogin(){
		$params=explode(':::', $_COOKIE['trista_user']);
		if(1<count($params)){
			App::$user = new User($params[0], $params[1]);
			return true;
		} else {
			return false;
		}

	}
	function login($params){
		extract($params);
		if (empty($username) || empty($password)){
			$this->text = "login failed";
			$this->display('pre_content');
			$this->index();
			return;
		}
		$user = new User($username, $password);
		if(!$user->login()) {
			$this->text = "Error: Could not login";
			$this->display('pre_content');
		} else {
			$this->text ="user logged in";
			$this->display('pre_content');
		}
		
	}

	function register($params){
		if($_SERVER['REQUEST_METHOD']=='GET'){
			$this->display('register_dialog');
			return false;	
		}
		extract($params);
		if (empty($username) || empty($password)){
			$this->text = "login failed";
			$this->display('pre_content');
			$this->index();
			return;
		}
		$user = new User($username, $password);
		if(!$user->login()) {
			if($user->register()){
				$this->text = "registered new user";
				$this->display('pre_content');
			} else {
				$this->text = "Error: Could not register";
				$this->display('pre_content');
			}
		}
		$this->text ="user logged in";
		$this->display('pre_content');
		
	}
	function logout(){
		if ($this->cookieLogin()){
			$user = App::$user;
			$user->logout();
			$this->text = "user logged out";
			$this->display('pre_content');
		}
	}
}


?>
