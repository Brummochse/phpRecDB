<?php /* Smarty version 2.6.26, created on 2011-12-13 23:28:22
         compiled from /media/Volume/Programmierung/php/phpRecDB/phpRecDB/templates/list.tpl */ ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
list.css">
<div id='phpRecDbList'>
<center>
<?php echo $this->_tpl_vars['artistSelector']; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'listCustom.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</center>
</div>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'signature.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 