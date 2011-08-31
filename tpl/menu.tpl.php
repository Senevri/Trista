<div class="menu">
<?php 
/* I could load these from the DB... */

if ($language == "fi") {
	$napit = array(
	"Etusivu" => "index",
	"Mökit" => "cabins",
	"Kuvia" => "kuvat",
	"Info" => "info",
	"In english" => "english",
	);
} else {
$napit = array(
	"Frontpage" => "index",
	"Cabins" => "cabins",
	"Pictures" => "kuvat&en",
	"Info" => "info",
	"Suomeksi" => "index",
	);
}

foreach ($napit as $k=>$v):
?>
	<a href="<?php echo Config::$http_location . "/sivut/" . $v; ?>">
		<div class="navi-b"><?php echo htmlentities($k); ?></div>
	</a>		
<?php  endforeach;  ?>	
</div>