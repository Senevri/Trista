<?php 
	//var_dump($pictures);
	foreach($pictures as $p) {	
			//echo $p['path'];
			?> 
			<div class="galimage"><a href="<?php echo Config::$http_location . "/sivut/kuvat/" . $p['id']?>">
			<img height="300" src="/beta/data/images/<?php echo $p['identifier']?>"/>
			</a>
			<?php if (App::$user instanceof User): ?>
			<div class="image_ctrl" style="width: auto; color:black;">
				<span style="margin-right:20px;">Poista</span>
		
				
				<form name="sel"
					action="<?=Config::$http_location ?>/hallinta/tallenna" 
					method="post">
				<input type="hidden" name="c" value="hallinta"/>
				<input type="hidden" name="a" value="tallenna"/>
				<input type="hidden" name="picture" value="<?=$p['id']?>"/>
				<span>Valitse sivu:</span>
				<select name="page">
					<option value="none">ei mit&auml;&auml;n</option>
					<?php 
					foreach($pages as $pg){
						?><option value=<?=$pg['id']?>><?=$pg['name']?></option> <?
					}
					?>
				</select>
				<span style="margin-left:20px;">
				<input type="submit" value="Tallenna" />
				<!-- a href="/mansikka/hallinta/tallenna">Tallenna</a --></span>
				</form>
				
				
			</div>
			<?php endif; ?>
			</div>
			<?
		
	}

?>