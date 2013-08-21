<?php

/**
 * This is the model class for table "screenshot".
 *
 * The followings are the available columns in table 'screenshot':
 * @property integer $id
 * @property integer $video_recordings_id
 * @property string $screenshot_filename
 * @property string $thumbnail
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property Video $videoRecordings
 * @property Video $video
 */
class Screenshot extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Screenshot the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'screenshot';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('video_recordings_id, screenshot_filename, thumbnail, order_id', 'required'),
            array('video_recordings_id', 'numerical', 'integerOnly' => true),
            array('screenshot_filename, thumbnail', 'length', 'max' => 255),
            array('order_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, video_recordings_id, screenshot_filename, thumbnail, order_id', 'safe', 'on' => 'search'),
        );
    }

    public function delete() {
        Yii::app()->screenshotManager->deleteScreenshot($this);
        parent::delete();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'video' => array(self::BELONGS_TO, 'Video', 'video_recordings_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'video_recordings_id' => 'Video Recordings',
            'screenshot_filename' => 'Screenshot Filename',
            'thumbnail' => 'Thumbnail',
            'order_id' => 'Order',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('video_recordings_id', $this->video_recordings_id);
        $criteria->compare('screenshot_filename', $this->screenshot_filename, true);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('order_id', $this->order_id, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * returns the position of a specific youtube model in a array (returns -1 when not found)
     * 
     * @param type $youtubeModelsArray array which contains youtube Models
     * @param type $youtubeId id of a youtube Model
     */
    private function getPosInArray($youtubeModelsArray, $youtubeId) {
        for ($i = 0; $i < count($youtubeModelsArray); $i++) {
            $curYoutubeModel = $youtubeModelsArray[$i];
            if ($curYoutubeModel->id == $youtubeId) {
                return $i;
            }
        }
        return -1;
    }

    public function getOrderIdForNewScreenshot($recordId) {
        $screenshotModels = $this->findAllByAttributes(array('video_recordings_id' => $recordId), array('order' => 'order_id ASC'));
        if (count($screenshotModels) == 0) {
            return 0;
        } else {
            $highestOrderId = $screenshotModels[count($screenshotModels) - 1]->order_id;
            return $highestOrderId + 1;
        }
    }

    private function switchOrder($screenshotId, $direction) {
        $screenshotModel = $this->findByPk($screenshotId);
        if ($screenshotModel != NULL) {
            $recordId = $screenshotModel->video_recordings_id;
            $screenshotModels = $this->findAllByAttributes(array('video_recordings_id' => $recordId), array('order' => 'order_id ASC'));

            $posInArray = $this->getPosInArray($screenshotModels, $screenshotId);

            if ($direction == Terms::BEFORE) {
                if ($posInArray >= 1) { //means youtube sample could be moved before
                    $screenshotSwitchModel = $screenshotModels[$posInArray - 1];
                } else {
                    return true; //no change needed, no error occured
                }
            } else { // $direction == Terms::BEHIND
                if ($posInArray < count($screenshotModels) - 1) { //means youtube sample could be moved behind
                    $screenshotSwitchModel = $screenshotModels[$posInArray + 1];
                } else {
                    return true; //no change needed, no error occured
                }
            }

            //switch order ids
            $orderIdTemp = $screenshotSwitchModel->order_id;
            $screenshotSwitchModel->order_id = $screenshotModel->order_id;
            $screenshotModel->order_id = $orderIdTemp;

            return $screenshotModel->save() && $screenshotSwitchModel->save();
        }
        return false;
    }

    public function moveBefore($screenshotId) {
        return $this->switchOrder($screenshotId, Terms::BEFORE);
    }

    public function moveBehind($screenshotId) {
        return $this->switchOrder($screenshotId, Terms::BEHIND);
    }

    /**
     * 
     * @param type $recordId
     * @return type
     */
    public function generateScreenshotName($recordId) {
        $recordModel = Record::model()->findByPk($recordId);

        $concertStr = $recordModel->concert->artist->name . '_' . $recordModel->concert->date;
        $timeStamp = time();

        $screenshotname = $concertStr . "_" . $timeStamp;

        $screenshotname = $this->removeEvilChars($screenshotname);
        $screenshotname = $this->convertSpaces($screenshotname);
        return $screenshotname;
    }

    private function removeEvilChars($string) {
        $patterns = array(
            "/\\&/",  // Kaufmaennisches UND
            "/\\</",  // < Zeichen
            "/\\>/",  // > Zeichen
            "/\\?/",  // ? Zeichen
            "/\"/",   // " Zeichen
            "/\\:/",  // : Zeichen
            "/\\|/",  // | Zeichen
            "/\\\\/", // \ Zeichen
            "/\\//",  // / Zeichen
            "/\\*/"   // * Zeichen
        );
        return preg_replace($patterns, '', $string);
    }

    private function convertSpaces($string) {
        $patterns = array(
            "/\\s/", # Leerzeichen
        );
        return preg_replace($patterns, '_', $string);
    }

}