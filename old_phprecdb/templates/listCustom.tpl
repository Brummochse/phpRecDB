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
{section name=i loop=$artists}
{strip}

	{* Creationdate begin *}
            {if $artists[i].concerts[0].records[0].creationDate!=''}
		
		<tr class='datesplit'>
			<td colspan='9' >
			</td>
		</tr>
		
		<tr class='datecell'>
			<td colspan='9' >
				<span class="date">{$artists[i].concerts[0].records[0].creationDate}</span>
			</td>
		</tr>
            {/if}
	{* Creationdate end *}
		
	<tr class="artistcell">
            <td colspan="6" ><span class="artist"><a href="{$artists[i].link}">{$artists[i].name}</a> {$artists[i].misc}</span> [{$artists[i].recordcount} records]</td>
            <td colspan="3" class="yearselector">
                {if $artists[i].years != ''}{$artists[i].years}{/if}
                {if isset($artists[i].artistHtml)}{$artists[i].artistHtml}{/if}
            </td>
        </tr>


	{section name=j loop=$artists[i].concerts}
	{strip}
	
		{assign var="rowspanSet" value="false"}
		{section name=k loop=$artists[i].concerts[j].records}
		{strip}
			
			{if $artists[i].concerts[j].records[k].videoOrAudio != null}
			<tr >
				<td colspan='9' class='videoOrAudio'>
					{$artists[i].concerts[j].records[k].videoOrAudio}
					{$k}
				</td>
			</tr>
			{/if} 
			
			{if $artists[i].concerts[j].newYear!='' && $rowspanSet!='true'}
			<tr >
				<td colspan='9' class='year'>
					<a href='{$artists[i].concerts[j].newYearLink}'>{$artists[i].concerts[j].newYear}</a>
				</td>
			</tr>
			{/if} 
			
			{if $artists[i].concerts[j].records[k].templateAlternate=='true'}
				<tr class="rec1">
			{else}
				<tr class="rec2">
			{/if} 
			
			{if $rowspanSet!='true'} 
				{if $artists[i].concerts[j].recordcount>1} 
					<td class="datetext" style="vertical-align:top" rowspan={$artists[i].concerts[j].recordcount}>{$artists[i].concerts[j].date}</td>
					<td class="artisttext" style="vertical-align:top" rowspan={$artists[i].concerts[j].recordcount}>
					{assign var="rowspanSet" value="true"}
				{else}
					<td class="datetext">{$artists[i].concerts[j].date}</td>
					<td class="artisttext">
				{/if} 
				{$artists[i].concerts[j].country}
				{if $artists[i].concerts[j].city!=''}, {/if}{$artists[i].concerts[j].city}
				{if $artists[i].concerts[j].venue!=''} - {/if}{$artists[i].concerts[j].venue} {$artists[i].concerts[j].supplement}</td>
			{/if} 
			
			<td>{if $artists[i].concerts[j].records[k].length!=''}{$artists[i].concerts[j].records[k].length} min{/if}</td>
			<td>{if $artists[i].concerts[j].records[k].quality!=''}{$artists[i].concerts[j].records[k].quality}/10{/if}</td>
			<td >{$artists[i].concerts[j].records[k].type}</td>
			<td>{$artists[i].concerts[j].records[k].videoformat} {$artists[i].concerts[j].records[k].medium} {if $artists[i].concerts[j].records[k].source!=''}({$artists[i].concerts[j].records[k].source}){/if}</td>
			<td>{$artists[i].concerts[j].records[k].sourceidentification}</td>
			<td class="buttons">{$artists[i].concerts[j].records[k].buttons}</td>
			<td class="tradestatus">{$artists[i].concerts[j].records[k].tradestatus}</td>
		</tr>
		{/strip}
		{/section}
	{/strip}
	{/section}

{/strip}
{/section}
</tr>
</table>
{if $reccount != ''}<div id="reccount">records={$reccount}</div>{/if} 

