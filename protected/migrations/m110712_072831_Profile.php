<?php

class m110712_072831_Profile extends CDbMigration {
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
      'create_time' => 'datetime',
      'update_time' => 'datetime',
    ));
  }

  public function down() {
    $this->dropTable('tbl_profile');
  }
}
