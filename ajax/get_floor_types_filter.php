<?php
include '../common/db.php'; // Use your actual DB connection file C:\xampp\htdocs\splitfloor\ajax\get_floor_types_filter.php

if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    $sql = "SELECT DISTINCT floor_type FROM floor_type WHERE property_id = $productId AND status = 'active'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select Type</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($row['floor_type']) . '">' . htmlspecialchars($row['floor_type']) . '</option>';
        }
    } else {
        echo '<option value="">No Types Found</option>';
    }
} else {
    echo '<option value="">Invalid Request</option>';
}
?>
