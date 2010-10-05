<div class="preformatted">
<span><b>Register</b></span>
<form action="<?=Config::$http_location?>/" method="post"> <!-- unsecure -->
<input type="hidden" name="c" value="login">
<input type="hidden" name="a" value="register">
<input type="text" name="username">
<input type="text" name="password">
<input type="submit" value="Register">
</form>
</div>
