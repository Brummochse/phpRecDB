<div id="menu" >
<table>
<tr>
    <td>{if isset($concertEditLink)}
        <a href="{$concertEditLink}">Concert</a>
        {else}Concert{/if}
    </td>
    <td>{if isset($editRecordLink)}
        <a href="{$editRecordLink}">Record</a>
        {else}Record{/if}
    </td>

    {if $videoOrAudio == 'video'}

    <td>{if isset($screenshotsEditorLink)}
        <a href="{$screenshotsEditorLink}">Screenshots</a>
        {else}Screenshots{/if}
    <td>
    <td>{if isset($youtubeEditorLink)}
        <a href="{$youtubeEditorLink}">Youtube Samples</a>
        {else}Youtube Samples{/if}
    </td>

    {/if}
</tr>
</table>
</div>
