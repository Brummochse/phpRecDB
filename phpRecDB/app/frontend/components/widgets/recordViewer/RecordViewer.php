<?php

/* ENUM */

class RI {

    const VIDEO = 0;
    const AUDIO = 1;

    //record
    const SUMLENGTH = "SUMLENGTH";
    const MEDIUM = "MEDIUM";
    const RECTYPE = "RECTYPE";
    const SOURCE = "SOURCE";
    const QUALITY = "QUALITY";
    const TRADESTATUS = "TRADESTATUS";
    const CREATION = "CREATION";
    const LASTMODIFIED = "LASTMODIFIED";
    const SUMMEDIA = "SUMMEDIA";
    const SOURCENOTES = "SOURCENOTES";
    const TAPER = "TAPER";
    const TRANSFERER = "TRANSFERER";
    const SETLIST = "SETLIST";
    const NOTES = "NOTES";
    const SOURCEIDENTIFICATION = "SOURCEIDENTIFICATION";
    const VIDEOORAUDIO = "VIDEOORAUDIO";
    const BITRATE = "BITRATE";
    
    const USERDEFINED1 = "USERDEFINED1";
    const USERDEFINED2 = "USERDEFINED2";
    const USERDEFINED1LABEL = "USERDEFINED1LABEL";
    const USERDEFINED2LABEL = "USERDEFINED2LABEL";

    //concert
    const ARTIST = "ARTIST";
    const DATE = "DATE";
    const COUNTRY = "COUNTRY";
    const CITY = "CITY";
    const VENUE = "VENUE";
    const SUPPLEMENT = "SUPPLEMENT";
    const MISC = "MISC";

    //audio
    const FREQUENCY = "FREQUENCY";

    //video
    const VIDEOFORMAT = "VIDEOFORMAT";
    const ASPECTRATIO = "ASPECTRATIO";
    const AUTHORER = "AUTHORER";
    const SCREENSHOTS = "SCREENSHOTS";
    const YOUTUBESAMPLES = 'YOUTUBESAMPLES';

    //screenshots
    const THUMBNAILFILE = "THUMBNAILFILE";
    const SCREENSHOTFILE = "SCREENSHOTFILE";

    //youtube
    const YOUTUBEID = 'YOUTUBEID';
    const YOUTUBETITLE = 'YOUTUBETITLE';

 
 }
 
class RecordViewer extends CWidget {

    public $recordId;

    private function fetchInfo($cols, $sourceModelName, $recordId, $joinSpecs = null) {
        $queryBuilder = new QueryBuilder();
        $queryParts = $queryBuilder->buildQueryParts($sourceModelName, $cols, $joinSpecs);

        $query = 'SELECT ' . $queryParts[QueryBuilder::SELECT] . ' ' .
                'FROM ' . $queryParts[QueryBuilder::FROM_] . ' ' .
                $queryParts[QueryBuilder::JOIN] . ' ' .
                'WHERE ' . 'recordings.id=' . $recordId;

        $dbC = Yii::app()->db->createCommand($query);

        return $dbC;
    }

    private function fetchRecordInfo($recordId) {
        $cols = array(
            '' => array(
                'sumlength AS ' . RI::SUMLENGTH,
                'quality AS ' . RI::QUALITY,
                'created AS ' . RI::CREATION,
                'lastmodified AS ' . RI::LASTMODIFIED,
                'summedia AS ' . RI::SUMMEDIA,
                'sourcenotes AS ' . RI::SOURCENOTES,
                'taper AS ' . RI::TAPER,
                'transferer AS ' . RI::TRANSFERER,
                'setlist AS ' . RI::SETLIST,
                'notes AS ' . RI::NOTES,
                'sourceidentification AS ' . RI::SOURCEIDENTIFICATION,
                'userdefined1 AS ' . RI::USERDEFINED1,
                'userdefined2 AS ' . RI::USERDEFINED2,
            ),
            'medium' => 'label AS ' . RI::MEDIUM,
            'rectype' => 'label AS ' . RI::RECTYPE,
            'source' => 'label AS ' . RI::SOURCE,
            'tradestatus' => 'label AS ' . RI::TRADESTATUS,
            'concert' => array(
                'date AS ' . RI::DATE,
                'supplement AS ' . RI::SUPPLEMENT,
                'misc AS ' . RI::MISC,
            ),
            'concert.artist' => 'name AS ' . RI::ARTIST,
            'concert.country' => 'name AS ' . RI::COUNTRY,
            'concert.city' => 'name AS ' . RI::CITY,
            'concert.venue' => 'name AS ' . RI::VENUE,
            'video' => 'recordings_id IS NULL As ' . RI::VIDEOORAUDIO,
        );
        $sourceModelName = 'Record';

        return $this->fetchInfo($cols, $sourceModelName, $recordId)->queryRow();
    }

