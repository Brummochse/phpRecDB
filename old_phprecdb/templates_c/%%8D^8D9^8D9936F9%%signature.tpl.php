<?php /* Smarty version 2.6.26, created on 2010-06-01 22:24:34
         compiled from admin/signature.tpl */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/v2.standalone.full.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/editrecord.css">
<div id="phpRecDb">

<form action='' method='POST' class="validate"> 
<table id="propertyTable">
	<tr>
		<td>Enabled:<div style="font-size:0.6em;">Dynamic Signature Creation</div> </td>
		<td><input type="checkbox" name="signature_signatureEnabled" value="true" <?php if ($this->_tpl_vars['signature_signatureEnabled'] == true): ?>checked<?php endif; ?>></td>
	</tr>
	<tr>
		<td>Additional Text:</td>
		<td><input name="signature_additionalText" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_additionalText']; ?>
"></td>
	</tr>

	<tr>
		<td>Records count:<div style="font-size:0.6em;">(1 - 40)</div></td>
		<td><input name="signature_recordsCount" class="numeric min-val_1 max-val_40 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_recordsCount']; ?>
"></td>
	</tr>
        <tr>
		<td>Background transparent:</td>
		<td><input type="checkbox" name="signature_bgTransparent" value="true" <?php if ($this->_tpl_vars['signature_bgTransparent'] == true): ?>checked<?php endif; ?>></td>
	</tr>
        <tr>
            <td>Background Color RGB:<div style="font-size:0.6em;">Red/Green/Blue (0 - 255)</div></td>
		<td>
                    <table><tr>
                    <td><input name="signature_bgColorRed" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_bgColorRed']; ?>
"></td>
                    <td><input name="signature_bgColorGreen" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_bgColorGreen']; ?>
"></td>
                    <td><input name="signature_bgColorBlue" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_bgColorBlue']; ?>
"></td>
                    </tr></table>
                </td>
	</tr>
        <tr>
            <td>Color1 RGB:<div style="font-size:0.6em;">Red/Green/Blue (0 - 255)</div></td>
		<td>
                    <table><tr>
                    <td><input name="signature_color1Red" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color1Red']; ?>
"></td>
                    <td><input name="signature_color1Green" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color1Green']; ?>
"></td>
                    <td><input name="signature_color1Blue" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color1Blue']; ?>
"></td>
                    </tr></table>
                </td>
	</tr>
        <tr>
            <td>Color2 RGB:<div style="font-size:0.6em;">Red/Green/Blue (0 - 255)</div></td>
		<td>
                    <table><tr>
                    <td><input name="signature_color2Red" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color2Red']; ?>
"></td>
                    <td><input name="signature_color2Green" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color2Green']; ?>
"></td>
                    <td><input name="signature_color2Blue" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color2Blue']; ?>
"></td>
                    </tr></table>
                </td>
	</tr>
        <tr>
            <td>Color3 RGB:<div style="font-size:0.6em;">Red/Green/Blue (0 - 255)</div></td>
		<td>
                    <table><tr>
                    <td><input name="signature_color3Red" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color3Red']; ?>
"></td>
                    <td><input name="signature_color3Green" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color3Green']; ?>
"></td>
                    <td><input name="signature_color3Blue" class="numeric min-val_0 max-val_255 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_color3Blue']; ?>
"></td>
                    </tr></table>
                </td>
	</tr>
	<tr>
		<td>JPG Quality:<div style="font-size:0.6em;">(0 - 9)</div></td>
		<td><input name="signature_quality" class="numeric min-val_0 max-val_9 required" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['signature_quality']; ?>
"></td>
	</tr>




</table>
<br>

<input type='hidden' value='1' name='submitted' />
<input type='submit' value='save' />
</form>

<div style="background:#EEEEEE">

<?php if (isset ( $this->_tpl_vars['signaturePicturePath'] )): ?>
<br>
<b>Sample Signature:</b><br>
<img src="<?php echo $this->_tpl_vars['signaturePicturePath']; ?>
" />
<br>
<br>
</div>
<br>


<div style="border:solid 2px;padding:10px;">

<div style="font-size:0.6em;margin:20px;">
Use one of this two links as image-address in your forum-signature.
</div>
<br>
<br>
<label><b>Static Signature Image Path:</b></label>
<input type="text" size="8" value="<?php echo $this->_tpl_vars['signatureImagePath']; ?>
" readonly>
<a target="_blank" href="<?php echo $this->_tpl_vars['signatureImagePath']; ?>
">Test</a>
<br>
<br>
<label><b>Dynamic Signature Creation Path:</b></label>
<input type="text" size="8" value="<?php echo $this->_tpl_vars['dynamicSignaturePath']; ?>
" readonly>
<a target="_blank" href="<?php echo $this->_tpl_vars['dynamicSignaturePath']; ?>
">Test</a>
 <br>
<br>
<br>
<br>
<div style="font-size:0.6em;margin:20px;">
<u><b>Which of these links should i use?</b></u><br><br>
There is a slight difference between this 2 links.<br><br>


<dl>
    <dt><b>Static Signature Image Path:</b></dt>
    <dd>
    <ul>
        <li><font color="green">a real static image file</font></li>
        <li><font color="green">image will be recreated new every time when a new record was added</font></li>
        <li><font color="green">very fast, because image is already rendered</font></li>
        <li><font color="green">should be compatible with all forums which support images</font></li>
        <li><font color="red">maybe cache problem with some browsers</font></li>
    </ul>
    </dd>
    <dt><br><b>Dynamic Signature Creation Path:</b></dt>
    <dd>
    <ul>
        <li><font color="green">i think there should be no cache problem</font></li>
        <li><font color="red">no real image</font></li>
        <li><font color="red">image loading on the fly when calling this link</font></li>
        <li><font color="red">i don't know if all forums can handle this dynamic created image</font></li>
    </ul>
    </dd>
</dl>


</div>
</div>
<?php endif; ?>