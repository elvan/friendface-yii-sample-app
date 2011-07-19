<?php

class m110719_142517_create_comment extends CDbMigration {
  public function up() {
    $this->createTable('tbl_comment', array(
      'id' => 'pk',
      'content' => 'text',
      'author_id' => 'integer',
      'post_id' => 'integer',
      'create_time' => 'integer',
      'update_time' => 'integer',
    ));
  }

  public function down() {
    $this->dropTable('tbl_comment');
  }
}