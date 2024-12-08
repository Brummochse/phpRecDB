<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'install-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'name',
        'size',
        'create_time',
        array(
            'class' => 'CButtonColumn',
            'template' => ' {download} {restore} {delete}',
            'buttons' => array
                (
                'download' => array
                    (
                    'url' => 'Yii::app()->createUrl("backup/download", array("file"=>$data["name"]))',
                    'label' => 'Download',
                    'imageUrl' => Yii::app()->params['wwwUrl'] . '/images/download.png',
                ),
                'restore' => array
                    (
                    'url' => 'Yii::app()->createUrl("backup/restore", array("file"=>$data["name"]))',
                    'label' => 'Restore',
                    'imageUrl' => Yii::app()->params['wwwUrl'] . '/images/restore.png',
                    'options' => array(
                        'confirm' => 'Are you sure you want restore this backup? This will overwrite the current settings.',
                    ),
                ),
                'delete' => array
                    (
                    'url' => 'Yii::app()->createUrl("backup/delete", array("file"=>$data["name"]))',
                ),
            ),
        ),
    ),
));
?>