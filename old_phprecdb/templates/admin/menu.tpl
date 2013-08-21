<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<link href="menu.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- start menu HTML -->
<div id="menu">

{foreach from=$chapters item=chapter}
{strip}
		<ul>
		  <li>
		  
			{if $chapter.link != ''}
				<a href="{$chapter.link}">{$chapter.name}</a>
			{else}
			  	<h3>{$chapter.name}</h3>
			    <ul>
			    {foreach from=$chapter.sections item=section}
				{strip}
			     <li><a href="{$section.link}"  {if $section.subsections|@count > 0}class="x"{/if}>{$section.name}</a>
			     {if $section.subsections|@count > 0}
			     	<ul>
					{foreach from=$section.subsections item=subsection}
						<li><a href="{$subsection.link}" >{$subsection.name}</a></li>
			      	{/foreach}
			      	</ul> 
			    {/if}
			    </li>
				{/strip}
				{/foreach} 
			    </ul>
			{/if} 
  
		  </li>
		</ul>
{/strip}
{/foreach}
<span style="color:#000000">You are logged in as: <b>{$userName}</b></span>
</div>
