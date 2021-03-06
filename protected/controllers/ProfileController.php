<?php

class ProfileController extends Controller {
  public function actionView() {
    $this->layout = 'profile';
    $profile = Profile::model()->findByPk($_GET['id']);
    $this->pageTitle = $profile->fullName;

    if ($this->isSignedIn()) {
      if ($_GET['id'] == Yii::app()->user->id) {
        $this->menu = array(
          array('label' => 'Change Profile Pic', 'url' => 'changeProfilePic'),
          array('label' => 'Edit Profile', 'url' => 'edit'),
        );
      }

      $post = new Post;
      $post->recipient_id = $_GET['id'];
      Yii::app()->user->setState('returnUrl', Yii::app()->request->url);
      $this->render('view', array(
        'profile' => $profile,
        'post' => $post,
        'dataProvider' => Post::getStatuses($profile),
      ));
    }
    else {
      $this->render('view', array(
        'profile' => $profile,
        'dataProvider' => Post::getStatuses($profile),
      ));
    }
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
        Yii::app()->user->setFlash('profile', 'Profile Picture successfuly uploaded.');
        $this->redirect(array('view', 'id' => $profile->id));
      }
    }

    $this->render('changeProfilePic', array(
      'profile' => $profile,
    ));
  }

  public function actionFollow() {
    if (isset($_POST['Profile'])) {
      $followed = Profile::model()->findByPk($_POST['Profile']['id']);
      $follower = Profile::model()->findByPk(Yii::app()->user->id);
      if ($follower->addFollowing($followed)) {
        Yii::app()->user->setFlash('profile', 'This profile successfuly followed.');
        $this->redirect(Yii::app()->user->getState('returnUrl'));
      }
    }
  }

  public function actionUnfollow() {
    if (isset($_POST['Profile'])) {
      $followed = Profile::model()->findByPk($_POST['Profile']['id']);
      $follower = Profile::model()->findByPk(Yii::app()->user->id);
      if ($follower->removeFollowing($followed)) {
        Yii::app()->user->setFlash('profile', 'This profile successfuly unfollowed.');
        $this->redirect(Yii::app()->user->getState('returnUrl'));
      }
    }
  }

  public function actionFollowers() {
    $this->layout = 'profile';
    $followed = Profile::model()->findByPk($_GET['id']);
    Yii::app()->user->setState('returnUrl', Yii::app()->request->url);

    $criteria = new CDbCriteria(array(
      'condition' => 'followed_id=' . $followed->id,
      'order' => 'create_time DESC',
    ));

    $dataProvider = new CActiveDataProvider('Connection', array(
      'pagination'=>array(
        'pageSize' => 20,
      ),
      'criteria'=>$criteria,
    ));

    $this->render('followers', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionFollowing() {
    $this->layout = 'profile';
    $follower = Profile::model()->findByPk($_GET['id']);
    Yii::app()->user->setState('returnUrl', Yii::app()->request->url);

    $criteria = new CDbCriteria(array(
      'condition' => 'follower_id=' . $follower->id,
      'order' => 'create_time DESC',
    ));

    $dataProvider = new CActiveDataProvider('Connection', array(
      'pagination'=>array(
        'pageSize' => 20,
      ),
      'criteria'=>$criteria,
    ));

    $this->render('following', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function filters() {
    return array('accessControl');
  }

  public function accessRules() {
    return array(
      array('allow',
        'actions' => array('view', 'followers', 'following'),
        'users' => array('*'),
      ),
      array('allow',
        'actions' => array('edit', 'changeProfilePic', 'follow', 'unfollow'),
        'users' => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
}
