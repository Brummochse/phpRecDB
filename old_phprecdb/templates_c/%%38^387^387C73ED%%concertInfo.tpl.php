<?php /* Smarty version 2.6.26, created on 2012-07-21 15:45:21
         compiled from admin/concertInfo.tpl */ ?>
<h2><?php echo $this->_tpl_vars['artist']; ?>
</h2>
<h3><?php echo $this->_tpl_vars['date']; ?>
</h3>
<h4><?php echo $this->_tpl_vars['country']; ?>
 - <?php echo $this->_tpl_vars['city']; ?>

<br><?php echo $this->_tpl_vars['venue']; ?>
 <?php if ($this->_tpl_vars['supplement'] != ''): ?><br><?php endif; ?><?php echo $this->_tpl_vars['supplement']; ?>
</h4>
<?php if ($this->_tpl_vars['misc'] != ''): ?><h5><?php echo $this->_tpl_vars['misc']; ?>
</h5><?php endif; ?>
<?php if ($this->_tpl_vars['sourceidentification'] != ''): ?><h5>Version: <?php echo $this->_tpl_vars['sourceidentification']; ?>
</h5><?php endif; ?>