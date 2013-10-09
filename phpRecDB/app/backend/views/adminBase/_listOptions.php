<?php
//signature explanation///////////////////begin
$this->beginWidget('bootstrap.widgets.TbModal', 
        array('id' => 'listOptions'));
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>List Options</h4>
</div>
<div class="modal-body" style="max-height:600px !important;">
    <div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
        
            ));
  
            echo $form->toggleButtonRow($model, 'collapsed');
            $form->checkBoxRow($model,'collapsed');

    ?>
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'OK')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
</div>

<?php 
$this->endWidget(); 
//signature explanation///////////////////end


?>


