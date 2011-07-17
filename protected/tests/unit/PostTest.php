<?php

class PostTest extends CDbTestCase {
  public $fixtures = array('posts' => 'Post',);
  public $attr = array(
    'content' => 'Lorem ipsum dolor sit amet, spero mihi servitute coniunx caritate completae ad',
    'user_id' => 1,
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
}
