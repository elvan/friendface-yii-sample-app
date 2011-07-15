<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
  private $_id;
  public $email;
  public $password;

  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
  }

  public function authenticate() {
    $email = strtolower($this->email);
    $user = User::model()->find('LOWER(email)=?', array($email));

    if ($user === null) {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    elseif (! $user->hasPassword($this->password)) {
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
    }
    else {
      $this->_id = $user->id;
      $this->username = $user->email;
      $this->errorCode = self::ERROR_NONE;
    }

    return $this->errorCode;
  }

  public function getId() {
    return $this->_id;
  }
}
