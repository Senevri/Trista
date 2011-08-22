<div class="preformatted" id="main">
<form action="<?=Config::$http_location?>/" method="post">
<input type="hidden" name="c" value="test">
<input type="hidden" name="a" value="sqlquery">
<span> query: </span><br/>
<textarea cols=80 rows=25 name="p" value=""></textarea>
<br>
<input type="submit" value="Post Query"> 
</form>
<?php foreach($output as $k => $v) {
		echo $k . "\t:\t" . "<code>" . htmlspecialchars($v) . "</code><br/>";		
	}; ?>
</div>