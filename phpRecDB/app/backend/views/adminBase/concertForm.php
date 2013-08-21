<?php echo $form->maskedTextFieldRow($model, 'date', '9999-99-99'); ?>

<div class="control-group"><?php echo CHtml::activeLabel($model, 'country', array('class' => 'control-label')); ?>
    <div class="controls"> 
        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array('model' => $model, 'attribute' => 'country', 'id' => 'country_tf', 'source' => $this->createUrl('suggest/suggestCountry',array('mode'=>'suggest')), 'options' => array('autoFocus' => true, 'minLength' => '0'))); ?>
    </div>
</div>

<div class="control-group"><?php echo CHtml::activeLabel($model, 'city', array('class' => 'control-label')); ?>
    <div class="controls"> 
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array('model' => $model, 'attribute' => 'city', 'id' => 'city_tf', 'options' => array('autoFocus' => true, 'minLength' => '0'),
            'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('suggest/suggestCity',array('mode'=>'suggest')) . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                country: $("#country_tf").val()
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                    }',
        ));
        ?>        
    </div>
</div>


<div class="control-group"><?php echo CHtml::activeLabel($model, 'venue', array('class' => 'control-label')); ?>
    <div class="controls"> 
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array('model' => $model, 'attribute' => 'venue', 'options' => array('autoFocus' => true, 'minLength' => '0'),
            'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('suggest/suggestVenue',array('mode'=>'suggest')) . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                country: $("#country_tf").val(),
                                city: $("#city_tf").val()
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                    }',
        ));
        ?>      
    </div>
</div>


<?php echo $form->textFieldRow($model, 'supplement'); ?>
<?php echo $form->checkBoxRow($model, 'misc'); ?>

