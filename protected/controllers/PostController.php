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
    $profile = Profile::model()->findByPk(array($_GET['uid']));
    $post = Post::model()->find('recipient_id=:uid AND create_time=:pid', array(':uid' => $_GET['uid'], ':pid' => $_GET['pid']));
    if ($post === null) {
      throw new CHttpException(404,'The requested page does not exist.');
    }

    $comment = $this->newComment($post);

    $this->render('view',array(
      'profile' => $profile,
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

  public function actionDelete() {
    if(Yii::app()->request->isPostRequest) {
      if(isset($_GET['id'])) {
        $post = Post::model()->find('id=:pid AND (author_id=:aid OR recipient_id=:aid)', array(':pid' => $_GET['id'], ':aid' => Yii::app()->user->id));
        if ($post === null) {
          throw new CHttpException(404,'The requested page does not exist.');
        }

        $post->delete();
      }
      $this->redirect(array('/'));
    }
    else
      throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  }

  public function accessRules() {
    return array(
      array('allow',
        'actions' => array('view'),
        'users' => array('*'),
      ),
      array('allow',
        'actions' => array('create', 'delete'),
        'users' => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
}
