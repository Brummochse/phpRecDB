<?php /* Smarty version 2.6.26, created on 2011-10-22 10:57:06
         compiled from admin/adminSubList.tpl */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/adminList.js"></script> 
<br>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
list.css">
<div id='phpRecDbList'>
<center>
<?php echo $this->_tpl_vars['artistSelector']; ?>

<hr>
<br>
<form action="" method="POST">
<input type="hidden" name="sent" value="yes">
<input type="submit" name="removeFromSublistBtn" value="remove from List">
<input type="submit" name="deleteBtn" onclick="return confirm('Do you really want delete all selected records?')" value="delete">
<input type="button" value="select all" onClick="selectAll(null)" />
<input type="button" value="deselect all" onClick="deselectAll(null)" />
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'listCustom.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 
 </form>
 
 </center>
</div>