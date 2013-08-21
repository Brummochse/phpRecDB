<?php /* Smarty version 2.6.26, created on 2012-07-21 02:44:13
         compiled from D:%5CProgrammierung%5Cphp%5Cxampp+installationen%5Cxampp-win32-1.7.7-VC9%5Cxampp%5Chtdocs%5CphpRecDB_test%5CphpRecDB/templates/navbar.tpl */ ?>
<div id='navBar'>
<?php unset($this->_sections['index']);
$this->_sections['index']['name'] = 'index';
$this->_sections['index']['loop'] = is_array($_loop=$this->_tpl_vars['navBarElements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['index']['show'] = true;
$this->_sections['index']['max'] = $this->_sections['index']['loop'];
$this->_sections['index']['step'] = 1;
$this->_sections['index']['start'] = $this->_sections['index']['step'] > 0 ? 0 : $this->_sections['index']['loop']-1;
if ($this->_sections['index']['show']) {
    $this->_sections['index']['total'] = $this->_sections['index']['loop'];
    if ($this->_sections['index']['total'] == 0)
        $this->_sections['index']['show'] = false;
} else
    $this->_sections['index']['total'] = 0;
if ($this->_sections['index']['show']):

            for ($this->_sections['index']['index'] = $this->_sections['index']['start'], $this->_sections['index']['iteration'] = 1;
                 $this->_sections['index']['iteration'] <= $this->_sections['index']['total'];
                 $this->_sections['index']['index'] += $this->_sections['index']['step'], $this->_sections['index']['iteration']++):
$this->_sections['index']['rownum'] = $this->_sections['index']['iteration'];
$this->_sections['index']['index_prev'] = $this->_sections['index']['index'] - $this->_sections['index']['step'];
$this->_sections['index']['index_next'] = $this->_sections['index']['index'] + $this->_sections['index']['step'];
$this->_sections['index']['first']      = ($this->_sections['index']['iteration'] == 1);
$this->_sections['index']['last']       = ($this->_sections['index']['iteration'] == $this->_sections['index']['total']);
?>
    <span id='navBarLinks'>
    <a href='<?php echo $this->_tpl_vars['navBarElements'][$this->_sections['index']['index']]['link']; ?>
'><?php echo $this->_tpl_vars['navBarElements'][$this->_sections['index']['index']]['caption']; ?>
</a>

    <?php if (! $this->_sections['index']['last']): ?>
        <span > &gt;</span>
    <?php endif; ?>
    </span>
<?php endfor; endif; ?>
</div>