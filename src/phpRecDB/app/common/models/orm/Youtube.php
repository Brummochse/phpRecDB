<?php

/**
 * This is the model class for table "youtubesamples".
 *
 * The followings are the available columns in table 'youtubesamples':
 * @property string $id
 * @property string $title
 * @property string $youtubeId
 * @property integer $recordings_id
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property Record $record
 */
class Youtube extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Youtube the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'youtubesamples';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('youtubeId, recordings_id, order_id', 'required'),
            array('recordings_id', 'numerical', 'integerOnly' => true),
            array('title, youtubeId', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, youtubeId, recordings_id, order_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'record' => array(self::BELONGS_TO, 'Record', 'recordings_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'youtubeId' => 'Youtube',
            'recordings_id' => 'Recordings',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('youtubeId', $this->youtubeId, true);
        $criteria->compare('recordings_id', $this->recordings_id);
        $criteria->compare('order_id', $this->order_id, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     *  extracts the youtube id from a youtube url. returns NULL when no id is found
     *  exmaple:
     *      input: http://www.youtube.com/watch?v=xEJfPvwitZI
     *      returns: xEJfPvwitZI
     */
    public function extractYoutubeId($url) {
        $id = null;
        if (preg_match('%youtube\\.com/(.+)%', $url, $match)) {
            $match = $match[1];
            $replace = array("watch?v=", "v/", "vi/");
            $match = str_replace($replace, "", $match);
            $parameters = explode("&", $match);
            $id = $parameters[0];
        }
        if ($id == null || strlen($id) <= 0)
            return null;
        return $id;
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
        $youtubeModels = $this->findAllByAttributes(array('recordings_id' => $recordId), array('order' => 'order_id ASC'));
        if (count($youtubeModels)==0) {
            return 0;
        } else {
            $highestOrderId=$youtubeModels[count($youtubeModels)-1]->order_id;
            return $highestOrderId+1;
        }
    }
    
    private function switchOrder($youtubeId, $direction) {
        $youtubeModel = $this->findByPk($youtubeId);
        if ($youtubeModel != NULL) {
            $recordId = $youtubeModel->recordings_id;
            $youtubeModels = $this->findAllByAttributes(array('recordings_id' => $recordId), array('order' => 'order_id ASC'));

            $posInArray = $this->getPosInArray($youtubeModels, $youtubeId);

            if ($direction == Terms::BEFORE) {
                if ($posInArray >= 1) { //means youtube sample could be moved before
                    $youtubeSwitchModel = $youtubeModels[$posInArray - 1];
                } else {
                    return true; //no change needed, no error occured
                }
            } else { // $direction == Terms::BEHIND
                if ($posInArray < count($youtubeModels) - 1) { //means youtube sample could be moved behind
                    $youtubeSwitchModel = $youtubeModels[$posInArray + 1];
                } else {
                    return true; //no change needed, no error occured
                }
            }

            //switch order ids
            $orderIdTemp = $youtubeSwitchModel->order_id;
            $youtubeSwitchModel->order_id = $youtubeModel->order_id;
            $youtubeModel->order_id = $orderIdTemp;

            return $youtubeModel->save() && $youtubeSwitchModel->save();
        }
        return false;
    }

    public function moveBefore($youtubeId) {
       return $this->switchOrder($youtubeId,Terms::BEFORE);
    }

    public function moveBehind($youtubeId) {
         return $this->switchOrder($youtubeId,Terms::BEHIND);
    }

}