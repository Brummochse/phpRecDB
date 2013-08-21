<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property integer $done
 * @property string $finish_time
 * @property string $open_time
 * @property string $random_id
 * @property string $random_key
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, done, random_id, random_key', 'required'),
			array('name, email', 'length', 'max'=>255),
			array('random_id, random_key', 'length', 'max'=>11),
			array('finish_time, open_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, done, finish_time, open_time, random_id, random_key', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'email' => 'Email',
			'done' => 'Done',
			'finish_time' => 'Finish Time',
			'open_time' => 'Open Time',
			'random_id' => 'Random',
			'random_key' => 'Random Key',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('done',$this->done);
		$criteria->compare('finish_time',$this->finish_time,true);
		$criteria->compare('open_time',$this->open_time,true);
		$criteria->compare('random_id',$this->random_id,true);
		$criteria->compare('random_key',$this->random_key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}