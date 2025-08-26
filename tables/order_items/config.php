<?php
$table = 'order_items';
$primary_key = 'order_item_id';
$fields = [
  'order_item_id' => ['type'=>'int','auto_increment'=>true,'primary'=>true],
  'order_id'      => [
    'type'=>'int','required'=>true,
    'foreign'=>['table'=>'orders','col'=>'order_id','ref_label'=>'order_id']
  ],
  'product_id'    => [
    'type'=>'int','required'=>true,
    'foreign'=>['table'=>'products','col'=>'product_id','ref_label'=>'name']
  ],
  'quantity'      => ['type'=>'int','required'=>true],
  'unit_price'    => ['type'=>'decimal','required'=>true],
];
$labels = [
  'order_item_id' => 'ID',
  'order_id'      => 'Order',
  'product_id'    => 'Product',
  'quantity'      => 'Qty',
  'unit_price'    => 'Unit Price',
];
?>
