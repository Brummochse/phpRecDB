<h1>Guide: Upgrade existing Installation</h1>

<p>This guide explains how to <em>upgrade an existing</em> phpRecDB installation to a newer version!</p>

<p><h2>step 1.</h2> backup <b>ALL</b> your files from your webspace, for the case something goes wrong!!!</p>

<p><h2>step 2.</h2> backup your <b>complete</b> MySQL database, for the case something goes wrong!!!</p>

<p><h2>step 3.</h2>download and decompress the latest version of the phpRecDB script.</p>

<p><h2>step
    4.</h2>go to your current installation folder and delete all folders and files in the dirctory <?php echo TbHtml::code('phpRecDB'); ?>
<b>except</b> this folders:<br>
<ul>
    <li><?php echo TbHtml::code('phpRecDB/settings'); ?></li>
    <li><?php echo TbHtml::code('phpRecDB/screenshots'); ?></li>
    <li><?php echo TbHtml::code('phpRecDB/themes'); ?></li>
</ul>
</p>

<p><h2>step
    5.</h2>copy all other folders and files from the new version into your <?php echo TbHtml::code('phpRecDB'); ?> folder (do NOT overwrite the 2 folders <?php echo TbHtml::code('settings'); ?> and <?php echo TbHtml::code('screenshots'); ?></p>

<p><h2>step 6.</h2>log into administration panel (and follow Database upgrading instructions, if required)</p>

<h2>finish</h2>