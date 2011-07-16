<?php

class m110716_072404_add_profile_picture extends CDbMigration {
  public function up() {
    $this->addColumn('tbl_profile', 'profile_picture', 'string');
  }

  public function down() {
    $this->dropColumn('tbl_profile', 'profile_picture');
  }
}
