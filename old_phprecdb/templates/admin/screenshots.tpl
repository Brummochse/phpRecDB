<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}admin/screenshots.css">

<div id="phpRecDbScreenshots">

{include file='admin/editMenu.tpl'}
{include file='admin/concertInfo.tpl'}

<div id="screenshotManagement">

<form action="" method="post" enctype="multipart/form-data">
	<p><input type="file" name="screenshot" /></p>
	<input type="submit" value="upload Screenshot">
        <input type="hidden" name="sent" value="yes">
</form>
<div id="upload_area">
	{section name=mysec loop=$screenshots}
	{strip}
	<div class="screenshot">
		<a href='#' onclick="window.open('{$screenshots[mysec].screenshot_filename}','ratmcover','width=740,height=596,location=no,menubar=no,toolbar=no,status=no,resizable=yes,scrollbars=yes');"><img src='{$screenshots[mysec].thumbnail}'></a>
		<div class="buttons">		
			<a href="{$screenshots[mysec].backwardLink}"> &lt; </a>
			<a href="{$screenshots[mysec].forwardLink}"> &gt; </a>
			<a href="{$screenshots[mysec].deleteLink}" alt="delete Screenshot"> X </a>
		</div>
	</div>		
	{/strip}
	{/section}
	<br style="clear:both" />
</div>
</div>
</div>
