<?php
session_start();
include "db.php";
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(["status"=>"error","message"=>"auth"]);
    exit;
}

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);
if (!$data || !isset($data["items"]) || !is_array($data["items"]) || count($data["items"]) === 0) {
    echo json_encode(["status"=>"error","message"=>"bad"]);
    exit;
}

$items = $data["items"];
$total = 0;
foreach ($items as $it) {
    $qty = intval($it["qty"] ?? 1);
    $price = floatval($it["price"] ?? 0);
    $total += $qty * $price;
}

$username = $conn->real_escape_string($_SESSION['username']);
$conn->query("INSERT INTO orders (username,total) VALUES ('$username',$total)");
$order_id = $conn->insert_id;

foreach ($items as $it) {
    $pid = isset($it["id"]) ? intval($it["id"]) : "NULL";
    $name = $conn->real_escape_string($it["name"]);
    $price = floatval($it["price"]);
    $qty = intval($it["qty"]);
    $conn->query("INSERT INTO order_items (order_id,product_id,name,price,qty) VALUES ($order_id,$pid,'$name',$price,$qty)");
}

echo json_encode(["status"=>"success","order_id"=>$order_id,"total"=>$total]);
?>
