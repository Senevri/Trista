<?php ?>
<div class="preformatted">
<form action="<?=Config::$http_location?>/" method="post">
<?php foreach ($contents as $content):?>
<input type="hidden" name="c" value="hallinta">
<input type="hidden" name="a" value="muutokset">
<input type="hidden" name="id" value="<?=$content->id?>">
<span>Nimi: </span><br/>
<input type="text" size=80 name="title" value="<?=$content->name?>"><br/>
<span>Teksti: </span><br/>
<textarea cols=80 rows=25  name="body">
<?=$content->data?>
</textarea>
<br>
<?php endforeach; ?>
<input type="submit" value="Post Message"> 
</form>
</div>
