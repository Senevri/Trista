<div id="messagelist">
<a href="<?=Config::$http_location?>/?c=message&a=list_all"><div class="button">Back to list</div></a>
<?php 
$even=false;
foreach($this->messages as $msg) { 
	if ($msg['index']==$this->topic) { ?>
	<a href="<?=Config::$http_location?>/?c=message&a=message&id=<?=$msg['id']?>&reply">
	<div class="button">Reply</div></a>
	<br/>

<?
	}
?>	
	<div class="odd"><hr/>
<? 	$this->post = new Post();
	$this->post->load($msg['id']);
		$this->display('viewmessage'); ?> <hr/></div>
	<!-- <a href="<?=Config::$http_location?>/?c=message&a=message&id=<?=$msg['id']?>">
	<b>User:</b><?=ucfirst($msg['user'])?>  <b>Topic:</b>
	<?=$msg['title']?></a></br>
	<div class="preformatted"><?=$msg['body']?></div> 
	</div> -->
<?
}?>
<br/>
<!-- <a href="<?=Config::$http_location?>/?c=message&a=message"<div class="button">New Message</div></a> -->
</div>
