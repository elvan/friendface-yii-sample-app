<?php

class UserTest extends WebTestCase {
  protected $attr = array(
    'first_name' => 'Example',
    'last_name' => 'Example',
    'email' => 'user@example.com',
    'password' => 'foobar',
    'password2' => 'foobar',
  );
  public $title = 'Friendface - ';
  public $fixtures = array('users' => 'User', 'profiles' => 'Profile');

  public function testSignUpPage() {
    $this->open('');
    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    $this->assertEquals($this->title . 'Home', $this->getTitle());
    $this->assertElementPresent('name=Profile[first_name]');
    $this->assertElementPresent('name=Profile[last_name]');
    $this->assertElementPresent('name=Profile[birth_date][day]');
    $this->assertElementPresent('name=Profile[birth_date][month]');
    $this->assertElementPresent('name=Profile[birth_date][year]');
    $this->assertElementPresent('name=User[email]');
    $this->assertElementPresent('name=User[password]');
    $this->assertElementPresent('name=User[password2]');
    $this->assertElementPresent('css=input[value=Sign Up]');
  }

  public function testSignUpFailure() {
    $userBefore = User::model()->findAll();
    $profileBefore = Profile::model()->findAll();
    $this->open('');
    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    $this->assertEquals($this->title . 'Home', $this->getTitle());

    $this->type('name=Profile[first_name]', '');
    $this->type('name=Profile[last_name]', '');
    $this->type('name=User[email]', '');
    $this->type('name=User[password]', '');
    $this->type('name=User[password2]', '');
    $this->clickAndWait('css=input[value=Sign Up]');

    // ensure error messages appear
    $this->assertTextPresent('First Name cannot be blank.');
    $this->assertTextPresent('Last Name cannot be blank.');
    $this->assertTextPresent('Date of Birth cannot be blank.');
    $this->assertTextPresent('Email cannot be blank.');
    $this->assertTextPresent('Password cannot be blank.');
    $this->assertTextPresent('Password Confirmation cannot be blank.');

    $userAfter = User::model()->findAll();
    $profileAfter = Profile::model()->findAll();
    $this->assertEquals(count($userBefore), count($userAfter));
    $this->assertEquals(count($profileBefore), count($profileAfter));
  }

  public function testSignUpSuccess() {
    User::model()->deleteAll();
    Profile::model()->deleteAll();
    $userBefore = User::model()->findAll();
    $profileBefore = Profile::model()->findAll();

    $this->open('');
    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    $this->assertEquals($this->title . 'Home', $this->getTitle());

    $this->type('name=Profile[first_name]', $this->attr['first_name']);
    $this->type('name=Profile[last_name]', $this->attr['last_name']);
    $this->select('name=Profile[birth_date][day]', 'index=19');
    $this->select('name=Profile[birth_date][month]', 'index=4');
    $this->select('name=Profile[birth_date][year]', 'index=83');
    $this->type('name=User[email]', $this->attr['email']);
    $this->type('name=User[password]', $this->attr['password']);
    $this->type('name=User[password2]', $this->attr['password2']);
    $this->clickAndWait('css=input[value=Sign Up]');

    // ensure error messages appear
    $this->assertTextNotPresent('First Name cannot be blank.');
    $this->assertTextNotPresent('Last Name cannot be blank.');
    $this->assertTextNotPresent('Date of Birth cannot be blank.');
    $this->assertTextNotPresent('Email cannot be blank.');
    $this->assertTextNotPresent('Password cannot be blank.');
    $this->assertTextNotPresent('Password Confirmation cannot be blank.');

    $userAfter = User::model()->findAll();
    $profileAfter = Profile::model()->findAll();
    $this->assertNotEquals(count($userBefore), count($userAfter));
    $this->assertNotEquals(count($profileBefore), count($profileAfter));
  }

  public function testShowUser() {
    $user = $this->users('user1');
    // should find the right user
    $this->open('user/' . $user->id);
    $this->assertTextPresent($user->profile->first_name);
  }

  public function testChangeEmailPage() {
    $this->signinUser();
    $user = $this->users('user1');

    // should be successful and have the right title
    $this->open('user/changeEmail/' . $user->id);
    $this->assertEquals($this->title . 'Change Email', $this->getTitle());

    // ensure all form elements present
    $this->assertElementPresent('name=User[email]');
    $this->assertElementPresent('css=input[value=Save]');
  }

  public function testChangeEmailFailure() {
    $this->signinUser();
    $user = $this->users('user1');

    // should be successful and have the right title
    $this->open('user/changeEmail/' . $user->id);
    $this->assertEquals($this->title . 'Change Email', $this->getTitle());

    // submit empty form
    $this->type('name=User[email]', '');
    $this->clickAndWait('css=input[value=Save]');

    // ensure error messages appear
    $this->assertTextPresent('Email cannot be blank.');
  }

