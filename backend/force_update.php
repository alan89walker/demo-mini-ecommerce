<?php
include "db.php";

$products = [
    ["name" => "Fresh Milk (1L)", "price" => 60, "image" => "../images/Maplehofe Dairy Skim Milk 1 Gallon - 4_Case.jpg"],
    ["name" => "Whole Wheat Bread", "price" => 45, "image" => "../images/Oroweat® Premium Breads _ Sourdough.jpg"],
    ["name" => "Farm Eggs (12pcs)", "price" => 80, "image" => "../images/Lo huevo que pongo to' lo día 😭.jpg"],
    ["name" => "Red Apples (1kg)", "price" => 150, "image" => "../images/An apple.jpg"],
    ["name" => "Basmati Rice (5kg)", "price" => 650, "image" => "../images/Basmati Rice-500 gr_ x 6.jpg"],
    ["name" => "Potatoes (1kg)", "price" => 30, "image" =>"../images/The Best Potatoes for Potato Salad.jpg"],
    ["name" => "Tomatoes (1kg)", "price" => 40, "image" => "../images/Why is Tomato Considered a Fruit_.jpg"],
    ["name" => "Onions (1kg)", "price" => 35, "image" =>"../images/Magenta Red Onions.jpg"],
    ["name" => "Cooking Oil (1L)", "price" => 140, "image" => "../images/Cooking Oil.jpg"],
    ["name" => "Salt (1kg)", "price" => 20, "image" =>"../images/Redmond Life Real Salt - Fine Salt.jpg"]
];

echo "<h2>Updating Product Images...</h2>";

foreach ($products as $product) {
    $name = $conn->real_escape_string($product['name']);
    $image = $conn->real_escape_string($product['image']);
    $price = $product['price'];
    
    // Force update the image for the matching product name
    $sql = "UPDATE products SET image = '$image' WHERE name = '$name'";
    
    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "Updated image for: <b>$name</b><br>";
        } else {
            echo "No change for: $name (Maybe already correct or not found)<br>";
        }
    } else {
        echo "Error updating $name: " . $conn->error . "<br>";
    }
}

echo "<br><strong>Update Complete!</strong>";
echo "<br><a href='../frontend/products.html'>Go to Products Page</a>";
?>