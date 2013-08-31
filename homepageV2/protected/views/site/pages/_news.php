<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/www/css/newsTable.css');
?>

<div id="newsTable">

    <label>2013-08-27</label>
    <p>
        Version 1.0 released
        <?php echo TbHtml::button('more', array('size' => TbHtml::BUTTON_SIZE_SMALL, 'data-toggle' => 'modal','data-target' => '#modal2013_08_27',)); ?>
    </p>

    <label>2010-12-14</label>
    <p>Version 0.6 released</p>

    <label>2010-08-30</label>
    <p>new design template uploaded (demo 3)</p>

    <label>2010-07-20</label>
    <p>Version 0.5 released</p>

    <label>2010-06-02</label>
    <p>Version 0.4 released</p>

    <label>2010-05-26</label>
    <p>Version 0.3 released</p>

</div>
