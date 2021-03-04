<?php

/**
 * This is the model class for table "video".
 *
 * The followings are the available columns in table 'video':
 * @property string $id
 * @property integer $recordings_id
 * @property integer $width
 * @property integer $height
 * @property integer $menu
 * @property integer $chapters
 * @property string $aspectratio_id
 * @property string $videoformat_id
 * @property string $bitrate
 * @property string $authorer
 * @property float $framerate
 *
 * The followings are the available model relations:
 * @property Record $record
 * @property Videoformat $videoformat
 * @property Aspectratio $aspectratio
 */
class Video extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Video the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'video';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('recordings_id', 'required'),
            array('recordings_id, menu, chapters, width, height', 'numerical', 'integerOnly' => true),
            array('bitrate, framerate', 'numerical', 'integerOnly' => false),
            array('authorer,videoformat_id,aspectratio_id', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, recordings_id, menu, chapters, aspectratio_id, videoformat_id, bitrate, authorer', 'safe', 'on' => 'search'),
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
            'videoformat' => array(self::BELONGS_TO, 'Videoformat', 'videoformat_id'),
            'aspectratio' => array(self::BELONGS_TO, 'Aspectratio', 'aspectratio_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'recordings_id' => 'Recordings',
            'aspectratio_id' => 'Aspect Ratio',
            'videoformat_id' => 'Video Format',
            'bitrate' => 'Bitrate',
            'authorer' => 'Authorer',
            'width' => 'Resolution Width',
            'height' => 'Resolution Height',
            'menu' => 'Menu',
            'chapters' => 'Chapters',
            'framerate' => 'Frame Rate',
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
        $criteria->compare('recordings_id', $this->recordings_id);
        $criteria->compare('aspectratio_id', $this->aspectratio_id, true);
        $criteria->compare('videoformat_id', $this->videoformat_id, true);
        $criteria->compare('bitrate', $this->bitrate, true);
        $criteria->compare('authorer', $this->authorer, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function getAllFromConcert($concert) {
        $videos = array();
        $records = $concert->records;
        foreach ($records as $record) {
            if ($record->video != NULL) {
                $videos[] = $record->video;
            }
        }
        return $videos;
    }

}