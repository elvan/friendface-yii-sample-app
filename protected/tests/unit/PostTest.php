<?php

class PostTest extends CDbTestCase {
  public $fixtures = array('posts' => 'Post',);
  public $attr = array(
    'content' => 'Lorem ipsum dolor sit amet, spero mihi servitute coniunx caritate completae ad',
    'author_id' => 1,
    'recipient_id' => 1,
  );

  public function testCreateValidPost() {
    $post = new Post;
    $post->setAttributes($this->attr);
    $this->assertTrue($post->save());
  }

  public function testRejectLongContent() {
    $long = '';
    for ($i = 1; $i <= 1025; $i++) {
      $long = $long . "a";
    }
    $post = new Post;
    $post->setAttributes(array_merge($this->attr, array(
      'content' => $long,
    )));
    $this->assertFalse($post->save());
  }

  public function testRelationAuthor() {
    $post = Post::model()->findByPk(1);
    $this->assertNotNull($post->author);
    $this->assertTrue($post->author instanceof User);
  }

  public function testRelationRecipient() {
    $post = Post::model()->findByPk(1);
    $this->assertNotNull($post->recipient);
    $this->assertTrue($post->recipient instanceof Profile);
  }

  public function testRecentlyScope() {
    $post = Post::model()->recently();
    $this->assertTrue($post instanceof Post);
    $posts = $post->findAll();
    $this->assertTrue(is_array($posts));
    $this->assertTrue($posts[0]->create_time > $posts[1]->create_time);
  }
}
