<?php

class ProfileControllerTest extends WebTestCase {
  public $fixtures = array('users' => 'User', 'profiles' => 'Profile');

  public function testShowProfilePage() {
    $full_name = $this->users('user1')->profile->first_name . ' ' . $this->users('user1')->profile->last_name;
    $this->signinUser();
    $this->assertElementPresent('link=Profile');
    $this->clickAndWait('link=Profile');
    $this->assertEquals($this->title . $full_name, $this->getTitle());
    $this->assertStringEndsWith('/friendface/profile/' . $this->users('user1')->id, $this->getLocation());
    $this->assertElementPresent('alt=Profile Pic');
    $this->assertTextPresent($full_name);
    $this->assertTextPresent('Date of Birth: ' . date('F j, Y', strtotime($this->users('user1')->profile->date_of_birth)));
  }

  public function testEditProfilePage() {
    $this->signinUser();
    $this->open('profile/' . $this->users('user1')->id);
    $this->assertElementPresent('link=Edit Profile');
    $this->clickAndWait('link=Edit Profile');
    $this->assertEquals($this->title . 'Edit Profile', $this->getTitle());
    $this->assertElementPresent('name=Profile[first_name]');
    $this->assertElementPresent('name=Profile[last_name]');
    $this->assertElementPresent('name=Profile[home_town]');
    $this->assertElementPresent('name=Profile[current_town]');
    $this->assertElementPresent('name=Profile[birth_date][day]');
    $this->assertElementPresent('name=Profile[birth_date][month]');
    $this->assertElementPresent('name=Profile[birth_date][year]');
    $this->assertElementPresent('css=input[value=Save]');
  }

  public function testEditProfileFailure() {
    $this->signinUser();
    $this->open('profile/edit');

    $this->type('name=Profile[first_name]', '');
    $this->type('name=Profile[last_name]', '');
    $this->type('name=Profile[home_town]', '');
    $this->type('name=Profile[current_town]', '');
    $this->select('name=Profile[birth_date][day]', 'index=0');
    $this->select('name=Profile[birth_date][month]', 'index=0');
    $this->select('name=Profile[birth_date][year]', 'index=0');
    $this->clickAndWait('css=input[value=Save]');

    // ensure error messages appear
    $this->assertTextPresent('First Name cannot be blank.');
    $this->assertTextPresent('Last Name cannot be blank.');
    $this->assertTextPresent('Date of Birth cannot be blank.');
  }

  public function testEditProfileSuccess() {
    $this->signinUser();
    $this->open('profile/edit');

    $this->type('name=Profile[first_name]', 'Jason');
    $this->type('name=Profile[last_name]', 'Stevens');
    $this->select('name=Profile[birth_date][day]', 'index=25');
    $this->select('name=Profile[birth_date][month]', 'index=5');
    $this->select('name=Profile[birth_date][year]', 'index=85');
    $this->clickAndWait('css=input[value=Save]');

    // ensure messages appear
    $this->assertTextPresent('Profile successfuly updated.');
    $this->assertTextNotPresent('First Name cannot be blank.');
    $this->assertTextNotPresent('Last Name cannot be blank.');
  }

  // authentication of edit profile page
  public function testAuthEditProfile() {
    $user = $this->users('user1');

    // ensure the user is logged out
    if ($this->isTextPresent('Sign Out')) {
      $this->assertElementPresent('link=Sign Out');
      $this->clickAndWait('link=Sign Out');
    }
    // should deny access to 'update'
    $this->open('profile/edit');
    $this->assertStringEndsWith('friendface/signin', $this->getLocation());
    $this->type('name=LoginForm[email]', 'test1@notanaddress.com');
    $this->type('name=LoginForm[password]', 'test_1');
    $this->clickAndWait('css=input[value=Sign In]');

    // should require matching users for update
    $this->open('profile/edit');
    $this->assertStringEndsWith('profile/edit', $this->getLocation());
  }

  public function testUploadProfilePicture() {
    $this->signinUser();
    $this->assertElementPresent('link=Profile');
    $this->clickAndWait('link=Profile');
    $this->assertElementPresent('link=Change Profile Pic');
    $this->clickAndWait('link=Change Profile Pic');
    $this->assertEquals($this->title . 'Profile Picture', $this->getTitle());
    $this->assertElementPresent('name=Profile[profile_pic]');
    $this->assertElementPresent('css=input[value=Upload]');
  }

  public function testCreatePost() {
    $this->signinUser();
    $this->assertElementPresent('link=Profile');
    $this->clickAndWait('link=Profile');
    $this->assertElementPresent('name=Post[content]');
    $this->assertElementPresent('name=Post[recipient_id]');
  }
}
