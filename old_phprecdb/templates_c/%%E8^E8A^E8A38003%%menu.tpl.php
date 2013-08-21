<?php /* Smarty version 2.6.26, created on 2012-07-21 15:43:04
         compiled from admin/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'admin/menu.tpl', 21, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<link href="menu.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- start menu HTML -->
<div id="menu">

<?php $_from = $this->_tpl_vars['chapters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chapter']):
?>
<?php echo '<ul><li>'; ?><?php if ($this->_tpl_vars['chapter']['link'] != ''): ?><?php echo '<a href="'; ?><?php echo $this->_tpl_vars['chapter']['link']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['chapter']['name']; ?><?php echo '</a>'; ?><?php else: ?><?php echo '<h3>'; ?><?php echo $this->_tpl_vars['chapter']['name']; ?><?php echo '</h3><ul>'; ?><?php $_from = $this->_tpl_vars['chapter']['sections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?><?php echo ''; ?><?php echo '<li><a href="'; ?><?php echo $this->_tpl_vars['section']['link']; ?><?php echo '"  '; ?><?php if (count($this->_tpl_vars['section']['subsections']) > 0): ?><?php echo 'class="x"'; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['section']['name']; ?><?php echo '</a>'; ?><?php if (count($this->_tpl_vars['section']['subsections']) > 0): ?><?php echo '<ul>'; ?><?php $_from = $this->_tpl_vars['section']['subsections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subsection']):
?><?php echo '<li><a href="'; ?><?php echo $this->_tpl_vars['subsection']['link']; ?><?php echo '" >'; ?><?php echo $this->_tpl_vars['subsection']['name']; ?><?php echo '</a></li>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</ul>'; ?><?php endif; ?><?php echo '</li>'; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '</ul>'; ?><?php endif; ?><?php echo '</li></ul>'; ?>

<?php endforeach; endif; unset($_from); ?>
<span style="color:#000000">You are logged in as: <b><?php echo $this->_tpl_vars['userName']; ?>
</b></span>
</div>