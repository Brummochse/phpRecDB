<?php /* Smarty version 2.6.26, created on 2010-05-24 18:24:58
         compiled from D:%5Cphp%5Cxampp+1.7.3%5Cxampp%5Chtdocs%5CphpRecDB%5CphpRecDB/templates/admin/indexAdmin.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin/menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<br>
<br>
<div style=" text-align:center;border:solid #000000 4px;background:#888888;">
	Status Messages:
	<ul>
	<?php $_from = $this->_tpl_vars['stateMsgs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['stateMsg']):
?>
	    <li><?php echo $this->_tpl_vars['stateMsg']; ?>
</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
</div>

<?php if ($this->_tpl_vars['contentPageTemplate'] != ''): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/".($this->_tpl_vars['contentPageTemplate']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>


<?php echo $this->_tpl_vars['content']; ?>

