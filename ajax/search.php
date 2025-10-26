<?php
// DB connection variables
$host = 'localhost';
$dbname = 'u404352962_rapto';
$username = 'root';
$password = '';

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);

    // Get products
    $sql = "
        SELECT productID, product_name, product_description, product_image, 'Society' AS source
        FROM products
           WHERE status = 'active' and product_name LIKE '%$q%' 
           OR product_description LIKE '%$q%' 
           OR tags LIKE '%$q%'
    ";

    $result = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $productID = $row['productID'];

        // Fetch related floor types for each product
        $floorSql = "
            SELECT floor_id, floor_type, type_image, status 
            FROM floor_type 
            WHERE property_id = $productID and status = 'active'
        ";
        $floorResult = mysqli_query($conn, $floorSql);

        $floors = [];
        while ($f = mysqli_fetch_assoc($floorResult)) {
            $floors[] = $f;
        }

        $row['floors'] = $floors; // attach floors to product
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
