<?php /* Smarty version 2.6.26, created on 2011-07-27 23:52:50
         compiled from D:%5CProgrammierung%5Cphp%5Cxampp+installationen%5Cxampp+1.7.4%5Chtdocs%5CphpRecDB%5CphpRecDB/templates/info.tpl */ ?>
<script type="text/javascript">
    lightBoxCloseImgPath='<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
images/lightbox/closelabel.gif';
     lightBoxLoadImgPath='<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
images/lightbox/loading.gif';
</script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
info.css">

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
js/lightbox/prototype.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
js/lightbox/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
js/lightbox/lightbox.js"></script>


<div id='phpRecDbInfo'>
<div id='infopage'>
<div id='headerinfo'>
<span id='tradestatus'><?php echo $this->_tpl_vars['tradestatus']; ?>
</span>
<span id='dates'>
<?php if ($this->_tpl_vars['created'] != ''): ?>created:<?php endif; ?> <?php echo $this->_tpl_vars['created']; ?>

<?php if ($this->_tpl_vars['lastmodified'] != ''): ?>last modified:<?php endif; ?> <?php echo $this->_tpl_vars['lastmodified']; ?>

</span>
</div>

<div id='concertinfo'>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin/concertInfo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>


<div id='recordinginfo'>
<?php if ($this->_tpl_vars['sumlength'] != ''): ?><label>Length:</label><?php endif; ?>  <?php echo $this->_tpl_vars['sumlength']; ?>

<?php if ($this->_tpl_vars['quality'] != ''): ?><br><label>Quality:</label><?php endif; ?>  <?php echo $this->_tpl_vars['quality']; ?>

<?php if ($this->_tpl_vars['rectype'] != ''): ?><br><label>Filming Type:</label><?php endif; ?>  <?php echo $this->_tpl_vars['rectype']; ?>

<?php if ($this->_tpl_vars['medium'] != ''): ?><br><label>Media:</label> <?php echo $this->_tpl_vars['summedia']; ?>
 <?php echo $this->_tpl_vars['medium']; ?>
<?php if ($this->_tpl_vars['summedia'] > 1): ?>s<?php endif; ?>  <?php endif; ?>
<?php if ($this->_tpl_vars['aspectratio'] != ''): ?><br><label>Aspect Ratio:</label><?php endif; ?>  <?php echo $this->_tpl_vars['aspectratio']; ?>

<?php if ($this->_tpl_vars['videoformat'] != ''): ?><br><label>Videoformat:</label><?php endif; ?>  <?php echo $this->_tpl_vars['videoformat']; ?>

<?php if ($this->_tpl_vars['bitrate'] != ''): ?><br><label>Bitrate:</label><?php echo $this->_tpl_vars['bitrate']; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['frequence'] != ''): ?><br><label>Frequency:</label><?php echo $this->_tpl_vars['frequence']; ?>
<?php endif; ?>  
<?php if ($this->_tpl_vars['source'] != ''): ?><br><label>Source:</label><?php endif; ?>  <?php echo $this->_tpl_vars['source']; ?>

<?php if ($this->_tpl_vars['sourcenotes'] != ''): ?><br><label>Sourcenotes:</label><?php endif; ?>  <?php echo $this->_tpl_vars['sourcenotes']; ?>

</div>

<?php if ($this->_tpl_vars['taper'] != '' || $this->_tpl_vars['transferer'] != '' || $this->_tpl_vars['authorer'] != ''): ?>
<div id='participants'>
<?php if ($this->_tpl_vars['taper'] != ''): ?><label>Taper:</label><?php endif; ?>  <?php echo $this->_tpl_vars['taper']; ?>

<?php if ($this->_tpl_vars['transferer'] != ''): ?><br><label>Transferer:</label><?php endif; ?>  <?php echo $this->_tpl_vars['transferer']; ?>

<?php if ($this->_tpl_vars['authorer'] != ''): ?><br><label>Authorer:</label><?php endif; ?>  <?php echo $this->_tpl_vars['authorer']; ?>

</div>
<?php endif; ?> 

<?php if ($this->_tpl_vars['setlist'] != ''): ?><div id='setlist'><label>Setlist:</label><br>
<?php echo $this->_tpl_vars['setlist']; ?>

</div>
<?php endif; ?> 

<?php if ($this->_tpl_vars['notes'] != ''): ?><div id='notes'><label>Notes:</label><br> 
<?php echo $this->_tpl_vars['notes']; ?>

</div>
<?php endif; ?> 

<?php if (count ( $this->_tpl_vars['screenshots'] ) > 0): ?><div id='screenshots'><label>Screenshots:</label><br>
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
<?php echo '<a href="'; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['screenshot_filename']; ?><?php echo '" rel="lightbox[screenshots]" title="'; ?><?php echo $this->_tpl_vars['artist']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['date']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['country']; ?><?php echo ' - '; ?><?php echo $this->_tpl_vars['city']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['venue']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['supplement']; ?><?php echo '"><img src="'; ?><?php echo $this->_tpl_vars['screenshots'][$this->_sections['mysec']['index']]['thumbnail']; ?><?php echo '"></a>'; ?>

<?php endfor; endif; ?>

<?php if ($this->_tpl_vars['aspectratio'] != ''): ?>
<br/>
<input type="checkbox" onclick="javascript:stretchToAspectRatio(aspectRatioText)" id="stretch" checked> stretch Screenshots to Aspect Ratio
<script type="text/javascript">
		aspectRatioText='<?php echo $this->_tpl_vars['aspectratio']; ?>
';
</script>
<script src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
stretchToAspectRatio.js" type="text/javascript" ></script>

<?php endif; ?>  
</div>
<?php endif; ?>

<?php if (count ( $this->_tpl_vars['youtubeSamples'] ) > 0): ?><div id='youtubeSamples'>
    <label>Youtube Samples:</label>
    <div id='embeddedVideos'>
    <?php $_from = $this->_tpl_vars['youtubeSamples']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['youtubeSample']):
?>
    <?php echo '<br>'; ?><?php echo $this->_tpl_vars['youtubeSample']['title']; ?><?php echo '<br><object width="480" height="385"><param name="movie" value="'; ?><?php echo $this->_tpl_vars['youtubeSample']['url']; ?><?php echo '"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'; ?><?php echo $this->_tpl_vars['youtubeSample']['url']; ?><?php echo '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>'; ?>

    <?php endforeach; endif; unset($_from); ?>
    </div>
</div>
<?php endif; ?>





</div>
</div>
<?php if ($this->_tpl_vars['signature'] != 'noSign'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'signature.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>