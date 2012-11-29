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
				$this->body .= "<span><a href='" .
					Config::$http_location . "/hallinta/sivut/" .
					$pg['id']."'>" . $pg['name'] . "</a></span></br>"; 
			}		
			$this->display("leiska.html");
		} else {
			$this->display("login_dialog");
		}
	}
	
	function sivut($params){
		if ($this->has_user) {
			$page_id = isset($params['p']) ? $params['p'] : 0;
			if (0 != $page_id) {
				var_dump($page_id);
				/* load selected page, load it's contents,show edit
				for each content*/
				$this->page = new Page($page_id);
				
				$this->display("editor");
			} else {
				//add content to pages thingy?
				$this->index();
			}
		} else {
			$this->display("login_dialog");	
		}
	}
	
	function muutokset($params){
		if ($this->has_user) {
			$page = $params['page'];
			$data = array();
			//FIXME: ugly as hell - comes from editor.tpl.php
			$c_count = (sizeof($params)-2)/2;
			for($i = 0; $i != $c_count; $i++){
				array_push($data, array($params["title_".$i], $params["body_" . $i]));
			}
			foreach ($data as $row ){
				//var_dump($row);
				$c = new Content($row[0]);
				$c->data = $row[1];
				$c->save();	
			//update contents 
			//  set data = $row[1] where page = $page and name = $data[0]
			}
			$this->sivut(array('p'=>$page));
		}
	}
	
	function sivupohja($params){
		if ($this->has_user) {
			$tpl = isset($params['p']) ? $params['p'] : "";
			if ( !empty($tpl)) {
				/* open editor for page */
			}
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
		
		if (App::$user instanceof User) {
			$this->display('upload_image');
		} else {
			$this->display('login_dialog');
		}
		$this->display('gallery');
	
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
			//$this->display("upload_image");
			$this->kuvat();
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
