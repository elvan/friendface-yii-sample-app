<?php

class PostController extends Controller {
  public function actionCreate() {
    $post = new Post;

    if (isset($_POST['Post']) && $_POST['Post']['content'] != '') {
      $post->attributes = $_POST['Post'];
      $post->author_id = Yii::app()->user->id;
      $post->save();
    }

    $this->redirect(Yii::app()->user->getState('returnUrl'));
  }

  public function actionView() {
    $post = Post::model()->find('create_time=?', array($_GET['pid']));
    //$comment = $this->newComment($post);

    $this->render('view',array(
      'post' => $post,
      //'comment' => $comment,
    ));
  }

  protected function newComment($post) {
    $comment =new Comment;
    if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form') {
      echo CActiveForm::validate($comment);
      Yii::app()->end();
    }

    if (isset($_POST['Comment'])) {
      $comment->attributes = $_POST['Comment'];
      if($post->addComment($comment)) {
        $this->refresh();
      }
    }
    return $comment;
  }
  
  public function accessRules() {
    return array(
      array('allow',
        'actions' => array('view'),
        'users' => array('*'),
      ),
      array('allow',
        'actions' => array('create'),
        'users' => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }

  // Uncomment the following methods and override them if needed
  /*
  public function filters()
  {
    // return the filter configuration for this controller, e.g.:
    return array(
      'inlineFilterName',
      array(
        'class'=>'path.to.FilterClass',
        'propertyName'=>'propertyValue',
      ),
    );
  }

  public function actions()
  {
    // return external action classes, e.g.:
    return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
        'class'=>'path.to.AnotherActionClass',
        'propertyName'=>'propertyValue',
      ),
    );
  }
  */
}
