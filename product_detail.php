<?php
/**
 * Product Detail Page
 * Displays detailed product information with accessories selection
 */

include 'common/header.php';

// ========================
// DATA LAYER / VALIDATION
// ========================

/**
 * Get Product Data
 */
function getProductData($productId, $connection)
{
	$productId = (int) $productId;

	if ($productId <= 0) {
		return ['success' => false, 'error' => 'Invalid product ID'];
	}

	$query = "SELECT * FROM products_item WHERE status = 'active' AND productID = $productId LIMIT 1";
	$result = mysqli_query($connection, $query);

	if (!$result || mysqli_num_rows($result) === 0) {
		return ['success' => false, 'error' => 'Product not found'];
	}

	return ['success' => true, 'data' => mysqli_fetch_assoc($result)];
}

/**
 * Parse Product Images
 */
function parseProductImages($imageString)
{
	if (empty($imageString)) {
		return [];
	}

	$images = array_map('trim', explode(',', $imageString));
	return array_filter($images);
}

/**
 * Get Product Accessories
 */
function getProductAccessories($productId, $hasAccessories, $connection)
{
	$productId = (int) $productId;
	$accessories = [];

	if (empty($hasAccessories) || $hasAccessories != 1) {
		return $accessories;
	}

	$query = "
		SELECT a.*, a.accessoryID as acc_id
		FROM product_accessories pa
		INNER JOIN accessories a ON a.accessoryID = pa.accessoryID
		WHERE pa.productID = $productId
		AND pa.status = 'active'
		AND a.status = 'active'
		ORDER BY a.accessory_name ASC
	";

	$result = mysqli_query($connection, $query);

	if ($result && mysqli_num_rows($result) > 0) {
		$accessories = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}

	return $accessories;
}

// ========================
// MAIN EXECUTION
// ========================

$proId = isset($_GET['proId']) ? $_GET['proId'] : null;
$productResult = getProductData($proId, $conn);

// Handle product not found
if (!$productResult['success']) {
	echo "<div class='container mt-5'><div class='alert alert-danger'>{$productResult['error']}</div></div>";
	include 'common/footer.php';
	exit;
}

// Extract product data
$itemsData = $productResult['data'];
$proId = (int) $itemsData['productID'];

// Get product images and accessories
$productImages = parseProductImages($itemsData['product_image']);
$accessories = getProductAccessories($proId, $itemsData['isAccessory'], $conn);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.min.css">

