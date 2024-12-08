<?php

class Helper {

    public static function isGdFreeTypeInstalled() {
        if (extension_loaded('gd')) {
            $gdinfo = gd_info();
            if($gdinfo['FreeType Support']) {
                return true;
            }
        }
        return false;
    }

    public static function getFilesFromFolder($folderPath) {
        $fontstyles = array();
        $dp = opendir($folderPath);
        while ($file = readdir($dp)) {
            if (strlen($file) > 3) {
                array_push($fontstyles, $file);
            }
        }
        closedir($dp);
        return $fontstyles;
    }

    public static function removeDir($dir) {
        $it = new RecursiveDirectoryIterator($dir);
        $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $file) {
            if ('.' === $file->getBasename() || '..' === $file->getBasename())
                continue;
            if ($file->isDir())
                rmdir($file->getPathname());
            else
                unlink($file->getPathname());
        }
        rmdir($dir);
    }

    public static function startsWith($haystack, $needle, $case = true) {
        if ($case)
            return strncmp($haystack, $needle, strlen($needle)) == 0;
        else
            return strncasecmp($haystack, $needle, strlen($needle)) == 0;
    }

    public static function endsWith($haystack, $needle, $case = true) {
        return startsWith(strrev($haystack), strrev($needle), $case);
    }

    public static $dropBoxDefaultNullStr = array('empty' => array("" => "-"));
    public static $dropBoxDefaultNull =array('htmlOptions' => array('empty'=>'-'));


    // if a value is a string == $dropBoxDefaultNullStr, it gets converted to NULL
    public static function convertNullStrValsToNull($arrayToConvert) {
        $nullStr = key(self::$dropBoxDefaultNullStr['empty']);
        foreach ($arrayToConvert as $key => $val) {
            if ($val == $nullStr)
                $arrayToConvert[$key] = NULL;
        }
        return $arrayToConvert;
    }

    /**
     * generateCountedArray(3,6) returns array( 3=>3 , 4=>4 , 5=>5 , 6=>6 )
     */
    public static function generateCountedArray($start, $max) {
        $result = array();
        $i = $start;
        while ($i <= $max) {
            $result[$i] = $i;
            $i++;
        }
        return $result;
    }

    /**
     * duplicates the values of a array to the keys (array[i]=i)
     * 
     */
    public static function parallelArray($array) {
        return array_combine($array, $array);
    }

    public static function checkSlashes($url) {
        return str_replace("\\", "/", $url);
    }

    public static function convertRgbToHex($R, $G, $B) {

        $R = dechex($R);
        If (strlen($R) < 2)
            $R = '0' . $R;

        $G = dechex($G);
        If (strlen($G) < 2)
            $G = '0' . $G;

        $B = dechex($B);
        If (strlen($B) < 2)
            $B = '0' . $B;

        return '#' . $R . $G . $B;
    }

    public static function findAllBySomeAttributes(CActiveRecord $model, array $attributes)
    {
        $resultRecords=[];
        foreach ($attributes as $attribute=>$value) {
            $records = $model->findAllByAttributes(array($attribute => $value));
            foreach ($records as $record) {
                $resultRecords[$record->getPrimaryKey()]=$record;
            }
        }
        return array_values($resultRecords);
    }

}

?>
