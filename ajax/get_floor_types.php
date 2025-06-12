<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header
header('Content-Type: application/json');

// Check if product_id is passed
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo json_encode([]);
    exit;
}

// Sanitize input
$product_id = intval($_GET['product_id']);

// --- Database connection ---
// Replace these with your actual DB config
$host = 'localhost';        // Usually localhost
$dbname = 'u404352962_rapto';  // Change this to your DB name
$username = 'root';         // Change as needed
$password = '';             // Change as needed

// Create DB connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

// Query to get floor types for the given product
$sql = "SELECT * FROM `floor_type` WHERE status = 'active' and property_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$floors = [];
while ($row = $result->fetch_assoc()) {
    $floors[] = [

        'floor_id' => $row['floor_id'],
        'floor_type' => $row['floor_type']
    ];
    
    
}

// Close connection
$stmt->close();
$conn->close();

// Return as JSON
echo json_encode($floors);
