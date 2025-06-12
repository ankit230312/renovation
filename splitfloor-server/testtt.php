<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u404352962_rapto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination parameters
$limit = 5;
$last_id = isset($_GET['last_id']) ? $_GET['last_id'] : 0;
$first_id = isset($_GET['first_id']) ? $_GET['first_id'] : 0;

// SQL to fetch products based on cursor (last_id)
$sql = "SELECT productID, product_name, added_on FROM products WHERE productID > ? ORDER BY productID LIMIT ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $last_id, $limit);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();

// Include Bootstrap CSS
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

// Display the products
if (count($products) > 0) {
    echo '<div class="container mt-4">';
    echo '<ul class="list-group">';
    foreach ($products as $product) {
        echo "<li class='list-group-item'>" . $product['product_name'] . " - " . $product['added_on'] . "</li>";
    }
    echo '</ul>';

    // If there are more products, show the "Next Page" link
    $lastProduct = end($products);
    $next_id = $lastProduct['productID'];

    echo '<div class="mt-3">';

    // Previous Page Button (if applicable)
    if ($first_id > 0) {
        echo '<a href="?first_id=' . $first_id . '&last_id=' . $products[0]['productID'] . '" class="btn btn-secondary mr-2">Previous Page</a>';
    }

    // Next Page Button
    echo '<a href="?last_id=' . $next_id . '&first_id=' . $products[0]['productID'] . '" class="btn btn-primary">Next Page</a>';
    echo '</div>';
    echo '</div>';
} else {
    echo "<p>No products found.</p>";
}

$conn->close();
?>
