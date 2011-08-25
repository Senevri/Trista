<form action='<!-- action -->' 
    method="post" 
	enctype="multipart/form-data">
  <h4>L&auml;het&auml; n&auml;m&auml; tiedostot:</h4>
  <input name="c" type="hidden" value="hallinta"/>
  <input name="a" type="hidden" value="lisaa_kuva"/>  
  <input name="pictures[]" type="file" /><br />
  <input name="pictures[]" type="file" /><br />
  <input type="submit" value="L&auml;het&auml;" />
</form>
<a href="/beta/?c=hallinta&a=kuvat">
<div class="menu"><div class="navi-b">Kuvat</div></div></a>