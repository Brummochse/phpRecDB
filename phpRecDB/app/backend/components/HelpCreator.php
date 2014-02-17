<?php

class HelpCreator extends CApplicationComponent {

    //counter for the html ids (for the case when more than 1 help dialog)
    private static $modalCounter = 0;

    //set by config
    public $helpFilesPath = null;
    
    public function renderModalAndGetHelpBtn($controller, $helpFile) {
        self::$modalCounter++;
        $modalDialogId='helpModal'.self::$modalCounter;
        
        $controller->beginWidget('bootstrap.widgets.TbModal', array('id' => $modalDialogId));
        $controller->renderPartial($this->helpFilesPath.'.' . $helpFile);
        $controller->endWidget();

        $bootstrapButtonGroupHelp = array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'inverse',
            'buttons' => array(
                array('label' => 'Help', 'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#'.$modalDialogId,
                    ))
            ),
        );
        return $bootstrapButtonGroupHelp;
    }
}
?>
