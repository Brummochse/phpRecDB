<?php

class ListOptionsForm extends SettingsDbModel {

    public $collapsed = false;
    
    public $listId; //name of list, saved to the settings
    
    public function __construct($listId) {
        $this->listId= $listId;
        parent::__construct();
    }

    protected function givePropertiesDbMap() {
        return array(
            'collapsed' => Settings::LIST_COLLAPSED_PREFIX . $this->listId,
        );
    }

    public function rules() {
        return array(
            array('collapsed', 'required'),
            array('collapsed', 'boolean'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'collapsed' => 'Start List Collapsed',
        );
    }

}

?>
