<?php

class CMaxSizeFileCache extends CFileCache {

    //set by config
    public $maxSize = 52428800; //=50 * 1024 * 1024 = 50 MegaBytes
    
    protected function getValue($key) {
        $cacheFile = $this->getCacheFile($key);
        touch($cacheFile); //to update the "last access time"
        return @file_get_contents($cacheFile, false, null, $this->embedExpiry ? 10 : -1);
    }

    private function gcFileSize() {
        $cachedFiles = $this->getCacheFiles();
        $size = $this->calcSize($cachedFiles);

        $sizeToRemove = $size - $this->maxSize;

        while ($sizeToRemove > 0) {
            $lastAccessedFileKey = $this->getLastAccessedFileKey($cachedFiles);
            $lastAccessedFile = $cachedFiles[$lastAccessedFileKey];
            unset($cachedFiles[$lastAccessedFileKey]);
            $sizeToRemove-=$lastAccessedFile[1];
            @unlink($lastAccessedFile[0]);
        }
    }

    private function getLastAccessedFileKey($cachedFiles) {
        if (count($cachedFiles) == 0) {
            return null;
        }
        $lastAccessedKey = key($cachedFiles);

        foreach ($cachedFiles as $key => $cachedFile) {
            if ($cachedFiles[$lastAccessedKey][2] > $cachedFiles[$key][2]) {
                $lastAccessedKey = $key;
            }
        }
        return $lastAccessedKey;
    }

    private function calcSize($cachedFiles) {
        $size = 0;
        foreach ($cachedFiles as $cachedFile) {
            $size+=$cachedFile[1]; //contasin the size of the file
        }
        return $size;
    }

    private function getCacheFiles() {

        $files = array();

        $path = $this->cachePath;
        if (($handle = opendir($path)) === false)
            return;
        while (($file = readdir($handle)) !== false) {
            if ($file[0] === '.')
                continue;
            $fullPath = $path . DIRECTORY_SEPARATOR . $file;

            $lastAccess = date("F d Y H:i:s.", fileatime($fullPath));
            $fileSize = filesize($fullPath);
            $files[] = array($fullPath, $fileSize, $lastAccess);
        }
        closedir($handle);

        return $files;
    }

    protected function setValue($key, $value, $expire) {
        $this->gcFileSize();
        parent::setValue($key, $value, $expire);
    }

}

?>