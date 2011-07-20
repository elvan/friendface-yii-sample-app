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
    $profile = $this->profiles('profile1');
    $profile->setAttributes(array('first_name' => $short, 'last_name' => $short));
    $this->assertFalse($profile->save());
  }

  public function testRejectLongName() {
    $long = '';
    for ($i = 1; $i <= 51; $i++) {
      $long = $long . "a";
    }
    $profile = $this->profiles('profile1');
    $profile->setAttributes(array('first_name' => $long, 'last_name' => $long));
    $this->assertFalse($profile->save());
  }

  public function testRejectShortDisplayName() {
    $short = 'aaaa';
    $profile = $this->profiles('profile1');
    $profile->setAttributes(array('username' => $short));
    $this->assertFalse($profile->save());
  }

  public function testRejectLongDisplayName() {
    $long = '';
    for ($i = 1; $i <= 17; $i++) {
      $long = $long . "a";
    }
    $profile = $this->profiles('profile1');
    $profile->setAttributes(array('username' => $long));
    $this->assertFalse($profile->save());
  }

  public function testAllowEmptyDisplayName() {
    $profile = $this->profiles('profile1');
    $profile->setAttributes(array('username' => ''));
    $this->assertTrue($profile->save());
  }

  public function testFullName() {
    $profile = $this->profiles('profile1');
    $this->assertEquals('John Smith', $profile->fullName);
  }

  public function testPostsProperty() {
    $profile = $this->profiles('profile1');
    $this->assertNotNull($profile->posts);
    $this->assertInstanceOf('Post', $profile->posts[0]);
  }

  public function testUserProperty() {
    $profile = $this->profiles('profile1');
    $this->assertNotNull($profile->user);
    $this->assertInstanceOf('User', $profile->user);
  }

  public function testConnectionsProperty() {
    $profile = $this->profiles('profile1');
    $this->assertNotNull($profile->connections);
    $this->assertInstanceOf('Connection', $profile->connections[0]);
  }

  public function testFollowingProperty() {
    $profile = $this->profiles('profile1');
    $this->assertNotNull($profile->following);
    $this->assertInstanceOf('Profile', $profile->following[0]);
  }

  public function testFollowersProperty() {
    $profile = $this->profiles('profile1');
    $this->assertNotNull($profile->followers);
    $this->assertInstanceOf('Profile', $profile->followers[0]);
  }

  public function testAddFollowingMethod() {
    $profile1 = $this->profiles('profile1');
    $profile2 = $this->profiles('profile2');
    $profile1->addFollowing($profile2);
    $this->assertTrue($profile1->save());
  }

  public function testIsFollowingMethod() {
    $profile1 = $this->profiles('profile1');
    $profile2 = $this->profiles('profile2');
    $profile3 = $this->profiles('profile3');
    $profile4 = $this->profiles('profile4');
    $this->assertTrue($profile1->isFollowing($profile3));
    $this->assertTrue($profile1->isFollowing($profile4));
    $this->assertTrue($profile2->isFollowing($profile4));
    $this->assertTrue($profile4->isFollowing($profile1));
  }

  public function testRemoveFollowingMethod() {
    $profile1 = $this->profiles('profile1');
    $profile2 = $this->profiles('profile2');
    $profile1->removeFollowing($profile2);
    $this->assertTrue($profile1->save());
    $this->assertFalse($profile1->isFollowing($profile2));
  }

  public function testReverseConnectionsProperty() {
    $profile = $this->profiles('profile1');
    $this->assertNotNull($profile->revConnections);
    $this->assertInstanceOf('Connection', $profile->revConnections[0]);
  }

  public function testCountConnections() {
    $profile1 = $this->profiles('profile1');
    $profile2 = $this->profiles('profile2');
    $profile3 = $this->profiles('profile3');
    $profile4 = $this->profiles('profile4');

    $this->assertEquals(2, $profile1->followingCount);
    $this->assertEquals(1, $profile2->followingCount);
    $this->assertEquals(0, $profile3->followingCount);
    $this->assertEquals(1, $profile4->followingCount);

    $this->assertEquals(1, $profile1->followersCount);
    $this->assertEquals(0, $profile2->followersCount);
    $this->assertEquals(1, $profile3->followersCount);
    $this->assertEquals(2, $profile4->followersCount);
  }
}
