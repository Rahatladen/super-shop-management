-- super_shop.sql
-- Create database and 7 tables for Super Shop Management
-- Engine: InnoDB, Charset: utf8mb4

DROP DATABASE IF EXISTS super_shop;
CREATE DATABASE super_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE super_shop;

-- 1) categories
CREATE TABLE categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2) suppliers
CREATE TABLE suppliers (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NULL,
  phone VARCHAR(50) NULL,
  address VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3) products
CREATE TABLE products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  supplier_id INT NULL,
  name VARCHAR(150) NOT NULL,
  sku VARCHAR(100) UNIQUE NULL,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_products_supplier
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4) customers
CREATE TABLE customers (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NULL,
  phone VARCHAR(50) NULL,
  address VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5) orders
CREATE TABLE orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  order_date DATE NOT NULL DEFAULT (CURRENT_DATE),
  status ENUM('pending','paid','shipped','cancelled') NOT NULL DEFAULT 'pending',
  total_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  CONSTRAINT fk_orders_customer
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 6) order_items
CREATE TABLE order_items (
  order_item_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_order_items_order
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_order_items_product
    FOREIGN KEY (product_id) REFERENCES products(product_id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 7) users (staff)
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Optional seed data
INSERT INTO categories (name, description) VALUES
('Beverages','Drinks and juices'),
('Snacks','Chips, biscuits, nuts'),
('Household','Cleaning and household items');

INSERT INTO suppliers (name,email,phone,address) VALUES
('Acme Supplies','acme@example.com','0123456789','Dhaka'),
('Global Foods','foods@example.com','0198765432','Chittagong');

INSERT INTO products (category_id,supplier_id,name,sku,price,stock) VALUES
(1,1,'Mango Juice 1L','MJ-1L',120.00,50),
(2,2,'Potato Chips 100g','PC-100',60.00,100),
(3,1,'Dish Soap 500ml','DS-500',95.00,80);

INSERT INTO customers (name,email,phone,address) VALUES
('Joy','joy@example.com','01700000000','Dhaka'),
('Rahat','rahat@example.com','01800000000','Narayanganj');

INSERT INTO users (username,password_hash,role) VALUES
('admin', '$2y$10$Yp7s8r7IY2v9e7P6hLxjUO1V6a75z2dqQKh1pF8p9gk3T6G9C5c1W', 'admin'); 
-- (Password hash dummy; you can create a new admin via the UI if desired)