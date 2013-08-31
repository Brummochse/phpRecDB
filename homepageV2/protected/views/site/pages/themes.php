<h1>Guide: Themes</h1>
<p><em>(only for version 1.0 and higher)</em></p>
<p>Since version 1.0 of phpRecDB there is a new frontend customizing mechanism. 
It is based on the <a href='http://www.yiiframework.com/doc/guide/1.1/en/topics.theming'>theming concept of the yii-framework</a>.</p>

<h2>themes-folder</h2>
<p>You can now manage several different themes. Every theme has an own directory. Themes are saved in the directory <?php echo TbHtml::code('phpRecDB/themes/'); ?>. On this picture you can see there are 3 different themes installed on this example:<br>
<?php echo CHtml::image(Yii::app()->baseUrl . '/www/img/themes/themes_dir.jpg'); ?><br>
the <?php echo TbHtml::code('default'); ?>-theme gets selected when no other theme is avaiable.</p>

<h2>changing themes</h2>
<p>
You can switch the themes in administration panal. Go to the Menu Configuration/Theme. Here you can see all installed themes and you can select the theme for your frontend:<br>
    <?php echo CHtml::image(Yii::app()->baseUrl . '/www/img/themes/theme_change.jpg'); ?><br>
</p>