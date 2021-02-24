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

$table_list = [
    "users" => $users,
];
