
{include file='admin/menu.tpl'}

<br>
<br>
<div style=" text-align:center;border:solid #000000 4px;background:#888888;">
	Status Messages:
	<ul>
	{foreach from=$stateMsgs item=stateMsg}
	    <li>{$stateMsg}</li>
	{/foreach}
	</ul>
</div>

{if $contentPageTemplate!=''}
	{include file="admin/$contentPageTemplate"}
{/if}


{$content}

