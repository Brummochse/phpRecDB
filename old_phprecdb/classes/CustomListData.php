<?php
define("VIDEO", 1);
define("AUDIO", 2);
define("VIDEO_AND_AUDIO", 3);

include_once dirname(__FILE__) . "/../constants.php";
include_once Constants :: getClassFolder() . "Helper.php";
include_once Constants :: getClassFolder() . "NavigationBar.php";

class CustomListData {

    private $bootlegType = null;

    private $artistId = null;

    private $selectedYear = null;

    private $showBootlegType = null;

    private $hideInvisibleRecords =null;

    public function CustomListData($bootlegType,$hideInvisibleRecords=true) {
        $this->bootlegType = $bootlegType;
        $this->hideInvisibleRecords=$hideInvisibleRecords;

        if ($bootlegType == VIDEO_AND_AUDIO) {
            $this->showBootlegType = true;
        } else {
            $this->showBootlegType = false;
        }

        $this->artistId = Helper :: getParamAsInt(Constants::getParamArtistId());
        $this->selectedYear = Helper :: getParamAsInt(Constants::getParamYear());

        dbConnect();
    }

    public function getArtistId() {
        return $this->artistId;
    }

    public function getSelectedYear() {
        return $this->selectedYear;
    }

    public function getShowBootlegType() {
        return $this->showBootlegType;
    }

    public function getListName() {
        switch ($this->bootlegType) {
            case VIDEO :
                $type="videos";
                break;
            case AUDIO :
                $type="audios";
                break;
            case VIDEO_AND_AUDIO :
                $type="records";
                break;
            default :
                throw new Exception("unexpected bootlegtype:" . $this->bootlegType);
        }
        return "all ".$type;
    }

    protected function chargeQueryBuilder($queryBuilder) {
        switch ($this->bootlegType) {
            case VIDEO :
                $this->getQueryForVideoRecords($queryBuilder);
                break;
            case AUDIO :
                $this->getQueryForAudioRecords($queryBuilder);
                break;
            case VIDEO_AND_AUDIO :
                $this->getQueryForAllRecords($queryBuilder);
                break;
            default :
                throw new Exception("unexpected bootlegtype:" . $this->bootlegType);
        }
    }

    protected function createQueryBuilder() {
        $selectBase = "SELECT " .
                "concerts.id," .
                "artists.name," .
                "concerts.date," .
                "countrys.name," .
                "citys.name," .
                "venues.name," .
                "concerts.supplement," .
                "concerts.misc," .
                "recordings.id," .
                "recordings.sumlength," .
                "media.shortname," .
                "rectypes.shortname," .
                "sources.shortname," .
                "recordings.quality," .
                "recordings.sourceidentification," .
                "tradestatus.shortname," .
                "artists.id," .
                "YEAR(date)," .
                "recordings.created ";

        $fromBase = " FROM concerts" .
                " LEFT OUTER JOIN artists ON artists.id = concerts.artists_id" .
                " LEFT OUTER JOIN countrys ON countrys.id = concerts.countrys_id" .
                " LEFT OUTER JOIN citys ON citys.id = concerts.citys_id" .
                " LEFT OUTER JOIN venues ON venues.id = concerts.venues_id" .
                " LEFT OUTER JOIN recordings ON concerts.id = recordings.concerts_id" .
                " LEFT OUTER JOIN media ON media.id = recordings.media_id" .
                " LEFT OUTER JOIN rectypes ON rectypes.id = recordings.rectypes_id" .
                " LEFT OUTER JOIN sources ON sources.id = recordings.sources_id" .
                " LEFT OUTER JOIN tradestatus ON tradestatus.id = recordings.tradestatus_id ";

        $orderbyBaseStart = " ORDER BY ";

        $orderbyBaseEnd = " artists.name," .
                "concerts.misc," .
                "videoOrAudio," .
                "concerts.date," .
                "concerts.id," .
                "recordings.sourceidentification";

        $queryBuilder = new SqlQueryBuilder($selectBase, $fromBase, $orderbyBaseStart, $orderbyBaseEnd);

        if ($this->hideInvisibleRecords == true) {
            $queryBuilder->addWhereExtension("recordings.visible=1");
        }

        if ($this->artistId != null) {
            $queryBuilder->addWhereExtension("artists.id=" . $this->artistId);
        }
        if ($this->selectedYear != null) {
            $queryBuilder->addWhereExtension("YEAR(date)=" . $this->selectedYear);
        }
        $this->chargeQueryBuilder($queryBuilder);
        return $queryBuilder;
    }

