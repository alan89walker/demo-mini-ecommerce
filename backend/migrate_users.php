<?php
include "db.php";

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

function col_exists($conn, $col) {
    $col = $conn->real_escape_string($col);
    $sql = "SELECT COUNT(*) AS c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = '$col'";
    $res = $conn->query($sql);
    if (!$res) return false;
    $row = $res->fetch_assoc();
    return intval($row["c"]) > 0;
}

if (!col_exists($conn, "username")) {
    $conn->query("ALTER TABLE users ADD COLUMN username VARCHAR(100) UNIQUE");
}
if (!col_exists($conn, "role")) {
    $conn->query("ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user'");
}

echo "ok";
?>
