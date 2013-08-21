<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants::getClassFolder()."ShowManager.php";
include_once Constants::getClassFolder()."RecordManager.php";
include_once Constants::getClassFolder()."CustomListData.php";


define("ARTIST_NAME", "ArtistName");
define("SHOW_DATE", "ShowDate");

define("SHOW_VENUE", "ShowVenue");
define("SHOW_CITY", "ShowCity");
define("SHOW_STATE", "ShowState");

define("SHOW_SET1", "ShowSet1");
define("SHOW_SET2", "ShowSet2");
define("SHOW_SET3", "ShowSet3");

define("SHOW_NOTES", "ShowNotes");
define("MY_NOTES", "MyNotes");
define("MY_TECHNOTES", "MyTechNotes");
define("MY_SOURCE", "MySource");
define("MY_MEDIATYPE", "MyMediaType");
define("MY_MEDIACOUNT", "MyMediaCount");
define("MY_TAPERNAME", "MyTaperName");


class DbEtreeImporter {

    private $delimiter=',';

    private $fields=array(ARTIST_NAME,
            SHOW_DATE,
            SHOW_VENUE,
            SHOW_CITY,
            SHOW_STATE,
            SHOW_SET1,
            SHOW_SET2,
            SHOW_SET3,
            SHOW_NOTES,
            MY_NOTES,
            MY_TECHNOTES,
            MY_SOURCE,
            MY_MEDIATYPE,
            MY_MEDIACOUNT,
            MY_TAPERNAME);

    private $positions=array();
    private $csvFilePath=null;
    private $lastRecordNumber=null;
    private $lastRecordInfo=null;
    private $log=array();
    private $firstShowVideoOrAudio=null;
    private $firstRow=null;

    public function __construct($csvFilePath) {
        $this->csvFilePath=$csvFilePath;
    }

    public function getCsvRecordsCount() {
        $handle = fopen($this->csvFilePath, "r") ;
        $length=filesize( $this->csvFilePath);
        $counter=0;
        if ($handle !== FALSE) {
            while (($data = fgetcsv($handle, $length, $this->delimiter)) !== FALSE) {
                $counter++;
            }
            fclose($handle);
        }
        return $counter-1; //first line is header
    }

    public function getLog() {
        return $this->log;
    }

    public function getLastAddedRecordNumber() {
        return $this->lastRecordNumber;
    }

    public function getLastRecordInfo() {
        return $this->lastRecordInfo;
    }

    public function parseCsvFile($firstRow,$recordsPerStep,$stopOnError=true,$firstShowVideoOrAudio=null) {
        $this->firstShowVideoOrAudio=$firstShowVideoOrAudio;

        $handle = fopen($this->csvFilePath, "r") ;
        $length=filesize( $this->csvFilePath);
        $successfully=true;

        $counter=0;
        if ($handle !== FALSE) {

            $headerData =fgetcsv($handle, $length, $this->delimiter);
            $this->analyzeHeader($headerData);

            while (($data = fgetcsv($handle, $length, $this->delimiter)) !== FALSE) {
                if ($counter==$firstRow) {
                    $this->firstRow=true;
                } else {
                    $this->firstRow=false;
                }

                if ($counter>=$firstRow) {
                    if  ($this->addRecord($data) == false) {
                        $successfully=false;
                        break;
                    }
                }
                $counter++;
                if ($counter>=$firstRow+$recordsPerStep) {
                    break;
                }
            }
            fclose($handle);
            $this->lastRecordNumber= $counter;
        }
        return $successfully;
    }

//    private function addConcertAndGetID($data) {
//        $artist=$data[$this->positions[ARTIST_NAME]];
//        $date=$this->convertDate($data[$this->positions[SHOW_DATE]]);
//
//        $city=$data[$this->positions[SHOW_CITY]];
//        $country=$this->convertShowState($data[$this->positions[SHOW_STATE]]);
//        if ($country==null) {
//            $country=$data[$this->positions[SHOW_STATE]];
//        } else {
//            $city=$city.", ".$data[$this->positions[SHOW_STATE]];
//        }
//        $venue=$data[$this->positions[SHOW_VENUE]];
//
//        $this->lastRecordInfo=$artist." - ".$date." ".$country." ". $city." ".$venue;
//        $msg=$this->lastRecordInfo." added successfully.";
//        $this->log[]=$msg;
//        return  ShowManager::insertConcertWithTextAndGetId($artist, $date, $country, $city, $venue, '', 0);
//    }

