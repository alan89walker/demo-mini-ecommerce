<?php
session_start();
header('Content-Type: application/json');
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
echo json_encode(["username"=>$username, "role"=>$role]);
?>