    private function fetchVideoInfo($recordId) {
        $cols = array(
            '' => array(
                'bitrate AS ' . RI::BITRATE,
                'authorer AS ' . RI::AUTHORER,
            ),
            'record' => 'id',
            'videoformat' => 'label AS ' . RI::VIDEOFORMAT,
            'aspectratio' => 'label AS ' . RI::ASPECTRATIO,
        );
        $sourceModelName = 'Video';

        return $this->fetchInfo($cols, $sourceModelName, $recordId)->queryRow();
    }

    private function fetchAudioInfo($recordId) {
        $cols = array(
            '' => array(
                'bitrate AS ' . RI::BITRATE,
                'frequence AS ' . RI::FREQUENCY,
            ),
            'record' => 'id',
        );
        $sourceModelName = 'Audio';

        return $this->fetchInfo($cols, $sourceModelName, $recordId)->queryRow();
    }

    private function fetchScreenshotInfo($recordId) {
        return Screenshot::model()->findAllByAttributes(array('video_recordings_id' => $recordId), array('order' => 'order_id ASC'));
    }

    private function fetchYoutubeInfo($recordId) {
        return Youtube::model()->findAllByAttributes(array('recordings_id' => $recordId), array('order' => 'order_id ASC'));
    }

    private function countVisitor($recordModel) {
        $visit = Recordvisit::model()->getVisitorsForRecord($recordModel);
        $visit->visitors++;
        $visit->save();
    }

    public function run() {
        if ($this->recordId != NULL) {
            $recordModel = Record::model()->findByPk($this->recordId);
            if ($recordModel == null || $recordModel->visible == false) {
                return;
            }

            //
            if (!Uservisit::model()->isBotVisitor()) {
                $this->countVisitor($recordModel);
                Uservisit::model()->logRecordVisit($this->recordId);
            }
            
            //
            $recordInfo = $this->fetchRecordInfo($this->recordId);

            if ($recordInfo[RI::VIDEOORAUDIO] == RI::VIDEO) {
                $videoInfo = $this->fetchVideoInfo($this->recordId);

                $screenshotData = $this->fetchScreenshotInfo($this->recordId);
                if (count($screenshotData) > 0) {
                    $videoInfo[RI::SCREENSHOTS] = $screenshotData;
                }

                $youtubeData = $this->fetchYoutubeInfo($this->recordId);
                if (count($youtubeData) > 0) {
                    $videoInfo[RI::YOUTUBESAMPLES] = $youtubeData;
                }

                $audioInfo = array();
            } else { // = RecordInfo::AUDIO
                $audioInfo = $this->fetchAudioInfo($this->recordId);
                $videoInfo = array();
            }

            //
            $recordInfo[RI::USERDEFINED1LABEL] = Yii::app()->settingsManager->getPropertyValue(Record::SETTINGS_USER_DEFINED1_LABEL);
            $recordInfo[RI::USERDEFINED2LABEL] = Yii::app()->settingsManager->getPropertyValue(Record::SETTINGS_USER_DEFINED2_LABEL);
            
            //
            $this->render('record', array(
                'r' => $recordInfo,
                'v' => $videoInfo,
                'a' => $audioInfo,
                'screenshotFolder' => Yii::app()->params["screenshotsUrl"],
            ));
        }
    }

}

?>
