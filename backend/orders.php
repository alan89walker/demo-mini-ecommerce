<?php
session_start();
include "db.php";
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(["status"=>"error","message"=>"auth"]);
    exit;
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';
$username = $conn->real_escape_string($_SESSION['username']);

if ($role === 'admin') {
    $sql = "SELECT id, username, total, created_at FROM orders ORDER BY id DESC";
} else {
    $sql = "SELECT id, username, total, created_at FROM orders WHERE username='$username' ORDER BY id DESC";
}

$res = $conn->query($sql);
$orders = [];
while($row = $res->fetch_assoc()){
    $oid = intval($row['id']);
    $items = [];
    $ires = $conn->query("SELECT name, price, qty FROM order_items WHERE order_id=$oid");
    while($ir = $ires->fetch_assoc()){
        $items[] = $ir;
    }
    $row['items'] = $items;
    $orders[] = $row;
}

echo json_encode(["status"=>"success","orders"=>$orders,"role"=>$role,"username"=>$_SESSION['username']]);
?>
