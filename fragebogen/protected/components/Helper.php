<?php

class Helper {

    public static function decodeIntParam($paramKey, $postOrGet) {
        if (isset($postOrGet[$paramKey])) {
            $valStr = $postOrGet[$paramKey];
            $valInt = (int) $valStr;

            if ('' . $valStr == '' . $valInt) { //check if converted int is the same like the input str
                return $valInt;
            }
        }
        return NULL;
    }

}

?>
