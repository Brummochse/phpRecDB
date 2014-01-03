<?php

/**
 * This is the model class for table "uservisit".
 *
 * The followings are the available columns in table 'recordvisit':
 * @property integer $id
 * @property integer $record_id
 * @property string $page
 * @property string $ip 
 * @property string $useragent
 * @property string $date
 */
class Uservisit extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'uservisit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ip, date', 'required'),
            array('record_id', 'numerical', 'integerOnly' => true),
            array('ip', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, record_id, ip, date', 'safe', 'on' => 'search'),
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
            'record_id' => 'Record',
            'page' => 'Page',
            'ip' => 'Ip',
            'useragent' => 'Useragent',
            'date' => 'Date',
        );
    }

    public function create() {
        $userVisit = new Uservisit();
        $userVisit->ip = Yii::app()->request->getUserHostAddress();
        $userVisit->date = date('Y-m-d H:i:s');
        $userVisit->useragent = $_SERVER['HTTP_USER_AGENT'];
        return $userVisit;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Recordvisit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function isBotVisitor() {
        $botIdBlackList = Yii::app()->params['botIdentBlackList'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        foreach ($botIdBlackList as $botIdentifier) {
            if (stristr($userAgent, $botIdentifier) != False) {
                return true;
            }
        }
        return false;
    }

    public function logPageVisit($pageVisit) {
        $userVisit = $this->create();
        $userVisit->page = $pageVisit;
        $userVisit->save();
    }

}