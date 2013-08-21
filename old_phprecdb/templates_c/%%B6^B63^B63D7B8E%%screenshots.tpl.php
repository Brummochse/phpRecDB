<?php /* Smarty version 2.6.26, created on 2010-07-19 22:24:32
         compiled from admin/screenshots.tpl */ ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/screenshots.css">

<div id="phpRecDbScreenshots">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin/editMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin/concertInfo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="screenshotManagement">

<form action="" method="post" enctype="multipart/form-data">
	<p><input type="file" name="screenshot" /></p>
	<input type="submit" value="upload Screenshot">
        <input type="hidden" name="sent" value="yes">
</form>
<div id="upload_area">
	<?php unset($this->_sections['mysec']);
$this->_sections['mysec']['name'] = 'mysec';
$this->_sections['mysec']['loop'] = is_array($_loop=$this->_tpl_vars['screenshots']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mysec']['show'] = true;
$this->_sections['mysec']['max'] = $this->_sections['mysec']['loop'];
$this->_sections['mysec']['step'] = 1;
$this->_sections['mysec']['start'] = $this->_sections['mysec']['step'] > 0 ? 0 : $this->_sections['mysec']['loop']-1;
if ($this->_sections['mysec']['show']) {
    $this->_sections['mysec']['total'] = $this->_sections['mysec']['loop'];
    if ($this->_sections['mysec']['total'] == 0)
        $this->_sections['mysec']['show'] = false;
} else
    $this->_sections['mysec']['total'] = 0;
if ($this->_sections['mysec']['show']):

            for ($this->_sections['mysec']['index'] = $this->_sections['mysec']['start'], $this->_sections['mysec']['iteration'] = 1;
                 $this->_sections['mysec']['iteration'] <= $this->_sections['mysec']['total'];
                 $this->_sections['mysec']['index'] += $this->_sections['mysec']['step'], $this->_sections['mysec']['iteration']++):
$this->_sections['mysec']['rownum'] = $this->_sections['mysec']['iteration'];
$this->_sections['mysec']['index_prev'] = $this->_sections['mysec']['index'] - $this->_sections['mysec']['step'];
$this->_sections['mysec']['index_next'] = $this->_sections['mysec']['index'] + $this->_sections['mysec']['step'];
$this->_sections['mysec']['first']      = ($this->_sections['mysec']['iteration'] == 1);
$this->_sections['mysec']['last']       = ($this->_sections['mysec']['iteration'] == $this->_sections['mysec']['total']);
?>
	<?php echo '<div class="screenshot"><a href=\'#\' onclick="window.open(\''; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['screenshot_filename']; ?><?php echo '\',\'ratmcover\',\'width=740,height=596,location=no,menubar=no,toolbar=no,status=no,resizable=yes,scrollbars=yes\');"><img src=\''; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['thumbnail']; ?><?php echo '\'></a><div class="buttons"><a href="'; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['backwardLink']; ?><?php echo '"> &lt; </a><a href="'; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['forwardLink']; ?><?php echo '"> &gt; </a><a href="'; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['deleteLink']; ?><?php echo '" alt="delete Screenshot"> X </a></div></div>'; ?>

	<?php endfor; endif; ?>
	<br style="clear:both" />
</div>
</div>
</div>