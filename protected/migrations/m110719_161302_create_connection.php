<?php

class m110719_161302_create_connection extends CDbMigration {
  public function up() {
    $this->createTable('tbl_connection', array(
      'id' => 'pk',
      'follower_id' => 'integer',
      'followed_id' => 'integer',
      'create_time' => 'integer',
      'update_time' => 'integer',
    ));
  }

  public function down() {
    $this->dropTable('tbl_connection');
  }
}
