<?php

class UserController extends Controller {
  public function actionCreate() {
    $this->pageTitle = 'Sign Up';
    $user = new User;
    $profile = new Profile;

    if (isset($_POST['User']) && isset($_POST['Profile'])) {
      $user->attributes = $_POST['User'];
      $profile->attributes = $_POST['Profile'];

      // set date of birth manually
      $date_of_birth = '';
      if (($_POST['Profile']['birth_date']['day'] != '') && ($_POST['Profile']['birth_date']['month'] != '') && ($_POST['Profile']['birth_date']['year']  != '')) {
        $date_of_birth = $_POST['Profile']['birth_date']['year'] .'-'.$_POST['Profile']['birth_date']['month'].'-'.$_POST['Profile']['birth_date']['day'];
        $profile->attributes = array_merge($_POST['Profile'], array('date_of_birth' => $date_of_birth));
      }

      $profile->birth_date = $_POST['Profile']['birth_date'];

      $userValid = $user->validate();
      $profileValid = $profile->validate();

      if ($userValid && $profileValid) {
        $user->save(false);
        $profile->user_id = $user->id;
        $profile->save(false);

        $login = new LoginForm;
        $login->email = $user->email;
        $login->password = $user->password;
        $login->login();
        Yii::app()->user->setFlash('user', 'Welcome to the Friendface.');
        $this->redirect(array('view', 'id' => $user->id));
      }
      else {
        if ($profile->hasErrors()) {
          $user->addErrors($profile->getErrors());
        }
      }

      $user->verifyCode = '';
    }

    $this->render('create', array('user' => $user, 'profile' => $profile));
  }

  public function actionView() {
    $this->layout = 'column2';

    if(isset($_GET['uid'])) {
      $this->_model = User::model()->find('LOWER(uid)=?', array(strtolower($_GET['uid'])));
      if ($this->_model == null) {
        throw new CHttpException(404,'The requested page does not exist.');
      }
    }
    else {
      $this->_model = $this->loadModel();
    }
    $this->pageTitle = $this->_model->profile->first_name;
    $username = $this->_model->profile->first_name;
    $this->render('view', array(
      'model' => $this->_model,
      'username' => $username,
    ));
  }

  public function actionChangeEmail() {
    $this->pageTitle = 'Change Email';
    $user = User::model()->findByPk(Yii::app()->user->id);
    $user->setScenario('change_email');

    if (Yii::app()->user->id != $user->id) {
      $this->redirect(Yii::app()->homeUrl);
    }

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    if (isset($_POST['User'])) {
      $user->email = $_POST['User']['email'];
      if ($user->save()) {
        Yii::app()->user->setFlash('user', 'User successfuly updated.');
        $this->redirect(array('view', 'id' => $user->id));
      }
    }

    $this->render('change_email', array(
      'user'=>$user,
    ));
  }

  public function actionChangePassword() {
    $this->pageTitle = 'Change Password';
    $user = User::model()->findByPk(Yii::app()->user->id);
    $user->setScenario('change_password');

    if (Yii::app()->user->id != $user->id) {
      $this->redirect(Yii::app()->homeUrl);
    }

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    if (isset($_POST['User'])) {
      $user->attributes = $_POST['User'];
      if ($user->save()) {
        Yii::app()->user->setFlash('user', 'User successfuly updated.');
        $this->redirect(array('view', 'id' => $user->id));
      }
    }

    $this->render('change_password', array(
      'user'=>$user,
    ));
  }

  public function filters() {
    return array('accessControl');
  }

  public function accessRules() {
    return array(
      array('allow',
        'actions' => array('view', 'create', 'captcha'),
        'users' => array('*'),
      ),
      array('allow',
        'actions' => array('update', 'show', 'changeEmail', 'changePassword'),
        'users' => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
}
