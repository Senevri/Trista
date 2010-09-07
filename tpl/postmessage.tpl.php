<div class="preformatted">
<form action="<?=Config::$http_location?>/tests/" method="post">
<input type="hidden" name="c" value="message">
<input type="hidden" name="a" value="postfile">
<input type="hidden" name="id" value="<?=$this->post->id?>">
<input type="hidden" name="topic" value="<?=$this->post->topic?>">
<input type="hidden" name="posted" value="<?=$this->post->posted?>">
<input type="hidden" name="edited" value="<?=$this->post->edited?>">
<span>Topic: </span><br/>
<input type="text" size=80 name="title" value="<?=$this->post->title?>"><br/>
<span>Body: </span><br/>
<textarea cols=80 rows=25  name="body">
<?=$this->post->body?>
</textarea>
<br>
<input type="submit" value="Post Message"> 
</form>
</div>
