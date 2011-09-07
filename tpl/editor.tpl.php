<? //php var_dump($page); 
$i = 0; ?>
<script type="text/javascript" src="<?=Config::$http_location?>/static/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function setup() {
   tinyMCE.init({
      mode : "textareas",
      theme : "advanced",
      plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
      theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
      theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
      theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
      //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      theme_advanced_resizing : true
   });
}
setup();
</script>
<div class="main">
<form action="<?=Config::$http_location?>/" method="post">
<input type="hidden" name="c" value="hallinta">
<input type="hidden" name="a" value="muutokset">
<input type="hidden" name="page" value="<?=$page->id?>">
<?php foreach ($page->contents as $k=>$v):?>
<input type="hidden" name="id" value="<?=$content['id']?>">
<span>Nimi: </span><br/>
<input type="text" size=80 name="title_<?=$i?>" value="<?=$k?>"><br/>
<span>Teksti: </span><br/>
<textarea cols=80 rows=12  name="body_<?=$i?>">
<?=$v?>
</textarea>
<br>
<?php $i++; 
endforeach; ?>
<input type="submit" value="Tallenna Muutokset"> 
</form>
</div>
