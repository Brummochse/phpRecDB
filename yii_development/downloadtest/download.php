<?php

/**
 * @version		$Id: download.php 2011-04-18 10:23:25Z dirk $
 * @package		DownloadCounter
 * @author		computer-daten-netze :: feenders (Dirk Hoeschen)
 * @authorurl	www.feenders.de
 * @copyright	Copyright (C) 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
$d = new download(@$_REQUEST["file"]);

switch (@$_REQUEST["action"]) {
    case "counter": // counter ausgeben
        header('Content-Type: text/html', true);
        echo "Die Datei wurde " . $d->getCounter() . " mal heruntergeladen";
        break;
    case "download": // default :: datei ausgeben
        if (!$d->download())
            die($d->error);
        break;
}

/**
 * Klasse für den downloadcounter ...
 */
class download {

    /** Downloadordner */
    public $folder = 'downloads/';

    /** Fehlerbehandlung */
    var $error = '';

    /** Test ob Scripthost und Referrer vom gleichen host stammen */
    var $_checkReferrer = true;

    /** Teile des aufgespaltenen Dateinamens */
    protected $fparts = array(
        'counter' => 0,
        'hash' => 0,
        'file' => false
    );

    /**
     * Konstruktor ...
     * @param string $filename name der Datei
     */
    public function __construct($f) {
        if (!empty($f)) {
            // Dateinamen säubern
            $f = preg_replace("/[^0-9a-z.\-_ ]/i", "", strip_tags(trim($f)));
            // verzeichnis lesen
            if (!$dir_handle = @opendir($this->folder)) {
                $this->error = "Unable to open " . $this->folder;
            }
            else
                while ($file = readdir($dir_handle)) {

                    if (!is_dir($file)) {
                       // echo "|(".$file.")|";
                        $fp = preg_split('/&&/', $file, 3);
                        if (end($fp) == $f) {
                            if (count($fp) >= 3) {
                                $this->fparts['counter'] = $fp[0];
                                $this->fparts['hash'] = $fp[1];
                            }
                            $this->fparts['file'] = $f;
                            return true;
                        }
                    }
                }
            $this->error = "File not found: " . $f;
        }
        return false;
    }

    /**
     * Datei Download ...
     */
    public function download() {
        if ($this->fparts['file']) {
            if ($this->_checkReferrer) {
                if (!$this->__checkReferrer()) {
                    $this->error = "No download from other sites allowed";
                    return false;
                }
            }
            $oldfile = ($this->fparts['counter'] == 0) ? $this->fparts['file'] : join("&&", $this->fparts);
            // counter+1, zufallswert ermitteln, datei umbenenenn
            $this->fparts['counter'] = ((int) $this->fparts['counter']) + 1;
            $this->fparts['hash'] = hash("md5", microtime());
            $newfile = join("&&", $this->fparts);
            echo "=".$oldfile."=";
            if (!@rename($this->folder . $oldfile, $this->folder . $newfile)) {
                $this->error = "Unable to acces " . $this->fparts['file'];
            } else {
                // datei mit dem namen ausgeben
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $this->fparts['file'] . '"');
                header("Content-Transfer-Encoding: binary");
                readfile($this->folder . $newfile);
                return true;
            }
        }
        return false;
    }

    /**
     * Gibt den Dateicounter zurück
     */
    public function getCounter() {
        return $this->fparts['counter'];
    }

    /**
     * Teste ob der referrer den gleichen hostnamen wie das script hat
     * Verhindert den Aufruf des Downloadscriptes von einer fremden Seite
     * 
     * @return boolean true or false
     * 
     */
    private function __checkReferrer() {
        $ref = parse_url(@$_SERVER["HTTP_REFERER"]);
        if (strtolower(@$ref['host']) != strtolower($_SERVER['HTTP_HOST'])) {
            return false;
        }
        return true;
    }

}

?>