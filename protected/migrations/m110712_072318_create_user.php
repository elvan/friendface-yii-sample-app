<?php

class m110712_072318_create_user extends CDbMigration {
  public function up() {
    $this->createTable('tbl_user', array(
      'id' => 'pk',
      'uid' => 'char(8)',
      'email' => 'string NOT NULL',
      'encrypted_password' => 'string',
      'salt' => 'string',
      'last_login_time' => 'integer',
      'create_time' => 'integer',
      'update_time' => 'integer',
    ));
  }

  public function down() {
    $this->dropTable('tbl_user');
  }
}
