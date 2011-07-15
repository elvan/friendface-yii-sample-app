<?php

/**
 * This is the model class for table "{{profile}}".
 *
 * The followings are the available columns in table '{{profile}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $display_name
 * @property string $full_name
 * @property string $home_town
 * @property string $current_town
 * @property string $date_of_birth
 * @property string $created_at
 * @property string $updated_at
 */
class Profile extends CActiveRecord {
  public $birth_date = array();

  /**
   * Returns the static model of the specified AR class.
   * @return Profile the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return '{{profile}}';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('first_name, last_name, date_of_birth', 'required'),
      array('user_id', 'numerical', 'integerOnly'=>true),
      array('first_name, last_name', 'length', 'min' => 3, 'max' => 50),
      array('username', 'length', 'min' => 5, 'max' => 16),
      array('home_town, current_town', 'length', 'max'=>50),
      array('date_of_birth, create_time, update_time', 'safe'),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, user_id, username, full_name, home_town, current_town, date_of_birth, create_time, update_time', 'safe', 'on'=>'search'),
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
      'user_id' => 'User',
      'display_name' => 'Display Name',
      'full_name' => 'Full Name',
      'home_town' => 'Home Town',
      'current_town' => 'Current Town',
      'date_of_birth' => 'Date of Birth',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
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

    $criteria->compare('id',$this->id);
    $criteria->compare('user_id',$this->user_id);
    $criteria->compare('display_name',$this->display_name,true);
    $criteria->compare('full_name',$this->full_name,true);
    $criteria->compare('home_town',$this->home_town,true);
    $criteria->compare('current_town',$this->current_town,true);
    $criteria->compare('date_of_birth',$this->date_of_birth,true);
    $criteria->compare('created_at',$this->created_at,true);
    $criteria->compare('updated_at',$this->updated_at,true);

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
  }
}
