<?php
// index.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Super Shop Management</title>
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>
  <div class="header">
    <h1>Super Shop Management (PHP + MySQL)</h1>
  </div>
  <div class="nav">
    <div class="container">
      <a href="tables/categories/list.php">Categories</a>
      <a href="tables/suppliers/list.php">Suppliers</a>
      <a href="tables/products/list.php">Products</a>
      <a href="tables/customers/list.php">Customers</a>
      <a href="tables/orders/list.php">Orders</a>
      <a href="tables/order_items/list.php">Order Items</a>
      <a href="tables/users/list.php">Users</a>
    </div>
  </div>
  <div class="container">
    <div class="card">
      <h2>Welcome 👋</h2>
      <p>This is a simple, educational Super Shop Management app with 7 tables and generic CRUD (Create, Read, Update, Delete).</p>
      <ol>
        <li>Import <code>sql/super_shop.sql</code> into MySQL using phpMyAdmin.</li>
        <li>Place this folder inside <code>htdocs</code> and visit <code>http://localhost/super-shop-management/</code>.</li>
      </ol>
      <p>You can start by adding <a href="tables/categories/list.php">Categories</a> and <a href="tables/suppliers/list.php">Suppliers</a>, then create <a href="tables/products/list.php">Products</a>.</p>
    </div>
  </div>
  <div class="footer">
    <p>&copy; <?php echo date('Y'); ?> Super Shop Management</p>
  </div>
</body>
</html>