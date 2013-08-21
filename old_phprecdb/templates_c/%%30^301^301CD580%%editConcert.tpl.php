<?php /* Smarty version 2.6.26, created on 2012-07-21 15:44:56
         compiled from admin/editConcert.tpl */ ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/editrecord.css">

<script src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/AutoCompleter.js" type="text/javascript" ></script>
<script src="<?php echo $this->_tpl_vars['relativeTemplatesPath']; ?>
admin/dFilter.js" type="text/javascript" ></script>

<div id="phpRecDb">

<?php if ($this->_tpl_vars['recordingId'] != ''): ?>
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
<?php endif; ?>

<form method="POST" action='<?php echo $this->_tpl_vars['addConcertLink']; ?>
' name="formular" onsubmit="if (!this.submitok) return !!this.submitok"><br>

<?php if ($this->_tpl_vars['recordsPerShowCount'] > 1): ?>
	<div style="border: 2px solid #000000;margin-top:40px;width:600px;margin-left:auto;margin-right:auto;padding:5px">
	There are <?php echo $this->_tpl_vars['recordsPerShowCount']; ?>
 records which belong to this show.<br>
	Do you want change the show-information for:
	
	<div style="margin:10px">
	 <input type="radio" name="morerecords" value="all" checked> all <?php echo $this->_tpl_vars['recordsPerShowCount']; ?>
 records
	<br>
	 <input type="radio" name="morerecords" value="this"> only this record
	</div>
	?
	</div>
	<br>
<?php endif; ?>
<table id="propertyTable">
<colgroup>
	<col id="col_property" />
	<col id="col_value" />
	<col id="col_loading" />
	<col id="col_dbstatus" />
	<col id="col_example" />
</colgroup>

	<tr id="row_header">
			<th></th>
			<th></th>
			<th colspan="2">DB-status</th>
			<th>Example</th>
	</tr>
	<td>Artist:</td>
	<td>
		<input value="<?php echo $this->_tpl_vars['artist']; ?>
" name="artist" autocomplete="off" id="artistsInput"  onblur="javascript:artistsCompleter.OnFocusLost()" onkeydown="javascript:artistsCompleter.keydown(event)" onkeyup="javascript:artistsCompleter.suggest(this.value,event)" type="text"><br>
		<div id="artistsOutput"></div>

	</td>
	<td><div id="artistsLoading"></div></td>
	<td><div id="artistsDbstatus"></div></td>
	<td>Paul McCartney</td>
</tr>
<tr>
	<td>Date:<div style="font-size:0.6em;">(YYYY-MM-DD)</div></td>
	<td>
		<input value="<?php echo $this->_tpl_vars['date']; ?>
" name="date" autocomplete="off" id="dateInput"  onkeydown="javascript: return dFilter (event.keyCode, this, '####-##-##');" type="text"><br>
	</td>
	<td></td>
	<td></td>
	<td>2005-07-02</td>
</tr>
<tr>
	<td>Country:</td>
	<td>
		<input value="<?php echo $this->_tpl_vars['country']; ?>
" name="country" autocomplete="off" id="countryInput" onblur="javascript:countryCompleter.OnFocusLost()"   onkeydown="javascript:countryCompleter.keydown(event)" onkeyup="javascript:countryCompleter.suggest(this.value,event)" type="text"><br>
		<div id="countryOutput"></div>
	</td>
	<td><div id="countryLoading"></div></td>
	<td><div id="countryDbstatus"></div></td>
	<td>U.K.</td>
</tr>
<tr>
	<td>City:</td>
	<td>
		<input value="<?php echo $this->_tpl_vars['city']; ?>
" name="city" autocomplete="off" id="cityInput"  onblur="javascript:cityCompleter.OnFocusLost()" onkeydown="javascript:cityCompleter.keydown(event)" onkeyup="javascript:cityCompleter.suggest(this.value,event)" type="text"><br>
		<div id="cityOutput"></div>
	</td>
	<td><div id="cityLoading"></div></td>
	<td><div id="cityDbstatus"></div></td>
	<td>London</td>
</tr>
<tr>
	<td>Venue:</td>
	<td>
		<input value="<?php echo $this->_tpl_vars['venue']; ?>
" name="venue" autocomplete="off" id="venueInput"  onblur="javascript:venueCompleter.OnFocusLost()" onkeydown="javascript:venueCompleter.keydown(event)" onkeyup="javascript:venueCompleter.suggest(this.value,event)" type="text"><br>
		<div id="venueOutput"></div>
	</td>
	<td><div id="venueLoading"></div></td>
	<td><div id="venueDbstatus"></div></td>
	<td>Hyde Park</td>
</tr>
<tr>
	<td>Supplement:</td>
	<td>
		<input value="<?php echo $this->_tpl_vars['supplement']; ?>
" name="supplement" autocomplete="off" id="supplementInput" type="text">
	</td>
	<td></td>
	<td></td>
	<td>Live8</td>
</tr>
<?php if ($this->_tpl_vars['audioOrVideoSelection'] != 'false'): ?>
<tr>
	<td>Video:</td>
	<td><input type="radio" name="videooraudio" value="video" checked></td> 
</tr>
<tr>
    <td>Audio:</td>
    <td><input type="radio" name="videooraudio" value="audio"></td>
</tr>
<?php endif; ?>
<tr>   
    <td>Misc:</td>
    <td><input type="checkbox" name="misc" value="misc" <?php if ($this->_tpl_vars['misc'] == 'true'): ?>checked<?php endif; ?>></td>
</tr>
</table>

<script type="text/javascript">
	artistsCompleter = new AutoCompleter('artist',
										document.formular.artistsInput,
										document.getElementById('artistsOutput'),
										document.getElementById('artistsLoading'),
										document.getElementById('artistsDbstatus'));
	
	countryCompleter = new AutoCompleter('country',
										document.formular.countryInput,
										document.getElementById('countryOutput'),
										document.getElementById('countryLoading'),
										document.getElementById('countryDbstatus'));
	
	cityCompleter = new AutoCompleter('city',
										document.formular.cityInput,
										document.getElementById('cityOutput'),
										document.getElementById('cityLoading'),
										document.getElementById('cityDbstatus'));
	
	venueCompleter = new AutoCompleter('venue',
										document.formular.venueInput,
										document.getElementById('venueOutput'),
										document.getElementById('venueLoading'),
										document.getElementById('venueDbstatus'));
	
	countryCompleter.setEffectedAutoCompleter(cityCompleter);
	cityCompleter.addParamAutoCompleter(countryCompleter);
	cityCompleter.setEffectedAutoCompleter(venueCompleter);
	venueCompleter.addParamAutoCompleter(cityCompleter);
	venueCompleter.addParamAutoCompleter(countryCompleter);
</script>
  
<input type="submit" onfocus="form.submitok=1" onblur="form.submitok=0">
<input type='hidden' value='<?php echo $this->_tpl_vars['concertId']; ?>
' name='concertid' />
<input type='hidden' value='<?php echo $this->_tpl_vars['recordingId']; ?>
' name='recordingId' />
<input type='hidden' value='1' name='submitted' />
</form>

</div>