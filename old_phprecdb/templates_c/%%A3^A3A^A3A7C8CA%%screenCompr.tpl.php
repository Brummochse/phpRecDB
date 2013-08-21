<?php /* Smarty version 2.6.26, created on 2010-12-14 00:31:24
         compiled from admin/screenCompr.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'admin/screenCompr.tpl', 8, false),)), $this); ?>
<br>
  <div style="text-align:center;">
       <div style="text-align:left;width:300px;margin-left:auto;margin-right:auto;border:1px #000000 solid;padding:20px;">
       <b>Compress uploaded Screenshots (for saving memory space)</b>
        <br />
        <br />
        <form action='' method='POST' >
        <?php echo smarty_function_html_radios(array('name' => 'compr','options' => $this->_tpl_vars['compr'],'selected' => $this->_tpl_vars['compr_id'],'separator' => "<br />"), $this);?>


        <br />
        <input type='hidden' value='1' name='submitted' />
        <input type='submit' value='save' />
      
     </form>
      </div>
</div>