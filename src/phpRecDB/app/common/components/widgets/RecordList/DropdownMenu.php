<?php

class DropdownMenu extends CWidget {
    public $items=null;
    
     public function run() {
            if ($this->items != null) {
                $this->render("dropdownMenu", array("items" => $this->items));
            }
        }
}

?>
