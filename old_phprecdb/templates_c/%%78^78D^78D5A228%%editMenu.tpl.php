<?php /* Smarty version 2.6.26, created on 2012-07-21 15:45:21
         compiled from admin/editMenu.tpl */ ?>
<div id="menu" >
<table>
<tr>
    <td><?php if (isset ( $this->_tpl_vars['concertEditLink'] )): ?>
        <a href="<?php echo $this->_tpl_vars['concertEditLink']; ?>
">Concert</a>
        <?php else: ?>Concert<?php endif; ?>
    </td>
    <td><?php if (isset ( $this->_tpl_vars['editRecordLink'] )): ?>
        <a href="<?php echo $this->_tpl_vars['editRecordLink']; ?>
">Record</a>
        <?php else: ?>Record<?php endif; ?>
    </td>

    <?php if ($this->_tpl_vars['videoOrAudio'] == 'video'): ?>

    <td><?php if (isset ( $this->_tpl_vars['screenshotsEditorLink'] )): ?>
        <a href="<?php echo $this->_tpl_vars['screenshotsEditorLink']; ?>
">Screenshots</a>
        <?php else: ?>Screenshots<?php endif; ?>
    <td>
    <td><?php if (isset ( $this->_tpl_vars['youtubeEditorLink'] )): ?>
        <a href="<?php echo $this->_tpl_vars['youtubeEditorLink']; ?>
">Youtube Samples</a>
        <?php else: ?>Youtube Samples<?php endif; ?>
    </td>

    <?php endif; ?>
</tr>
</table>
</div>