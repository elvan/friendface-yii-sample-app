<?php

class ProfileTest extends CDbTestCase {
  public $fixtures = array('profiles' => 'Profile',);

  public function testCreateValidProfile() {
    $profile = $this->profiles('profile1');
    $this->assertTrue($profile->save());
  }

  public function testRequireName() {
    $noName = $this->profiles('profile1');
    $noName->setAttributes(array('first_name' => '', 'last_name' => ''));
    $this->assertFalse($noName->save());
  }

  public function testRequireDateBirth() {
    $noDateBirth = $this->profiles('profile1');
    $noDateBirth->setAttributes(array('date_of_birth' => ''));
    $this->assertFalse($noDateBirth->save());
  }

  public function testRejectShortName() {
    $short = 'aa';
    $user = $this->profiles('profile1');
    $user->setAttributes(array('first_name' => $short, 'last_name' => $short));
    $this->assertFalse($user->save());
  }

  public function testRejectLongName() {
    $long = '';
    for ($i = 1; $i <= 51; $i++) {
      $long = $long . "a";
    }
    $user = $this->profiles('profile1');
    $user->setAttributes(array('first_name' => $long, 'last_name' => $long));
    $this->assertFalse($user->save());
  }

  public function testRejectShortDisplayName() {
    $short = 'aaaa';
    $user = $this->profiles('profile1');
    $user->setAttributes(array('username' => $short));
    $this->assertFalse($user->save());
  }

  public function testRejectLongDisplayName() {
    $long = '';
    for ($i = 1; $i <= 17; $i++) {
      $long = $long . "a";
    }
    $user = $this->profiles('profile1');
    $user->setAttributes(array('username' => $long));
    $this->assertFalse($user->save());
  }

  public function testAllowEmptyDisplayName() {
    $user = $this->profiles('profile1');
    $user->setAttributes(array('username' => ''));
    $this->assertTrue($user->save());
  }

  public function testFullName() {
    $profile = Profile::model()->findByPk(1);
    $this->assertEquals('John Smith', $profile->fullName);
  }
  
  public function testRelationPosts() {
    $profile = Profile::model()->findByPk(1);
    $this->assertTrue($profile instanceof Profile);
    $this->assertNotNull($profile->posts);
    $this->assertTrue($profile->posts['0'] instanceof Post);
  }
  
  public function testRelationUser() {
    $profile = Profile::model()->findByPk(1);
    $this->assertNotNull($profile->user);
    $this->assertTrue($profile->user instanceof User);
  }
}
