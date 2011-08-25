<div class="preformatted" id="main">
<form action="<?=Config::$http_location?>/" method="post">
<input type="hidden" name="c" value="test">
<input type="hidden" name="a" value="sqlquery">
<span> query: </span><br/>
<textarea cols=80 rows=25 name="p" value=""></textarea>
<br>
<input type="submit" value="Post Query"> 
</form>

<?php 
	if (is_array($output)) {
		foreach($output as $row) {
			if(is_array($row)) {
			foreach ($row as $k => $v) {
				echo $k . "\t:\t" . "<code>" . htmlspecialchars($v) . "</code><span width='20'>\t  \t</span>";		
			}} else {
			
			}
			echo "<br/>";
		}; 
	} else echo $output ?>
</div>