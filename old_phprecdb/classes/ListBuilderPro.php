<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once Constants::getClassFolder() . "NavigationBar.php";
include_once Constants::getClassFolder() . "Helper.php";


abstract class ListBuilderPro {

    protected $years = array ();
    protected $templateAlternate;
    private $artists = array ();
    private $showYears = false;
    private $showArtistSelector = false;
    private $showRecordCount = true;
    private $showCreationDate = false;
    private $signatureVisibility = true;

    private $listBuilderData = null;

    public function setSignatureVisibility($signatureVisibility) {
        $this->signatureVisibility = $signatureVisibility;
    }

    public function setShowArtistSelector($showArtistSelector) {
        $this->showArtistSelector = $showArtistSelector;
    }

    public function setShowCreationDate($showCreationDate) {
        $this->showCreationDate = $showCreationDate;
    }

    public function ListBuilderPro($data) {
        $this->listBuilderData = $data;

        include_once dirname(__FILE__) . "/../settings/dbConnection.php";
        include_once dirname(__FILE__) . '/../libs/Smarty/Smarty.class.php';

        $artistId = $this->listBuilderData->getArtistId();
        if (!empty ($artistId)) {
            $this->showYears = true;
        }

        $this->showArtistSelector = !$this->showYears;
        dbConnect();
    }

    public function setShowRecordCount($showRecordCount) {
        $this->showRecordCount = $showRecordCount;
    }

