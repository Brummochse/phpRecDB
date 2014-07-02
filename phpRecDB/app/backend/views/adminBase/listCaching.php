<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'List Caching',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
     'headerButtons' => array(
         Yii::app()->helpCreator->renderModalAndGetHelpBtn($this,'listCaching')
    )
));
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'inlineForm',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
            ));
    
    echo $form->toggleButtonRow($model, 'value',array('hint'=>'<strong>Maximum Cache Size: </strong>'.(Yii::app()->cache->maxSize/1024./1024.)." MB"));
    ?>


    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php $this->endWidget();?>