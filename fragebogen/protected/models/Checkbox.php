<?php

/**
 * This is the model class for table "checkbox".
 *
 * The followings are the available columns in table 'checkbox':
 * @property string $id
 * @property string $users_id
 * @property string $element_id
 * @property integer $value
 */
class Checkbox extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Checkbox the static model class
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
		return 'checkbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, element_id', 'required'),
			array('users_id', 'length', 'max'=>11),
			array('element_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, users_id, element_id, value', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users_id' => 'Users',
			'element_id' => 'Element',
			'value' => 'Value',
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
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('element_id',$this->element_id,true);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}