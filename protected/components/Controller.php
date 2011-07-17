<?php

class Controller extends CController {
  public $layout = '//layouts/column1';
  public $menu = array();
  public $breadcrumbs=array();
  public $pageTitle = '';
  protected $_user;

  public function actions() {
    return array(
      'captcha'=>array(
        'class'=>'CCaptchaAction',
        'backColor'=>0xFFFFFF,
        'fixedVerifyCode' => YII_DEBUG ? 'abcdef' : null,
      ),
    );
  }

  public function loadUser() {
    if ($this->_user === null) {
      if(isset($_GET['id'])) {
        $this->_user = User::model()->findbyPk($_GET['id']);
      }
      else {
        $this->_user= User::model()->findbyPk(Yii::app()->user->id);
      }

      if($this->_user === null) {
        throw new CHttpException(404,'The requested page does not exist.');
      }
    }

    return $this->_user;
  }

  public function isCurrentUser() {
    return $this->_user->id == Yii::app()->user->id;
  }

  public function createPost() {
    $user = $this->loadUser();
    $post = new Post;
    $post->recipient_id = $user->id;
    $post->author_id = Yii::app()->user->id;

    if (isset($_POST['Post']) && $_POST['Post']['content'] != '') {
      $post->attributes = $_POST['Post'];
      if($post->save()) {
        $this->refresh();
      }
    }

    return $post;
  }

  public function listPosts() {
    $criteria = new CDbCriteria(array(
      'condition' => 'recipient_id=' . $this->loadUser()->id,
      'order' => 'create_time DESC',
    ));

    $dataProvider = new CActiveDataProvider('Post', array(
      'pagination'=>array(
        'pageSize' => 20,
      ),
      'criteria'=>$criteria,
    ));

    return $dataProvider;
  }
}
