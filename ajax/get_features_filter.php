<?php
include '../common/db.php'; // Replace with your actual DB file

if (!empty($_POST['product_id']) && !empty($_POST['floor_type'])) {
    $propertyId = intval($_POST['product_id']);
    $floorType = $_POST['floor_type']; // safe because it's matched in WHERE

    // Get the property_type_id (floor_id) for selected floor_type
    $typeQuery = "SELECT floor_id FROM floor_type WHERE property_id = $propertyId AND floor_type = '" . mysqli_real_escape_string($conn, $floorType) . "' LIMIT 1";
    $typeResult = mysqli_query($conn, $typeQuery);

    if ($typeRow = mysqli_fetch_assoc($typeResult)) {
        $propertyTypeId = $typeRow['floor_id'];

        // Fetch unique room types
        $featureQuery = "SELECT DISTINCT room_type FROM floor_dimensions WHERE property_id = $propertyId AND property_type_id = $propertyTypeId AND room_type IS NOT NULL AND status = 'Active'";
        $featureResult = mysqli_query($conn, $featureQuery);

        if (mysqli_num_rows($featureResult) > 0) {
            while ($row = mysqli_fetch_assoc($featureResult)) {
                $roomType = htmlspecialchars($row['room_type']);
                echo '<div class="form-check pl-4">
                        <input class="form-check-input" type="checkbox" value="' . $roomType . '" id="feature_' . $roomType . '">
                        <label class="form-check-label" for="feature_' . $roomType . '">' . $roomType . '</label>
                      </div>';
            }
        } else {
            echo '<small class="text-muted">No features found for selected type</small>';
        }
    } else {
        echo '<small class="text-danger">Invalid floor type</small>';
    }
} else {
    echo '<small class="text-danger">Missing input data</small>';
}
?>
