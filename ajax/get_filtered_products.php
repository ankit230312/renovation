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
    $subquery = "SELECT floor_id FROM floor_type 
                 WHERE floor_type = '" . mysqli_real_escape_string($conn, $floorType) . "' 
                 AND property_id = $productId 
                 LIMIT 1";
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

// ✅ Final Query with Offer Joins
$sql = "
    SELECT 
        p.*, 
        o.offer_type, 
        o.offer_value, 
        o.apply_on, 
        o.start_date, 
        o.end_date, 
        o.is_active
    FROM 
        products_item p
    LEFT JOIN 
        offer_products op ON op.product_id = p.productID
    LEFT JOIN 
        offers o ON o.offerID = op.offer_id 
        AND o.is_active = 'Y' 
        AND o.apply_on = 'ITEM'
        AND CURDATE() BETWEEN o.start_date AND o.end_date
    WHERE 
        " . implode(" AND ", $whereClauses) . "
    ORDER BY 
        p.productID DESC
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row">';
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['productID'];
        $carouselId = 'carousel_' . $productId;

        // Handle images
        $images = array_filter(array_map('trim', explode(',', $row['product_image'])));

        // ✅ Build Offer Text dynamically
        $offerText = '';
        $offerDesc = '';
        if (!empty($row['offer_value']) && $row['apply_on'] === 'ITEM') {
            if ($row['offer_type'] === 'PERCENTAGE') {
                $offerText = "{$row['offer_value']}% Off";
                $offerDesc = "Discount on this product";
            } elseif ($row['offer_type'] === 'FIXED') {
                $offerText = "₹{$row['offer_value']} Off";
                $offerDesc = "Instant price reduction";
            } elseif (strpos($row['offer_type'], 'CASHBACK') !== false) {
                $offerText = "₹{$row['offer_value']} Cashback";
                $offerDesc = "Cashback on purchase";
            }
        }

        // ✅ Price Calculation
        $originalPrice = (float)$row['price'];
        $discountPrice = $originalPrice;

        if (!empty($offerText) && preg_match('/(\d+)%/', $offerText, $match)) {
            $discountPercent = (float)$match[1];
            $discountPrice = $originalPrice - ($originalPrice * $discountPercent / 100);
        } elseif (!empty($row['offer_type']) && $row['offer_type'] === 'FIXED') {
            $discountPrice = max(0, $originalPrice - (float)$row['offer_value']);
        }

        // ✅ Start Card
        echo '<div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">';

        // ✅ Product Carousel
        if (!empty($images)) {
            echo '<div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">';
            foreach ($images as $index => $img) {
                $active = $index === 0 ? 'active' : '';
                $imgPath = 'admin/uploads/items/' . htmlspecialchars(trim($img));

                echo '<div class="carousel-item ' . $active . '">
                        <a href="' . $imgPath . '" data-lightbox="product-gallery-' . $productId . '" data-title="Product Image ' . ($index + 1) . '">
                            <img src="' . $imgPath . '" 
                                 class="d-block w-100" 
                                 style="max-height: 300px; object-fit: cover; cursor: zoom-in;" 
                                 alt="Product Image">
                        </a>
                      </div>';
            }
            echo '</div>';

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

        // ✅ Card Body
        echo '<div class="card-body">
                <a href="product_detail.php?proId=' . $productId . '" class="fw-bold text-decoration-none">' . htmlspecialchars($row["product_name"]) . '</a>
                <p class="text-muted">' . htmlspecialchars($row['product_description']) . '</p>';

        // ✅ Offer Display
        if (!empty($offerText)) {
            echo '<div class="p-2 bg-light rounded mb-2">
                    <h5 class="mb-1">
                        <span class="badge bg-primary me-2 text-white">' . htmlspecialchars($offerText) . '</span>
                        <small>' . htmlspecialchars($offerDesc) . '</small>
                    </h5>
                    <small class="text-muted">Valid till ' . date('d M Y', strtotime($row['end_date'])) . '</small>
                  </div>';
        }

        // ✅ Price Display
        if ($discountPrice < $originalPrice) {
            echo '<p class="fw-bold mb-0">
                    <span class="text-danger">₹' . number_format($discountPrice, 2) . '</span> &nbsp;
                    <del class="text-muted">₹' . number_format($originalPrice, 2) . '</del>
                  </p>';
        } else {
            echo '<p class="fw-bold mb-0">Price: ₹' . number_format($originalPrice, 2) . '</p>';
        }

        echo '<button class="btn btn-sm btn-success mt-3 add-to-cart" data-feature="' . $row['property_type_id'] . '" data-id="' . $row['productID'] . '">Select Product</button>';

        echo '</div></div></div>';
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-warning">No products found based on selected filters.</div>';
}
?>
