<?php

class m110712_072318_User extends CDbMigration {
  public function up() {
    $this->createTable('tbl_user', array(
      'id' => 'pk',
      'uid' => 'char(8)',
      'email' => 'string NOT NULL',
      'encrypted_password' => 'string',
      'salt' => 'string',
      'last_login_time' => 'datetime',
      'create_time' => 'datetime',
      'update_time' => 'datetime',
    ));
  }

  public function down() {
    $this->dropTable('tbl_user');
  }
}
