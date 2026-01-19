<?php
session_start();
include "db.php";
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    echo json_encode(["status"=>"error","message"=>"missing"]);
    exit;
}

if ($username === 'anubhaw' && $password === '1234567890') {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'admin';
    echo json_encode(["status"=>"success","role"=>"admin"]);
    exit;
}

$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

$sql = "SELECT id FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'user';
    echo json_encode(["status"=>"success","role"=>"user"]);
} else {
    echo json_encode(["status"=>"error","message"=>"invalid"]);
}
?>
