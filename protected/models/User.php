<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $uid
 * @property string $email
 * @property string $encrypted_password
 * @property integer $profile_id
 * @property string $last_login_time
 * @property string $created_at
 * @property string $updated_at
 */
class User extends CActiveRecord {
  public $password;
  public $password2;
  public $verifyCode;

  /**
   * Returns the static model of the specified AR class.
   * @return User the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return '{{user}}';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('email, password, password2, verifyCode', 'required', 'on' => 'insert'),
      array('email', 'required', 'on' => 'change_email'),
      array('password, password2', 'required', 'on' => 'change_password'),
      array('password', 'compare', 'compareAttribute'=>'password2'),
      array('email', 'email'),
      array('email', 'unique', 'caseSensitive' => false),
      array('password', 'length', 'min' => 6, 'max' => 40),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, uid, email', 'safe', 'on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'ID',
      'uid' => 'Uid',
      'email' => 'Email',
      'password' => 'Password',
      'password2' => 'Password Confirmation',
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;

    $criteria->compare('id', $this->id);
    $criteria->compare('uid', $this->uid,true);
    $criteria->compare('email', $this->email,true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
    ));
  }

  public function beforeSave() {
    if (parent::beforeSave()) {
      if ($this->isNewRecord) {
        $this->encryptPassword();
        $this->createUid();
      }
      return true;
    }
    else {
      return false;
    }
  }

  public function hasPassword($submittedPassword) {
    return $this->encrypted_password == $this->encrypt($submittedPassword);
  }

  public static function authenticate($email, $password) {
    $email = strtolower($email);
    $user = User::model()->find('LOWER(email)=?', array($email));

    if ($user instanceof User) {
      if ($user->hasPassword($password)) {
        return $user;
      };
    }
    return NULL;
  }

  /* private methods */

  private function encryptPassword() {
    $this->salt = $this->makeSalt();
    $this->encrypted_password = $this->encrypt($this->password);
  }

  private function encrypt($string) {
    return md5($this->salt . '--' . $string);
  }

  private function makeSalt() {
    return md5(time() . '--' . $this->password);
  }

  private function createUid() {
    $crc32 = sprintf('%x', crc32($this->salt));
    $this->uid = strtoupper($crc32);
  }
}