    function evaluateVideoOrAudio($data) {
        $mediaType=strtolower($data[$this->positions[MY_MEDIATYPE]]);
        if (in_array($mediaType,$this->mediasVideo)) {
            return VIDEO;
        } else if (in_array($mediaType,$this->mediasAudio)) {
            return AUDIO;
        } else {
            return VIDEO_AND_AUDIO;
        }
    }

    private function addRecord($data) {
        foreach ($this->positions as $name=>$index) {
            $data[$index]= mysql_real_escape_string(utf8_decode($data[$index]));
        }
        $videoOrAudio=$this->evaluateVideoOrAudio($data);
        $myMediaType=$data[$this->positions[MY_MEDIATYPE]];
        
        //
                 $artist=$data[$this->positions[ARTIST_NAME]];
        $date=$this->convertDate($data[$this->positions[SHOW_DATE]]);

        $city=$data[$this->positions[SHOW_CITY]];
        $country=$this->convertShowState($data[$this->positions[SHOW_STATE]]);
        if ($country==null) {
            $country=$data[$this->positions[SHOW_STATE]];
        } else {
            $city=$city.", ".$data[$this->positions[SHOW_STATE]];
        }
        $venue=$data[$this->positions[SHOW_VENUE]];

        $this->lastRecordInfo=$artist." - ".$date." ".$country." ". $city." ".$venue;
        
        //
        if ($videoOrAudio==VIDEO_AND_AUDIO) {
            if ($this->firstRow && $this->firstShowVideoOrAudio!=null) {
                $videoOrAudio=$this->firstShowVideoOrAudio;
                if ($myMediaType!=null && strlen($myMediaType)>1) {
                    if ($videoOrAudio==VIDEO) {
                        $this->mediasVideo[]=strtolower($myMediaType);
                        }
                    if ($videoOrAudio==AUDIO) {
                        $this->mediasAudio[]=strtolower($myMediaType);
                    }
                }
            } else {
                $this->log[]='<font color="red">'.$this->lastRecordInfo.
                        '  ERROR. no audio or vidoe information detected. found mediatype: '.
                        $myMediaType.'</font>';
                return false;
            }

        }
        //addConcertAndGetID////////////////7
        $msg=$this->lastRecordInfo." added successfully.";
        $this->log[]=$msg;
         $concertId=  ShowManager::insertConcertWithTextAndGetId($artist, $date, $country, $city, $venue, '', 0);
        ////////////////////////////////7
        $recordId=RecordManager::createRecordAndGetId($concertId);

        $setlist=$data[$this->positions[SHOW_SET1]];
        $setlist2=$data[$this->positions[SHOW_SET2]];
        $setlist=$setlist. $this->addOrNothing($setlist2);
        $setlist3=$data[$this->positions[SHOW_SET3]];
        $setlist=$setlist. $this->addOrNothing($setlist3);

        $showNotes=$data[$this->positions[SHOW_NOTES]];
        $myNotes=$data[$this->positions[MY_NOTES]];
        $notes=$showNotes. $this->addOrNothing($myNotes);

        $mySource=$data[$this->positions[MY_SOURCE]];
        $myTechNotes=$data[$this->positions[MY_TECHNOTES]];
        $sourcenotes=$mySource. $this->addOrNothing($myTechNotes). $this->addOrNothing($myMediaType);

        $summedia=$data[$this->positions[MY_MEDIACOUNT]];
        $taper=$data[$this->positions[MY_TAPERNAME]];

//            MY_MEDIATYPE,

        RecordManager::updateRecord('NULL','NULL','NULL','NULL','NULL',
                $setlist,$notes,$sourcenotes,$taper,'','','NULL',
                $summedia,$recordId);
        if ($videoOrAudio==VIDEO) {
            RecordManager::createVideoAndGetId($recordId);
        }
        if ($videoOrAudio==AUDIO) {
            RecordManager::createAudioAndGetId($recordId);
        }

        return true;
    }

