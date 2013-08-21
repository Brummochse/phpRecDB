<script type="text/javascript" src="{$relativeTemplatesPath}admin/v2.standalone.full.min.js"></script>

<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}admin/editrecord.css">
<div id="phpRecDb">

<form action='' method='POST' class="validate"> 
<table id="propertyTable">
	<tr>
		<td>Watermark Text:</td>
		<td><input type="checkbox" name="textenabled" value="true" {if $textenabled == true}checked{/if}></td>
	</tr>
	<tr>
		<td>Text:</td>
		<td><input name="text" class="required" autocomplete="off" type="text" value="{$text}"></td>
	</tr>
	
	<tr>
		<td>Fontsize:</td>
		<td><input name="fontsize" class="numeric min-val_1 required" autocomplete="off" type="text" value="{$fontsize}"></td>
	</tr>
	
	<tr>
		<td>Border:</td>
		<td><input name="textborder" class="numeric required" autocomplete="off" type="text" value="{$textborder}"></td>
	</tr>
	<tr>
		<td>Align:</td>
		<td>{html_radios name="align" options=$align selected=$align_id separator="<br />"}</td> 
	</tr>
	<tr>
	<td>Vertical Align:</td>
		<td>{html_radios name="valign" options=$valign selected=$valign_id separator="<br />"}</td> 
	</tr>	
	<tr>
	<td>Fontstyle:</td>
	    <td>
	    	<select name="fontstyle" class="required">
			{html_options values=$fontstyles output=$fontstyles selected=$fontstyleSelection}
			</select>
		</td>
	</tr>	
	<tr>
		<td>Red:<div style="font-size:0.6em;">(0 - 255)</div></td>
		<td><input name="red" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="{$red}"></td>
	</tr>
	<tr>
		<td>Green:<div style="font-size:0.6em;">(0 - 255)</div></td>
		<td><input name="green" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="{$green}"></td>
	</tr>
	<tr>
		<td>Blue:<div style="font-size:0.6em;">(0 - 255)</div></td>
		<td><input name="blue" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="{$blue}"></td>
	</tr>
	<tr>
		<td>Watermark Thumbnails:</td>
		<td><input type="checkbox" name="thumbailenabled" value="true" {if $thumbailenabled == true}checked{/if}></td>
	</tr>
	<tr>
		<td>Resize on Thumbail:</td>
		<td><input type="checkbox" name="resizeenabled" value="true" {if $resizeenabled == true}checked{/if}></td>
	</tr>	
</table>
<br>

<input type='hidden' value='1' name='submitted' />
<input type='submit' value='save' />
</form>
<br>
Sample Screenshot:<br>
<img src="{$previewPicturePath}" />
<br>
Sample Thumbnail:<br>
<img src="{$previewThumbnailPath}" />
</div>

