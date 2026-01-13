<?php

/**
 * This is the model class for table "recordvisit".
 *
 * The followings are the available columns in table 'recordvisit':
 * @property int $id
 * @property int $record_id
 * @property int $visitors
 *
 * The followings are the available model relations:
 * @property Record $record
 */
class Recordvisit extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'recordvisit';
    }

    public function getVisitorsForRecord($recordModel) {
        $visit = $this->findByAttributes(array('record_id' => $recordModel->id));
        if ($visit == null) { //does not exist -> create new
            $visit = new Recordvisit();
            $visit->record_id = $recordModel->id;
            $visit->visitors = 0;
        }
        return $visit;
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('record_id', 'required'),
            array('record_id, visitors', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, record_id, visitors', 'safe', 'on'=>'search'),
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
            'record' => array(self::BELONGS_TO, 'Record', 'record_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'record_id' => 'Record',
            'visitors' => 'Visitors',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('record_id',$this->record_id);
        $criteria->compare('visitors',$this->visitors);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Recordvisit the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}