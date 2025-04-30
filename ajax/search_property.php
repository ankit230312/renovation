<?php
// DB connection variables
$host = 'localhost';        // Usually localhost
$dbname = 'u404352962_rapto';  // Change this to your DB name
$username = 'root';         // Change as needed
$password = '';             // Change as needed

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search term from the GET request
$term = isset($_GET['term']) ? $_GET['term'] : '';

// Prepare and execute query
$stmt = $conn->prepare("SELECT product_name FROM products WHERE product_name LIKE ? LIMIT 10");
$like_term = '%' . $term . '%';
$stmt->bind_param("s", $like_term);
$stmt->execute();

$result = $stmt->get_result();

// Fetch results
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row['product_name'];
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$stmt->close();
$conn->close();
?>
