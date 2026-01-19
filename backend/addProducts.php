<?php
include "db.php";

$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'];

$sql = "INSERT INTO products (name,price,image,status)
VALUES ('$name','$price','$image','active')";

if ($conn->query($sql)) {
    echo "Product Added";
} else {
    echo "Error";
}
?>
