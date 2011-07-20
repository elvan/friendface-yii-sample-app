<?php

class ConnectionTest extends CDbTestCase {
  public $fixtures = array('profiles' => 'Profile', 'connections' => 'Connection');

  public function testCreateValidConnection() {
    $profile1 = $this->profiles('profile1');
    $profile2 = $this->profiles('profile2');
    $connection = new Connection;
    $connection->follower_id = $profile1->id;
    $connection->followed_id = $profile2->id;
    $this->assertNotNull($connection->follower);
    $this->assertNotNull($connection->followed);
    $this->assertInstanceOf('Profile', $connection->follower);
    $this->assertInstanceOf('Profile', $connection->followed);
    $this->assertEquals($connection->follower, $profile1);
    $this->assertEquals($connection->followed, $profile2);
    $this->assertTrue($connection->save());
  }

  public function testRequireFollower() {
    $connection = $this->connections('connection1');
    $connection->follower_id = '';
    $this->assertFalse($connection->save());
  }

  public function testRequireFollowed() {
    $connection = $this->connections('connection2');
    $connection->followed_id = '';
    $this->assertFalse($connection->save());
  }
  
  public function testConnectionIds() {
    $connection1 = $this->connections('connection1');
    $connection2 = $this->connections('connection2');
    $connection3 = $this->connections('connection3');
    $connection4 = $this->connections('connection4');
    $this->assertEquals(1, $connection1->id);
    $this->assertEquals(2, $connection2->id);
    $this->assertEquals(3, $connection3->id);
    $this->assertEquals(4, $connection4->id);

    $this->assertEquals(1, $connection1->follower_id);
    $this->assertEquals(1, $connection2->follower_id);
    $this->assertEquals(2, $connection3->follower_id);
    $this->assertEquals(4, $connection4->follower_id);
    
    $this->assertEquals(3, $connection1->followed_id);
    $this->assertEquals(4, $connection2->followed_id);
    $this->assertEquals(4, $connection3->followed_id);
    $this->assertEquals(1, $connection4->followed_id);
  }
}
