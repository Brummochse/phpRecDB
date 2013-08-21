<?php /* Smarty version 2.6.26, created on 2012-07-21 15:45:21
         compiled from admin/editRecord.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/editRecord.tpl', 31, false),)), $this); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/editrecord.css">


<div id="phpRecDb">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin/editMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<div id="concertinfo">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin/concertInfo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>


<div id="sublists">
<table>
    <?php $_from = $this->_tpl_vars['relatedSublists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sublistId'] => $this->_tpl_vars['sublistName']):
?>
    <tr>
        <td>
            <form action="" method="POST">
            <input type="submit" value="remove from Sublist">
            <input type="hidden" name="delete" value="<?php echo $this->_tpl_vars['sublistId']; ?>
">
            </form>
        </td>
        <td><?php echo $this->_tpl_vars['sublistName']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<form action="" method="POST">
    <input type="hidden" name="sent" value="sublist">
    <input type="submit" value="add to Sublist">
    <?php echo smarty_function_html_options(array('name' => 'sublist_id','options' => $this->_tpl_vars['sublists']), $this);?>

</form>
</div>

<form action='' method='POST'> 
<table id="propertyTable">
<colgroup>
	<col id="col_property" />
	<col id="col_value" />
	<col id="col_example" />
</colgroup>
<tr id="row_header">
		<th></th>
		<th></th>
		<th>Example</th>
</tr>

<tr>
	<td>Sourceidentification</td>
	<td><input name="sourceidentification" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['sourceidentification']; ?>
"></td>
	<td>Source 2</td>
</tr>
<tr>
	<td>Rectypes</td>
	<td><?php echo $this->_tpl_vars['rectypes']; ?>
</td>
	<td></td>
</tr>
<tr>
	<td>Sources</td>
	<td><?php echo $this->_tpl_vars['sources']; ?>
</td>
	<td></td>
</tr>
<tr>
	<td>Media</td>
	<td><?php echo $this->_tpl_vars['media']; ?>
</td>
	<td></td>
</tr>
<tr>
	<td>Quality<div style="font-size:0.6em;">(0-10, 0=worst 10=best)</div></td>
	<td><input name="quality" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['quality']; ?>
"></td>
	<td>7</td>
</tr>
<tr>
	<td>Length<div style="font-size:0.6em;">(in minutes)</div></td>
	<td><input name="sumlength" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['sumlength']; ?>
"></td>
	<td>75</td>
</tr>
<tr>
	<td>Media count</div></td>
	<td><input name="summedia" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['summedia']; ?>
"></td>
	<td>1</td>
</tr>
<tr>
	<td>Setlist</td>
	<td><textarea id="setlist" name="setlist"><?php echo $this->_tpl_vars['setlist']; ?>
</textarea></td>
	<td>1. first song<br>2. second song<br>3. third song<br>....</td>
</tr>
<tr>
	<td>Notes</td>
	<td><textarea name="notes"><?php echo $this->_tpl_vars['notes']; ?>
</textarea> </td>
	<td>blabla...</td>
</tr>
<tr>
	<td>Sourcenotes</td>
	<td><textarea name="sourcenotes"><?php echo $this->_tpl_vars['sourcenotes']; ?>
</textarea> </td>
	<td>lineage info</td>
</tr>
<tr>
	<td>Taper</td>
	<td><input name="taper" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['taper']; ?>
"></td>
	<td>name of the taper</td>
</tr>
<tr>
	<td>Transferer</td>
	<td><input name="transferer" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['transferer']; ?>
"></td>
	<td>name of the transferer</td>
</tr>
<tr>
	<td>Tradestatus</td>
	<td><?php echo $this->_tpl_vars['tradestatus']; ?>
</td>
	<td></td>
</tr>
<?php if ($this->_tpl_vars['videoOrAudio'] == 'video'): ?>
	<tr>
		<td>Authorer</td>
		<td><input name="authorer" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['authorer']; ?>
"></td>
		<td>name of the authorer</td>
	</tr>
	<tr>
		<td>Format</td>
		<td><?php echo $this->_tpl_vars['videoformat']; ?>
</td>
		<td></td>
	</tr>
	<tr>
		<td>Bitrate</td>
		<td><input name="bitrate" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['bitrate']; ?>
"></td>
		<td>8000</td>
	</tr>
	<tr>
		<td>Aspectratio</td>
		<td><?php echo $this->_tpl_vars['aspectratio']; ?>
</td>
		<td></td>
	</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['videoOrAudio'] == 'audio'): ?>
	<tr>
		<td>Bitrate</td>
		<td><input name="bitrate" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['bitrate']; ?>
"></td>
		<td></td>
	</tr>
	<tr>
		<td>Frequency</td>
		<td><input name="frequence" autocomplete="off" type="text" value="<?php echo $this->_tpl_vars['frequence']; ?>
"></td>
		<td></td>
	</tr>
<?php endif; ?>
	<tr>
		<td>Upgrade:</td>
		<td><input type="checkbox" name="upgrade" value="upgrade"></td>
		<td></td>
	</tr>
	<tr>
		<td>Visible:</td>
		<td><input type="checkbox" name="visible" value="visible" <?php if ($this->_tpl_vars['visible'] == 1): ?>checked<?php endif; ?>></td>
		<td></td>
	</tr>
</table>
<input type='hidden' value='1' name='submitted' />
<input type="hidden" name="sent" value="editRecord">
<input type='submit' value='save' />
</form>
</div>