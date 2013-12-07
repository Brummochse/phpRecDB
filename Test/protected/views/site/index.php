<?php
$this->widget('bootstrap.widgets.TbFileUpload', array(
    'url' => $this->createUrl("site/upload"),
    'model' => $model,
    'attribute' => 'picture', // see the attribute?
    'multiple' => true,
//        'formView'=>'application.components.fileupload.form',
    'options' => array(
        'maxFileSize' => 2000000,
        'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i',
)));
?>
test
