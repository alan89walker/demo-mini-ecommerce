<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS ecommerce_db";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db("ecommerce_db");

// Create table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'active',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table products created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table orders created successfully<br>";
} else {
    echo "Error creating orders table: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS order_items (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT(10) UNSIGNED NOT NULL,
    product_id INT(6) UNSIGNED,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    qty INT(6) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table order_items created successfully<br>";
} else {
    echo "Error creating order_items table: " . $conn->error . "<br>";
}

$conn->close();
?>
