<?php /* Smarty version 2.6.26, created on 2010-07-20 02:05:59
         compiled from admin/youtubeSamples.tpl */ ?>
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
    <table>
    <tr>
        <td>Title</td>
        <td><input name="youtubeTitle" autocomplete="off" type="text" ></td>
    </tr>
    <tr>
        <td>Youtube URL:</td>
        <td><input name="youtubeUrl" autocomplete="off" type="text" ></td>
    </tr>
    </table>

	<input type="submit" value="add youtube sample">
        <input type="hidden" name="sent" value="yes">
</form>
<div id="upload_area">
     <?php $_from = $this->_tpl_vars['youtubeSamples']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['youtubeSample']):
?>
     <?php echo '<div class="screenshot"><div style="width:180px;">'; ?><?php echo $this->_tpl_vars['youtubeSample']['title']; ?><?php echo '</div><object width="192" height="152"><param name="movie" value="'; ?><?php echo $this->_tpl_vars['youtubeSample']['url']; ?><?php echo '"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'; ?><?php echo $this->_tpl_vars['youtubeSample']['url']; ?><?php echo '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="192" height="152"></embed></object><div class="buttons"><a href="'; ?><?php echo $this->_tpl_vars['youtubeSample']['backwardLink']; ?><?php echo '"> &lt; </a><a href="'; ?><?php echo $this->_tpl_vars['youtubeSample']['forwardLink']; ?><?php echo '"> &gt; </a><a href="'; ?><?php echo $this->_tpl_vars['youtubeSample']['deleteLink']; ?><?php echo '" alt="delete Screenshot"> X </a></div></div>'; ?>

    <?php endforeach; endif; unset($_from); ?>

    <br style="clear:both" />
</div>
</div>
</div>