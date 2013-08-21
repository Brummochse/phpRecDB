<?php

/**
 * This is the model class for table "signature".
 *
 * The followings are the available columns in table 'signature':
 * @property integer $id
 * @property string $name
 * @property integer $enabled
 * @property string $additionalText
 * @property integer $bgTransparent
 * @property string $bgColor
 * @property string $color1
 * @property string $color2
 * @property string $color3
 * @property integer $quality
 * @property integer $recordsCount
 */
class Signature extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Signature the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'signature';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, bgColor, color1, color2, color3, recordsCount', 'required'),
            array('enabled, bgTransparent, quality, recordsCount', 'numerical', 'integerOnly' => true),
            array('name, additionalText', 'length', 'max' => 255),
            array('name', 'match', 'pattern' => '/[A-Za-z0-9]+/', 'message' => 'only letters and numbers are allowed!'),
            array('bgColor, color1, color2, color3', 'length', 'max' => 7),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, enabled, additionalText, bgTransparent, bgColor, color1, color2, color3, quality, recordsCount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'enabled' => 'Enabled',
            'additionalText' => 'Additional Text',
            'bgTransparent' => 'Bg Transparent',
            'bgColor' => 'Bg Color',
            'color1' => 'Color1',
            'color2' => 'Color2',
            'color3' => 'Color3',
            'quality' => 'Quality',
            'recordsCount' => 'Records Count',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('additionalText', $this->additionalText, true);
        $criteria->compare('bgTransparent', $this->bgTransparent);
        $criteria->compare('bgColor', $this->bgColor, true);
        $criteria->compare('color1', $this->color1, true);
        $criteria->compare('color2', $this->color2, true);
        $criteria->compare('color3', $this->color3, true);
        $criteria->compare('quality', $this->quality);
        $criteria->compare('recordsCount', $this->recordsCount);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getRecords() {

        $criteria = new CDbCriteria;
        $criteria->order = 'created DESC';
        $criteria->limit = $this->recordsCount;
        $criteria->offset = 0;
        $criteria->addCondition('visible=true');

        return Record::model()->findAll($criteria);
    }

    /**
     * checks is this signature contains a specific record
     * 
     * @param type $recordId
     * @return boolean
     */
    public function signatureContainsRecord($recordId) {
        $signatureRecords = $this->getRecords();
        foreach ($signatureRecords as $record) {
            if ($record->id == $recordId) {
                return true;
            }
        }
        return false;
    }

}