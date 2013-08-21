<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}admin/screenshots.css">

<div id="phpRecDbScreenshots">

{include file='admin/editMenu.tpl'}
{include file='admin/concertInfo.tpl'}

<div id="screenshotManagement">

<form action="" method="post" enctype="multipart/form-data">
    <table>
    <tr>
        <td>Title</td>
        <td><input name="youtubeTitle" autocomplete="off" type="text" ></td>
    </tr>
    <tr>
        <td>Youtube URL:</td>
        <td><input name="youtubeUrl" autocomplete="off" type="text" ></td>
    </tr>
    </table>

	<input type="submit" value="add youtube sample">
        <input type="hidden" name="sent" value="yes">
</form>
<div id="upload_area">
     {foreach from=$youtubeSamples item=youtubeSample}
     {strip}
	<div class="screenshot">
                <div style="width:180px;">{$youtubeSample.title}</div>
                <object width="192" height="152">
                <param name="movie" value="{$youtubeSample.url}"></param>
                <param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                <embed src="{$youtubeSample.url}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="192" height="152"></embed>
                </object>
                
		<div class="buttons">
			<a href="{$youtubeSample.backwardLink}"> &lt; </a>
			<a href="{$youtubeSample.forwardLink}"> &gt; </a>
			<a href="{$youtubeSample.deleteLink}" alt="delete Screenshot"> X </a>
		</div>
	</div>
    {/strip}
    {/foreach}

    <br style="clear:both" />
</div>
</div>
</div>
