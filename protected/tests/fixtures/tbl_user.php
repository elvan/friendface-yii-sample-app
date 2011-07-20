<?php

$salt1 = md5(time());
$salt2 = md5(time());
$salt3 = md5(time());
$salt4 = md5(time());

return array(
  'user1'=>array(
    'uid' => '',
    'email' => 'test1@notanaddress.com',
    'encrypted_password' => md5($salt1 . '--' . 'test_1'),
    'salt' => $salt1,
    'last_login_time' => '',
    'create_time' => '',
    'update_time' => '',
  ),

  'user2'=>array(
    'uid' => '',
    'email' => 'test2@notanaddress.com',
    'encrypted_password' => md5($salt2 . '--' . 'test_2'),
    'salt' => $salt2,
    'last_login_time' => '',
    'create_time' => '',
    'update_time' => '',
  ),

  'user3'=>array(
    'uid' => '',
    'email' => 'test3@notanaddress.com',
    'encrypted_password' => md5($salt3 . '--' . 'test_3'),
    'salt' => $salt3,
    'last_login_time' => '',
    'create_time' => '',
    'update_time' => '',
  ),

  'user4'=>array(
    'uid' => '',
    'email' => 'test4@notanaddress.com',
    'encrypted_password' => md5($salt4 . '--' . 'test_4'),
    'salt' => $salt4,
    'last_login_time' => '',
    'create_time' => '',
    'update_time' => '',
  ),
);
