<?php /* Smarty version 2.6.26, created on 2012-07-21 02:44:14
         compiled from listCustom.tpl */ ?>
<table id="list">
<tr>
	<th>Date</th>
	<th>Location</th>
	<th>Length</th>
	<th>Quality</th>
	<th>Type</th>
	<th>Media(Source)</th>
	<th>Version</th>
	<th></th>
	<th></th>
</tr>
<tr>
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['artists']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
<?php echo ''; ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][0]['records'][0]['creationDate'] != ''): ?><?php echo '<tr class=\'datesplit\'><td colspan=\'9\' ></td></tr><tr class=\'datecell\'><td colspan=\'9\' ><span class="date">'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][0]['records'][0]['creationDate']; ?><?php echo '</span></td></tr>'; ?><?php endif; ?><?php echo ''; ?><?php echo '<tr class="artistcell"><td colspan="6" ><span class="artist"><a href="'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['link']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['name']; ?><?php echo '</a> '; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['misc']; ?><?php echo '</span> ['; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['recordcount']; ?><?php echo ' records]</td><td colspan="3" class="yearselector">'; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['years'] != ''): ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['years']; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if (isset ( $this->_tpl_vars['artists'][$this->_sections['i']['index']]['artistHtml'] )): ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['artistHtml']; ?><?php echo ''; ?><?php endif; ?><?php echo '</td></tr>'; ?><?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?><?php echo ''; ?><?php echo ''; ?><?php $this->assign('rowspanSet', 'false'); ?><?php echo ''; ?><?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['step'] = 1;
$this->_sections['k']['start'] = $this->_sections['k']['step'] > 0 ? 0 : $this->_sections['k']['loop']-1;
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = $this->_sections['k']['loop'];
    if ($this->_sections['k']['total'] == 0)
        $this->_sections['k']['show'] = false;
} else
    $this->_sections['k']['total'] = 0;
if ($this->_sections['k']['show']):

            for ($this->_sections['k']['index'] = $this->_sections['k']['start'], $this->_sections['k']['iteration'] = 1;
                 $this->_sections['k']['iteration'] <= $this->_sections['k']['total'];
                 $this->_sections['k']['index'] += $this->_sections['k']['step'], $this->_sections['k']['iteration']++):
$this->_sections['k']['rownum'] = $this->_sections['k']['iteration'];
$this->_sections['k']['index_prev'] = $this->_sections['k']['index'] - $this->_sections['k']['step'];
$this->_sections['k']['index_next'] = $this->_sections['k']['index'] + $this->_sections['k']['step'];
$this->_sections['k']['first']      = ($this->_sections['k']['iteration'] == 1);
$this->_sections['k']['last']       = ($this->_sections['k']['iteration'] == $this->_sections['k']['total']);
?><?php echo ''; ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['videoOrAudio'] != null): ?><?php echo '<tr ><td colspan=\'9\' class=\'videoOrAudio\'>'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['videoOrAudio']; ?><?php echo ''; ?><?php echo $this->_tpl_vars['k']; ?><?php echo '</td></tr>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['newYear'] != '' && $this->_tpl_vars['rowspanSet'] != 'true'): ?><?php echo '<tr ><td colspan=\'9\' class=\'year\'><a href=\''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['newYearLink']; ?><?php echo '\'>'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['newYear']; ?><?php echo '</a></td></tr>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['templateAlternate'] == 'true'): ?><?php echo '<tr class="rec1">'; ?><?php else: ?><?php echo '<tr class="rec2">'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['rowspanSet'] != 'true'): ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['recordcount'] > 1): ?><?php echo '<td class="datetext" style="vertical-align:top" rowspan='; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['recordcount']; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['date']; ?><?php echo '</td><td class="artisttext" style="vertical-align:top" rowspan='; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['recordcount']; ?><?php echo '>'; ?><?php $this->assign('rowspanSet', 'true'); ?><?php echo ''; ?><?php else: ?><?php echo '<td class="datetext">'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['date']; ?><?php echo '</td><td class="artisttext">'; ?><?php endif; ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['country']; ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['city'] != ''): ?><?php echo ', '; ?><?php endif; ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['city']; ?><?php echo ''; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['venue'] != ''): ?><?php echo ' - '; ?><?php endif; ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['venue']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['supplement']; ?><?php echo '</td>'; ?><?php endif; ?><?php echo '<td>'; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['length'] != ''): ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['length']; ?><?php echo ' min'; ?><?php endif; ?><?php echo '</td><td>'; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['quality'] != ''): ?><?php echo ''; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['quality']; ?><?php echo '/10'; ?><?php endif; ?><?php echo '</td><td >'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['type']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['videoformat']; ?><?php echo ' '; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['medium']; ?><?php echo ' '; ?><?php if ($this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['source'] != ''): ?><?php echo '('; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['source']; ?><?php echo ')'; ?><?php endif; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['sourceidentification']; ?><?php echo '</td><td class="buttons">'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['buttons']; ?><?php echo '</td><td class="tradestatus">'; ?><?php echo $this->_tpl_vars['artists'][$this->_sections['i']['index']]['concerts'][$this->_sections['j']['index']]['records'][$this->_sections['k']['index']]['tradestatus']; ?><?php echo '</td></tr>'; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?>

<?php endfor; endif; ?>
</tr>
</table>
<?php if ($this->_tpl_vars['reccount'] != ''): ?><div id="reccount">records=<?php echo $this->_tpl_vars['reccount']; ?>
</div><?php endif; ?> 
