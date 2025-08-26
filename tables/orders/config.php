<?php
$table = 'orders';
$primary_key = 'order_id';
$fields = [
  'order_id'     => ['type'=>'int','auto_increment'=>true,'primary'=>true],
  'customer_id'  => [
    'type'=>'int','required'=>true,
    'foreign'=>['table'=>'customers','col'=>'customer_id','ref_label'=>'name']
  ],
  'order_date'   => ['type'=>'date','required'=>true],
  'status'       => ['type'=>'enum','required'=>true,'options'=>['pending','paid','shipped','cancelled']],
  'total_amount' => ['type'=>'decimal','required'=>true],
];
$labels = [
  'order_id'     => 'ID',
  'customer_id'  => 'Customer',
  'order_date'   => 'Order Date',
  'status'       => 'Status',
  'total_amount' => 'Total Amount',
];
?>
