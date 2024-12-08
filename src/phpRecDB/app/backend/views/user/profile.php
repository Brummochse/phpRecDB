<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'View User "'.$model->username."'",
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
    $this->widget(
        'booster.widgets.TbDetailView',
        array(
            'data' => $model,
            'attributes'=>array(
                'id',
                'username',
                'role',
            ),
        )
    );
     $this->widget('booster.widgets.TbButton', array('label' => 'Change Password', 'url' => array('changePassword'), 'buttonType' =>'link','context' => 'primary'));
$this->endWidget();