<?php

// resolve a path which contains folder up commands /../
// for example: path=a/b/../c/d -> resolvePath(path)=a/c/d
//
function resolvePath($oldPath) {
    $oldPathParts=explode("/",$oldPath);
    $folderUps=array();
    
   for($i=count($oldPathParts)-1; $i > 0 ; $i--)
   {
         if ($oldPathParts[$i]=='..') {
            array_push($folderUps,$i);
        } else {
            if (count($folderUps)>0) {
                unset($oldPathParts[array_pop($folderUps)]);
                unset($oldPathParts[$i]);
            }
        }
   }
   return implode("/", $oldPathParts);
}

// returns a relative path from the source php (=index.php)
function getRelativePathTo($destination) {
    $source =realpath(dirname($_SERVER['SCRIPT_FILENAME']));
    $source=correctPath($source);
    $destination=correctPath($destination);
        
    if ($source==$destination) {
        return '';
    }

    //cut off all parts of both strings,
    //which equals from begin to the first different character
    while ($source[0]==$destination[0]) {
        $source=substr($source,1);
        $destination=substr($destination,1);
    }

    // add a '../' for every remaining directory
    $path="";
    while (stripos($source, "/")>0) {
        $source=substr($source,stripos($source, "/")+1);
        $path=$path."../";
    }

    return resolvePath($path.$destination);
}

function correctPath($path) {
    $path=$path."/";
    $path = str_replace("\\", "/", $path);
    $path = str_replace("//", "/", $path);
    return trim($path);
}


?>
