<?php /* Smarty version 2.6.26, created on 2011-10-22 12:44:47
         compiled from admin/dbEtreeImport.tpl */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/v2.standalone.full.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/editrecord.css">
<div id="phpRecDb" style="border:solid 2px;">

<?php if (! isset ( $this->_tpl_vars['recordsCount'] )): ?>
	select here the csv file you exported from db.etree (usually 'export.csv').<br>
	only csv files created from db.etree can be used here.<br>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="<?php echo $this->_tpl_vars['uploadFileName']; ?>
"><br>
    <input type="submit" value="Hochladen">
    </form>
<?php endif; ?>

<?php if (isset ( $this->_tpl_vars['recordsCount'] )): ?>
    <p>found <?php echo $this->_tpl_vars['recordsCount']; ?>
 in this file</p>
    <p><?php echo $this->_tpl_vars['nextRow']; ?>
 records are already added</p>
<br><br>
    <form action="" method="POST" class="validate">
    add records in one step (max 100): <input type="text" name="recordsPerStep" class="numeric min-val_1 max-val_100 required" value="<?php echo $this->_tpl_vars['recordsPerStep']; ?>
">
    media types for detecting video records: <input type="text" name="mediaVideo" class="required" value="<?php echo $this->_tpl_vars['mediaVideo']; ?>
">
    media types for detecting audio records: <input type="text" name="mediaAudio" class="required" value="<?php echo $this->_tpl_vars['mediaAudio']; ?>
">


    <?php if (isset ( $this->_tpl_vars['recordinfo'] )): ?>
    <div style="background:#999999;margin:20px;border:1px #000000;">
        error: cannot detect if this is a audio or video record:<br><br>
        <b><?php echo $this->_tpl_vars['recordinfo']; ?>
</b>
        <br><br>
        please select:<br>
        <table>
        <tr>
            <td>Video:</td>
                <td><input type="radio" name="videooraudio" value="video" checked></td>
        </tr>
        <tr>
            <td>Audio:</td>
            <td><input type="radio" name="videooraudio" value="audio"></td>
        </tr>
        </table>
    </div>
    <?php endif; ?>
    <input type="submit" value="next step">
    <input type="hidden" name="nextRow" value="<?php echo $this->_tpl_vars['nextRow']; ?>
">
    </form>
<?php endif; ?>

</div>
<?php unset($this->_sections['logMsg']);
$this->_sections['logMsg']['name'] = 'logMsg';
$this->_sections['logMsg']['loop'] = is_array($_loop=$this->_tpl_vars['log']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['logMsg']['step'] = ((int)-1) == 0 ? 1 : (int)-1;
$this->_sections['logMsg']['show'] = true;
$this->_sections['logMsg']['max'] = $this->_sections['logMsg']['loop'];
$this->_sections['logMsg']['start'] = $this->_sections['logMsg']['step'] > 0 ? 0 : $this->_sections['logMsg']['loop']-1;
if ($this->_sections['logMsg']['show']) {
    $this->_sections['logMsg']['total'] = min(ceil(($this->_sections['logMsg']['step'] > 0 ? $this->_sections['logMsg']['loop'] - $this->_sections['logMsg']['start'] : $this->_sections['logMsg']['start']+1)/abs($this->_sections['logMsg']['step'])), $this->_sections['logMsg']['max']);
    if ($this->_sections['logMsg']['total'] == 0)
        $this->_sections['logMsg']['show'] = false;
} else
    $this->_sections['logMsg']['total'] = 0;
if ($this->_sections['logMsg']['show']):

            for ($this->_sections['logMsg']['index'] = $this->_sections['logMsg']['start'], $this->_sections['logMsg']['iteration'] = 1;
                 $this->_sections['logMsg']['iteration'] <= $this->_sections['logMsg']['total'];
                 $this->_sections['logMsg']['index'] += $this->_sections['logMsg']['step'], $this->_sections['logMsg']['iteration']++):
$this->_sections['logMsg']['rownum'] = $this->_sections['logMsg']['iteration'];
$this->_sections['logMsg']['index_prev'] = $this->_sections['logMsg']['index'] - $this->_sections['logMsg']['step'];
$this->_sections['logMsg']['index_next'] = $this->_sections['logMsg']['index'] + $this->_sections['logMsg']['step'];
$this->_sections['logMsg']['first']      = ($this->_sections['logMsg']['iteration'] == 1);
$this->_sections['logMsg']['last']       = ($this->_sections['logMsg']['iteration'] == $this->_sections['logMsg']['total']);
?>
<br><?php echo $this->_tpl_vars['log'][$this->_sections['logMsg']['index']]; ?>

<?php endfor; endif; ?>