    public function getList($smarty) {
        $this->artists = array ();
        $concerts = array ();
        $currentConcert = null;
        $concertsSql = $this->listBuilderData->getRecords();

        $this->templateAlternate = false;
        $lastArtist = '';
        $lastArtistsId = -1;
        $lastConcertId = -1;
        $lastRecordCreated = null;
        $lastYear = '';
        $lastMisc = -1;
        $firstrun = true;
        $recordCounter = 0;
        $counter = 0;
        $lastVideoOrAudio=null;
        while ($concert = mysql_fetch_row($concertsSql)) {
            foreach ($concert AS $key => $value) {
                $concert[$key] = stripslashes($value);
            }

            $concertId = $concert[0];
            $artist = $concert[1];
            $date = $concert[2];
            $country = $concert[3];
            $city = $concert[4];
            $venue = $concert[5];
            $supplement = $concert[6];
            $misc = $concert[7];
            $recordingId = $concert[8];
            $length = $concert[9];
            $medium = $concert[10];
            $rectype = $concert[11];
            $source = $concert[12];
            $quality = $concert[13];
            $sourceidentification = $concert[14];
            $tradestatus = $concert[15];
            $artistsId = $concert[16];
            $year = $concert[17];
            $created = $concert[18];
            //video=0, audio=1
            $videoOrAudio = $concert[19];

            $selectedYear = $this->listBuilderData->getSelectedYear();
            if (!empty ($selectedYear)) {
                if ($this->listBuilderData->getSelectedYear() != $year) {
                    continue;
                }
            }
            $counter++;

            if ($lastArtist != $artist || $lastMisc != $misc) {
                $this->templateAlternate = false;
                $lastVideoOrAudio=null;
            }
            if ($lastConcertId == $concertId) {
                $this->templateAlternate = !$this->templateAlternate;
            }
            if ($this->templateAlternate) {
                $templateAlternate = 'true';
            } else {
                $templateAlternate = 'false';
            }

            $record = array (
                    "templateAlternate" => $templateAlternate,
                    "sourceidentification" => $sourceidentification,
                    "quality" => $quality,
                    "length" => $length,
                    "type" => $rectype,
                    "medium" => $medium,
                    "source" => $source,
                    "buttons" => $this->getButtons($recordingId,$artistsId),
                    "tradestatus" => $tradestatus);
            
            if ($videoOrAudio==0)
            {
                $videoformat = $concert[20];
                $record["videoformat"]=$videoformat;
            }

            if ($this->showCreationDate && $this->cutTime($lastRecordCreated) != $this->cutTime($created)) {
                $record['creationDate'] = $this->cutTime($created);
            }

            if ($this->listBuilderData->getShowBootlegType()==true &&  $lastVideoOrAudio != $videoOrAudio) {
                if ($videoOrAudio==0) {
                    $videoOrAudioText='Video';
                } else { //$videoOrAudio==1
                    $videoOrAudioText='Audio';
                }
                $record['videoOrAudio'] = $videoOrAudioText;
            }


            if (($lastConcertId != $concertId) || ($lastVideoOrAudio != $videoOrAudio) || ($this->showCreationDate && ($this->cutTime($lastRecordCreated) != $this->cutTime($created)))) {
                if ($currentConcert != null) {
                    array_push($concerts, $currentConcert);
                }
                $currentConcert = array (
                        "date" => $date,
                        "country" => $country,
                        "city" => $city,
                        "venue" => $venue,
                        "supplement" => $supplement,
                        "records" => array (
                                $record
                        )
                );
            } else {
                array_push($currentConcert["records"], $record);
                $currentConcert["recordcount"] = count($currentConcert["records"]);
            }

            if ($lastArtist != $artist || $lastMisc != $misc || ($this->showCreationDate && ($this->cutTime($lastRecordCreated) != $this->cutTime($created)))) {
                $lastYear = '';
                if (!$firstrun) {
                    $this->addArtist($lastArtist, $lastArtistsId, $lastMisc, $recordCounter, $concerts);
                }
                $recordCounter = 1;
                $concerts = array ();
            } else {
                $recordCounter++;
            }

            if ($this->showYears && (($year != $lastYear) || ($lastVideoOrAudio != $videoOrAudio))) {
                $yearLink = $this->getYearLink($year);
                $currentConcert["newYearLink"] = $yearLink;
                $currentConcert["newYear"] = $year;
                $this->years[$year] = $yearLink;
            }

            $this->templateAlternate = !$this->templateAlternate;

            $lastArtist = $artist;
            $lastArtistsId = $artistsId;
            $lastConcertId = $concertId;
            $lastRecordCreated = $created;
            $lastVideoOrAudio=$videoOrAudio;
            $lastMisc = $misc;
            $lastYear = $year;
            $firstrun = false;
        }
        array_push($concerts, $currentConcert);
        $this->addArtist($lastArtist, $lastArtistsId, $lastMisc, $recordCounter, $concerts);

        include_once dirname(__FILE__) . "/../constants.php";

        $smarty->assign("artists", $this->artists);
        if ($this->showRecordCount)
            $smarty->assign("reccount", $counter);

        if ($this->showArtistSelector) {
            $smarty->assign('artistSelector', $this->getBandsSelector());
        }

        include_once Constants :: getFunctionsFolder() . 'function.getRelativePathTo.php';

        $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants :: getTemplateFolder()));

        if ($this->signatureVisibility == false) {
            $smarty->assign("signature", 'noSign');
        }
    }

    private function cutTime($datetime) {
        return substr($datetime,0,10);
    }

    private function getYearLink($year) {
        return  Helper::makeUrl(array (
                Constants::getParamArtistId() => $this->listBuilderData->getArtistId(), Constants::getParamYear() => $year));
    }

    private function getArtistLink($artistId) {
        return Helper::makeUrl(array (
                Constants::getParamArtistId() => $artistId,
                Constants::getParamYear() => null
        ));
    }

    private function addArtist($artist, $artistId, $lastMisc, $recordCounter, $concerts) {
        if ($lastMisc == '1') {
            $miscText = '(misc)';
        } else {
            $miscText = '';
        }
        $artist = array (
                "name" => $artist,
                "id" => $artistId,
                "misc" => $miscText,
                "artistHtml"=>$this->getArtistHtml($artistId),
                "link" => $this->getArtistLink($artistId
                ), "recordcount" => $recordCounter, "concerts" => $concerts, "years" => $this->getYearsSelector());
        array_push($this->artists, $artist);
    }

    private function getYearsSelector() {

        $selectedYear = $this->listBuilderData->getSelectedYear();
        if (!empty ($selectedYear) || count($this->years) <= 1) {
            return "";
        }
        $yearsHtml = "<form name='yearForm' method='get' action='" . basename($GLOBALS['_SERVER']['PHP_SELF']) . "'>" .
                $this->createHiddenInputs(array (
                Constants::getParamArtistId() => $this->listBuilderData->getArtistId())) .
                "<select name='".Constants::getParamYear()."' onchange='submit();'><option>Year</option>";
        foreach ($this->years as $year => $link) {
            $yearsHtml = $yearsHtml . "<option>" . $year . "</option>";
        }
        $yearsHtml = $yearsHtml . "</select></form>";
        $this->years = array ();
        return $yearsHtml;
    }

    private function getBandsSelector() {
        $counter = 0;
        $bandsHtml = "<form name='artistForm' method='get' action='" . basename($GLOBALS['_SERVER']['PHP_SELF']) . "'>" .
                $this->createHiddenInputs() .
                "<select name='".Constants::getParamArtistId()."' onchange='submit();'><option>Artist</option>";
        foreach ($this->artists as $artist) {
            if (empty ($artist['misc'])) {
                $bandsHtml = $bandsHtml . "<option value='" . $artist['id'] . "'>" . $artist['name'] . "</option>";
                $counter++;
            }
        }
        $bandsHtml = $bandsHtml . "</select></form>";
        if ($counter > 1) {
            return $bandsHtml;
        } else {
            return "";
        }
    }

    private function createHiddenInputs($overGet = array ()) {
        $get = $GLOBALS['_GET'];

        foreach ($overGet as $k => $v) {
            $get[$k] = $v;
        }

        $ga = array ();
        foreach ($get as $k => $v) {
            if (is_array($v)) continue;
            $ga[] = "<input type='hidden' name='" . urlencode($k) . "' value='" . urlencode($v) . "'>";
        }
        return implode($ga);
    }

    protected abstract function getButtons($recordingId,$artistsId);

    protected abstract function getArtistHtml($artistId);

}
?>
