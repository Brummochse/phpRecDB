<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title><?= CHtml::encode($this->pageTitle) ?></title>

        <style type="text/css">
            #sign {
                margin-top:30px;
                text-align: center;
                font-size: 0.7em;
            }
            #sign A {
                text-decoration:  underline;
                font-weight:bold;
            }
            #sign A:hover {
                text-decoration: none;
                font-weight:bolder;
            }
        </style>
    </head>
    <body>

        <?= $content ?>

        <div id="sign">
            Powered by <a href="http://www.phprecdb.com">phpRecDB</a> Version <?=Yii::app()->params['version'] ?>
        </div>

    </body>
</html>