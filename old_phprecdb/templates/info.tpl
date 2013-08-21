<script type="text/javascript">
    lightBoxCloseImgPath='{$relativeTemplatesPath}images/lightbox/closelabel.gif';
     lightBoxLoadImgPath='{$relativeTemplatesPath}images/lightbox/loading.gif';
</script>

<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}info.css">

<link rel="stylesheet" href="{$relativeTemplatesPath}lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="{$relativeTemplatesPath}js/lightbox/prototype.js"></script>
<script type="text/javascript" src="{$relativeTemplatesPath}js/lightbox/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="{$relativeTemplatesPath}js/lightbox/lightbox.js"></script>


<div id='phpRecDbInfo'>
<div id='infopage'>
<div id='headerinfo'>
<span id='tradestatus'>{$tradestatus}</span>
<span id='dates'>
{if $created != ''}created:{/if} {$created}
{if $lastmodified != ''}last modified:{/if} {$lastmodified}
</span>
</div>

<div id='concertinfo'>
{include file='admin/concertInfo.tpl'}
</div>


<div id='recordinginfo'>
{if $sumlength != ''}<label>Length:</label>{/if}  {$sumlength}
{if $quality != ''}<br><label>Quality:</label>{/if}  {$quality}
{if $rectype != ''}<br><label>Filming Type:</label>{/if}  {$rectype}
{if $medium != ''}<br><label>Media:</label> {$summedia} {$medium}{if $summedia > 1}s{/if}  {/if}
{if $aspectratio != ''}<br><label>Aspect Ratio:</label>{/if}  {$aspectratio}
{if $videoformat != ''}<br><label>Videoformat:</label>{/if}  {$videoformat}
{if $bitrate != ''}<br><label>Bitrate:</label>{$bitrate}{/if}
{if $frequence != ''}<br><label>Frequency:</label>{$frequence}{/if}  
{if $source != ''}<br><label>Source:</label>{/if}  {$source}
{if $sourcenotes != ''}<br><label>Sourcenotes:</label>{/if}  {$sourcenotes}
</div>

{if $taper != '' or $transferer != '' or $authorer != ''}
<div id='participants'>
{if $taper != ''}<label>Taper:</label>{/if}  {$taper}
{if $transferer != ''}<br><label>Transferer:</label>{/if}  {$transferer}
{if $authorer != ''}<br><label>Authorer:</label>{/if}  {$authorer}
</div>
{/if} 

{if $setlist != ''}<div id='setlist'><label>Setlist:</label><br>
{$setlist}
</div>
{/if} 

{if $notes != ''}<div id='notes'><label>Notes:</label><br> 
{$notes}
</div>
{/if} 

{if count($screenshots) > 0}<div id='screenshots'><label>Screenshots:</label><br>
{section name=mysec loop=$screenshots}
{strip}
<a href="{$screenshots[mysec].screenshot_filename}" rel="lightbox[screenshots]" title="{$artist} {$date} {$country} - {$city} {$venue} {$supplement}">
<img src="{$screenshots[mysec].thumbnail}">
</a>

{/strip}
{/section}

{if $aspectratio != ''}
<br/>
<input type="checkbox" onclick="javascript:stretchToAspectRatio(aspectRatioText)" id="stretch" checked> stretch Screenshots to Aspect Ratio
<script type="text/javascript">
		aspectRatioText='{$aspectratio}';
</script>
<script src="{$relativeTemplatesPath}stretchToAspectRatio.js" type="text/javascript" ></script>

{/if}  
</div>
{/if}

{if count($youtubeSamples) > 0}<div id='youtubeSamples'>
    <label>Youtube Samples:</label>
    <div id='embeddedVideos'>
    {foreach from=$youtubeSamples item=youtubeSample}
    {strip}
            <br>
           {$youtubeSample.title}<br>
            <object width="480" height="385">
            <param name="movie" value="{$youtubeSample.url}"></param>
            <param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
            <embed src="{$youtubeSample.url}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed>
            </object>

    {/strip}
    {/foreach}
    </div>
</div>
{/if}





</div>
</div>
{if $signature!='noSign'}
{include file='signature.tpl'}
{/if}