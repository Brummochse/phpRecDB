<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $role
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, salt, role', 'required'),
            array('username, password, salt, role', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, salt, role', 'safe', 'on' => 'search'),
            array('username', 'checkDuplicateUsernames'),
        );
    }

    public function checkDuplicateUsernames($attribute, $params) {
        if (!$this->hasErrors()) {
            $newUsername = $this->username;
            $equalUserModels = User::model()->findAll('LOWER(username)=?', array(strtolower($newUsername)));
                 
            if ($this->isNewRecord) { //create
                 if (count($equalUserModels)>0) {
                     $this->addError('username', 'username already exists');
                 }
            } else { //update
                $oldUserModel = User::model()->findByPk($this->id);
                $oldUsername = $oldUserModel->username;
                
                if ($oldUsername!=$newUsername && count($equalUserModels)>0) {
                    $this->addError('username', 'username already exists');
                }
            }
        }
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
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'role' => 'Role',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('role', $this->role, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    public function generateSalt() {
        return uniqid('', true);
    }

}

