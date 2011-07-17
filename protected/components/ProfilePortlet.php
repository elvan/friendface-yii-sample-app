<?php

Yii::import('zii.widgets.CPortlet');

class ProfilePortlet extends CPortlet {
  protected function renderContent() {
    if (isset($_GET['id'])) {
      $user = User::model()->findbyPk($_GET['id']);
    }
    else {
      $user = User::model()->findbyPk(Yii::app()->user->id);
    }

    $profile = $user->profile;
    $this->render('viewProfile', array('profile' => $profile));
  }
}
