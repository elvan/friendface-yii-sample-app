<?php

class Helper {
  public static function title($title) {
    $base_title = Yii::app()->name;
    if ($title == NULL) {
      return $base_title;
    }
    else {
      return $base_title . ' - ' . $title;
    }
  }

  public static function profile() {
    $link = '/profile';

    if (! Yii::app()->user->isGuest) {
      $user = User::model()->findByPk(Yii::app()->user->id);
      if ($user->uid) {
        $link = '/u/' . $user->uid;
      }
      else {
        $link = '/user/' . $user->id;
      }
    }
    return $link;
  }

  public static function birthDate() {
    $birth_date = array();

    for ($i = 1; $i <= 31; $i++) {
      $birth_date['day'][$i] = $i;
    }

    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    for ($i = 1; $i <= 12; $i++) {
      $birth_date['month'][$i] = $months[$i - 1];
    }

    for ($i = 1901; $i <= 2010; $i++) {
      $birth_date['year'][$i] = $i;
    }

    return $birth_date;
  }
}
