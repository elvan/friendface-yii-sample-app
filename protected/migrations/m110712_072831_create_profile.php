<?php

class m110712_072831_create_profile extends CDbMigration {
  public function up() {
    $this->createTable('tbl_profile', array(
      'id' => 'pk',
      'user_id' => 'integer',
      'username' => 'string',
      'first_name' => 'string NOT NULL',
      'last_name' => 'string NOT NULL',
      'home_town' => 'string',
      'current_town' => 'string',
      'date_of_birth' => 'datetime',
      'profile_picture' => 'string',
      'create_time' => 'integer',
      'update_time' => 'integer',
    ));
  }

  public function down() {
    $this->dropTable('tbl_profile');
  }
}
