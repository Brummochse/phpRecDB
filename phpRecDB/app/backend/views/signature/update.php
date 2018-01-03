<?php

$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Update Signature "' . $model->name.'"',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttons' => array(
                array('label' => 'Manage Signatures', 'buttonType' =>'link', 'url' => array('admin'))
            ),
        ),
    )
));

 $this->renderPartial('_form', array('model' => $model)); 
 
 $this->endWidget(); 
 
 isset($signatureStaticUrl) ? $this->renderPartial('_preview', array('signatureStaticUrl' => $signatureStaticUrl, 'signatureDynamicUrl' => $signatureDynamicUrl, 'signaturePreviewUrl'=>$signaturePreviewUrl)) : ''; 
 
 ?>
