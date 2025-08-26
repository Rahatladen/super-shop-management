<?php
$table = 'categories';
$primary_key = 'category_id';
$fields = [
  'category_id' => ['type'=>'int','auto_increment'=>true,'primary'=>true,'hidden'=>false],
  'name'        => ['type'=>'varchar','required'=>true],
  'description' => ['type'=>'text','required'=>false,'nullable'=>true],
  'created_at'  => ['type'=>'datetime','auto'=>true,'hidden'=>false],
];
$labels = [
  'category_id' => 'ID',
  'name'        => 'Category Name',
  'description' => 'Description',
  'created_at'  => 'Created',
];
?>
