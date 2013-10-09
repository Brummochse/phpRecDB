<?php

class ListOptionsForm extends SettingsDbModel {

    public $collapsed = false;
    
    private $dbSettingsPrefix="listOptions_collapsed_";
    public $listId; //name of list, saved to the settings
    
    public function __construct($listId) {
        $this->listId= $listId;
        parent::__construct();
    }
    /*
     * redundant code, is needed because only in php 5.3 and above
     * it is possible to use the method form the parent class
     */

    public static function createFromSettingsDb($listId) {
        $settingsDbModel = new ListOptionsForm($listId);
        $settingsDbModel->loadFromSettingsDb();
        return $settingsDbModel;
    }

    protected function givePropertiesDbMap() {
        return array(
            'collapsed' => $this->dbSettingsPrefix . $this->listId,
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
