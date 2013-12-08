<?php

class AdminMenuItems {

    private static $instance = NULL;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (NULL === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function createSubListMenu() {
        $sublistModels = Sublist::model()->findAll();
        $subListItems = array();
        foreach ($sublistModels as $sublistModel) {
            $newSublistMenuItem = array('label' => $sublistModel->label, 'url' => array('adminBase/sublist', ParamHelper::PARAM_SUBLIST_ID => $sublistModel->id));
            $subListItems[] = $newSublistMenuItem;
        }
        $sublistMenu = array('label' => 'Sublists', 'visible' => count($subListItems) > 0);
        if (count($subListItems) > 0) {
            $sublistMenu['items'] = $subListItems;
        } else {
            $sublistMenu['visible'] = false;
        }

        return $sublistMenu;
    }

    public function createAdminMenuItems() {
        return array(
            array('label' => 'Records',
                'items' => array(
                    array('label' => 'Add Record', 'url' => array('adminBase/addRecord')),
                    array('label' => 'Manage Records', 'url' => array('adminBase/listRecords')),
                    $this->createSubListMenu(),
                ),
            ),
            array('label' => 'Configuration',
                'items' => array(
                    array('label' => 'Sublist Management', 'url' => array('sublist/admin')),
                    array('label' => 'Theme', 'url' => array('adminBase/theme')),
                    array('label' => 'Signature Management', 'url' => array('signature/admin')),
                    array('label' => 'Screenshots',
                        'items' => array(
                            array('label' => 'Watermark', 'url' => array('watermark/index')),
                            array('label' => 'Compression', 'url' => array('adminBase/screenshotCompression')),
                        )
                    ),
                    array('label' => 'List Presets',
                        'items' => array(
                            array('label' => 'Aspect Ratio', 'url' => array('aspectratio/admin')),
                            array('label' => 'Medium', 'url' => array('medium/admin')),
                            array('label' => 'Rectype', 'url' => array('rectype/admin')),
                            array('label' => 'Source', 'url' => array('source/admin')),
                            array('label' => 'Tradestatus', 'url' => array('tradestatus/admin')),
                            array('label' => 'Videoformat', 'url' => array('videoformat/admin')),
                        ),
                    ),
                    array('label' => 'User Management', 'visible' => !Yii::app()->user->isDemo(),
                        'items' => array(
                            array('label' => 'Users', 'url' => array('user/admin'), 'visible' => Yii::app()->user->isAdmin()),
                            array('label' => 'My Profile', 'url' => array('user/profile')),
                        )
                    ),
                    array('label' => 'List Columns', 'items' => array(
                            array('label' => 'Frontend', 'url' => array('adminBase/listColConfigFrontend')),
                            array('label' => 'Admininistration Panel', 'url' => array('adminBase/listColConfigBackend')),
                        )
                    ),
                    array('label' => 'Statistics', 'items' => array(
                            array('label' => 'Screenshots', 'url' => array('adminBase/screenshotStatistics')),
                            array('label' => 'Last Record Visitors', 'url' => array('adminBase/recordVisitStatistics')),
                        )
                    )
                ),
            ),
            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('adminBase/logout')),
        );
    }

}

?>
