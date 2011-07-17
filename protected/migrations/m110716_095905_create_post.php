<?php

class m110716_095905_create_post extends CDbMigration {
  public function up() {
    $this->createTable('tbl_post', array(
      'id' => 'pk',
      'content' => 'text',
      'author_id' => 'integer',
      'recipient_id' => 'integer',
      'create_time' => 'integer',
      'update_time' => 'integer',
    ));
  }

  public function down() {
    $this->dropTable('tbl_post');
  }
}
