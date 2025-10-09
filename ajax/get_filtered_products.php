<?php
include '../common/db.php'; // DB connection

$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
$floorType = isset($_POST['floor_type']) ? $_POST['floor_type'] : null;
$features = isset($_POST['features']) ? $_POST['features'] : [];

$whereClauses = ["p.status = 'active'"];

// Filter by product_id
if (!empty($productId)) {
    $whereClauses[] = "p.productID = $productId";
}

// Filter by floor_type
if (!empty($floorType)) {
    $subquery = "SELECT floor_id FROM floor_type WHERE floor_type = '" . mysqli_real_escape_string($conn, $floorType) . "' AND property_id = $productId LIMIT 1";
    $subResult = mysqli_query($conn, $subquery);
    if ($row = mysqli_fetch_assoc($subResult)) {
        $propertyTypeId = intval($row['floor_id']);
        $whereClauses[] = "p.property_type_id = $propertyTypeId";
    }
}

// Filter by features (room_type)
if (!empty($features)) {
    $escaped = array_map(function ($f) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $f) . "'";
    }, $features);
    $featureQuery = "SELECT DISTINCT id FROM floor_dimensions 
                     WHERE room_type IN (" . implode(",", $escaped) . ") 
                     AND status = 'Active'";
    $featureResult = mysqli_query($conn, $featureQuery);

    $featureIDs = [];
    while ($frow = mysqli_fetch_assoc($featureResult)) {
        $featureIDs[] = "'" . $frow['id'] . "'";
    }

    if (!empty($featureIDs)) {
        $whereClauses[] = "p.property_feature_id IN (" . implode(",", $featureIDs) . ")";
    }
}

// Final product query
$sql = "SELECT * FROM products_item p WHERE " . implode(" AND ", $whereClauses) . " ORDER BY p.productID Desc";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row">';
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['productID'];
        $carouselId = 'carousel_' . $productId;

        // Get comma-separated image names and convert to array
        $images = array_filter(array_map('trim', explode(',', $row['product_image'])));

        echo '<div class="col-md-4 mb-3">
            <div class="card h-100">';

        if (!empty($images)) {
            echo '<div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">';
            foreach ($images as $index => $img) {
                $active = $index === 0 ? 'active' : '';
                $imgPath = 'admin/uploads/items/' . htmlspecialchars(trim($img));

                echo '<div class="carousel-item ' . $active . '">
            <a href="' . $imgPath . '" data-lightbox="product-gallery'.$productId.' " data-title="Product Image ' . ($index + 1) . '">
                <img src="' . $imgPath . '" 
                     class="d-block w-100" 
                     style="max-height: 300px; object-fit: cover; cursor: zoom-in;" 
                     alt="Product Image">
            </a>
          </div>';
            }
            echo '</div>';

            // Show controls only if more than one image
            if (count($images) > 1) {
                echo '<button class="carousel-control-prev" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>';
            }

            echo '</div>';
        } else {
            echo '<img src="admin/uploads/items/default.jpg" class="card-img-top" style="max-height: 300px; object-fit: cover;" alt="No Image">';
        }

        echo '<div class="card-body">
                <a href="product_detail.php?proId=' . $productId . '">' . htmlspecialchars($row["product_name"]) . '</a>
                <p class="card-text">' . htmlspecialchars($row['product_description']) . '</p>
                <p><strong>Price:</strong> ₹' . number_format($row['price'], 2) . '</p>

         <button class="btn btn-sm btn-success mt-2 add-to-cart" data-feature = "' . $row['property_type_id'] . '" data-id="' . $row['productID'] . '">Select Product</button>


              </div>
            </div>
        </div>';
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-warning">No products found based on selected filters.</div>';
}
