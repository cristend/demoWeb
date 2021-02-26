<?php
$users = "CREATE TABLE users(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL UNIQUE,
    pass VARCHAR(128) NOT NULL,
    permission ENUM ('0', '1') DEFAULT '0',
    bio VARCHAR(200),
    sex ENUM ('female','male','other') NOT NULL,
    phone VARCHAR(10),
    birth DATETIME,
    image VARCHAR(200), 
    address VARCHAR(200)
)";
$products = "CREATE TABLE products(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    price VARCHAR(10) NOT NULL,
    variable VARCHAR(256) NOT NULL,
    quantity INT(10) UNSIGNED DEFAULT 0,
    detail TEXT,
    image VARCHAR(256)
)";
$carts = "CREATE TABLE carts(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(10) UNSIGNED UNIQUE NOT NULL
)";
$cart_items = "CREATE TABLE cart_items(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cart_id INT(10) UNSIGNED NOT NULL,
    product_id INT(10) UNSIGNED UNIQUE NOT NULL,
    quantity INT(10) UNSIGNED
)";
$table_list = [
    "users" => $users,
    "products" => $products,
    "carts" => $carts,
    "cart_items" => $cart_items
];
