<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}admin/editrecord.css">


<div id="phpRecDb">

{include file='admin/editMenu.tpl'}


<div id="concertinfo">
{include file='admin/concertInfo.tpl'}
</div>


<div id="sublists">
<table>
    {foreach from=$relatedSublists item=sublistName key=sublistId}
    <tr>
        <td>
            <form action="" method="POST">
            <input type="submit" value="remove from Sublist">
            <input type="hidden" name="delete" value="{$sublistId}">
            </form>
        </td>
        <td>{$sublistName}</td>
    </tr>
    {/foreach}
</table>
<form action="" method="POST">
    <input type="hidden" name="sent" value="sublist">
    <input type="submit" value="add to Sublist">
    {html_options name=sublist_id options=$sublists }
</form>
</div>

<form action='' method='POST'> 
<table id="propertyTable">
<colgroup>
	<col id="col_property" />
	<col id="col_value" />
	<col id="col_example" />
</colgroup>
<tr id="row_header">
		<th></th>
		<th></th>
		<th>Example</th>
</tr>

<tr>
	<td>Sourceidentification</td>
	<td><input name="sourceidentification" autocomplete="off" type="text" value="{$sourceidentification}"></td>
	<td>Source 2</td>
</tr>
<tr>
	<td>Rectypes</td>
	<td>{$rectypes}</td>
	<td></td>
</tr>
<tr>
	<td>Sources</td>
	<td>{$sources}</td>
	<td></td>
</tr>
<tr>
	<td>Media</td>
	<td>{$media}</td>
	<td></td>
</tr>
<tr>
	<td>Quality<div style="font-size:0.6em;">(0-10, 0=worst 10=best)</div></td>
	<td><input name="quality" autocomplete="off" type="text" value="{$quality}"></td>
	<td>7</td>
</tr>
<tr>
	<td>Length<div style="font-size:0.6em;">(in minutes)</div></td>
	<td><input name="sumlength" autocomplete="off" type="text" value="{$sumlength}"></td>
	<td>75</td>
</tr>
<tr>
	<td>Media count</div></td>
	<td><input name="summedia" autocomplete="off" type="text" value="{$summedia}"></td>
	<td>1</td>
</tr>
<tr>
	<td>Setlist</td>
	<td><textarea id="setlist" name="setlist">{$setlist}</textarea></td>
	<td>1. first song<br>2. second song<br>3. third song<br>....</td>
</tr>
<tr>
	<td>Notes</td>
	<td><textarea name="notes">{$notes}</textarea> </td>
	<td>blabla...</td>
</tr>
<tr>
	<td>Sourcenotes</td>
	<td><textarea name="sourcenotes">{$sourcenotes}</textarea> </td>
	<td>lineage info</td>
</tr>
<tr>
	<td>Taper</td>
	<td><input name="taper" autocomplete="off" type="text" value="{$taper}"></td>
	<td>name of the taper</td>
</tr>
<tr>
	<td>Transferer</td>
	<td><input name="transferer" autocomplete="off" type="text" value="{$transferer}"></td>
	<td>name of the transferer</td>
</tr>
<tr>
	<td>Tradestatus</td>
	<td>{$tradestatus}</td>
	<td></td>
</tr>
{if $videoOrAudio == 'video'}
	<tr>
		<td>Authorer</td>
		<td><input name="authorer" autocomplete="off" type="text" value="{$authorer}"></td>
		<td>name of the authorer</td>
	</tr>
	<tr>
		<td>Format</td>
		<td>{$videoformat}</td>
		<td></td>
	</tr>
	<tr>
		<td>Bitrate</td>
		<td><input name="bitrate" autocomplete="off" type="text" value="{$bitrate}"></td>
		<td>8000</td>
	</tr>
	<tr>
		<td>Aspectratio</td>
		<td>{$aspectratio}</td>
		<td></td>
	</tr>
{/if}
{if $videoOrAudio == 'audio'}
	<tr>
		<td>Bitrate</td>
		<td><input name="bitrate" autocomplete="off" type="text" value="{$bitrate}"></td>
		<td></td>
	</tr>
	<tr>
		<td>Frequency</td>
		<td><input name="frequence" autocomplete="off" type="text" value="{$frequence}"></td>
		<td></td>
	</tr>
{/if}
	<tr>
		<td>Upgrade:</td>
		<td><input type="checkbox" name="upgrade" value="upgrade"></td>
		<td></td>
	</tr>
	<tr>
		<td>Visible:</td>
		<td><input type="checkbox" name="visible" value="visible" {if $visible == 1}checked{/if}></td>
		<td></td>
	</tr>
</table>
<input type='hidden' value='1' name='submitted' />
<input type="hidden" name="sent" value="editRecord">
<input type='submit' value='save' />
</form>
</div>
