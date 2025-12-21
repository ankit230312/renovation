<?php
include '../common/db.php'; // DB connection

$productId  = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
$floorType  = isset($_POST['floor_type']) ? $_POST['floor_type'] : null;
$features   = isset($_POST['features']) ? $_POST['features'] : [];

$whereClauses = ["p.status = 'active'"];

/* Filter by product_id */
if (!empty($productId)) {
    // $whereClauses[] = "p.productID = $productId";
}

/* Filter by floor_type */
if (!empty($floorType)) {
    $subquery = "
        SELECT floor_id 
        FROM floor_type 
        WHERE floor_type = '" . mysqli_real_escape_string($conn, $floorType) . "'
        AND property_id = $productId
        LIMIT 1
    ";

    $subResult = mysqli_query($conn, $subquery);

    if ($row = mysqli_fetch_assoc($subResult)) {
        $propertyTypeId = intval($row['floor_id']);
        // $whereClauses[] = "p.property_type_id = $propertyTypeId";
    }
}

/* Filter by features */
if (!empty($features)) {

    $escaped = array_map(function ($f) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $f) . "'";
    }, $features);

    $featureQuery = "
        SELECT DISTINCT id 
        FROM floor_dimensions
        WHERE room_type IN (" . implode(",", $escaped) . ")
          AND status = 'Active'
    ";

    $featureResult = mysqli_query($conn, $featureQuery);

    $featureIDs = [];
    while ($frow = mysqli_fetch_assoc($featureResult)) {
        $featureIDs[] = "'" . $frow['id'] . "'";
    }

    if (!empty($featureIDs)) {
        // $whereClauses[] = "p.property_feature_id IN (" . implode(",", $featureIDs) . ")";
    }
}

/* Final Query */
$sql = "
    SELECT 
        p.*, 
        o.offer_type, o.offer_value, o.apply_on,
        o.start_date, o.end_date, o.is_active
    FROM products_item p
    LEFT JOIN offer_products op 
        ON op.product_id = p.productID
    LEFT JOIN offers o 
        ON o.offerID = op.offer_id
       AND o.is_active = 'Y'
       AND o.apply_on = 'ITEM'
       AND CURDATE() BETWEEN o.start_date AND o.end_date
    WHERE " . implode(" AND ", $whereClauses) . "
    ORDER BY p.productID DESC
";

$result = mysqli_query($conn, $sql);
?>

<?php if (mysqli_num_rows($result) > 0): ?>

    <div class="row">

        <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <?php
            $productId  = $row['productID'];
            $carouselId = 'carousel_' . $productId;

            $images = array_filter(array_map('trim', explode(',', $row['product_image'])));

            /* Offer Text Logic */
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

            /* Price Calculation */
            $originalPrice = (float)$row['price'];
            $discountPrice = $originalPrice;

            if (!empty($offerText) && preg_match('/(\d+)%/', $offerText, $match)) {
                $discountPercent = (float)$match[1];
                $discountPrice = $originalPrice - ($originalPrice * $discountPercent / 100);
            } elseif (!empty($row['offer_type']) && $row['offer_type'] === 'FIXED') {
                $discountPrice = max(0, $originalPrice - (float)$row['offer_value']);
            }
            ?>

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">

                    <!-- Product Carousel -->
                    <?php if (!empty($images)): ?>
                        <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <?php foreach ($images as $index => $img):
                                    $active = $index === 0 ? 'active' : '';
                                    $imgPath = 'admin/uploads/items/' . htmlspecialchars($img);
                                ?>
                                    <div class="carousel-item <?= $active ?>">
                                        <a href="<?= $imgPath ?>"
                                            data-lightbox="product-gallery-<?= $productId ?>">
                                            <img src="<?= $imgPath ?>"
                                                class="d-block w-100"
                                                style="max-height:300px; object-fit:cover;">
                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <?php if (count($images) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>

                        </div>
                    <?php else: ?>
                        <img src="admin/uploads/items/default.jpg"
                            class="card-img-top"
                            style="max-height:300px; object-fit:cover;">
                    <?php endif; ?>

                    <!-- Card Body -->
                    <div class="card-body">

                        <a href="product_detail.php?proId=<?= $productId ?>"
                            class="fw-bold text-decoration-none">
                            <?= htmlspecialchars($row["product_name"]) ?>
                        </a>

                        <p class="text-muted"><?= htmlspecialchars($row['product_description']) ?></p>

                        <!-- Offer box -->
                        <?php if (!empty($offerText)): ?>
                            <div class="p-2 bg-light rounded mb-2">
                                <h5 class="mb-1">
                                    <span class="badge bg-primary me-2 text-white"><?= htmlspecialchars($offerText) ?></span>
                                    <small><?= htmlspecialchars($offerDesc) ?></small>
                                </h5>
                                <small class="text-muted">
                                    Valid till <?= date('d M Y', strtotime($row['end_date'])) ?>
                                </small>
                            </div>
                        <?php endif; ?>

                        <!-- Price -->
                        <div class="p-2  rounded mb-2">
                            <?php if ($discountPrice < $originalPrice): ?>
                                <p class="fw-bold mb-0">
                                    <span class="text-danger">₹<?= number_format($discountPrice, 2) ?></span>
                                    <del class="text-muted ms-2">₹<?= number_format($originalPrice, 2) ?></del>
                                </p>
                            <?php else: ?>
                                <p class="fw-bold mb-0">₹<?= number_format($originalPrice, 2) ?>/Sqft</p>
                            <?php endif; ?>

                            <button class="btn btn-sm btn-success mt-3 add-to-cart"
                                data-feature="<?= $row['property_type_id'] ?>"
                                data-id="<?= $row['productID'] ?>">
                                Select Product
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        <?php endwhile; ?>

    </div>

<?php else: ?>

    <div class="alert alert-warning">No products found based on selected filters.</div>

<?php endif; ?>