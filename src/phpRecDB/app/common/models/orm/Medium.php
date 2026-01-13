<?php

/**
 * This is the model class for table "media".
 *
 * The followings are the available columns in table 'media':
 * @property int $id
 * @property int $bootlegtypes_id
 * @property string $label
 * @property string $shortname
 *
 * The followings are the available model relations:
 * @property Record[] $records
 */
class Medium extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Medium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bootlegtypes_id, label, shortname', 'required'),
			array('bootlegtypes_id', 'length', 'max'=>10),
			array('label, shortname', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bootlegtypes_id, label, shortname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'records' => array(self::HAS_MANY, 'Record', 'media_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bootlegtypes_id' => 'Bootlegtypes',
			'label' => 'Label',
			'shortname' => 'Shortname',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('bootlegtypes_id',$this->bootlegtypes_id,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('shortname',$this->shortname,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}