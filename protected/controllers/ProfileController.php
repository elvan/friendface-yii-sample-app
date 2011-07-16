<?php

class ProfileController extends Controller {
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

    if (Yii::app()->user->id == $this->_model->id) {
      $this->menu = array(
        array('label' => 'Change Profile Pic', 'url' => 'changeProfilePic'),
        array('label' => 'Edit Profile', 'url' => 'edit'),
      );
    }

    $full_name = $this->_model->profile->first_name . ' ' . $this->_model->profile->last_name;;
    $this->pageTitle = $full_name;
    $this->render('view', array(
      'profile' => $this->_model->profile,
      'full_name' => $full_name,
    ));
  }

  public function actionEdit() {
    $this->pageTitle = 'Edit Profile';
    $profile = Profile::model()->findByPk(Yii::app()->user->id);
    $profile->birth_date['day'] = date('j', strtotime($profile->date_of_birth));
    $profile->birth_date['month'] = date('n', strtotime($profile->date_of_birth));
    $profile->birth_date['year'] = date('Y', strtotime($profile->date_of_birth));

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    if (isset($_POST['Profile'])) {
      $profile->attributes = $_POST['Profile'];
      // set date of birth manually
      $date_of_birth = '';
      if (($_POST['Profile']['birth_date']['day'] != '') && ($_POST['Profile']['birth_date']['month'] != '') && ($_POST['Profile']['birth_date']['year']  != '')) {
        $date_of_birth = $_POST['Profile']['birth_date']['year'] .'-'.$_POST['Profile']['birth_date']['month'].'-'.$_POST['Profile']['birth_date']['day'];
        $profile->attributes = array_merge($_POST['Profile'], array('date_of_birth' => $date_of_birth));
      }

      $profile->validate();

      if (($_POST['Profile']['birth_date']['day'] == '') OR ($_POST['Profile']['birth_date']['month'] == '') OR ($_POST['Profile']['birth_date']['year']  == '')) {
        $profile->date_of_birth = '';
      }
      else {
        $profile->birth_date = $_POST['Profile']['birth_date'];
      }

      if ($profile->save()) {
        Yii::app()->user->setFlash('profile', 'Profile successfuly updated.');
        $this->redirect(array('view', 'id' => $profile->id));
      }
    }

    $this->render('edit', array(
      'profile' => $profile,
    ));
  }

  public function actionChangeProfilePic() {
    $this->pageTitle = 'Profile Picture';
    $profile = Profile::model()->findByPk(Yii::app()->user->id);
    $profile->setScenario('change_profile_pic');

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    if (isset($_POST['Profile'])) {
      $uploaddir = Yii::app()->basePath . '/../uploads/';
      $newName = md5(basename($_FILES['Profile']['name']['profile_pic'])) . '.jpg';
      $uploadfile = $uploaddir . $newName;

      if (move_uploaded_file($_FILES['Profile']['tmp_name']['profile_pic'], $uploadfile)) {
        $profile->profile_picture = $newName;
      }

      if ($profile->save()) {
        Yii::app()->user->setFlash('profile', 'Profile Puctire successfuly uploaded.');
        $this->redirect(array('view', 'id' => $profile->id));
      }
    }

    $this->render('changeProfilePic', array(
      'profile' => $profile,
    ));
  }

  public function filters() {
    return array('accessControl');
  }

  public function accessRules() {
    return array(
      array('allow',
        'actions' => array('view'),
        'users' => array('*'),
      ),
      array('allow',
        'actions' => array('edit', 'changeProfilePic'),
        'users' => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
}
