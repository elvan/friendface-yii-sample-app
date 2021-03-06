<?php

class SiteController extends Controller {
  /**
   * This is the default 'index' action that is invoked
   * when an action is not explicitly requested by users.
   */
  public function actionIndex() {
    $this->layout = 'home';
    $this->pageTitle = 'Home';

    if ($this->isSignedIn()) {
      $profileId = Yii::app()->user->id;
      $post = new Post;
      $post->recipient_id = $profileId;
      $profile = Profile::model()->findByPk($profileId);
      Yii::app()->user->setState('returnUrl', Yii::app()->request->url);
      $this->render('index', array(
        'post' => $post,
        'profile' => $profile,
        'dataProvider' => Post::getFeeds($profile),
      ));
    }
    else {
      $user = new User;
      $profile = new Profile;
      $this->render('index', array(
        'user' => $user,
        'profile' => $profile,
      ));
    }
  }

  public function actionAbout() {
    $this->pageTitle = 'About';
    $this->render('about');
  }

  public function actionHelp() {
    $this->pageTitle = 'Help';
    $this->render('help');
  }

  /**
   * This is the action to handle external exceptions.
   */
  public function actionError() {
    $this->pageTitle = 'Error';
    if($error=Yii::app()->errorHandler->error) {
      if(Yii::app()->request->isAjaxRequest) {
        echo $error['message'];
      }
      else {
        $this->render('error', $error);
      }
    }
  }

  /**
   * Displays the contact page
   */
  public function actionContact() {
    $this->pageTitle = 'Contact';
    $model=new ContactForm;
    if(isset($_POST['ContactForm'])) {
      $model->attributes=$_POST['ContactForm'];
      if($model->validate()) {
        $headers="From: {$model->email}\r\nReply-To: {$model->email}";
        mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
        Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
        $this->refresh();
      }
    }
    $this->render('contact',array('model'=>$model));
  }

  /**
   * Displays the login page
   */
  public function actionLogin() {
    $this->pageTitle = 'Sign In';
    $model=new LoginForm;

    // if it is ajax validation request
    if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }

    // collect user input data
    if(isset($_POST['LoginForm'])) {
      $model->attributes=$_POST['LoginForm'];
      // validate user input and redirect to the previous page if valid
      if($model->validate() && $model->login()) {
        $this->redirect(Yii::app()->user->returnUrl);
      }
    }
    // display the login form
    $this->render('login',array('model'=>$model));
  }

  /**
   * Logs out the current user and redirect to homepage.
   */
  public function actionLogout() {
    $this->pageTitle = '';
    Yii::app()->user->logout();
    $this->redirect(Yii::app()->homeUrl);
  }
}
