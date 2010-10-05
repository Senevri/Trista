<div id="messagelist">
<h2>List of Messages in System:</h2>
<?php 
$even=false;
foreach($this->messages as $msg) { ?>
	<div class="<? if ($even) {echo "even"; $even=false;} else {echo "odd"; $even=true; }?>">
	<a href="<?=Config::$http_location?>/?c=message&a=list_all&topic=<?=$msg['index']?>">
	<b>User:</b><?=ucfirst($msg['user'])?>  <b>Topic:</b>
	<?=$msg['title']?></a></br>
	</div>
<?
}?>
<br/>
<a href="<?=Config::$http_location?>/?c=message&a=message"<div class="button">New Message</div></a>
</div>
