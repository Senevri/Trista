<div id="message">
<a href="<?=Config::$http_location?>/?c=message&a=list_all"><div class="button">Back to list</div></a>
<?php 
$even=false;
foreach($messages as $msg) { 
	if ($msg['index']==$this->topic) { ?>
	<a href="<?=Config::$http_location?>/?c=message&a=message&id=<?=$msg['id']?>&reply">
	<div class="button">Reply</div></a><br/>
	<div class="message">

<?
	}
?>	
	<!-- hr/ --><? 
	$this->post = new Post();
	$this->post->load($msg['id']);
	$this->display('viewmessage'); ?> <hr/>
	<!-- <a href="<?=Config::$http_location?>/?c=message&a=message&id=<?=$msg['id']?>">
	<b>User:</b><?=ucfirst($msg['user'])?>  <b>Topic:</b>
	<?=$msg['title']?></a></br>
	<div class="preformatted"><?=$msg['body']?></div> 
	</div> -->
<?
}?>
</div>
<br/>
<!-- <a href="<?=Config::$http_location?>/?c=message&a=message"<div class="button">New Message</div></a> -->
</div>
