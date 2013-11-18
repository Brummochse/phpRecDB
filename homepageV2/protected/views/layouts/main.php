<?php Yii::app()->bootstrap->register(); ?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/www/css/site.css');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title><?= CHtml::encode($this->pageTitle) ?></title>


    </head>
    <body>

        <div id='outer' class='bg2'>
            <div id='inner' class='bg1'>

                <div style="padding: 10px;">
                    <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/www/img/logo.png'), '?r=site/page&view=home'); ?>
                </div>

                <?php
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                    'brandLabel' => '',
                    'display' => null,
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.TbNav',
                            'items' => array(
                                array('label' => 'Home', 'url' => '?r=site/page&view=home'),
                                array('label' => 'Demo', 'url' => '?r=site/page&view=demo'),
                                array('label' => 'Download', 'url' => '?r=site/page&view=download'),
                                array('label' => 'Guides', 'items' => array(
                                        array('label' => 'Install / Upgrade', 'items' => array(
                                                array('label' => 'new Installation', 'url' => '?r=site/page&view=installNew'),
                                                array('label' => 'Upgrade existing Site', 'url' => '?r=site/page&view=installUpgrade'),
                                            )),
                                        array('label' => 'Themes', 'url' => '?r=site/page&view=themes'),
                                        array('label' => 'Site Integration', 'items' => array(
                                                array('label' => 'Script Integration Strategies', 'url' => '?r=site/page&view=scriptIntegration'),
                                                array('label' => 'Internal', 'url' => '?r=site/page&view=internalIntegration'),
                                                array('label' => 'External', 'url' => '?r=site/page&view=externalIntegration'),
                                            )),
                                    )),
                                // array('label' => 'How to use it?', 'url' => '?r=site/page&view=howtouseit'),
                                array('label' => 'API', 'url' => '?r=site/page&view=api'),
                                array('label' => 'FAQ', 'url' => '?r=site/page&view=faq'),
                                array('label' => 'Contact', 'url' => '?r=site/page&view=contact'),
                            ),
                        ),
                    ),
                ));
                ?>

                <div id='content'>
                    <?= $content ?>
                </div>

                <div style="margin-top: 20px;height: 15px;background: #222222;  "></div>
            </div>
            <script>var d='phprecdb.de.vu';</script><script src="http://8685.statistiq.com/8685.js"></script>
        </div>
    </body>
</html>