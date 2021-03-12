<?php

/**
 * This is the model class for table "citys".
 *
 * The followings are the available columns in table 'citys':
 * @property string $id
 * @property string $countrys_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property Concert[] $concerts
 * @property Venue[] $venues
 */
class City extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return City the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'citys';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('countrys_id', 'length', 'max' => 10),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, countrys_id, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country' => array(self::BELONGS_TO, 'Country', 'countrys_id'),
            'concerts' => array(self::HAS_MANY, 'Concert', 'citys_id'),
            'venues' => array(self::HAS_MANY, 'Venues', 'citys_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'countrys_id' => 'Countrys',
            'name' => 'City',
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
        $criteria->compare('countrys_id', $this->countrys_id, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function getExistingOrCreateNew($cityName, $countryId = '') {
        $cityRecord = $this->with('country')->findByAttributes(array(
            'name' => $cityName,
            'countrys_id' => $countryId));

        if ($cityRecord == null) {
            $cityRecord = new self();
            $cityRecord->name = $cityName;
            $cityRecord->countrys_id = $countryId;
            $cityRecord->save();
        }
        return $cityRecord;
    }

    public function suggest($city, $countryFilter, $limit = 20) {
        $dbC = Yii::app()->db->createCommand();
        $dbC->select(array('citys.id', 'citys.name'))
                ->from(array('citys', 'countrys'))
                ->where(array(
                    'and',
                    'citys.countrys_id=countrys.id',
                    'countrys.name = :countryname',
                    'citys.name LIKE :city'
                ))
                ->order('citys.name');
        $dbC->params[':countryname'] = "$countryFilter";
        $dbC->params[':city'] = "$city%";

        $queryResult = $dbC->queryAll();

        $suggest = array();
        foreach ($queryResult as $row) {
            $suggest[] = array(
                'label' => $row['name'], // label for dropdown list
                'value' => $row['name'], // value for input field
                'id' => $row['id'], // return values from autocomplete
            );
        }
        return $suggest;
    }

}