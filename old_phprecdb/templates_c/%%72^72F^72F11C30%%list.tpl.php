<?php /* Smarty version 2.6.26, created on 2011-07-27 23:48:37
         compiled from D:%5CProgrammierung%5Cphp%5Cxampp+installationen%5Cxampp+1.7.4%5Chtdocs%5CphpRecDB%5CphpRecDB/templates/list.tpl */ ?>
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
 