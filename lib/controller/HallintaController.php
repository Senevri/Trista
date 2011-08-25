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
		$this->title = "Mansikkaranta - Hallinta";
		$this->footer = "ongelmia? admin@mansikkaranta.net";
	}

	function index(){
		if ($this->has_user) {
			$db = new DBConnection();	
			$pages = $db->fetchTable("pages");
			$this->body = "";			
			foreach($pages as $pg){
				$this->body .= "<span>" . $pg['name'] . "</span></br>"; 
			}		
			$this->display("leiska.html");
		} else {
			$this->display("login_dialog");
		}
	}
	
	function kuvat()
	{
		$index = 1;
		$this->pictures = array();
		$count = Picture::count();
		while($index <= $count) {
			$p = new Picture($index);	
			//if (true == $p->found) {
				$this->pictures[] = $p->getData();				
			//}
			$index = $index + 1;
		}
		$this->pages =Page::get_all();
		
		$this->display('gallery');
		if (App::$user instanceof User) {
			$this->display('upload_image');
		} else {
			$this->display('login_dialog');
		}
	}
	
	function tallenna(){
		if (App::$post) {
			var_dump($_POST);
			
		} else $this->kuvat();
	}
	
	function lisaa_kuva(){
		if ($this->has_user){			
			$p = new Picture();
			
			$this->num_images = $p->count();
			
			//echo "testi --";
			//echo (true == App::$post)?"true " : "false ";
			//echo $_SERVER['REQUEST_METHOD'];
			
			
			if (App::$post) {
			
				echo("uploading...");
				//var_dump($_FILES);
				$uploads_dir=Config::$data_dir . "/images";
				foreach ($_FILES["pictures"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
						$name = $_FILES["pictures"]["name"][$key];
						$identifier = $this->generatename($name);
						//if( strcasecmp(substr($name, -3), 'jpg') ) {
						move_uploaded_file($tmp_name, "$uploads_dir/". $identifier);
						//}
						/* also add to database */
						$p = new Picture();
						$p->name = $name;
						$p->identifier = $identifier;
						$p->save();
						
					}
				}
				
			}
			$this->display("upload_image");
		} else {
			$this->display('login_dialog');
		}
	
	
	}
	
	function lisaa_paikallinen() {
	
	}
	
	private function generatename($filename) {
		return date("YmdHis") . $filename;
	}
	
	
}


?>