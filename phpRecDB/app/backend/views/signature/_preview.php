
<?php
//preview image///////////////////begin
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Sample Signature',
));
echo CHtml::image($signaturePreviewUrl);
$this->endWidget();
//preview image///////////////////end
?>

<?php
//signature links///////////////////begin
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Signature Image Link',
));
?>
<p>Use one of this two links as image-address in your forum-signature.</p>
<label><b>Static Signature Image Path:</b></label>
<?= CHtml::link('Test', $signatureStaticUrl, array('target' => '_blank')); ?>    
<?= CHtml::textField('static', $signatureStaticUrl, array('readonly' => true, 'style' => 'width:100%;')); ?>
<br>
<br>
<label><b>Dynamic Signature Creation Path:</b></label>
<?= CHtml::link('Test', $signatureDynamicUrl, array('target' => '_blank')); ?>
<?= CHtml::textField('static', $signatureDynamicUrl, array('readonly' => true, 'style' => 'width:100%;')); ?>

<?php
//signature explanation///////////////////begin
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Which of these links should i use?',
    'type' => 'inverse',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#sigExplain',
)));
$this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'sigExplain'));
?>

<div class="modal-header">
    <h4>Which of these links should i use?</h4>
</div>
<div class="modal-body">
    <p>There is a slight difference between this 2 links.</p>
    <dl>
        <dt><b>Static Signature Image Path:</b></dt>
        <dd>
            <ul>
                <li><font color="green">a real static image file</font></li>
                <li><font color="green">image will be recreated new every time when a new record was added</font></li>
                <li><font color="green">very fast, because image is already rendered</font></li>
                <li><font color="green">should be compatible with all forums which support images</font></li>
                <li><font color="red">maybe cache problem with some browsers</font></li>
            </ul>
        </dd>
        <dt><br><b>Dynamic Signature Creation Path:</b></dt>
        <dd>
            <ul>
                <li><font color="green">i think there should be no cache problem</font></li>
                <li><font color="red">no real image</font></li>
                <li><font color="red">image loading on the fly when calling this link</font></li>
                <li><font color="red">i don't know if all forums can handle this dynamic created image</font></li>
            </ul>
        </dd>
    </dl>
</div>

<?php 
$this->endWidget(); 
//signature explanation///////////////////end

$this->endWidget();
//signature links///////////////////end
?>