<style>
	/* ========== BASE STYLES ========== */
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		background-color: #f5f5f5;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
	}

	.course {
		background-color: #f5f5f5;
		padding: 40px 0;
		min-height: 100vh;
	}

	.container {

		margin: 0 auto;
		padding: 0 15px;
	}

	/* ========== RESPONSIVE PRODUCT LAYOUT ========== */

	/* DESKTOP VIEW (≥992px) */
	@media (min-width: 992px) {
		.course_title {
			font-size: 36px;
			font-weight: 800;
			margin-bottom: 30px;
		}

		.action-button {
			font-size: 16px;
			padding: 16px 40px;
		}

		.col-md-4 {
			position: sticky;
			top: 100px;
		}
	}

	/* TABLET VIEW (768px - 991px) */
	@media (min-width: 768px) and (max-width: 991px) {
		.course_title {
			font-size: 28px;
			font-weight: 700;
			margin-bottom: 25px;
		}

		.action-button {
			font-size: 15px;
			padding: 14px 30px;
		}

		.accessory-card {
			border-radius: 8px;
		}
	}

	/* MOBILE VIEW (<768px) */
	@media (max-width: 767px) {
		.course {
			padding: 20px 0;
		}

		.course_title {
			font-size: 24px;
			font-weight: 700;
			margin-bottom: 20px;
		}

		.action-button {
			font-size: 15px;
			padding: 14px 20px;
			width: 100%;
			margin-top: 20px;
		}

		.row.g-3 {
			gap: 1rem !important;
		}

		.col-md-6 {
			flex: 0 0 100%;
		}

		.price-section {
			margin-top: 20px;
		}

		.accordion-body {
			padding: 1rem;
		}
	}

	/* ========== COMPONENT STYLES ========== */

	/* Image Carousel */
	.accordion-flush .accordion-item {
		border-radius: 10px;
	}

	.course_image {
		background: white;
		border-radius: 12px;
		overflow: hidden;
		box-shadow: 0 6px 24px rgba(1, 78, 121, 0.12);
		margin-bottom: 20px;
		border: 1px solid #e8f0f7;
	}

	.course_image img {
		width: 100%;
		height: auto;
		display: block;
		min-height: 400px;
		max-height: 500px;
		object-fit: contain;
		background: linear-gradient(135deg, #f9f9f9 0%, #f0f0f0 100%);
	}

	.carousel-control-prev,
	.carousel-control-next {
		width: 50px;
		height: 50px;
		background: rgba(1, 78, 121, 0.8);
		border-radius: 50%;
		top: 50%;
		transform: translateY(-50%);
		border: none;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	}

	.carousel-control-prev:hover,
	.carousel-control-next:hover {
		background: rgba(1, 78, 121, 1);
		transform: translateY(-50%) scale(1.1);
	}

	/* Title */
	.course_title {
		color: #014e79;
		line-height: 1.4;
		word-break: break-word;
		margin-bottom: 20px;
	}

	/* Tabs/Panel */
	.tab_panel {
		width: 100%;
		animation: fadeEffect 0.5s ease;
		border: 1px solid #e0e0e0;
		padding: 20px;
		border-radius: 8px;
		background: white;
		margin-bottom: 20px;
	}

	.tab_panel ul {
		list-style: disc;
		margin-left: 20px;
	}

	.tab_panel h2,
	.tab_panel h3,
	.tab_panel h4 {
		color: #014e79;
		margin-bottom: 15px;
		margin-top: 15px;
	}

	/* Accessories Grid */
	.accessory-grid {
		display: grid;
		margin-bottom: 30px;
	}

	/* Accessory Card */
	.accessory-card {
		background: #ffffff;
		border-radius: 12px;
		overflow: hidden;
		border: 2px solid #e8f0f7;
		box-shadow: 0 2px 12px rgba(1, 78, 121, 0.08);
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		cursor: pointer;
		height: 100%;
		display: flex;
		flex-direction: column;
	}

	.accessory-card:hover {
		transform: translateY(-8px);
		box-shadow: 0 12px 24px rgba(1, 78, 121, 0.15);
		border-color: #014e79;
	}

	.accessory-card.selected {
		border-color: #014e79;
		background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
		box-shadow: 0 8px 20px rgba(1, 78, 121, 0.2);
	}

	.accessory-image {
		width: 100%;
		height: 200px;
		overflow: hidden;
		background: linear-gradient(135deg, #f9f9f9 0%, #f0f0f0 100%);
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.accessory-image img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
		transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
	}

	.accessory-card:hover .accessory-image img {
		transform: scale(1.08);
	}

	.accessory-body {
		padding: 16px;
		flex-grow: 1;
		display: flex;
		flex-direction: column;
	}

	.accessory-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
		margin-bottom: 10px;
	}

	.accessory-header a {
		flex: 1;
		font-size: 15px;
		font-weight: 700;
		color: #014e79;
		text-decoration: none;
		word-break: break-word;
		transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		line-height: 1.3;
	}

	.accessory-header a:hover {
		color: #016ba6;
	}

	.accessory-header h4 {
		margin: 0;
		font-size: 13px;
		font-weight: 600;
		color: #555;
	}

	.accessory-header input[type="checkbox"] {
		width: 24px;
		height: 24px;
		cursor: pointer;
		flex-shrink: 0;
		accent-color: #014e79;
		transition: all 0.2s ease;
	}

	.accessory-header input[type="checkbox"]:checked {
		transform: scale(1.1);
	}

	.price-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding-top: 12px;
		border-top: 1px solid #e8f0f7;
		margin-top: auto;
		margin-left: 10px;
		margin-right: 10px;
	}

	.price-row h4 {
		margin: 0;
		font-size: 12px;
		font-weight: 700;
		color: #666;
		text-transform: uppercase;
		letter-spacing: 0.3px;
	}

	.price-row .price {
		font-size: 16px;
		font-weight: 800;
		color: #014e79;
	}

	/* Calculation Section */
	.calculation-section {
		background: linear-gradient(135deg, #f0f7ff 0%, #e8f3ff 100%);
		border: 2px solid #014e79;
		border-radius: 8px;
		padding: 20px;
		margin-bottom: 15px;
	}

	.calculation-section h4 {
		color: #014e79;
		font-size: 16px;
		font-weight: 700;
		margin-bottom: 15px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.calc-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
		border-bottom: 1px solid #d0e8f2;
		font-size: 14px;
		color: #333;
	}

	.calc-row:last-child {
		border-bottom: none;
		padding-top: 12px;
		padding-bottom: 0;
		font-weight: 700;
		font-size: 16px;
		color: #014e79;
		margin-top: 8px;
		border-top: 2px solid #014e79;
	}

	.calc-row .label {
		display: flex;
		align-items: center;
		gap: 8px;
		font-weight: 600;
		color: #014e79;
	}

	.calc-row .value {
		font-weight: 700;
		color: #016ba6;
		font-size: 14px;
	}

	.calc-row:last-child .value {
		color: #014e79;
		font-size: 18px;
	}

	/* Action Button */
	.action-button {
		display: block;
		background: linear-gradient(135deg, #014e79 0%, #016ba6 100%);
		color: white;
		border: none;
		border-radius: 8px;
		font-weight: 800;
		font-size: 16px;
		cursor: pointer;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		box-shadow: 0 6px 20px rgba(1, 78, 121, 0.3);
		text-decoration: none;
		width: 100%;
		text-align: center;
		letter-spacing: 0.5px;
		text-transform: uppercase;
	}

	.action-button:hover {
		transform: translateY(-4px);
		box-shadow: 0 12px 28px rgba(1, 78, 121, 0.4);
		background: linear-gradient(135deg, #016ba6 0%, #014e79 100%);
		color: white;
		text-decoration: none;
	}

	.action-button:active {
		transform: translateY(-2px);
	}

	/* Description Section */
	/* ========== DESCRIPTION SECTION ========== */
	.description-section {
		background: white;
		border-radius: 8px;
		padding: 0;
		margin: 18px 0;
		border: none;
	}

	.description-section h2,
	.description-section h3 {
		color: #014e79;
		margin-top: 15px;
		margin-bottom: 10px;
		font-weight: 700;
	}

	.description-section p {
		color: #555;
		line-height: 1.8;
		margin-bottom: 12px;
		font-size: 15px;
	}

	.description-section ul,
	.description-section ol {
		margin: 12px 0 12px 20px;
		color: #555;
		line-height: 1.8;
	}

	.description-section li {
		margin-bottom: 8px;
	}

	/* Animations */
	@keyframes fadeEffect {
		from {
			opacity: 0;
			transform: translateY(10px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	/* ========== ACCORDION STYLES ========== */
	.accordion-flush {
		margin-bottom: 0;
	}

	.accordion-item {
		border: 2px solid #e8f0f7;
		border-radius: 10px;
		margin-bottom: 20px;
		overflow: hidden;
		box-shadow: 0 2px 12px rgba(1, 78, 121, 0.08);
		background: white;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	}

	.accordion-item:hover {
		box-shadow: 0 4px 20px rgba(1, 78, 121, 0.12);
		border-color: #014e79;
	}

	.accordion-button {
		color: #014e79;
		font-weight: 800;
		font-size: 16px;
		padding: 18px 24px;
		background-color: #ffffff;
		border: none;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		text-transform: uppercase;
		letter-spacing: 0.5px;
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.accordion-button::after {
		transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	}

	.accordion-button:not(.collapsed) {
		background: linear-gradient(135deg, #f0f7ff 0%, #e8f3ff 100%);
		color: #014e79;
		box-shadow: inset 0 -2px 0 rgba(1, 78, 121, 0.15);
	}

	.accordion-button:hover {
		background: linear-gradient(135deg, #e8f3ff 0%, #dfeeff 100%);
	}

	.accordion-button:focus {
		border-color: #014e79;
		box-shadow: 0 0 0 0.25rem rgba(1, 78, 121, 0.25);
	}

	.accordion-body {
		padding: 24px;
		background-color: #ffffff;
		border-top: 1px solid #e8f0f7;
	}

	/* ========== PRICING SECTION ========== */
	.price-section {
		background: linear-gradient(135deg, #f0f7ff 0%, #e8f3ff 100%);
		border: 2px solid #014e79;
		border-radius: 12px;
		padding: 24px;
		margin-top: 30px;
		box-shadow: 0 4px 16px rgba(1, 78, 121, 0.1);
	}

	.price-section h4 {
		color: #014e79;
		font-size: 18px;
		font-weight: 800;
		margin-bottom: 20px;
		text-transform: uppercase;
		letter-spacing: 0.8px;
	}

	.price-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 12px 0;
		border-bottom: 1px solid #d0e8f2;
		font-size: 15px;
	}

	.price-item:last-child {
		border-bottom: none;
	}

	.price-item.total {
		padding: 16px 0;
		padding-top: 16px;
		font-weight: 800;
		font-size: 18px;
		color: #014e79;
		border-top: 2px solid #014e79;
		margin-top: 12px;
		background: rgba(1, 78, 121, 0.05);
		padding-left: 12px;
		padding-right: 12px;
		margin-left: -12px;
		margin-right: -12px;
		border-radius: 4px;
	}

	.price-label {
		font-weight: 600;
		color: #555;
	}

	.price-value {
		font-weight: 700;
		color: #014e79;
		font-size: 16px;
	}

	.price-item.total .price-value {
		color: #014e79;
		font-size: 20px;
	}

	/* ========== SECTION HEADERS ========== */
	.section-header {
		display: flex;
		align-items: center;
		gap: 12px;
		margin-bottom: 25px;
		font-size: 18px;
		font-weight: 800;
		color: #014e79;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.section-header::before {
		content: '';
		width: 4px;
		height: 24px;
		background: linear-gradient(135deg, #014e79 0%, #016ba6 100%);
		border-radius: 2px;
	}

	/* ========== BUTTON IN PRICING ========== */
	.action-button-wrapper {
		margin-top: 24px;
	}

	/* ========== ROW LAYOUT STYLES ========== */
	.product-row {
		background: white;
		border-radius: 12px;
		padding: 30px;
		margin-bottom: 30px;
		box-shadow: 0 4px 16px rgba(1, 78, 121, 0.08);
		border: 1px solid #e8f0f7;
	}

	.product-row.row-first {
		order: 1;
	}

	.product-row.row-accessories {
		order: 2;
	}

	.product-row.row-price {
		order: 3;
	}

	@media (max-width: 767px) {
		.product-row {
			padding: 20px;
			margin-bottom: 20px;
		}

		.product-row.row-price {
			order: 3;
		}
	}

	/* ========== PRICE SECTION IN ROW 1 ========== */
	.price-section-desktop {
		display: none;
	}

	@media (min-width: 992px) {
		.price-section-desktop {
			display: block;
		}

		.price-section-desktop .price-section {
			margin-top: 0;
		}
	}

	/* ========== SLIDER STYLES ========== */
	.accessory-slider-wrapper {
		position: relative;
	}

	.slider-controls {
		display: flex;
		gap: 12px;
		margin-bottom: 20px;
		align-items: center;
	}

	.slider-control-btn {
		width: 48px;
		height: 48px;
		border-radius: 50%;
		background: linear-gradient(135deg, #014e79 0%, #016ba6 100%);
		border: none;
		color: white;
		font-size: 20px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		box-shadow: 0 4px 12px rgba(1, 78, 121, 0.2);
	}

	.slider-control-btn:hover {
		transform: scale(1.1);
		box-shadow: 0 6px 16px rgba(1, 78, 121, 0.3);
	}

	.slider-control-btn:disabled {
		opacity: 0.4;
		cursor: not-allowed;
		transform: none;
	}

	.slider-control-btn:disabled:hover {
		box-shadow: 0 4px 12px rgba(1, 78, 121, 0.2);
	}

	.accessory-slider {
		overflow-x: auto;
		scroll-behavior: smooth;
		-webkit-overflow-scrolling: touch;
		margin: 20px 0;

	}

	.accessory-slider::-webkit-scrollbar {
		height: 8px;
	}

	.accessory-slider::-webkit-scrollbar-track {
		background: #f0f0f0;
		border-radius: 10px;
	}

	.accessory-slider::-webkit-scrollbar-thumb {
		background: #014e79;
		border-radius: 10px;
	}

	.accessory-slider::-webkit-scrollbar-thumb:hover {
		background: #016ba6;
	}

	.slider-items {
		display: flex;
		gap: 20px;
		min-width: min-content;
	}

	.slider-item {
		flex: 0 0 calc(33.333% - 14px);
		max-width: 280px;
		margin-bottom: 25px;
	}

	@media (max-width: 1024px) {
		.slider-item {
			flex: 0 0 calc(50% - 10px);
			max-width: 250px;
		}
	}

	@media (max-width: 767px) {
		.slider-item {
			flex: 0 0 calc(80% - 4px);
			max-width: 200px;
		}
	}
</style>

<!-- ========== HTML STRUCTURE ========== -->

<div class="course">
	<div class="container mt-5">
		<div style="display: flex; flex-direction: column;">

			<!-- ========== ROW 1: PRODUCT IMAGES + PRODUCT DESCRIPTION + PRICE (DESKTOP) ========== -->
			<div class="product-row row-first">
				<div class="row">
					<div class="col-md-12">
						<div style="margin-bottom: 25px;">
							<h1 class="course_title">
								<?= htmlspecialchars($itemsData['product_name']) ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- Product Images -->
					<div class="col-lg-4">


						<?php if (!empty($productImages)): ?>
							<div class="course_image">
								<div id="courseImageCarousel" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-inner">
										<?php foreach ($productImages as $index => $img): ?>
											<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
												<a href="admin/uploads/items/<?= htmlspecialchars($img) ?>"
													data-lightbox="product-gallery"
													data-title="<?= htmlspecialchars($itemsData['product_name']) ?>">
													<img src="admin/uploads/items/<?= htmlspecialchars($img) ?>"
														onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;400&quot; height=&quot;400&quot;><rect fill=&quot;%23ddd&quot; width=&quot;400&quot; height=&quot;400&quot;/><text x=&quot;50%&quot; y=&quot;50%&quot; dominant-baseline=&quot;middle&quot; text-anchor=&quot;middle&quot; font-family=&quot;Arial&quot; font-size=&quot;16&quot; fill=&quot;%23999&quot;>Product Image</text></svg>'"
														alt="Product Image <?= $index + 1 ?>">
												</a>
											</div>
										<?php endforeach; ?>
									</div>

									<?php if (count($productImages) > 1): ?>
										<button class="carousel-control-prev" type="button"
											data-bs-target="#courseImageCarousel" data-bs-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="visually-hidden">Previous</span>
										</button>
										<button class="carousel-control-next" type="button"
											data-bs-target="#courseImageCarousel" data-bs-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="visually-hidden">Next</span>
										</button>
									<?php endif; ?>
								</div>
							</div>
						<?php else: ?>
							<div class="product-row row-accessories">
								<div style="margin-bottom: 20px;">
									<h2 class="section-header">✨ Accessories</h2>
								</div>
								<div class="alert alert-info">No accessories available for this product.</div>
							</div>
						<?php endif; ?>

						<div class="price-item">

							
							<div class="action-button-wrapper">
								<button class="action-button" onclick="proceedToPayment(<?= $proId ?>)">
									💳 Proceed to Payment
								</button>
							</div>
						</div>
					</div>

					<!-- Right Column: Description (Mobile) + Price (Desktop) -->
					<div class="col-lg-8">
						<!-- Product Description (Mobile/Tablet/Desktop) -->
						<div class="product-description-section">
							<!-- Product Title -->


							<!-- Product Description -->
							<?php if (!empty($itemsData['long_desc'])): ?>
								<div class="description-section">
									<?= html_entity_decode($itemsData['long_desc']) ?>
								</div>
							<?php endif; ?>


					<div class="price-item">

						<span class="price-value">₹ <span id="productPrice"><?= number_format($itemsData['price'], 2) ?></span> / Sqft</span>
					</div>

					<!-- Price summary (accessories total + final total) -->
					<div class="price-section" style="margin-top:12px;">
						<div class="price-item" style="display:flex; justify-content:space-between;">
							<div class="price-label">Accessories</div>
							<div class="price-value">₹ <span id="accessoriesTotal">0.00</span></div>
						</div>
						<div class="price-item total" style="display:flex; justify-content:space-between; margin-top:8px;">
							<div class="price-label">Total</div>
							<div class="price-value">₹ <span id="totalPrice"><?= number_format($itemsData['price'], 2) ?></span></div>
						</div>
					</div>
						</div>

						

								<!-- ========== ROW 2: ACCESSORIES SLIDER ========== -->
			<?php if (!empty($accessories)): ?>
				<div class="product-row row-accessories">
					<div style="margin-bottom: 20px;">
						<h2 class="section-header">✨ Available Accessories</h2>
					</div>

					<div class="accessory-slider-wrapper">
						<!-- Slider Controls -->
						<div class="slider-controls">
							<button class="slider-control-btn" id="sliderPrevBtn" onclick="slideLeft()" title="Scroll Left">
								❮
							</button>
							<span style="color: #666; font-weight: 600;">Swipe or use arrows to browse</span>
							<button class="slider-control-btn" id="sliderNextBtn" onclick="slideRight()"
								title="Scroll Right">
								❯
							</button>
						</div>

						<!-- Slider Container -->
						<div class="accessory-slider" id="accessorySlider">
							<div class="slider-items">
								<?php foreach ($accessories as $acc): ?>
									<div class="slider-item">
										<div class="accessory-card selected">
											<div class="accessory-image">
												<img src="admin/uploads/accessories/<?= htmlspecialchars($acc['product_image']) ?>"
													
													alt="<?= htmlspecialchars($acc['accessory_name']) ?>">
											</div>

											<div class="accessory-body">
												<div class="accessory-header">
													<a href="accessory_detail.php?proId=<?= (int) $acc['acc_id'] ?>">
														<?= htmlspecialchars($acc['accessory_name']) ?>
													</a>
													<input type="checkbox" name="accessories[]"
														value="<?= (int) $acc['accessoryID'] ?>" checked="checked"
														onchange="updateSelection()">
												</div>
											</div>

											<div class="price-row">
												<h4>Price</h4>
												<div class="price">₹<?= number_format((float) $acc['price'], 0) ?></div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
					</div>
				</div>
			</div>

	



		</div>
	</div>
</div>

<?php include 'common/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/js/jquery.magnify.min.js"></script>

<script>
	/**
	 * Slider Navigation Functions
	 */
	function slideLeft() {
		const slider = document.getElementById('accessorySlider');
		const scrollAmount = 320;
		slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
		updateSliderButtons();
	}

	function slideRight() {
		const slider = document.getElementById('accessorySlider');
		const scrollAmount = 320;
		slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
		updateSliderButtons();
	}

	function updateSliderButtons() {
		const slider = document.getElementById('accessorySlider');
		const prevBtn = document.getElementById('sliderPrevBtn');
		const nextBtn = document.getElementById('sliderNextBtn');

		if (!slider) return;

		// Disable/enable previous button
		prevBtn.disabled = slider.scrollLeft <= 0;

		// Disable/enable next button
		const maxScroll = slider.scrollWidth - slider.clientWidth;
		nextBtn.disabled = slider.scrollLeft >= maxScroll - 10;
	}

	/**
	 * Update accessory selection styling
	 */
	function updateSelection() {
		document.querySelectorAll('.accessory-card').forEach(card => {
			const checkbox = card.querySelector('input[type="checkbox"]');
			card.classList.toggle('selected', checkbox.checked);
		});
		calculateTotalPrice();
	}

	/**
	 * Calculate and update total price
	 */
	function calculateTotalPrice() {
		const productPrice = parseFloat(
			document.getElementById('productPrice').textContent.replace(/,/g, '')
		);
		let accessoriesTotal = 0;

		// Sum prices of selected accessories
		document.querySelectorAll('.accessory-card.selected').forEach(card => {
			const priceElement = card.querySelector('.price');
			if (priceElement) {
				const price = parseFloat(
					priceElement.textContent.replace(/₹|,/g, '').trim()
				);
				if (!isNaN(price)) {
					accessoriesTotal += price;
				}
			}
		});

		// Update display in both sections
		const totalPrice = productPrice + accessoriesTotal;

		// Update Desktop version
		document.getElementById('accessoriesTotal').textContent = accessoriesTotal.toFixed(2);
		document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);

		// Update Mobile version
		const accessoriesTotalMobile = document.getElementById('accessoriesTotal2');
		const totalPriceMobile = document.getElementById('totalPrice2');
		if (accessoriesTotalMobile) accessoriesTotalMobile.textContent = accessoriesTotal.toFixed(2);
		if (totalPriceMobile) totalPriceMobile.textContent = totalPrice.toFixed(2);
	}

	/**
	 * Toggle checkbox on card click
	 */
	$(document).on('click', '.accessory-card', function (e) {
		if ($(e.target).is('input') || $(e.target).is('a')) return;

		let checkbox = $(this).find('input[type="checkbox"]');
		checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
		updateSelection();
	});

	/**
	 * Handle checkbox change
	 */
	$(document).on('change', '.accessory-header input[type="checkbox"]', function () {
		updateSelection();
	});

	/**
	 * Slider scroll event listener
	 */
	$(document).on('scroll', function () {
		updateSliderButtons();
	});

	/**
	 * Proceed to payment with selected accessories
	 */
	function proceedToPayment(proId) {
		const selectedAccessories = Array.from(
			document.querySelectorAll('input[name="accessories[]"]:checked')
		).map(cb => cb.value).join(',');

		// Get visible total price from DOM (calculated earlier)
		let total = '';
		const totalEl = document.getElementById('totalPrice');
		if (totalEl) {
			total = totalEl.textContent.replace(/,/g, '').trim();
			// Ensure it's a number
			if (isNaN(parseFloat(total))) total = '';
		}

		const url = `payment_temp.php?proId=${proId}` +
			(selectedAccessories ? `&accessories=${selectedAccessories}` : '') +
			(total ? `&total=${encodeURIComponent(total)}` : '');
		window.location.href = url;
	}

	/**
	 * Initialize lightbox and slider
	 */
	$(document).ready(function () {
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true,
			'alwaysShowNavOnTouchDevices': true
		});

		updateSelection();
		updateSliderButtons();

		// Update slider buttons on resize and scroll
		$(window).resize(function () {
			updateSliderButtons();
		});

		$('#accessorySlider').on('scroll', function () {
			updateSliderButtons();
		});
	});
</script>