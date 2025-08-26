<?php
$table = 'users';
$primary_key = 'user_id';
$fields = [
  'user_id'       => ['type'=>'int','auto_increment'=>true,'primary'=>true],
  'username'      => ['type'=>'varchar','required'=>true],
  'password_hash' => ['type'=>'varchar','required'=>true,'input'=>'password','hash_password'=>true],
  'role'          => ['type'=>'enum','required'=>true,'options'=>['admin','staff']],
  'created_at'    => ['type'=>'datetime','auto'=>true],
];
$labels = [
  'user_id'       => 'ID',
  'username'      => 'Username',
  'password_hash' => 'Password',
  'role'          => 'Role',
  'created_at'    => 'Created',
];
?>
