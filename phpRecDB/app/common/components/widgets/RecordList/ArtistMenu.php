<?php

class ArtistMenu extends CWidget {
    public $items=null;
    
     public function run() {
            if ($this->items != null) {
                $this->render("artistMenu", array("items" => $this->items));
            }
        }
}

?>
