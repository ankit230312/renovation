<?php

include 'common/header.php';

$proId = $_GET['proId'];
$itemsQuery = "SELECT * FROM products_item WHERE status = 'active' AND productID = '$proId'";
$itemsResult = mysqli_query($conn, $itemsQuery);
$itemsData = mysqli_fetch_assoc($itemsResult);

// Parse product images
$productImages = !empty($itemsData['product_image']) ? array_map('trim', explode(',', $itemsData['product_image'])) : ['placeholder.jpg'];
$productImages = array_filter($productImages); // Remove empty values

// Fetch accessories
$accessories = [];
if (!empty($itemsData['isAccessory']) && $itemsData['isAccessory'] == 1) {
	$sql = "
		SELECT a.*, a.accessoryID as acc_id
		FROM product_accessories pa
		INNER JOIN accessories a ON a.accessoryID = pa.accessoryID
		WHERE pa.productID = ?
		AND pa.status = 'active'
		AND a.status = 'active'
	";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $proId);
	$stmt->execute();
	$accessories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.min.css">

<style>
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
		padding: 20px 0;
		min-height: 100vh;
	}

	/* Main Product Container */
	.product-container {
		background: white;
		border-radius: 4px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
		margin-bottom: 20px;
		overflow: hidden;
	}

	.product-wrapper {
		padding: 20px;
	}

	/* Left Column - Image Gallery */
	.product-image-col {
		di
	.product-row {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 30px;
		align-items: start;
	}

	/* Left Column - Image Gallery */
	.product-image-col {
		display: flex;
		flex-direction: column;
		gap: 15px;
	}

	.main-image-container {
		position: relative;
		background: #fff;
		border-radius: 4px;
		border: 1px solid #e0e0e0;
		overflow: hidden;
		aspect-ratio: 1;
		disp	min-height: 300px;
	}

	.main-image {
		width: 100%;
		height: 100%;
		object-fit: contain;
		cursor: zoom-in;
		max-width: 100%;
		max-height: 100%100%;
		height: 100%;
		object-fit: contain;
		cursor: zoom-in;
	}

	.zoom-icon {
		position: absolute;
		top: 10px;
		right: 10px;
		background: rgba(0, 0, 0, 0.7);
		color: white;
		padding: 8px 12px;
		border-radius: 3px;
		font-size: 12px;
		cursor: pointer;
		z-index: 10;
	}

	.thumbnail-container {
		display: flex;
		gap: 10px;
		overflow-x: auto;
		padding-bottom: 10px;
	}

	.thumbnail {
		width: 60px;
		height: 60px;
		border: 2px solid #e0e0e0;
		border-radius: 4px;
		cursor: pointer;
		flex-shrink: 0;
		overflow: hidden;
		background: #f5f5f5;
	}

	.thumbnail img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.thumbnail.active {
		border-color: #2874f0;
	}

	/* Right Column - Product Details */
	.product-details-col {
		display: flex;
		flex-direction: column;
		gap: 15px;
	}

	.product-header {
		border-bottom: 1px solid #e0e0e0;
		padding-bottom: 15px;
	}

	.product-title {
		font-size: 24px;
		font-weight: 500;
		color: #1a1a1a;
		margin-bottom: 8px;
		line-height: 1.4;
	}

	.rating-container {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-bottom: 15px;
	}

	.rating-stars {
		color: #2874f0;
		font-weight: bold;
		display: flex;
		align-items: center;
		gap: 3px;
	}

	.rating-count {
		color: #878787;
		font-size: 13px;
		cursor: pointer;
	}

	/* Price Section */
	.price-section {
		padding: 15px 0;
		border-bottom: 1px solid #e0e0e0;
	}

	.price-container {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-bottom: 10px;
	}

	.price {
		font-size: 28px;
		font-weight: 600;
		color: #1a1a1a;
	}

	.original-price {
		font-size: 14px;
		color: #878787;
		text-decoration: line-through;
	}

	.discount-badge {
		background-color: #31a049;
		color: white;
		padding: 4px 8px;
		border-radius: 3px;
		font-size: 12px;
		font-weight: 600;
	}

	.price-info {
		font-size: 12px;
		color: #878787;
		margin-top: 5px;
	}

	/* Stock Status */
	.stock-status {
		padding: 10px 0;
		margin: 10px 0;
		border-bottom: 1px solid #e0e0e0;
	}

	.stock-status.in-stock {
		color: #31a049;
		font-weight: 600;
	}

	.stock-status.out-of-stock {
		color: #cc0000;
		font-weight: 600;
	}

	/* Offers Section */
	.offers-section {
		background: #f5f5f5;
		padding: 15px;
		border-radius: 4px;
		margin: 15px 0;
	}

	.offers-title {
		font-weight: 600;
		color: #1a1a1a;
		margin-bottom: 10px;
		font-size: 14px;
	}

	.offer-item {
		display: flex;
		gap: 10px;
		margin-bottom: 10px;
		font-size: 13px;
		color: #575757;
		padding-bottom: 10px;
		border-bottom: 1px solid #e0e0e0;
	}

	.offer-item:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
	}

	.offer-badge {
		color: #2874f0;
		font-weight: 600;
		flex-shrink: 0;
	}

	/* Action Buttons */
	.action-buttons {
		display: flex;
		gap: 10px;
		margin: 20px 0;
	}

	.btn-add-cart,
	.btn-buy-now {
		flex: 1;
		padding: 12px 20px;
		font-size: 16px;
		font-weight: 600;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.btn-add-cart {
		background-color: #ff9f00;
		color: white;
		border: 1px solid #ff9f00;
	}

	.btn-add-cart:hover {
		background-color: #f08f00;
	}

	.btn-buy-now {
		background-color: #2874f0;
		color: white;
		border: 1px solid #2874f0;
	}

	.btn-buy-now:hover {
		background-color: #0a66f2;
	}

	/* Accessories Add-ons Section */
	.addons-section {
		background: white;
		border-radius: 4px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
		padding: 20px;
		margin-bottom: 20px;
	}

	.addons-title {
		font-size: 18px;
		font-weight: 600;
		color: #1a1a1a;
		margin-bottom: 15px;
		padding-bottom: 10px;
		border-bottom: 1px solid #e0e0e0;
	}

	.addons-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
		gap: 15px;
	}

	.addon-card {
		border: 1px solid #e0e0e0;
		border-radius: 4px;
		overflow: hidden;
		transition: all 0.3s ease;
		cursor: pointer;
		display: flex;
		flex-direction: column;
	}

	.addon-card:hover {
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
		border-color: #2874f0;
	}

	.addon-card.selected {
		border-color: #2874f0;
		background: #f0f7ff;
	}

	.addon-image {
		width: 100%;
		height: 120px;
		object-fit: cover;
		background: #f5f5f5;
	}

	.addon-info {
		padding: 12px;
		flex: 1;
		display: flex;
		flex-direction: column;
	}

	.addon-name {
		font-size: 13px;
		font-weight: 600;
		color: #1a1a1a;
		margin-bottom: 8px;
		line-height: 1.3;
	}

	.addon-price {
		font-size: 14px;
		font-weight: 600;
		color: #2874f0;
		margin-bottom: 8px;
	}

	.addon-checkbox {
		width: 18px;
		height: 18px;
		cursor: pointer;
		accent-color: #2874f0;
	}

	.addon-checkbox-container {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	/* Description Section */
	.description-section {
		background: white;
		border-radius: 4px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
		padding: 20px;
		margin-bottom: 20px;
	}

	.description-title {
		font-size: 18px;
		font-weight: 600;
		color: #1a1a1a;
		margin-bottom: 15px;
		padding-bottom: 10px;
		border-bottom: 1px solid #e0e0e0;
	}

	.description-content {
		color: #575757;
		line-height: 1.6;
		font-size: 14px;
	}

	.description-content h2,
	.description-content h3 {
		color: #1a1a1a;
		margin-top: 15px;
		margin-bottom: 10px;
		font-size: 16px;
	}

	.description-content ul,
	.description-content ol {
		margin: 10px 0;
		padding-left: 20px;
	}

	.description-content li {
		margin-bottom: 8px;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.product-row {
			grid-template-columns: 1fr;
			gap: 20px;
		}

		.product-wrapper {
			padding: 15px;
		}

		.product-title {
			font-size: 20px;
		}

		.price {
			font-size: 24px;
		}

		.action-buttons {
			flex-direction: column;
		}

		.addons-grid {
			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
		}

		.thumbnail {
			width: 50px;
			height: 50px;
		}
	}
</style>

<div class="course">
	<div class="container">
		<!-- Main Product Container -->
		<div class="product-container">
			<div class="product-wrapper">
				<div class="product-row">
					<!-- LEFT: Image Gallery -->
					<div class="produc?php 
								$mainImagePath = 'admin/uploads/items/' . htmlspecialchars(trim($productImages[0] ?? ''));
							?>
							<img id="mainImage" class="main-image" 
								src="<?= $mainImagePath ?>"
							onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;500&quot; height=&quot;500&quot;><rect fill=&quot;%23ddd&quot; width=&quot;500&quot; height=&quot;500&quot;/><text x=&quot;50%&quot; y=&quot;50%&quot; dominant-baseline=&quot;middle&quot; text-anchor=&quot;middle&quot; font-family=&quot;Arial&quot; font-size=&quot;18&quot; fill=&quot;%23999&quot;>Product Image</text></svg>'"
								alt="<?= htmlspecialchars($itemsData['product_name']); ?>">
							<div class="zoom-icon">🔍 Zoom</div>
						</div>

						<!-- Thumbnails -->
						<div class="thumbnail-container">
							<?php foreach ($productImages as $index => $img): ?>
								<?php $thumbPath = 'admin/uploads/items/' . htmlspecialchars(trim($img)); ?>
								<div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" onclick="changeImage(this)">
									<img src="<?= $thumbPath ?>"
								onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;60&quot; height=&quot;60&quot;><rect fill=&quot;%23ddd&quot; width=&quot;60&quot; height=&quot;60&quot;/></svg>'"
										alt="Thumbnail <?= $index + 1 ?>">
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- RIGHT: Product Details -->
					<div class="product-details-col">
						<!-- Header -->
						<div class="product-header">
							<h1 class="product-title"><?= htmlspecialchars($itemsData['product_name']); ?></h1>
							<div class="rating-container">
								<div class="rating-stars">⭐ 4.5</div>
								<span class="rating-count">(2,345 Reviews)</span>
							</div>
						</div>

						<!-- Price Section -->
						<div class="price-section">
							<div class="price-container">
								<span class="price">₹<?= number_format((float)$itemsData['price'], 0); ?></span>
								<span class="original-price">₹<?= number_format((float)$itemsData['price'] * 1.2, 0); ?></span>
								<span class="discount-badge">20% OFF</span>
							</div>
							<div class="price-info">Free delivery | 7-day return policy</div>
						</div>

						<!-- Stock Status -->
						<div class="stock-status in-stock">✓ In Stock</div>

						<!-- Offers -->
						<div class="offers-section">
							<div class="offers-title">Best Offers</div>
							<div class="offer-item">
								<span class="offer-badge">Bank Offer</span>
								<span>Get 10% discount with ICICI Bank cards</span>
							</div>
							<div class="offer-item">
								<span class="offer-badge">Free Delivery</span>
								<span>Free delivery on this order</span>
							</div>
							<div class="offer-item">
								<span class="offer-badge">Easy Returns</span>
								<span>Return this product within 7 days for a full refund</span>
							</div>
						</div>

						<!-- Action Buttons -->
						<div class="action-buttons">
							<button class="btn-add-cart" onclick="addToCart(<?= $proId ?>)">
								🛒 Add to Cart
							</button>
							<button class="btn-buy-now" onclick="buyNow(<?= $proId ?>)">
								⚡ Buy Now
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Accessories Add-ons Section -->
		<?php if (!empty($accessories)): ?>
			<div class="addons-section">
				<div class="addons-title">Frequently Bought Together</div>
				<div class="addons-grid">
					<?php foreach ($accessories as $acc): ?>
						<div class="addon-card" onclick="toggleAddon(this, <?= (int)$acc['accessoryID']; ?>)">
							<img class="addon-image" src="admin/uploads/accessories/<?= htmlspecialchars($acc['product_image']); ?>"
								alt="<?= htmlspecialchars($acc['accessory_name']); ?>">
							<div class="addon-info">
								<div class="addon-name"><?= htmlspecialchars($acc['accessory_name']); ?></div>
								<div class="addon-price">₹<?= number_format((float)$acc['price'], 0); ?></div>
								<div class="addon-checkbox-container">
									<input type="checkbox" class="addon-checkbox" name="accessories[]"
										value="<?= (int)$acc['accessoryID']; ?>" onchange="updateAddonPrice()">
									<span style="font-size: 12px; color: #878787;">Add</span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Description Section -->
		<div class="description-section">
			<div class="description-title">Product Details</div>
			<div class="description-content">
				<?= html_entity_decode($itemsData['long_desc']); ?>
			</div>
		</div>
	</div>
</div>

<?php include 'common/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/js/jquery.magnify.min.js"></script>

<script>
	// Store accessory data
	const accessoryData = {};
	const productPrice = <?= (float) $itemsData['price']; ?>;

	<?php if (!empty($accessories)) { ?>
		<?php foreach ($accessories as $acc) { ?>
			accessoryData[<?= (int) $acc['accessoryID']; ?>] = {
				name: '<?= htmlspecialchars(addslashes($acc['accessory_name'])); ?>',
				price: <?= (float) $acc['price']; ?>
			};
		<?php } ?>
	<?php } ?>

	// Change main image
	function changeImage(element) {
		const imageSrc = element.querySelector('img').src;
		document.getElementById('mainImage').src = imageSrc;

		// Update active thumbnail
		document.querySelectorAll('.thumbnail').forEach(thumb => {
			thumb.classList.remove('active');
		});
		element.classList.add('active');
	}

	// Toggle addon card
	function toggleAddon(element, accessoryId) {
		const checkbox = element.querySelector('input[type="checkbox"]');
		checkbox.checked = !checkbox.checked;
		element.classList.toggle('selected', checkbox.checked);
		updateAddonPrice();
	}

	// Update addon price
	function updateAddonPrice() {
		let totalAccessoryPrice = 0;
		const checkedAccessories = document.querySelectorAll('.addon-checkbox:checked');

		checkedAccessories.forEach(checkbox => {
			const accessoryId = parseInt(checkbox.value);
			if (accessoryData[accessoryId]) {
				totalAccessoryPrice += accessoryData[accessoryId].price;
			}
		});

		// Update addon card styles
		document.querySelectorAll('.addon-card').forEach(card => {
			const checkbox = card.querySelector('.addon-checkbox');
			card.classList.toggle('selected', checkbox.checked);
		});
	}

	// Add to cart
	function addToCart(proId) {
		const selectedAccessories = Array.from(document.querySelectorAll('.addon-checkbox:checked'))
			.map(cb => cb.value)
			.join(',');
		
		const url = `payment_temp.php?proId=${proId}` + (selectedAccessories ? `&accessories=${selectedAccessories}` : '');
		window.location.href = url;
	}

	// Buy now
	function buyNow(proId) {
		const selectedAccessories = Array.from(document.querySelectorAll('.addon-checkbox:checked'))
			.map(cb => cb.value)
			.join(',');
		
		const url = `checkout.php?proId=${proId}` + (selectedAccessories ? `&accessories=${selectedAccessories}` : '');
		window.location.href = url;
	}

	// Lightbox
	lightbox.option({
		'resizeDuration': 200,
		'wrapAround': true,
		'alwaysShowNavOnTouchDevices': true
	});

	// Zoom main image
	document.getElementById('mainImage').addEventListener('click', function() {
		const lightboxLink = document.createElement('a');
		lightboxLink.href = this.src;
		lightboxLink.setAttribute('data-lightbox', 'product-zoom');
		lightboxLink.click();
	});
</script>
