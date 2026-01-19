<?php
$conn = new mysqli("localhost","root","","ecommerce_db");
if ($conn->connect_error) {
    die("DB Connection Failed");
}
?>
