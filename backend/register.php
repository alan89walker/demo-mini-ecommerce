<?php
include "db.php";
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    echo json_encode(["status"=>"error","message"=>"missing"]);
    exit;
}

$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

$check = $conn->query("SELECT id FROM users WHERE username='$username'");
if ($check && $check->num_rows > 0) {
    echo json_encode(["status"=>"error","message"=>"exists"]);
    exit;
}

$sql = "INSERT INTO users (username,password,role) VALUES ('$username','$password','user')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","message"=>"db"]);
}
?>
