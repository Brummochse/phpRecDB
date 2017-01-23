<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta name="description" content="Rage Against The Machine Video Bootleg Trading Page" />
        <meta name="keywords" content="Rage Against The Machine,Videos,Bootlegs,DVDs,Trading,Trade,Video,Bootleg,RATM" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="index,follow" />
        <title>Rage Against The Machine Video Bootlegs</title>
        <?php Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/style.css'); ?>
    </head>
    <body >
        <div id="top_menu">
            <div style="font-size:24px;font-weight:bold;">Nothing here is for sale!</div>
            <?= CHtml::image(Yii::app()->getTheme()->getBaseUrl() . '/images/logo.png'); ?><br />
            <ul >
                <li><?= CHtml::link('Home', '?r=site/page&view=index'); ?></li>
                <li><?= CHtml::link('News', '?r=site/page&view=news'); ?></li> <!--V2-->
                <li><?= CHtml::link('Rage Against The Machine', '?r=site/page&view=ratm'); ?></li> <!--V2-->
                <li><?= CHtml::link('My Masters', '?r=site/page&view=masters'); ?></li><!--V2-->
                <li><?= CHtml::link('Other Bands', '?r=site/page&view=records'); ?></li>
                <li><?= CHtml::link('My Wants', '?r=site/page&view=mywants'); ?></li>
                <li><?= CHtml::link('Statistics', '?r=site/page&view=statistics'); ?></li>
                <li><?= CHtml::link('Bad Traders', '?r=site/page&view=badtraders'); ?></a></li>
            </ul>
        </div>
       <?php include dirname(__FILE__) . DIRECTORY_SEPARATOR."content.php"; ?>
    </body>
</html>