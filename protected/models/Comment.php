<?php

class Comment extends CActiveRecord {
  /**
   * Returns the static model of the specified AR class.
   * @return CActiveRecord the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return '{{comment}}';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('content, author_id, post_id', 'required'),
      array('content', 'length', 'max' => 512),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
      'author' => array(self::BELONGS_TO, 'User', 'author_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'Id',
      'content' => 'Comment',
      'status' => 'Status',
      'create_time' => 'Create Time',
      'author' => 'Name',
      'email' => 'Email',
      'url' => 'Website',
      'post_id' => 'Post',
    );
  }

  protected function beforeSave() {
    if(parent::beforeSave())
    {
      if($this->isNewRecord)
        $this->create_time=time();
      return true;
    }
    else
      return false;
  }

  public function scopes() {
    return array(
      'recently' => array(
        'order' => 'create_time ASC',
        'limit' => 100,
      ),
    );
  }
}
