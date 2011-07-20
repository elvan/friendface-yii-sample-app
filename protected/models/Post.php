<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property string $content
 * @property integer $user_id
 * @property integer $recipient_id
 * @property string $create_time
 * @property string $update_time
 */
class Post extends CActiveRecord {
  /**
   * Returns the static model of the specified AR class.
   * @return Post the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return '{{post}}';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('content, author_id, recipient_id', 'required'),
      array('content', 'length', 'max' => '1024'),
      array('author_id, recipient_id', 'numerical', 'integerOnly' => true),
      array('content, create_time, update_time', 'safe'),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, content, user_id, recipient_id, create_time, update_time', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'author' => array(self::BELONGS_TO, 'User', 'author_id'),
      'recipient' => array(self::BELONGS_TO, 'Profile', 'recipient_id'),
      'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
    );
  }

  public function scopes() {
    return array(
      'recently' => array(
        'order' => 'create_time DESC',
        'limit' => 100,
      ),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id' => 'ID',
      'content' => 'Content',
      'user_id' => 'User',
      'recipient_id' => 'Recipient',
      'create_time' => 'Create Time',
      'update_time' => 'Update Time',
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
    $criteria->compare('content', $this->content,true);
    $criteria->compare('user_id', $this->user_id);
    $criteria->compare('recipient_id', $this->recipient_id);
    $criteria->compare('create_time', $this->create_time,true);
    $criteria->compare('update_time', $this->update_time,true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
    ));
  }

  protected function beforeSave() {
    if (parent::beforeSave()) {
      if ($this->isNewRecord) {
        $this->create_time = $this->update_time = time();
      }
      else {
        $this-> update_time = time();
      }
      return true;
    }
    else {
      return false;
    }
  }

  public function addComment($comment) {
    $comment->post_id = $this->id;
    return $comment->save();
  }

  public static function getFeeds($profile) {
    $followedIds = implode(", ", array_map(function($following) { return $following->id; }, $profile->following));
    $where = $followedIds ? "recipient_id IN ({$followedIds}) OR recipient_id=" . $profile->id : "recipient_id=" . $profile->id;
    return new CActiveDataProvider(__CLASS__, array(
      'criteria'=>array(
        'condition'=>$where,
        'order'=>'create_time DESC',
      ),
    ));
  }

  public static function getStatuses($profile) {
    $where = "author_id=" . $profile->user->id . " OR recipient_id=" . $profile->id;
    return new CActiveDataProvider(__CLASS__, array(
      'criteria'=>array(
        'condition'=>$where,
        'order'=>'create_time DESC',
      ),
    ));
  }
}
