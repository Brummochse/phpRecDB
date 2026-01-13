<?php

/**
 * This is the model class for table "audio".
 *
 * The followings are the available columns in table 'audio':
 * @property int $id
 * @property int $recordings_id
 * @property string $bitrate
 * @property string $frequence
 *
 * The followings are the available model relations:
 * @property Record $record
 */
class Audio extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Audio the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'audio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('recordings_id', 'required'),
            array('recordings_id', 'numerical', 'integerOnly' => true),
            array('bitrate, frequence', 'numerical', 'integerOnly' => false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, recordings_id, bitrate, frequence', 'safe', 'on' => 'search'),
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
            'recordings_id' => 'Recordings',
            'bitrate' => 'Bitrate',
            'frequence' => 'Frequence',
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
        $criteria->compare('bitrate', $this->bitrate, true);
        $criteria->compare('frequence', $this->frequence, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getAllFromConcert($concert) {
        $audios = array();
        $records = $concert->records;
        foreach ($records as $record) {
            if ($record->audio != NULL) {
                $audios[] = $record->audio;
            }
        }
        return $audios;
    }

}