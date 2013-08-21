<?php /* Smarty version 2.6.26, created on 2010-05-24 18:41:43
         compiled from admin/watermark.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'admin/watermark.tpl', 28, false),array('function', 'html_options', 'admin/watermark.tpl', 38, false),)), $this); ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/v2.standalone.full.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/editrecord.css">
<div id="phpRecDb">

<form action='' method='POST' class="validate"> 
<table id="propertyTable">
	<tr>
		<td>Watermark Text:</td>
		<td><input type="checkbox" name="textenabled" value="true" <?php if ($this->_tpl_vars['textenabled'] == true): ?>checked<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Text:</td>
		<td><input name="text" class="required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['text']; ?>
"></td>
	</tr>
	
	<tr>
		<td>Fontsize:</td>
		<td><input name="fontsize" class="numeric min-val_1 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['fontsize']; ?>
"></td>
	</tr>
	
	<tr>
		<td>Border:</td>
		<td><input name="textborder" class="numeric required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['textborder']; ?>
"></td>
	</tr>
	<tr>
		<td>Align:</td>
		<td><?php echo smarty_function_html_radios(array('name' => 'align','options' => $this->_tpl_vars['align'],'selected' => $this->_tpl_vars['align_id'],'separator' => "<br />"), $this);?>
</td> 
	</tr>
	<tr>
	<td>Vertical Align:</td>
		<td><?php echo smarty_function_html_radios(array('name' => 'valign','options' => $this->_tpl_vars['valign'],'selected' => $this->_tpl_vars['valign_id'],'separator' => "<br />"), $this);?>
</td> 
	</tr>	
	<tr>
	<td>Fontstyle:</td>
	    <td>
	    	<select name="fontstyle" class="required">
			<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['fontstyles'],'output' => $this->_tpl_vars['fontstyles'],'selected' => $this->_tpl_vars['fontstyleSelection']), $this);?>

			</select>
		</td>
	</tr>	
	<tr>
		<td>Red:<div style="font-size:0.6em;">(0 - 255)</div></td>
		<td><input name="red" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['red']; ?>
"></td>
	</tr>
	<tr>
		<td>Green:<div style="font-size:0.6em;">(0 - 255)</div></td>
		<td><input name="green" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['green']; ?>
"></td>
	</tr>
	<tr>
		<td>Blue:<div style="font-size:0.6em;">(0 - 255)</div></td>
		<td><input name="blue" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['blue']; ?>
"></td>
	</tr>
	<tr>
		<td>Watermark Thumbnails:</td>
		<td><input type="checkbox" name="thumbailenabled" value="true" <?php if ($this->_tpl_vars['thumbailenabled'] == true): ?>checked<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Resize on Thumbail:</td>
		<td><input type="checkbox" name="resizeenabled" value="true" <?php if ($this->_tpl_vars['resizeenabled'] == true): ?>checked<?php endif; ?>></td>
	</tr>	
</table>
<br>

<input type='hidden' value='1' name='submitted' />
<input type='submit' value='save' />
</form>
<br>
Sample Screenshot:<br>
<img src="<?php echo $this->_tpl_vars['previewPicturePath']; ?>
" />
<br>
Sample Thumbnail:<br>
<img src="<?php echo $this->_tpl_vars['previewThumbnailPath']; ?>
" />
</div>
