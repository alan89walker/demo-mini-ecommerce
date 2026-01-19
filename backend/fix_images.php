<?php
include "db.php";

$sql = "SELECT id, image FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $old_image = $row["image"];
        
        // Check if the image path is an absolute Windows path
        if (strpos($old_image, 'C:\\xampp\\htdocs\\demo mini ecommerce\\') !== false) {
            // Replace the absolute path with the relative web path
            $new_image = str_replace('C:\\xampp\\htdocs\\demo mini ecommerce\\', '../', $old_image);
            
            // Fix backslashes to forward slashes for URLs
            $new_image = str_replace('\\', '/', $new_image);
            
            // Update the database
            $update_sql = "UPDATE products SET image = '$new_image' WHERE id = $id";
            if ($conn->query($update_sql) === TRUE) {
                echo "Fixed ID $id: <br>Old: $old_image <br>New: $new_image<br><hr>";
            } else {
                echo "Error updating ID $id: " . $conn->error . "<br>";
            }
        } else {
             echo "ID $id already looks okay or doesn't match the pattern: $old_image<br><hr>";
        }
    }
} else {
    echo "No products found.";
}

echo "<br><strong>Image paths fixed!</strong>";
echo "<br><a href='../frontend/products.html'>Go to Products Page</a>";
?>