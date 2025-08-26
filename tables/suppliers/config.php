<?php
$table = 'suppliers';
$primary_key = 'supplier_id';
$fields = [
  'supplier_id' => ['type'=>'int','auto_increment'=>true,'primary'=>true],
  'name'        => ['type'=>'varchar','required'=>true],
  'email'       => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'phone'       => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'address'     => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'created_at'  => ['type'=>'datetime','auto'=>true],
];
$labels = [
  'supplier_id' => 'ID',
  'name'        => 'Supplier Name',
  'email'       => 'Email',
  'phone'       => 'Phone',
  'address'     => 'Address',
  'created_at'  => 'Created',
];
?>
