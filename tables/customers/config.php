<?php
$table = 'customers';
$primary_key = 'customer_id';
$fields = [
  'customer_id' => ['type'=>'int','auto_increment'=>true,'primary'=>true],
  'name'        => ['type'=>'varchar','required'=>true],
  'email'       => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'phone'       => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'address'     => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'created_at'  => ['type'=>'datetime','auto'=>true],
];
$labels = [
  'customer_id' => 'ID',
  'name'        => 'Customer Name',
  'email'       => 'Email',
  'phone'       => 'Phone',
  'address'     => 'Address',
  'created_at'  => 'Created',
];
?>
