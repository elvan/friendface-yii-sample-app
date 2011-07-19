<?php

class PostController extends Controller {
  public function actionCreate() {
    $post = new Post;

    if (isset($_POST['Post'])) {
      $post->attributes = $_POST['Post'];
      $post->author_id = Yii::app()->user->id;
      $post->save();
    }

    $this->redirect($this->createUrl($_POST['returnUrl']));
  }

  public function actionView() {
    $post = Post::model()->find('create_time=?', array($_GET['pid']));
    $comment = $this->newComment($post);

    $this->render('view',array(
      'post' => $post,
      'comment' => $comment,
      'dataProvider' => $this->listComments($post->id),
    ));
  }

  protected function newComment($post) {
    $comment = new Comment;

    if (isset($_POST['Comment'])) {
      $comment->attributes = $_POST['Comment'];
      $comment->author_id = Yii::app()->user->id;
      if($post->addComment($comment)) {
        $this->refresh();
      }
    }
    return $comment;
  }
  
  protected function listComments($postId)  {
    $criteria = new CDbCriteria(array(
      'condition' => 'post_id=' . $postId,
      'order' => 'create_time ASC',
    ));

    $dataProvider = new CActiveDataProvider('Comment', array(
      'pagination'=>array(
        'pageSize' => 50,
      ),
      'criteria'=>$criteria,
    ));

    return $dataProvider;
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
}
