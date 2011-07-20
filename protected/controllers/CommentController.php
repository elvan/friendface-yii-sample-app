<?php

class CommentController extends Controller {
  public function actionDelete() {
    if(Yii::app()->request->isPostRequest) {
      if(isset($_GET['id'])) {
        $post = Comment::model()->find('id=:cid AND author_id=:aid', array(':cid' => $_GET['id'], ':aid' => Yii::app()->user->id));
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
        'actions' => array('delete'),
        'users' => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
}
