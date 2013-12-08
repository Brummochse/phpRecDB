<?php
$jsConnectListsJs =
        '$(function() {' .
        '    $("#listLeft, #listRight").sortable({' .
        '        connectWith: ".connectedSortable"' .
        '    }).disableSelection();' .
        '});';
Yii::app()->getClientScript()->registerScript("listConnectorJs", $jsConnectListsJs);
?>

<?php
//start build avoid moving not allowed cols js
$jsCheckColMoveJs =
        'function isMovingAllowed(event, ui) {';
foreach ($notMoveableCols as $col) {
    $jsCheckColMoveJs .= 'if (ui.item.context.id == "' . $col . '") return false; ';
}
$jsCheckColMoveJs.= ' return true; }';
Yii::app()->getClientScript()->registerScript("jsCheckColMoveJs", $jsCheckColMoveJs);
// end
?>

<?php
Yii::app()->getClientScript()->registerCss('listCss', '#listLeft, #listRight { border:solid 1px black; list-style-type: none; margin-left:  auto !important; margin-right: auto !important; padding: 0; background: #555555; padding: 10px; width: 150px;}' .
        '#listLeft li, #listRight li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em;  background: #FFFFFF; border:0;}' .
        '#evilLayoutTable {width:100%;} #evilLayoutTable td {text-align: center;}'
);
?>


<?php
$this->renderPartial('_listColConfigHelp');
$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Configure List Columns for ' . $title,
    'htmlOptions' => array('class' => 'bootstrap-box-small'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse',
            'buttons' => array(
                array('label' => 'Help', 'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#sigExplain',
                    ))
            ),
        ),
    )
));

?>

<div class="well">

    <table id="evilLayoutTable">
        <colgroup width="50%"></colgroup>
        <colgroup width="50$"></colgroup>
        <tr>
            <td><h4>visible columns</h4></td>
            <td><h4>hidden columns</h4></td>
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
                            return isMovingAllowed(event,ui);
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
    'params' => array(ParamHelper::PARAM_SELECTED_COLS => $defaults)
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

