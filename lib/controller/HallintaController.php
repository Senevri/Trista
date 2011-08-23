<?php 
class HallintaController extends Controller{

	private $has_user=false;
	function __construct(){
		$login = new LoginController();
		/*disabled for mansikkaranta layout work*/
		//$login->index();
		if(App::$user instanceof User) {
			$this->has_user=true;
		} else {
			$this->has_user=false;
		}
	}

	function index(){
		if ($this->has_user) {
			$db = new DBConnection();	
			$pages = $db->fetchTable("pages");
			$this->body = "";			
			foreach($pages as $pg){
				$this->body .= "<span>" . $pg['name'] . "</span></br>"; 
			}		
			$this->title = "Mansikkaranta - Hallinta";
			$this->footer = "ongelmia? admin@mansikkaranta.net";
		$this->display("leiska.html");
		} else {
			$this->display('login_dialog');
		}
	}
}


?>