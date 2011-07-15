<?php

class UserTest extends CDbTestCase {
  public $attr = array('password' => 'test_1', 'password2' => 'test_1');
  public $fixtures = array('users' => 'User');

  public function testCreateValidUser() {
    $user = $this->users('user1');
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
  }

  public function testRequireEmailAddress() {
    $noEmailUser = new User;
    $noEmailUser->setAttributes(array_merge($this->users('user1')->attributes, array('email' => '')));
    $this->assertFalse($noEmailUser->save());
  }

  public function testAcceptValidEmailAddresses() {
    $addresses = array('user@foo.com', 'THE_USER@foo.bar.org', 'first.last@foo.jp');
    foreach ($addresses as $address) {
      $validEmailUser = $this->users('user1');
      $validEmailUser->setAttributes(array_merge($this->attr, array('email' => $address)));
      $this->assertTrue($validEmailUser->save());
    }
  }

  public function testRejectInvalidEmailAddresses() {
    $addresses = array('user@foo,com', 'user_at_foo.org', 'example.user@foo.');
    foreach ($addresses as $address) {
      $invalidEmailUser = $this->users('user1');
      $invalidEmailUser->setAttributes(array_merge($this->attr, array('email' => $address)));
      $this->assertFalse($invalidEmailUser->save());
    }
  }

  public function testRejectDuplicateEmailAddresses() {
    $user = $this->users('user1');
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());

    $userWithDuplicateEmail = $this->users('user2');
    $userWithDuplicateEmail->setAttributes(array_merge($this->attr, array('email' => $this->users('user1')->email)));
    $this->assertFalse($userWithDuplicateEmail->save());
  }

  public function testRejectEmailAddressesIdenticalCase() {
    $user = $this->users('user1');
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());

    $upcasedEmail = strtoupper($this->users('user1')->email);
    $userWithDuplicateEmail = $this->users('user2');
    $userWithDuplicateEmail->setAttributes(array_merge($this->attr, array('email' => $upcasedEmail)));
    $this->assertFalse($userWithDuplicateEmail->save());
  }

  public function testRequirePassword() {
    $user = new User;
    $user->setAttributes(array_merge($this->users('user1')->attributes, array(
      'password' => '',
      'password2' => ''
    )));
    $this->assertFalse($user->save());
  }

  public function testRequirePasswordConfirmation() {
    $user = new User;
    $user->setAttributes(array_merge($this->users('user1')->attributes, array(
      'password2' => ''
    )));
    $this->assertFalse($user->save());
  }

  public function testRejectShortPasswords() {
    $short = 'aaaaa';
    $user = $this->users('user1');
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
    $user = $this->users('user1');
    $user->setAttributes(array_merge($this->attr, array(
      'password' => $long,
      'password2' => $long,
    )));
    $this->assertFalse($user->save());
  }

  public function testEncryptPasswords() {
    $user = $this->users('user1');
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
    $this->assertNotEmpty($user->encrypted_password);
  }

  public function testPasswordEncryptionValid() {
    // should be true if the passwords match
    $user = $this->users('user1');
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
    $user = $this->users('user1');
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());
    $retUser = User::model()->findByPk($user->id);
    $this->assertTrue($retUser instanceof User);
    $this->assertNotEmpty($retUser->salt);
    $this->assertNotEmpty($retUser->encrypted_password);
    $this->assertFalse($user->hasPassword('invalid password'));
  }

  public function testAuthenticateMethod() {
    $user = $this->users('user1');
    $user->setAttributes($this->attr);
    $this->assertTrue($user->save());

    // should return nil on email/password mismatch
    $wrongPassUser = User::authenticate($this->users('user1')->email, 'wrong pass');
    $this->assertNull($wrongPassUser);

    // should return nil for an email address with no user
    $nonexistUser = User::authenticate('bar@foo.baz', $this->users('user1')->password);
    $this->assertNull($nonexistUser);

    // should return the user on email/password match
    $matchingUser = User::authenticate($this->users('user1')->email, $this->users('user1')->password);
    $this->assertTrue($matchingUser instanceof User);
  }

  public function testGetProfile() {
    $user = User::model()->findByPk(1);
    $this->assertTrue($user instanceof User);
    $this->assertNotNull($user->profile);
    $this->assertTrue($user->profile instanceof Profile);
    $this->assertEquals('Profile', $user->profile->first_name);
    $this->assertEquals('One', $user->profile->last_name);
    $this->assertEquals('Bandung', $user->profile->home_town);
    $this->assertEquals('Bandung', $user->profile->current_town);
  }
}