    private function addOrNothing($addition) {
        if ($addition !=null && strlen($addition)>0) {
            return "\n".$addition;
        } else {
            return '';
        }
    }

    function convertShowState($showState) {
        if (strlen($showState)<=4) {
            foreach ($this->states as $country=>$counties) {
                if (in_array(strtolower($showState), $counties)) {
                    return $country;
                }
            }
        }
        return null;
    }

    function convertDate($etreeDate) {
        //unkonw date is in dbetree ?
        $etreeDate=str_replace("?","0",$etreeDate);

        //format:      MM/DD/YY
        $parts = explode("/", $etreeDate);

        $month=$parts[0];
        $day=$parts[1];
        $year=$parts[2];
        if ($year>30) {
            $year="19".$year;
        } else {
            $year="20".$year;
        }
        $newDate=$year."-".$month."-".$day;
        return $newDate;
    }

    private function analyzeHeader($headerData) {
        for ($i=0;
        $i <  count($headerData);
        $i++) {
            $fieldHeader=$headerData[$i];
            if (in_array(  $fieldHeader  ,  $this->fields )) {
                $this->positions[$fieldHeader]=$i;
            }
        }
    }

    public function getMediasVideo() {
        return implode(',', $this->mediasVideo);
    }

    public function setMediasVideo($mediasVideo) {
        $this->mediasVideo =explode(',',strtolower ( $mediasVideo));

    }

    public function getMediasAudio() {
        return implode(',', $this->mediasAudio);
    }

    public function setMediasAudio($mediasAudio) {
        $this->mediasAudio =explode(',', strtolower ($mediasAudio));
    }



    private $mediasVideo=array('dvd','video','vhs','dvdr','dvd-r','dvd+r','dvd-dl','dvd+dl','divx','mov','xvid','mpg','mpeg');
    private $mediasAudio=array('cd','cdr','cd-r','flac','shn','cdr','wav','mp3');

    private $states=array (
            'Canada'=>array('ab',
                            'bc',
                            'mb',
                            'nb',
                            'nl',
                            'ns',
                            'on',
                            'qc',
                            'pe',
                            'sk',
                            'nt',
                            'nu',
                            'yk',
                            'alta',
                            'man',
                            'nfld',
                            'ont',
                            'que',
                            'sask'
            ),
            'USA'=>array('al',
                            'ak',
                            'az',
                            'ar',
                            'ca',
                            'co',
                            'ct',
                            'dc',
                            'de',
                            'fl',
                            'ga',
                            'hi',
                            'id',
                            'il',
                            'in',
                            'ia',
                            'ks',
                            'ky',
                            'la',
                            'me',
                            'md',
                            'ma',
                            'mi',
                            'mn',
                            'ms',
                            'mo',
                            'mt',
                            'ne',
                            'nv',
                            'nh',
                            'nj',
                            'nm',
                            'ny',
                            'nc',
                            'nd',
                            'oh',
                            'ok',
                            'or',
                            'pa',
                            'ri',
                            'sc',
                            'sd',
                            'tn',
                            'tx',
                            'ut',
                            'vt',
                            'va',
                            'wa',
                            'wv',
                            'wi',
                            'wy'));
}
?>
