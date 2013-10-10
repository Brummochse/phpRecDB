<?php

/**
 * This is the model class for table "job".
 */
class Job extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'job':
	 * @var integer $jid
	 * @var string $jdesc
	 * @var integer $jseq
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Job the static model class
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
		return 'job';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jdesc', 'length', 'max'=>50),
			array('jdesc', 'required'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jseq', 'numerical', 'integerOnly'=>true),
			array('jid, jdesc,jseq', 'safe', 'on'=>'search'),
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
			'jid' => 'Job id',
			'jdesc' => 'Description',
			'jseq' => 'Sequence',
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

		$criteria->compare('jid',$this->jid);
		$criteria->compare('jseq',$this->jseq);
		$criteria->compare('jdesc',$this->jdesc,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}