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
            new SqlBuildCol("","sumlength",RI::SUMLENGTH),
            new SqlBuildCol("","quality",RI::QUALITY),
            new SqlBuildCol("","created",RI::CREATION),
            new SqlBuildCol("","lastmodified",RI::LASTMODIFIED),
            new SqlBuildCol("","summedia",RI::SUMMEDIA),
            new SqlBuildCol("","sourcenotes",RI::SOURCENOTES),
            new SqlBuildCol("","taper",RI::TAPER),
            new SqlBuildCol("","transferer",RI::TRANSFERER),
            new SqlBuildCol("","setlist",RI::SETLIST),
            new SqlBuildCol("","notes",RI::NOTES),
            new SqlBuildCol("","sourceidentification",RI::SOURCEIDENTIFICATION),
            new SqlBuildCol("","userdefined1",RI::USERDEFINED1),
            new SqlBuildCol("","userdefined2",RI::USERDEFINED2),

            new SqlBuildCol("medium","label",RI::MEDIUM),
            new SqlBuildCol("rectype","label",RI::RECTYPE),
            new SqlBuildCol("source","label",RI::SOURCE),
            new SqlBuildCol("tradestatus","label",RI::TRADESTATUS),

            new SqlBuildCol("concert","date",RI::DATE),
            new SqlBuildCol("concert","supplement",RI::SUPPLEMENT),
            new SqlBuildCol("concert","misc",RI::MISC),

            new SqlBuildCol("concert.artist","name",RI::ARTIST),
            new SqlBuildCol("concert.country","name",RI::COUNTRY),
            new SqlBuildCol("concert.city","name",RI::CITY),
            new SqlBuildCol("concert.venue","name",RI::VENUE),
            new SqlBuildCol("video","recordings_id IS NULL",RI::VIDEOORAUDIO),
        );

        $sourceModelName = 'Record';

        return $this->fetchInfo($cols, $sourceModelName, $recordId)->queryRow();
    }

    private function fetchVideoInfo($recordId) {
        $cols = array(
            new SqlBuildCol("","bitrate",RI::BITRATE),
            new SqlBuildCol("","authorer",RI::AUTHORER),
            new SqlBuildCol("record","id",""),
            new SqlBuildCol("videoformat","label",RI::VIDEOFORMAT),
            new SqlBuildCol("aspectratio","label",RI::ASPECTRATIO),
        );
        $sourceModelName = 'Video';

        return $this->fetchInfo($cols, $sourceModelName, $recordId)->queryRow();
    }

    private function fetchAudioInfo($recordId) {
        $cols = array(
            new SqlBuildCol("","bitrate",RI::BITRATE),
            new SqlBuildCol("","frequence",RI::FREQUENCY),
            new SqlBuildCol("record","id",""),
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
            $recordInfo[RI::USERDEFINED1LABEL] = Yii::app()->settingsManager->getPropertyValue(Settings::USER_DEFINED1_LABEL);
            $recordInfo[RI::USERDEFINED2LABEL] = Yii::app()->settingsManager->getPropertyValue(Settings::USER_DEFINED2_LABEL);
            
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
