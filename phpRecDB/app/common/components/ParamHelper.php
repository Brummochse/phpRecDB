<?php

class ParamHelper {

    const PARAM_ARTIST_ID = 'aid';
    const PARAM_RECORD_ID = 'rid';
    const PARAM_YOUTUBE_ID = 'yid';
    const PARAM_SCREENSHOT_ID = 'sid';
    const PARAM_SUBLIST_ID = 'said';
    const PARAM_CONCERT_ID = 'cid';

    public static $PARAM_SUGGEST_MODE = array("mode" => "suggest");

    public static function createParamUrl($controller, $paramKey, $paramValue = null, $removeGetKey=null) {
        $params = $_GET;

        if (isset($params[$removeGetKey])) {
            unset($params[$removeGetKey]);
        }


        if ($paramValue != null) {
            $params[$paramKey] = $paramValue;
        } else {
            if (isset($params[$paramKey])) {
                unset($params[$paramKey]);
            }
        }

        $url = Yii::app()->getController()->createUrl($controller, $params);
        return $url;
    }

    public static function decodeIntParam($paramKey, $postOrGet) {
        if (isset($postOrGet[$paramKey])) {
            $valStr = $postOrGet[$paramKey];
            $valInt = (int) $valStr;

            if ('' . $valStr == '' . $valInt) { //check if converted int is the same like the input str
                return $valInt;
            }
        }
        return NULL;
    }

    public static function decodeIntGetParam($paramKey) {
        return self::decodeIntParam($paramKey, $_GET);
    }

    public static function decodeIntPostParam($paramKey) {
        return self::decodeIntParam($paramKey, $_POST);
    }

    public static function createArtistListUrl($artistId = null) {
        $controller = Yii::app()->controller->getId() . '/' . Yii::app()->controller->getAction()->getId();
        return self::createParamUrl($controller, self::PARAM_ARTIST_ID, $artistId, self::PARAM_RECORD_ID);
    }

    public static function createRecordDetailUrl($recordId = null) {

        $controller = Yii::app()->controller->getId() . '/' . Yii::app()->controller->getAction()->getId();
        return self::createParamUrl($controller, self::PARAM_RECORD_ID, $recordId);


        //   return self::createParamUrl('recordDetail/index', self::PARAM_RECORD_ID, $recordId);
    }

    public static function createRecordUpdateUrl($recordId = null) {
        return self::createParamUrl('adminEditRecord/updateRecord', self::PARAM_RECORD_ID, $recordId);
    }

    public static function createRecordSublistsUrl($recordId = null) {
        return self::createParamUrl('adminEditRecord/updateSublists', self::PARAM_RECORD_ID, $recordId);
    }

    public static function createRecordScreenshotsUrl($recordId = null) {
        return self::createParamUrl('adminEditRecord/updateScreenshots', self::PARAM_RECORD_ID, $recordId);
    }

    public static function createRecordYoutubesUrl($recordId = null) {
        return self::createParamUrl('adminEditRecord/updateYoutubes', self::PARAM_RECORD_ID, $recordId);
    }

    public static function createRecordDeleteUrl($recordId = null) {
        return self::createParamUrl('adminBase/deleteRecord', self::PARAM_RECORD_ID, $recordId);
    }

    public static function decodeSublistIdParam() {
        return self::decodeIntGetParam(self::PARAM_SUBLIST_ID);
    }

    public static function decodeScreenshotIdParam() {
        return self::decodeIntGetParam(self::PARAM_SCREENSHOT_ID);
    }

    public static function decodeYoutubeIdParam() {
        return self::decodeIntGetParam(self::PARAM_YOUTUBE_ID);
    }

    public static function decodeArtistIdParam() {
        return self::decodeIntGetParam(self::PARAM_ARTIST_ID);
    }

    public static function decodeRecordIdParam() {
        return self::decodeIntGetParam(self::PARAM_RECORD_ID);
    }

    public static function decodeModel($paramKey, $model) {
        if (($decodedId = self::decodeIntGetParam($paramKey)) != NULL) {
            return $model->findByPk($decodedId);
        }
        return null;
    }

    public static function decodeRecordModel() {
        return self::decodeModel(self::PARAM_RECORD_ID, Record::model());
    }

    public static function decodeConcertModel() {
        return self::decodeModel(self::PARAM_CONCERT_ID, Concert::model());
    }

    public static function decodeScreenshotModel() {
        return self::decodeModel(self::PARAM_SCREENSHOT_ID, Screenshot::model());
    }

    public static function decodeYoutubeModel() {
        return self::decodeModel(self::PARAM_YOUTUBE_ID, Youtube::model());
    }

    public static function decodeSublistModel() {
        return self::decodeModel(self::PARAM_SUBLIST_ID, Sublist::model());
    }

}

?>
