<?php
class Model{
	protected function createfile($filename) {
		//$out = "Creating file";
		exec("touch " . Config::$data_dir . '/' . $filename);
		//$this->text = $out;
		//$this->display('pre_content');
	}

}


?>
