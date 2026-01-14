<?php

/**
 * This is the model class for table "concerts".
 *
 * The followings are the available columns in table 'concerts':
 * @property int $id
 * @property int $artists_id
 * @property string $date
 * @property int $countrys_id
 * @property int $citys_id
 * @property int $venues_id
 * @property string $supplement
 * @property int $misc
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property City $city
 * @property Venue $venue
 * @property Artist $artist
 * @property Record[] $records
 */
class Concert extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Concert the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'concerts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('artists_id, date', 'required'),
            array('misc', 'numerical', 'integerOnly' => true),
            array('artists_id, countrys_id, citys_id, venues_id', 'length', 'max' => 10),
            array('supplement', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, artists_id, date, countrys_id, citys_id, venues_id, supplement, misc', 'safe', 'on' => 'search'),
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
            'city' => array(self::BELONGS_TO, 'City', 'citys_id'),
            'venue' => array(self::BELONGS_TO, 'Venue', 'venues_id'),
            'artist' => array(self::BELONGS_TO, 'Artist', 'artists_id'),
            'records' => array(self::HAS_MANY, 'Record', 'concerts_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'artists_id' => 'Artist',
            'date' => 'Date',
            'countrys_id' => 'Country',
            'citys_id' => 'City',
            'venues_id' => 'Venue',
            'supplement' => 'Supplement',
            'misc' => 'Misc',
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
        $criteria->compare('artists_id', $this->artists_id, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('countrys_id', $this->countrys_id, true);
        $criteria->compare('citys_id', $this->citys_id, true);
        $criteria->compare('venues_id', $this->venues_id, true);
        $criteria->compare('supplement', $this->supplement, true);
        $criteria->compare('misc', $this->misc);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function __toString() {
        $date = $this->date;
        $country = $this->country != null ? $this->country->name : "";
        $city = $this->city != null ? $this->city->name : "";
        $venue = $this->venue != null ? $this->venue->name : "";

        return Concert::generateString($date, $country, $city, $venue, $this->supplement, $this->misc);
    }

    public static function generateString($date = null, $country = null, $city = null, $venue = null, $supplement = null, $misc = null) {
        $outStr = "";
        if (!empty($date))
            $outStr.=" " . $date;
        $outStr .= ' '.self::formatLocation($country, $city, $venue, $supplement);
        if ($misc === 1) {
            $outStr.=" (MISC)";
        }
        return $outStr;
    }

    public static function formatLocation(?string $country, ?string $city, ?string $venue, ?string $supplement): string
    {
        $formatPattern=Yii::app()->settingsManager->getPropertyValue(Settings::LOCATION_FORMAT_PATTERN);

        $values = [
            '{country}'    => $country,
            '{city}'       => $city,
            '{venue}'      => $venue,
            '{supplement}' => $supplement,
        ];

        // Split the pattern into parts (placeholders vs. delimiters)
        $parts = preg_split('/(\{.*?\})/', $formatPattern, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $formatted = '';
        $lastDelimiter = '';

        foreach ($parts as $part) {
            if (isset($values[$part])) {
                // it is a placeholder
                $val = trim((string)$values[$part]);

                if ($val !== '') {
                    $formatted .= $lastDelimiter . $val;
                    $lastDelimiter = '';
                }
            } else {
                // It's a delimiter (e.g. ", " or " - ")
                // Remember the delimiter if it is between two values.
                // If a delimiter is already waiting, ignore this one ("only the first" logic).
                if ($lastDelimiter === '' && $formatted !== '') {
                    $lastDelimiter = $part;
                }
            }
        }
         return $formatted;
    }

    public function searchExistingConcerts($artist, $date, $misc) {
        $artistId = Artist::model()->getExistingOrCreateNew($artist)->id;
        return Concert::model()->findAllByAttributes(array("date" => $date, "artists_id" => $artistId, "misc" => $misc));
    }

    public function getConcertFormModel() {
        $concertForm = new ConcertForm();

        $concertForm->artist = ($this->artist == NULL) ? '' : $this->artist->name;
        $concertForm->date = $this->date;
        $concertForm->country = ($this->country == NULL) ? '' : $this->country->name;
        $concertForm->city = ($this->city == NULL) ? '' : $this->city->name;
        $concertForm->venue = ($this->venue == NULL) ? '' : $this->venue->name;
        $concertForm->supplement = $this->supplement;
        $concertForm->misc = $this->misc;

        return $concertForm;
    }

    public function fillDataFromConcertFormModel($concertFormModel) {
        $this->artists_id = Artist::model()->getExistingOrCreateNew($concertFormModel->artist)->id;
        $this->date = $concertFormModel->date;
        $this->countrys_id = Country::model()->getExistingOrCreateNew($concertFormModel->country)->id;
        $this->citys_id = City::model()->getExistingOrCreateNew($concertFormModel->city, $this->countrys_id)->id;
        $this->venues_id = Venue::model()->getExistingOrCreateNew($concertFormModel->venue, $this->citys_id)->id;
        $this->supplement = $concertFormModel->supplement;
        $this->misc = $concertFormModel->misc;
    }

}