    public function getRecords() {
        $queryBuilder = $this->createQueryBuilder();
        $sqlSelect = $queryBuilder->getQuery();
        $concertsSql = mysql_query($sqlSelect) or die("MySQL-Error: " . mysql_error());
        return $concertsSql;
    }

    public function getQueryForAllRecords($queryBuilder) {
        $queryBuilder->addSelectExtension('video.recordings_id IS NULL As videoOrAudio');
        $queryBuilder->addSelectExtension('videoformat.label');
        $queryBuilder->addFromExtension('LEFT OUTER JOIN video ON video.recordings_id = recordings.id');
        $queryBuilder->addFromExtension('LEFT OUTER JOIN audio ON audio.recordings_id = recordings.id');
        $queryBuilder->addFromExtension('LEFT OUTER JOIN videoformat ON videoformat.id = video.videoformat_id');
    }

    public function getQueryForVideoRecords($queryBuilder) {
        $queryBuilder->addSelectExtension('0 As videoOrAudio');
        $queryBuilder->addSelectExtension('videoformat.label');
        $queryBuilder->addFromExtension('INNER JOIN video ON video.recordings_id = recordings.id');
        $queryBuilder->addFromExtension('LEFT OUTER JOIN videoformat ON videoformat.id = video.videoformat_id');
    }

    public function getQueryForAudioRecords($queryBuilder) {
        $queryBuilder->addSelectExtension('1 As videoOrAudio');
        $queryBuilder->addFromExtension('INNER JOIN audio ON audio.recordings_id = recordings.id');
    }

}

class SqlQueryBuilder {
    private $selectExtensions = array ();
    private $fromExtensions = array ();
    private $whereExtensions = array ();
    private $orderbyExtensions = array ();

    private $selectBase;
    private $fromBase;
    private $orderbyBaseStart;
    private $orderbyBaseEnd;

    private $limit=null;

    public function SqlQueryBuilder($selectBase, $fromBase, $orderbyBaseStart, $orderbyBaseEnd) {
        $this->selectBase = $selectBase;
        $this->fromBase = $fromBase;
        $this->orderbyBaseStart = $orderbyBaseStart;
        $this->orderbyBaseEnd = $orderbyBaseEnd;
    }

    public function getQuery() {
        return $this->selectBase . $this->getSelectExtension() .
                $this->fromBase . $this->getFromExtension() .
                $this->getWhereExtension() .
                $this->orderbyBaseStart . $this->getOrderbyExtension() . $this->orderbyBaseEnd.
                $this->getLimitExtension();

    }

    public function clearSelectExtensions() {
        $this->selectExtensions = array ();
    }

    private function getLimitExtension() {
        if ($this->limit!=null && $this->limit>=0) {
            return " LIMIT 0,".$this->limit;
        } else {
            return '';
        }
    }

    private function getSelectExtension() {
        if (count($this->selectExtensions) == 0) {
            return '';
        }
        return "," . implode(',', $this->selectExtensions) . " ";
    }

    private function getFromExtension() {
        return " " . implode(' ', $this->fromExtensions) . " ";
    }

    //connects with AND
    private function getWhereExtension() {
        if (count($this->whereExtensions) == 0) {
            return '';
        }
        return " WHERE " . implode(' AND ', $this->whereExtensions) . " ";
    }

    private function getOrderbyExtension() {
        if (count($this->orderbyExtensions) == 0) {
            return '';
        }
        return " " . implode(',', $this->orderbyExtensions) . ", ";
    }

    public function addSelectExtension($selectExtension) {
        $this->selectExtensions[] = $selectExtension;
    }

    public function addFromExtension($fromExtension) {
        $this->fromExtensions[] = $fromExtension;
    }

    public function addWhereExtension($whereExtension) {
        $this->whereExtensions[] = $whereExtension;
    }

    public function addOrderbyExtension($orderbyExtension) {
        $this->orderbyExtensions[] = $orderbyExtension;
    }

    public function setLimit($limit) {
        $this->limit=$limit;
    }
}
?>
