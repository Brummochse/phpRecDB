



<script>
    $(function() {
        $("#listLeft, #listRight").sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();
    });
    $(function() {
        //$("#listLeft").sortable({cancel: "li div"});

    });

</script>
<style>
    #listLeft, #listRight { border:solid 1px black; list-style-type: none; margin-left:  auto !important; margin-right: auto !important; padding: 0; background: #555555; padding: 10px; width: 150px;}
    #listLeft li, #listRight li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em;  background: #FFFFFF; border:0;}
    #evilLayoutTable {width:100%;} #evilLayoutTable td {text-align: center;}
</style>










<?php
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Configure List Columns',
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
));
?>

<div class="well">

    <table id="evilLayoutTable">
        <colgroup width="50%"></colgroup>
        <colgroup width="50$"></colgroup>
        <tr>
            <td><h4>selected columns</h4></td>
            <td><h4>available columns</h4></td>
        </tr>
        <tr>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiSortable', array(
                    'id' => 'listLeft',
                    'items' => $colsSelected,
                    'htmlOptions' => array(
                        'class' => 'connectedSortable',
                    ),
                    'options' => array(
                        'update' => "js:function(event,ui){
                        if (ui.item.context.innerHTML=='Artist') {
                            return false;
                        }
                }",
                    ),
                ));
                ?>
            </td>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiSortable', array(
                    'id' => 'listRight',
                    'items' => $colsAvailable,
                    'htmlOptions' => array(
                        'class' => 'connectedSortable', // textField size
                    ),
                ));
                ?>
            </td>
        </tr>
    </table>


    <div class="form-actions" style="text-align: center; padding: 10px;">
        <?php
        echo CHtml::button('Restore Defaults', array(
            'submit' => '',
            'class' => "btn btn-inverse",
            'params' => array(ParamHelper::PARAM_SELECTED_COLS => ColumnStock::SETTINGS_DEFAULT)
        ));

        echo CHtml::button('Save', array(
            'submit' => '',
            'params' => array(ParamHelper::PARAM_SELECTED_COLS => 'js:$("#listLeft").sortable("toArray").toString()'),
            'class' => "btn btn-primary",
        ));
        ?>
    </div>
</div>

<?php
$this->endWidget();
?>
