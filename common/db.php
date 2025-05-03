<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'u404352962_rapto';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Optional: set charset
$conn->set_charset("utf8");

// echo "Connected successfully"; // Uncomment for testing


?>
