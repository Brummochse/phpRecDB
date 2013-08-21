<?php /* Smarty version 2.6.26, created on 2010-05-24 18:33:57
         compiled from admin/selectConcert.tpl */ ?>
<h2><?php echo $this->_tpl_vars['c_artist']; ?>
<h2>
<h3><?php echo $this->_tpl_vars['c_date']; ?>
</h3>
<?php if ($this->_tpl_vars['miscBoolean'] == true): ?>
	<h5>MISC</h5>
<?php endif; ?>


<form method="POST" action="<?php echo $this->_tpl_vars['appendRecordingLink']; ?>
" name="formular" >
	<table>
		<tr>
			<td>
				<input type="radio" name="select" value="new" checked> 
			</td>
			<td>
				new Entry
			</td>
		</tr>
		<?php $_from = $this->_tpl_vars['concerts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['concert']):
?>
		<?php echo '<tr><td><input type="radio" name="select" value="'; ?><?php echo $this->_tpl_vars['concert']['id']; ?><?php echo '"></td><td>'; ?><?php echo $this->_tpl_vars['concert']['date']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['concert']['country']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['concert']['city']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['concert']['venue']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['concert']['supplement']; ?><?php echo '</td></tr>'; ?>

		<?php endforeach; endif; unset($_from); ?>
	</table>
	<input type="submit">
</form>