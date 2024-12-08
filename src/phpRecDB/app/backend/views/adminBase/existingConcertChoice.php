<script type="text/javascript">
function updateVisibility(){
    var existingConcertsDiv= document.getElementById("existingConcertsList");

    if (document.getElementById("choice").checked == true) {
        existingConcertsDiv.style.visibility  = "visible";
    } else {
        existingConcertsDiv.style.visibility  = "hidden";
    }
}
</script>
    
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'citiesdialog',
    'options' => array(
        'title' => 'Concert already exist!',
        'autoOpen' => true,
        'modal' => true,
        'width' => 'auto',
        'draggable'=> false,
        'resizable' => false,
        'open'=>"js:function(){ $('.ui-dialog-titlebar-close').hide(); }",
        ))
);
?>

    You entered this concert information:<br/>
    <?= $newConcert; ?>
    <br />
    <br />
    There exist already a concert on this date for this artist in the database<br/>
    <br />
    <br />
    
    <div>
    <?= CHtml::beginForm(array('AdminBase/ExistingConcertChoice'), 'post') ?>
        What do you want to do?<br/>
        <?= CHtml::radioButton('choice', true,array('value'=>'appendRecord','onclick'=> 'javascript:updateVisibility()')); ?>
        <label>add new record as additional source for this existing concert</label>
        <div id="existingConcertsList" style="margin: 10px 10px 10px 30px;">
            <?= CHtml::radioButtonList('existingConcerts', $selection, $existingConcerts)  ?>
        </div>
        <?= CHtml::radioButton('choice', false,array('value'=>'newConcert','onclick'=> 'javascript:updateVisibility()')); ?><label>create a new independent concert</label>
        <br />
        <br />
        <?= CHtml::submitButton('OK'); ?>
    <?= CHtml::endForm(); ?>
    </div>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>




