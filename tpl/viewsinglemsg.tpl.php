<div class="preformatted">
<input type="hidden" name="c" value="message">
<input type="hidden" name="a" value="postfile">
<input type="hidden" name="id" value="<?=$this->post->id?>">
<input type="hidden" name="topic" value="<?=$this->post->topic?>">
<input type="hidden" name="posted" value="<?=$this->post->posted?>">
<input type="hidden" name="edited" value="<?=$this->post->edited?>">
<span class="description"><b>Topic:</b> </span><?=$this->post->title?><br/>
<span class="description"><b>User:</b> </span><?=ucfirst($this->post->user)?><br/>
<span class="description"><b>Body:</b> </span>
<div class="indent">
<?=str_replace("\r\n", "<br/>", $this->post->body)?>

</div>
<br />
<a href="<?=Config::$http_location?>/?c=message&a=list_all"><div class="button">Back to list</div></a>
<? if (App::$user instanceof User): ?>
<a href="<?=$_SERVER['REQUEST_URI']?>&reply"><div class="button">Reply</div></a>
<? endif // has user?> 
<? if (App::$user instanceof User  && App::$user->username == $this->post->user):?> 
<a href="<?=$_SERVER['REQUEST_URI']?>&edit"><div class="button">Edit</div></a>
<? endif // correct user ?>
</div>
