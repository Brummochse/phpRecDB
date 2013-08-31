<h1>Script Integration Strategies</h1>
<p>
    <em>(only for version 1.0 and higher)</em>
</p>

<p>
    If you wanna use the phpRecDB script with your website, there are 2 different ways, to integrate the script into your homepage:<br>
<ul>
    <li><a href='?r=site/page&view=internalIntegration'>Internal Integration</a></li>
    <li><a href='?r=site/page&view=externalIntegration'>External Integration</a></li>
</ul>
</p>

<h2>Internal Integration</h2>
<p>This method is new since version 1.0.<br>
    The idea is, that all your page files are included into the phpRecDB theme folder (to be exact: included in a particular theme).
</p>
<p>
This has a big main advantage: you don't have to fight with different designs outside (->external integration) and inside (->theme) phpRecDB.<br>
There is only one file (<?php echo TbHtml::code('index.php'); ?>) left outside the <?php echo TbHtml::code('phpRecDB'); ?>-folder. This file simply starts phpRecDB and setting the correct theme. Now the complete site is working inside this particular phpRecDB-theme.</p>
<p>
    You can see a example file structure on this picture:<br>
    <?php echo CHtml::image(Yii::app()->baseUrl . '/www/img/integration/internal.jpg'); ?>
</p>



<h2>External Integration</h2>
<p>This is the old school way, like it was used in the old phpRecDB versions (from 0.1 to 0.9) exclusively.<br>
    You have files outside the <?php echo TbHtml::code('phpRecDB'); ?>-folder, which are calling phpRecDB-functions. </p>
<p>
    The problem with this way is, it is more complex to design a page , because you have to care about the design of the external pages outside phpRecDB and the files into the selected theme.<br>
    And another problem appears with the new feature, that phpRecDB supports several different themes: If you choose another theme, you have to update your external files, that they will suit to the new selected theme again.
</p>
<p>
    You can see a example file structure on this picture:<br>
<?php echo CHtml::image(Yii::app()->baseUrl . '/www/img/integration/external.jpg'); ?>
</p>