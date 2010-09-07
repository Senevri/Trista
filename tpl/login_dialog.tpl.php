<div class="preformatted">
<form action="<?=Config::$http_location?>/tests/" method="post"> <!-- unsecure -->
<input type="hidden" name="c" value="login">
<input type="hidden" name="a" value="login">
<input type="text" name="username">
<input type="text" name="password">
<input type="submit" value="login">
</form>
</div>
