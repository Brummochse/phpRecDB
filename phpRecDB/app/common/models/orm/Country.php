<?php

/**
 * This is the model class for table "countrys".
 *
 * The followings are the available columns in table 'countrys':
 * @property string $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Citys[] $citys
 * @property Concerts[] $concerts
 */
class Country extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Country the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'countrys';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'citys' => array(self::HAS_MANY, 'Citys', 'countrys_id'),
            'concerts' => array(self::HAS_MANY, 'Concert', 'countrys_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Country',
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
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function getExistingOrCreateNew($countryName) {
        $countryRecord = $this->findByAttributes(array('name' => $countryName));
        
        if ($countryRecord == null) {
            $countryRecord = new self();
            $countryRecord->name = $countryName;
            $countryRecord->save();
        }
        return $countryRecord;
    }

    /**
     * Suggests a list of existing values matching the specified keyword.
     * @param string the keyword to be matched
     * @param integer maximum number of names to be returned
     * @return array list of matching items
     */
    public function suggest($keyword, $limit = 20) {
        $models = $this->findAll(array(
            'condition' => 'name LIKE :keyword',
            'order' => 'name',
            'limit' => $limit,
            'params' => array(':keyword' => "$keyword%")
                ));
        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model->name, // label for dropdown list
                'value' => $model->name, // value for input field
                'id' => $model->id, // return values from autocomplete
            );
        }
        return $suggest;
    }

}