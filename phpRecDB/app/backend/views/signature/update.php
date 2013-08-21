<?php

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Update Signature "' . $model->name.'"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Signatures', 'url' => array('admin'))
            ),
        ),
    )
));
?>

<?= $this->renderPartial('_form', array('model' => $model)); ?>
<?php $this->endWidget(); ?>

<?= isset($signatureStaticUrl) ? $this->renderPartial('_preview', array('signatureStaticUrl' => $signatureStaticUrl, 'signatureDynamicUrl' => $signatureDynamicUrl)) : ''; ?>
