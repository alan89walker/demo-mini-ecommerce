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

foreach ($products as $product) {
    $name = $product['name'];
    $price = $product['price'];
    $image = $product['image'];
    
    // Check if product already exists to avoid duplicates
    $check = $conn->query("SELECT id FROM products WHERE name = '$name'");
    if ($check->num_rows == 0) {
        $sql = "INSERT INTO products (name, price, image, status) VALUES ('$name', '$price', '$image', 'active')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Added: $name - ₹$price<br>";
        } else {
            echo "Error adding $name: " . $conn->error . "<br>";
        }
    } else {
        echo "Skipped: $name (Already exists)<br>";
    }
}

echo "<br><strong>All products processed!</strong>";
echo "<br><a href='../frontend/products.html'>Go to Products Page</a>";
?>