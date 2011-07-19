<?php

class Controller extends CController {
  public $layout = '//layouts/column1';
  public $menu = array();
  public $breadcrumbs=array();
  public $pageTitle = '';

  public function actions() {
    return array(
      'captcha'=>array(
        'class'=>'CCaptchaAction',
        'backColor'=>0xFFFFFF,
        'fixedVerifyCode' => YII_DEBUG ? 'abcdef' : null,
      ),
    );
  }

  public function isSignedIn() {
    return ! Yii::app()->user->isGuest;
  }

  protected function listPosts($profileId) {
    $criteria = new CDbCriteria(array(
      'condition' => 'recipient_id=' . $profileId,
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
