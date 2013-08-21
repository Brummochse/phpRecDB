<script type="text/javascript" src="{$relativeTemplatesPath}admin/v2.standalone.full.min.js"></script>

<link rel="stylesheet" type="text/css" href="{$relativeTemplatesPath}admin/editrecord.css">
<div id="phpRecDb" style="border:solid 2px;">

{if !isset($recordsCount)}
	select here the csv file you exported from db.etree (usually 'export.csv').<br>
	only csv files created from db.etree can be used here.<br>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="{$uploadFileName}"><br>
    <input type="submit" value="Hochladen">
    </form>
{/if}

{if isset($recordsCount)}
    <p>found {$recordsCount} in this file</p>
    <p>{$nextRow} records are already added</p>
<br><br>
    <form action="" method="POST" class="validate">
    add records in one step (max 100): <input type="text" name="recordsPerStep" class="numeric min-val_1 max-val_100 required" value="{$recordsPerStep}">
    media types for detecting video records: <input type="text" name="mediaVideo" class="required" value="{$mediaVideo}">
    media types for detecting audio records: <input type="text" name="mediaAudio" class="required" value="{$mediaAudio}">


    {if isset($recordinfo)}
    <div style="background:#999999;margin:20px;border:1px #000000;">
        error: cannot detect if this is a audio or video record:<br><br>
        <b>{$recordinfo}</b>
        <br><br>
        please select:<br>
        <table>
        <tr>
            <td>Video:</td>
                <td><input type="radio" name="videooraudio" value="video" checked></td>
        </tr>
        <tr>
            <td>Audio:</td>
            <td><input type="radio" name="videooraudio" value="audio"></td>
        </tr>
        </table>
    </div>
    {/if}
    <input type="submit" value="next step">
    <input type="hidden" name="nextRow" value="{$nextRow}">
    </form>
{/if}

</div>
{section name=logMsg loop=$log step=-1}
<br>{$log[logMsg]}
{/section}
