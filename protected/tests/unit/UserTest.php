<?php

class UserTest extends CDbTestCase {
  public $fixtures = array('users' => 'User');
  public $attr = array(
    'email' => 'test5@notanaddress.com',
    'password' => 'test_5',
    'password2' => 'test_5',
    'verifyCode' => 'abcdef',
  );

  public function testCreateValidUser() {
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
  }

  public function testRequireEmailAddress() {
    $noEmailUser = new User;
    $noEmailUser->setAttributes(array_merge($this->attr, array('email' => '')));
    $this->assertFalse($noEmailUser->save());
  }

  public function testAcceptValidEmailAddresses() {
    $addresses = array('user@foo.com', 'THE_USER@foo.bar.org', 'first.last@foo.jp');
    foreach ($addresses as $address) {
      $validEmailUser = new User;
      $validEmailUser->setAttributes(array_merge($this->attr, array('email' => $address)));
      $this->assertTrue($validEmailUser->save());
    }
  }

  public function testRejectInvalidEmailAddresses() {
    $addresses = array('user@foo,com', 'user_at_foo.org', 'example.user@foo.');
    foreach ($addresses as $address) {
      $invalidEmailUser = new User;
      $invalidEmailUser->setAttributes(array_merge($this->attr, array('email' => $address)));
      $this->assertFalse($invalidEmailUser->save());
    }
  }

  public function testRejectDuplicateEmailAddresses() {
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());

    $userWithDuplicateEmail = new User;
    $userWithDuplicateEmail->setAttributes(array_merge($this->attr, array('email' => $this->users('user1')->email)));
    $this->assertFalse($userWithDuplicateEmail->save());
  }

  public function testRejectEmailAddressesIdenticalCase() {
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());

    $userWithDuplicateEmail = new User;
    $userWithDuplicateEmail->setAttributes(array_merge($this->attr, array('email' => strtoupper($this->users('user1')->email))));
    $this->assertFalse($userWithDuplicateEmail->save());
  }

  public function testRequirePassword() {
    $user = new User;
    $user->setAttributes(array_merge($this->attr, array(
      'password' => '',
      'password2' => ''
    )));
    $this->assertFalse($user->save());
  }

  public function testRequirePasswordConfirmation() {
    $user1 = new User;
    $user1->setAttributes(array_merge($this->attr, array(
      'password2' => ''
    )));
    $this->assertFalse($user1->save());

    $user2 = new User;
    $user2->setAttributes(array_merge($this->attr, array(
      'password2' => 'test_2'
    )));
    $this->assertFalse($user2->save());
  }

  public function testRejectShortPasswords() {
    $short = 'aaaaa';
    $user = new User;
    $user->setAttributes(array_merge($this->attr, array(
      'password' => $short,
      'password2' => $short,
    )));
    $this->assertFalse($user->save());
  }

  public function testRejectLongPasswords() {
    $long = '';
    for ($i = 1; $i <= 41; $i++) {
      $long = $long . "a";
    }
    $user = new User;
    $user->setAttributes(array_merge($this->attr, array(
      'password' => $long,
      'password2' => $long,
    )));
    $this->assertFalse($user->save());
  }

  public function testEncryptPasswords() {
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
    $this->assertNotEmpty($user->encrypted_password);
  }

  public function testPasswordEncryptionValid() {
    // should be true if the passwords match
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
    $retUser = User::model()->findByPk($user->id);
    $this->assertTrue($retUser instanceof User);
    $this->assertNotEmpty($retUser->salt);
    $this->assertNotEmpty($retUser->encrypted_password);
    $this->assertTrue($retUser->hasPassword($this->attr['password']));
  }

  public function testPasswordEncryptionInvalid() {
    // should be false if the passwords don't match
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
    $retUser = User::model()->findByPk($user->id);
    $this->assertTrue($retUser instanceof User);
    $this->assertNotEmpty($retUser->salt);
    $this->assertNotEmpty($retUser->encrypted_password);
    $this->assertFalse($user->hasPassword('invalid_password'));
  }

  public function testAuthenticateMethod() {
    $user = new User;
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());

    // should return nil on email/password mismatch
    $wrongPassUser = User::authenticate($this->attr['email'], 'wrong pass');
    $this->assertNull($wrongPassUser);

    // should return nil for an email address with no user
    $nonexistUser = User::authenticate('bar@foo.baz', $this->attr['password']);
    $this->assertNull($nonexistUser);

    // should return the user on email/password match
    $matchingUser = User::authenticate($this->attr['email'], $this->attr['password']);
    $this->assertTrue($matchingUser instanceof User);
  }

  public function testRelationProfile() {
    $user = User::model()->findByPk(1);
    $this->assertTrue($user instanceof User);
    $this->assertNotNull($user->profile);
    $this->assertTrue($user->profile instanceof Profile);
  }

  public function testRelationPosts() {
    $user = User::model()->findByPk(1);
    $this->assertTrue($user instanceof User);
    $this->assertNotNull($user->posts);
    $this->assertTrue($user->posts['0'] instanceof Post);
  }
}
