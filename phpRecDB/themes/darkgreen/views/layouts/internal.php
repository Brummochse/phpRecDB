<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>phpRecDB Demo Website</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <?php Yii::app()->clientScript->registerCssFile( Yii::app()->getTheme()->getBaseUrl().'/css/darkgreenStyle.css'); ?>
    </head>
    <body>
        <div id="wrapper">
            <!-- start header -->
            <div id="header">
                <div id="menu">
                    <ul >

                        <li><?= CHtml::link('Home', '?r=site/page&view=index'); ?></li>
                        <li><?= CHtml::link('News', '?r=site/page&view=news'); ?></li> 
                        <li><?= CHtml::link('Records', '?r=site/page&view=records'); ?></li>
                        <li><?= CHtml::link('Statistics', '?r=site/page&view=statistics'); ?></li>
                        <li><?= CHtml::link('About', '?r=site/page&view=about'); ?></a></li>
                    </ul>
                </div>
                <div id="logo">
                    <h1>phpRecDB</h1>
                    <p>Designed By Free CSS Templates</p>
                </div>
            </div>
            <!-- end header -->
            <!-- start page -->
            <div id="page">

                <?php include dirname(__FILE__) . DIRECTORY_SEPARATOR . "content.php"; ?> 
                
            </div>
            <!-- end page -->
        </div>
        <div id="footer">
            <p class="copyright">&copy;&nbsp;&nbsp;2009 All Rights Reserved &nbsp;&bull;&nbsp; Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
        </div>
    </body>
</html>
