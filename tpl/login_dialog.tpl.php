<div><div class="main-title login" id="login">
<form action="<?=Config::$http_location?>/<?=App::$lastrq?>" method="post"> <!-- unsecure -->
<input type="hidden" name="c" value="login">
<input type="hidden" name="a" value="login">
<input type="text" name="username">
<input type="password" name="password" id="pwd">
<input type="checkbox" onClick="showhide()" name="v_pass"><span>show password?</span>
<input type="submit" value="login">
</form>
</div></div>
