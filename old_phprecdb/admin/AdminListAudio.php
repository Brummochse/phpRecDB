<?php
include_once "AdminListCustom.php";

class ContentPage extends AdminListCustom {
    public function __construct() {
        parent::__construct(AUDIO);
    }
}

?>
