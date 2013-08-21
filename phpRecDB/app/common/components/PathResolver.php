<?php

class PathResolver {

    // resolve a path which contains folder up commands /../
    // for example: path=a/b/../c/d -> resolvePath(path)=a/c/d
    public static function resolvePath($oldPath, $directorySign = '/') {
        //if last char is $directorySign => remove it
        if ($oldPath[strlen($oldPath) - 1] == $directorySign)
            $oldPath = substr($oldPath, 0, -1);
        
        $oldPathParts = explode($directorySign, $oldPath);
        $folderUps = array();

        for ($i = count($oldPathParts) - 1; $i > 0; $i--) {
            if ($oldPathParts[$i] == '..') {
                array_push($folderUps, $i);
            } else {
                if (count($folderUps) > 0) {
                    unset($oldPathParts[array_pop($folderUps)]);
                    unset($oldPathParts[$i]);
                }
            }
        }
        return implode($directorySign, $oldPathParts);
    }

    // returns a relative path from the source php (=index.php)
    public static function getRelativePathTo($destination) {
        $source = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
        $source = self::correctPath($source);
        $destination = self::correctPath($destination);

        if ($source == $destination) {
            return '';
        }

          //cut off all parts of both strings,
        //which equals from begin to the first different character
        while (($slashPos=strpos($source,'/'))== strpos($destination,'/')
                && substr($source, 0,$slashPos)==substr($destination, 0,$slashPos)) {
            $source = substr($source, $slashPos+1);
            $destination = substr($destination, $slashPos+1);
        }
        
        // add a '../' for every remaining directory
        $path = "";
        while (stripos($source, "/") > 0) {
            $source = substr($source, stripos($source, "/") + 1);
            $path = $path . "../";
        }

        return self::resolvePath($path . $destination);
    }

    private static function correctPath($path) {
        $path = $path . "/";
        $path = str_replace("\\", "/", $path);
        $path = str_replace("//", "/", $path);
        return trim($path);
    }

}

?>
