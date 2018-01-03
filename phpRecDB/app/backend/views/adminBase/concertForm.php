<?php
echo $form->maskedTextFieldGroup($model, 'date', array('widgetOptions'=>array('mask'=>'9999-99-99','htmlOptions'=>array('placeholder'=>'Date'))));
?>

<div class="form-group"><?php echo CHtml::activeLabel($model, 'country', array('class' => 'control-label col-sm-3 ')); ?>
    <div class="col-sm-9">
        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array('htmlOptions'=>array('class'=>'form-control','placeholder'=>'Country'),'model' => $model, 'attribute' => 'country', 'id' => 'country_tf', 'source' => $this->createUrl('suggest/suggestCountry',array('mode'=>'suggest')), 'options' => array('autoFocus' => true, 'minLength' => '0'))); ?>
    </div>
</div>



<div class="form-group"><?php echo CHtml::activeLabel($model, 'city', array('class' => 'control-label col-sm-3 ')); ?>
    <div class="col-sm-9">
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array('htmlOptions'=>array('class'=>'form-control','placeholder'=>'City'),'model' => $model, 'attribute' => 'city', 'id' => 'city_tf', 'options' => array('autoFocus' => true, 'minLength' => '0'),
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


<div class="form-group"><?php echo CHtml::activeLabel($model, 'venue', array('class' => 'control-label col-sm-3 ')); ?>
    <div class="col-sm-9">
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array('htmlOptions'=>array('class'=>'form-control','placeholder'=>'Venue'),'model' => $model, 'attribute' => 'venue', 'options' => array('autoFocus' => true, 'minLength' => '0'),
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


<?php echo $form->textFieldGroup($model, 'supplement'); ?>
<?php echo $form->checkBoxGroup($model, 'misc'); ?>