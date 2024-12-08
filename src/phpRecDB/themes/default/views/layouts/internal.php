<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>phpRecDB Demo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <center>
            <h1>phpRecDB Demo</h1>
              <?= CHtml::link('Home', '?r=site/page&view=index'); ?>
            <?= CHtml::link('News', '?r=site/page&view=news'); ?>
            <?= CHtml::link('Records', '?r=site/page&view=records'); ?>
            <?= CHtml::link('Statistics', '?r=site/page&view=statistics'); ?>
            <br /><hr /><br />
            <?php include dirname(__FILE__) . DIRECTORY_SEPARATOR."content.php"; ?>
        </center>
    </body>
</html>
