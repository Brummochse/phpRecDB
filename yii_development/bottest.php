<?php

class Test {
    
    public function __construct() {
        $this->str='hello';
    }
    
    public function getString() {
        return $this->str;
    }
    
    
}


$t=new Test();
echo $t->getString();

?>