  public function testChangeEmailSuccess() {
    $this->signinUser();
    $user = $this->users('user1');

    // should be successful and have the right title
    $this->open('user/changeEmail/' . $user->id);
    $this->assertEquals($this->title . 'Change Email', $this->getTitle());

    // should change the user's attributes
    $this->type('name=User[email]', 'new_test1@notanaddress.com');
    $this->clickAndWait('css=input[value=Save]');

    $this->assertTextNotPresent('Email cannot be blank.');

    $updatedUser = User::model()->findByPk($user->id);
    $this->assertEquals('new_test1@notanaddress.com', $updatedUser->email);

    // should redirect to the user show page
    $this->assertStringEndsWith('/friendface/user/' . $updatedUser->id, $this->getLocation());

    // should have a flash message
    $this->assertTextPresent('User successfuly updated.');
  }

  public function testChangePasswordPage() {
    $this->signinUser();
    $user = $this->users('user1');

    // should be successful and have the right title
    $this->open('user/changePassword/' . $user->id);
    $this->assertEquals('Friendface - Change Password', $this->getTitle());

    // ensure all form elements present
    $this->assertElementPresent('name=User[password]');
    $this->assertElementPresent('name=User[password2]');
    $this->assertElementPresent('css=input[value=Save]');
  }

  public function testChangePasswordFailure() {
    $this->signinUser();
    $user = $this->users('user1');

    // should be successful and have the right title
    $this->open('user/changePassword/' . $user->id);
    $this->assertEquals('Friendface - Change Password', $this->getTitle());

    // submit empty form
    $this->type('name=User[password]', '');
    $this->type('name=User[password2]', '');
    $this->clickAndWait('css=input[value=Save]');

    // ensure error messages appear
    $this->assertTextPresent('Password cannot be blank.');
    $this->assertTextPresent('Password Confirmation cannot be blank.');
  }

  public function testChangePasswordSuccess() {
    $this->signinUser();
    $user = $this->users('user1');

    // should be successful and have the right title
    $this->open('user/changePassword/' . $user->id);
    $this->assertEquals('Friendface - Change Password', $this->getTitle());

    // should change the user's attributes
    $this->type('name=User[password]', 'barbaz');
    $this->type('name=User[password2]', 'barbaz');
    $this->clickAndWait('css=input[value=Save]');

    $this->assertTextNotPresent('Password cannot be blank.');
    $this->assertTextNotPresent('Password Confirmation cannot be blank.');

    $updatedUser = User::model()->findByPk($user->id);
    //$this->assertTrue($updatedUser->hasPassword('barbaz'));

    // should redirect to the user show page
    $this->assertStringEndsWith('/friendface/user/' . $updatedUser->id, $this->getLocation());

    // should have a flash message
    $this->assertTextPresent('User successfuly updated.');
  }

  // authentication of update pages
  public function testAuthChangeEmail() {
    $user = $this->users('user1');

    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    // should deny access to 'update'
    $this->open('user/changeEmail');
    $this->assertStringEndsWith('friendface/signin', $this->getLocation());
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');

    // should require matching users for update
    $this->open('user/changeEmail');
    $this->assertStringEndsWith('user/changeEmail', $this->getLocation());
  }

  public function testAuthChangePassword() {
    $user = $this->users('user1');

    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    // should deny access to 'update'
    $this->open('user/changePassword');
    $this->assertStringEndsWith('friendface/signin', $this->getLocation());
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');

    // should require matching users for update
    $this->open('user/changePassword');
    $this->assertStringEndsWith('user/changePassword', $this->getLocation());
  }

  public function testFriendlyForwardings() {
    $this->open('');
    $this->assertElementPresent('link=Sign In');
    $this->clickAndWait('link=Sign In');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertElementPresent('link=Sign Out');
    $this->clickAndWait('link=Sign Out');

    // the test automatically follows the redirect to the signin page
    $this->open('user/changeEmail');
    $this->assertStringEndsWith('friendface/signin', $this->getLocation());

    $this->open('');
    $this->assertElementPresent('link=Sign In');
    $this->clickAndWait('link=Sign In');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');

    // the test follows the redirect again, this time to user/update/[id]
    $this->assertStringEndsWith('user/changeEmail', $this->getLocation());
  }

  public function signinUser() {
    $this->open('');
    $this->clickAndWait('link=Sign In');
    $this->assertEquals('Friendface - Sign In', $this->getTitle());
    $this->assertElementPresent('name=LoginForm[email]');
    $this->assertElementPresent('name=LoginForm[password]');
    $this->assertElementPresent('css=input[value=Sign In]');
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');
    $this->assertEquals('Friendface - Home', $this->getTitle());
    $this->assertElementPresent('link=Sign Out');
  }
}
