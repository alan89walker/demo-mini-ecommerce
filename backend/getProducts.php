<?php
include "db.php";

$data = [];
$result = $conn->query("SELECT * FROM products WHERE status='active'");
while($row = $result->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
?>
