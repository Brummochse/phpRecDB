<h2>{$c_artist}<h2>
<h3>{$c_date}</h3>
{if $miscBoolean==true}
	<h5>MISC</h5>
{/if}


<form method="POST" action="{$appendRecordingLink}" name="formular" >
	<table>
		<tr>
			<td>
				<input type="radio" name="select" value="new" checked> 
			</td>
			<td>
				new Entry
			</td>
		</tr>
		{foreach from=$concerts item=concert}
		{strip}

		<tr>
			<td>
				<input type="radio" name="select" value="{$concert.id}"> 
			</td>
			<td>
				{$concert.date} {$concert.country} {$concert.city} {$concert.venue} {$concert.supplement}
			</td>
		</tr>
		{/strip}
		{/foreach}
	</table>
	<input type="submit">
</form>