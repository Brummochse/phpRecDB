<script type="text/javascript" src="{$relativeTemplatesPath}admin/adminList.js"></script> 
<br>
<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}list.css">
<div id='phpRecDbList'>
<center>
{$artistSelector}
<hr>
<br>
<form action="" method="POST">
<input type="hidden" name="sent" value="yes">
<input type="submit" name="moveToSublistBtn" value="move selected Records to Sublist">
 {html_options name=sublist_id options=$sublists }
<input type="submit" name="deleteBtn" onclick="return confirm('Do you really want delete all selected records?')" value="delete">
<input type="button" value="select all" onClick="selectAll(null)" />
<input type="button" value="deselect all" onClick="deselectAll(null)" />
 {include file='listCustom.tpl'}
 
 </form>
 
 </center>
</div>