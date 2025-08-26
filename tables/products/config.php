<?php
$table = 'products';
$primary_key = 'product_id';
$fields = [
  'product_id'  => ['type'=>'int','auto_increment'=>true,'primary'=>true],
  'category_id' => [
    'type'=>'int','required'=>true,
    'foreign'=>['table'=>'categories','col'=>'category_id','ref_label'=>'name']
  ],
  'supplier_id' => [
    'type'=>'int','required'=>false,'nullable'=>true,
    'foreign'=>['table'=>'suppliers','col'=>'supplier_id','ref_label'=>'name']
  ],
  'name'        => ['type'=>'varchar','required'=>true],
  'sku'         => ['type'=>'varchar','required'=>false,'nullable'=>true],
  'price'       => ['type'=>'decimal','required'=>true],
  'stock'       => ['type'=>'int','required'=>true],
  'created_at'  => ['type'=>'datetime','auto'=>true],
];
$labels = [
  'product_id'  => 'ID',
  'category_id' => 'Category',
  'supplier_id' => 'Supplier',
  'name'        => 'Product Name',
  'sku'         => 'SKU',
  'price'       => 'Price',
  'stock'       => 'Stock',
  'created_at'  => 'Created',
];
?>
