<?php

class CommentTest extends CDbTestCase {
  public $fixtures = array('posts' => 'Post', 'comments' => 'Comment',);
  public $attr = array(
    'content' => 'Lorem ipsum dolor sit amet, spero mihi servitute coniunx caritate completae ad',
    'author_id' => 1,
  );

  public function testCreateValidComment() {
    $post = $this->posts('post1');
    $comment = new Comment;
    $comment->setAttributes(array_merge($this->attr, array('post_id' => $post->id)));
    $this->assertTrue($comment->save());
  }

  public function testRejectLongComment() {
    $long = '';
    for ($i = 1; $i <= 513; $i++) {
      $long = $long . "a";
    }
    $post = $this->posts('post1');
    $comment = new Comment;
    $comment->setAttributes(array(
      'content' => $long,
      'author_id' => 1,
      'post_id' => $post->id,
    ));
    $this->assertFalse($comment->save());
  }

  public function testRelationAuthor() {
    $comment = $this->comments('comment1');
    $this->assertNotNull($comment->author);
    $this->assertTrue($comment->author instanceof User);
  }

  public function testRelationPost() {
    $comment = $this->comments('comment1');
    $this->assertNotNull($comment->post);
    $this->assertTrue($comment->post instanceof Post);
  }

  public function testRecentlyScope() {
    $comment = Comment::model()->recently();
    $this->assertTrue($comment instanceof Comment);
    $comments = $comment->findAll();
    $this->assertTrue(is_array($comments));
    $this->assertTrue($comments[0]->create_time < $comments[1]->create_time);
  }
}
