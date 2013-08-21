<?php

/**
 * This is the model class for table "venues".
 *
 * The followings are the available columns in table 'venues':
 * @property string $id
 * @property string $citys_id
 * @property string $name
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Concerts[] $concerts
 * @property Citys $citys
 */
class Venue extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Venue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'venues';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('citys_id', 'length', 'max' => 10),
            array('name', 'length', 'max' => 255),
            array('notes', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, citys_id, name, notes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'concerts' => array(self::HAS_MANY, 'Concert', 'venues_id'),
            'city' => array(self::BELONGS_TO, 'City', 'citys_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'citys_id' => 'Citys',
            'name' => 'Venue',
            'notes' => 'Notes',
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
        $criteria->compare('citys_id', $this->citys_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('notes', $this->notes, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function getExistingOrCreateNew($venueName, $cityId = '') {

        $venueRecord = $this->with('city')->findByAttributes(array(
            'name' => $venueName,
            'citys_id' => $cityId));

        if ($venueRecord == null) {
            $venueRecord = new self();
            $venueRecord->name = $venueName;
            $venueRecord->citys_id = $cityId;
            $venueRecord->save();
        }
        return $venueRecord;
    }

    public function suggest($venue, $cityFilter, $countryFilter, $limit = 20) {
        $dbC = Yii::app()->db->createCommand();
        $dbC->select(array('venues.id', 'venues.name'))
                ->from(array('citys', 'countrys', 'venues'))
                ->where(array(
                    'and',
                    'citys.countrys_id=countrys.id',
                    'venues.citys_id=citys.id',
                    'countrys.name = :countryname',
                    'citys.name= :cityname',
                    'venues.name LIKE :venue'
                ))
                ->order('venues.name');
        $dbC->params[':countryname'] = "$countryFilter";
        $dbC->params[':cityname'] = "$cityFilter";
        $dbC->params[':venue'] = "$venue%";

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

    public function __toString() {
    //public function toString2() {
        $venueName=$this->name;
        if ($this->city!=NULL) {
            $cityCountryName=$this->city->name;
            if ($this->city->country!=NULL) {
                $countryName=$this->city->country->name;
                $cityCountryName=$countryName . " - " . $cityCountryName;
            }
             $venueName = $venueName.'('.$cityCountryName.')';
        }
        
        return $venueName ;
    }
    
   
}