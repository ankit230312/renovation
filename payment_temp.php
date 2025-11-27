	<?php
	include 'common/header.php'; ?>



	<?php
$noProducts = false;

if (isset($_GET['proId'])) {
	$_SESSION['single_cart_product'] = $_GET['proId'];
} elseif (!isset($_SESSION['single_cart_product'])) {
	$noProducts = true;
}

// Decode and validate floor_id
if (isset($_GET['floor_id'])) {
	$proID = base64_decode($_GET['floor_id']);
	$proID = filter_var($proID, FILTER_VALIDATE_INT);
} else {
	$proID = false;
}

// Fetch floor product
$product = [];
if ($proID) {
	$stmt = $conn->prepare("SELECT * FROM floor_type WHERE floor_id = ?");
	$stmt->bind_param("i", $proID);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result && $result->num_rows > 0) {
		$product = $result->fetch_assoc();
	}
	$stmt->close();
}

// Fetch main product item
$prc = 0;
$productId = (int) ($_SESSION['single_cart_product'] ?? 0);
$rowitem = [];

if ($productId > 0) {
	$stmt = $conn->prepare("
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
			p.productID = ? 
			AND p.status = 'active'
		ORDER BY 
			p.productID DESC
		LIMIT 1
	");
	$stmt->bind_param("i", $productId);
	$stmt->execute();
	$resultitem = $stmt->get_result();

	if ($resultitem && $resultitem->num_rows > 0) {
		$rowitem = $resultitem->fetch_assoc();

		// --- Calculate discount if offer is active ---
		$originalPrice = (float)$rowitem['price'];
		$discountPrice = $originalPrice;
		$offerText = '';
		$offerDesc = '';

		if (!empty($rowitem['offer_value']) && $rowitem['is_active'] === 'Y') {
			if ($rowitem['offer_type'] === 'PERCENTAGE') {
				$offerText = "{$rowitem['offer_value']}% Off";
				$offerDesc = "Discount on this product";
				$discountPrice = $originalPrice - ($originalPrice * ((float)$rowitem['offer_value']) / 100);
			} elseif ($rowitem['offer_type'] === 'FIXED') {
				$offerText = "₹{$rowitem['offer_value']} Off";
				$offerDesc = "Instant price reduction";
				$discountPrice = max(0, $originalPrice - (float)$rowitem['offer_value']);
			} elseif (strpos($rowitem['offer_type'], 'CASHBACK') !== false) {
				$offerText = "₹{$rowitem['offer_value']} Cashback";
				$offerDesc = "Cashback on purchase";
			}
		}

		// --- Store prices in session for easy access elsewhere ---
		$_SESSION['prc'] = $discountPrice;

		$prc = $_SESSION['prc'];
		$_SESSION['original_price'] = $originalPrice;
		$_SESSION['offer_text'] = $offerText;
		$_SESSION['offer_desc'] = $offerDesc;
		$_SESSION['offer_end_date'] = $rowitem['end_date'];
	} else {
		$_SESSION['prc'] = 0;
	}
	$stmt->close();
}
?>

	<style>
		.team {
			padding-top: 0;
		}

		.cart {
			width: 40%;
			position: fixed;
			bottom: -100px;
			left: 0px;
			right: 0px;
			background-color: rgb(52, 58, 64);
			color: rgb(255, 255, 255);
			padding: 15px 20px;
			margin-left: 30%;
			display: flex;
			justify-content: space-between;
			border-radius: 10px;
			align-items: center;
			transition: bottom 0.3s ease-in-out;
			z-index: 9999;
		}

		.team_body {
			width: 250px;
			height: 180px;
			padding-top: 10px;
			padding-bottom: 24px;
			background: #FFFFFF;
			border-radius: 6px;
			box-shadow: 0px 1px 10px rgba(29, 34, 47, 0.1);
			text-align: center;
			-webkit-transition: all 200ms ease;
			-moz-transition: all 200ms ease;
			-ms-transition: all 200ms ease;
			-o-transition: all 200ms ease;
			transition: all 200ms ease;
		}

		/* Container holding the search bar, dropdown, and button */
		.search-form {
			display: flex;
			align-items: center;
			gap: 10px;
			flex-wrap: wrap;
			/* Wrap on smaller screens */
		}

		.team_title {
			display: flex;
			justify-content: space-evenly;
			font-size: 14px;
			margin-bottom: 10px;
			padding: 0 10px;
		}

		/* Search input field */
		#property_search {
			padding: 10px 15px;
			border: 1px solid #ccc;
			border-radius: 4px;
			flex: 1;
			min-width: 250px;
			font-size: 14px;
		}

		/* Dropdown selector */
		#bhkSelect {
			padding: 10px 15px;
			border: 1px solid #ccc;
			border-radius: 4px;
			min-width: 180px;
			font-size: 14px;
			background-color: #fff;
			appearance: none;
			-webkit-appearance: none;
			-moz-appearance: none;
		}

		/* Search button */
		.home_search_button {
			padding: 10px 25px;
			border: none;
			background-color: #007bff;
			color: white;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			transition: background-color 0.3s ease;
		}

		.home_search_button:hover {
			background-color: #0056b3;
		}

		/* Autocomplete dropdown (shown under search box) */
		.autocomplete-results {
			position: absolute;
			top: 100%;
			left: 0;
			right: 0;
			z-index: 999;
			background: white;
			border: 1px solid #ccc;
			border-top: none;
			list-style: none;
			margin: 0;
			padding: 0;
			max-height: 200px;
			overflow-y: auto;
		}

		.autocomplete-results li {
			padding: 10px;
			cursor: pointer;
		}

		.autocomplete-results li:hover {
			background-color: #f0f0f0;
		}

		.course {
			width: 100%;
			padding-top: 29px;
			padding-bottom: 100px;
			background: #FFFFFF;
		}

		.home {
			width: 100%;
			height: 129px;
			background: #f2f4f5;
			border-bottom: solid 1px #edeff0;
		}


		.cart-container {
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 10px;
			padding: 15px;
			width: 350px;
			margin: 20px auto;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			position: absolute;
			bottom: 50px;
		}

		.cart-header h5 {
			font-size: 18px;
			margin-bottom: 10px;
			text-align: center;
		}

		.cart-items {
			max-height: 300px;
			overflow-y: auto;
		}

		.cart-item {
			background: #f8f8f8;
			padding: 10px;
			margin-bottom: 8px;
			border-radius: 6px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.cart-item .info {
			font-size: 14px;
		}

		.cart-item .remove {
			color: red;
			font-size: 18px;
			background: none;
			border: none;
			cursor: pointer;
			font-weight: bold;
		}

		.cart-footer {
			border-top: 1px solid #eee;
			padding-top: 10px;
			/* text-align: right; */
			font-size: 14px;
		}

		@media only screen and (max-width: 767px) {
			.home {
				height: 55px;
			}

			.cart-container {
				background-color: #fff;
				border: 1px solid #ccc;
				border-radius: 10px;
				padding: 15px;
				width: 350px;
				margin: 20px auto;
				margin-top: 20px;
				box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
				position: unset;

			}
		}
	</style>

	<div class="home">
		<div class="breadcrumbs_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumbs">
							<ul>
								<!-- <li><a href="index.php">Home</a></li>
								<li><a href="courses.php">Courses</a></li>
								<li>Course Details</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Course -->




	<div class="course">
		<div class="container">
			<div class="row noProduct">
				<?php if ($noProducts): ?>
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">No Product Selected</h5>
								<p class="card-text">Please select a product to view its details and available floor types.</p>
								<a href="product.php" class="btn btn-primary">Go to Products</a>
							</div>
						</div>

					</div>
				<?php exit;
				endif; ?>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron jumbotron-fluid">
						<div class="container">

							<div class="row">

								<?php
								$images = explode(",", $rowitem['product_image']);
								$totalImages = count($images);
								?>

								<div class="col-md-4">
									<?php if ($totalImages > 1): ?>
										<!-- Bootstrap Carousel -->
										<div id="productCarousel" class="carousel slide" data-ride="carousel">
											<div class="carousel-inner">
												<?php foreach ($images as $index => $img): ?>
													<div class="carousel-item <?php echo ($index == 0) ? 'active' : ''; ?>">
														<img src="admin/uploads/items/<?php echo trim($img); ?>" class="d-block w-100" style="height: 300px;" alt="Product Image">
													</div>
												<?php endforeach; ?>
											</div>

											<!-- Controls (only if multiple images) -->
											<a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
												<span class="carousel-control-prev-icon" aria-hidden="true"></span>
												<span class="sr-only">Previous</span>
											</a>
											<a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
												<span class="sr-only">Next</span>
											</a>
										</div>
									<?php else: ?>
										<!-- Just a single image -->
										<img src="admin/uploads/items/<?php echo trim($images[0]); ?>" class="d-block w-100" alt="Product Image">
									<?php endif; ?>


								</div>



								<div class="col-md-8 pl-5">
									<?php if (isset($_SESSION['single_cart_product']) && !empty($rowitem)): ?>
										<?php
										// --- Extract product info ---
										$productName = htmlspecialchars($rowitem['product_name']);
										$originalPrice = (float)$rowitem['price'];
										$discountPrice = $originalPrice;
										$offerText = '';
										$offerDesc = '';

										// --- Fetch active offer for this product ---
										$offerQuery = "
            SELECT 
                o.offer_type, 
                o.offer_value, 
                o.apply_on, 
                o.start_date, 
                o.end_date
            FROM 
                offer_products op
            LEFT JOIN 
                offers o ON o.offerID = op.offer_id 
                AND o.is_active = 'Y' 
                AND o.apply_on = 'ITEM'
                AND CURDATE() BETWEEN o.start_date AND o.end_date
            WHERE 
                op.product_id = '" . intval($rowitem['productID']) . "'
            LIMIT 1
        ";
										$offerResult = mysqli_query($conn, $offerQuery);
										if ($offerRow = mysqli_fetch_assoc($offerResult)) {
											// Build Offer Details
											if ($offerRow['offer_type'] === 'PERCENTAGE') {
												$offerText = "{$offerRow['offer_value']}% Off";
												$offerDesc = "Discount on this product";
												$discountPrice = $originalPrice - ($originalPrice * ((float)$offerRow['offer_value']) / 100);
											} elseif ($offerRow['offer_type'] === 'FIXED') {
												$offerText = "₹{$offerRow['offer_value']} Off";
												$offerDesc = "Instant price reduction";
												$discountPrice = max(0, $originalPrice - (float)$offerRow['offer_value']);
											} elseif (strpos($offerRow['offer_type'], 'CASHBACK') !== false) {
												$offerText = "₹{$offerRow['offer_value']} Cashback";
												$offerDesc = "Cashback on purchase";
											}
										}
										?>
										<!-- Product Details -->
										<h1 class="display-4 mb-3"><?= $productName; ?></h1>

										<!-- ✅ Offer + Price Section -->
										<?php if (!empty($offerText)): ?>

										<?php endif; ?>

										<!-- ✅ Price Display -->
										<p class="lead mt-2 mb-3">
											<?php if ($discountPrice < $originalPrice): ?>
												<span class="text-danger fs-3 fw-bold">₹<?= number_format($discountPrice, 2)  ."/Sqft"; ?></span>
												&nbsp;
												<del class="text-muted fs-5">₹<?= number_format($originalPrice, 2); ?></del>
											<?php else: ?>
												<span class="fw-bold fs-3">₹<?= number_format($originalPrice, 2) . "/Sqft"; ?></span>
											<?php endif; ?>
										</p>
									<?php endif; ?>

									<!-- ✅ Search + Floor Type Section -->
									<div class="d-flex flex-row align-items-center justify-content-start">
										<div class="search-container" style="position: relative;">
											<input type="search" id="property_search" class="home_search_input property_search" placeholder="Enter Your Society or Building Name" required>
											<ul id="autocomplete-results" class="autocomplete-results"></ul>
										</div>
										<div class="bhkSelectBG ms-2">
											<select id="bhkSelect" class="dropdown_item_select bhkSelect home_search_input">
												<option value="">Select Floor Type</option>
												<!-- Options dynamically populated via JS or PHP -->
											</select>
										</div>
									</div>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">

				<!-- Course -->
				<div class="col-lg-9">

					<div class="row mt-3">
						<div class="col-md-6">

						</div>
					</div>
					<?php
					if (!empty($product)) {
						$prodId = $product['property_id'];
					?>
						<div class="course_container mt-3">

							<div class="course_title"><?php echo $product['floor_type'] ?></div>

							<div class="course_image"><img src="admin/uploads/property_type/<?php echo $product['type_image'] ?>" width="800" alt="2BHK + 2 T"></div>

							<!-- Course Tabs -->
							<div class="course_tabs_container">
								<div class="tabs d-flex flex-row align-items-center justify-content-start">

								</div>
								<div class="tab_panels">


									<div class="tab_panel active">

										<div class="tab_panel_content">


											<div class="tab_panel_faq">
												<div class="tab_panel_title"></div>


												<div class="team">
													<div class="team_background parallax-window" data-parallax="scroll"
														data-image-src="images/team_background.jpg" data-speed="0.8"></div>
													<div class="container">
														<div class="row">
															<div class="col">
																<div class="section_title_container text-center">
																	<!-- <h2 class="section_title">Property Floor</h2> -->
																</div>
															</div>
														</div>

														<?php
														$sql = "SELECT * FROM `floor_dimensions` 
																WHERE status ='active' 
																AND property_id = {$product['property_id']} 
																AND property_type_id = {$proID}";
														$result = $conn->query($sql);
														$floorList = [];
														?>

														<div class="row team_row">
															<?php
															if ($result && $result->num_rows > 0) {
																$floorIndex = 1;
																while ($row = $result->fetch_assoc()) {
																	$floorName = htmlspecialchars($row['room_type']);
																	$floorId = 'ff-' . $floorIndex;
																	$floorDimensionId = (int)$row['id'];

																	// Store floor info for later use
																	$floorList[] = [
																		'id' => $floorId,
																		'dimension_id' => $floorDimensionId
																	];
															?>
																	<!-- <div class="col-md-4 mb-3">
																		<div class="team_item" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
																			<div class="team_body">
																				<div class="team_title" style="font-weight: bold; font-size: 16px;">
																					<a href="#" class="toggle-ff" data-target="<?= $floorId ?>" style="text-decoration: none; color: #333;">
																						<?= $floorName ?>
																					</a>
																				</div>
																				<div>
																					<p class="label">Area Sq Ft</p>
																				</div>
																				<div>
																					<p class="value"><?= htmlspecialchars($row['area_sqft']) ?></p>
																				</div>
																			</div>
																		</div>
																	</div> -->
																	<!-- Inside the while loop, replace the old block with this -->
																	<div class="col-md-4 mb-3">
																		<div class="team_item" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
																			<div class="team_body ">
																				<div class="team_title" style="font-weight: bold; font-size: 16px;">
																					<?= $floorName ?>
																				</div>
																				<div>
																					<p class="label">Area Sq Ft</p>
																					<p class="value"><?= htmlspecialchars($row['area_sqft']) ?></p>
																				</div>

																				<button class="btn btn-sm btn-primary add-to-cart"
																					data-id="<?= $floorDimensionId ?>"
																					data-name="<?= $floorName ?>"
																					data-area="<?= htmlspecialchars($row['area_sqft']) ?>"
																					data-price="<?php echo $prc; ?>"
																					data-productId="<?php echo $$prodId; ?>">
																					Add to Cart
																				</button>
																			</div>
																		</div>
																	</div>

																<?php
																	$floorIndex++;
																}
															} else {
																?>
																<div class="col-md-12">
																	<p>No floor data found.</p>
																</div>
															<?php
															}
															?>
														</div> <!-- END of .team_row -->


														<?php $conn->close(); ?>
													</div>
												</div>

											</div>
										</div>

										<!-- Floating Cart Summary -->
										<div id="cart-summary" class="cart">
											<div><span id="cart-count">0</span> item(s) selected</div>
											<button class="btn btn-light" onclick="window.location.href='cart.php'">Go to Cart</button>
										</div>
									</div>




								</div>
							</div>
						</div>
					<?php }



					?>
				</div>

				<div class="col-md-3">
					<div class="cart-container mt-5" style="display: none;">
						<div class="cart-header">
							<h5>Selected Features</h5>
						</div>

						<div class="cart-items" id="cart-items">
							<!-- Dynamically added items here -->
						</div>

						<div class="cart-footer d-flex justify-content-between">
							<p><strong>Total Items:</strong> <span id="total-items">0</span></p>
							<p><strong>Total Price:</strong> <span id="total-price">0</span></p>

						</div>
						<form id="cart-form" method="POST" action="payment.php">
							<input type="hidden" name="cart_data" id="cart-data">
							<button type="submit" class="btn btn-primary">Buy Now</button>
						</form>

					</div>

				</div>


			</div>


		</div>
		<!-- Cart Container -->


	</div>





	<!-- Newsletter -->



	<!-- Footer -->

	<?php
	$page = 'course';
	include 'common/footer.php'; ?>


	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const input = document.getElementById('property_search');
			const results = document.getElementById('autocomplete-results');

			let floorData = [];

			// Fetch floor types dynamically
			fetch('ajax/get_floor_types.php?product_id=1')
				.then(res => res.json())
				.then(data => {
					floorData = data;
				});

			input.addEventListener('input', function() {
				const query = this.value.toLowerCase();
				results.innerHTML = '';

				if (!query) return;

				const matches = floorData.filter(f =>
					f.floor_type.toLowerCase().includes(query)
				);

				matches.forEach(f => {
					const li = document.createElement('li');
					li.textContent = f.floor_type;
					li.dataset.floorId = f.floor_id;
					li.style.cursor = 'pointer';
					li.addEventListener('click', function() {
						const encodedId = btoa(this.dataset.floorId);
						const currentUrl = window.location.href.split('?')[0];
						window.location.href = `${currentUrl}?floor_id=${encodedId}`;
					});
					results.appendChild(li);
				});
			});

			// Hide on click outside
			document.addEventListener('click', function(e) {
				if (!results.contains(e.target) && e.target !== input) {
					results.innerHTML = '';
				}
			});
		});
	</script>

	<script>
		document.getElementById('bhkSelect').addEventListener('change', function() {
			const selectedId = this.value;
			const encodedId = btoa(selectedId); // Encode floor_id
			const currentUrl = window.location.href.split('?')[0];

			const urlParams = new URLSearchParams(window.location.search);
			const productId = urlParams.get('id');

			window.location.href = `${currentUrl}?floor_id=${encodedId}${productId ? `&id=${productId}` : ''}`;
		});
	</script>



	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const cartItems = document.getElementById('cart-items');
			const totalItems = document.getElementById('total-items');
			const totalPrice = document.getElementById('total-price');
			const cartForm = document.getElementById('cart-form');
			const cartDataInput = document.getElementById('cart-data');

			function updateCartCount() {
				const count = cartItems.querySelectorAll('.cart-item').length;
				totalItems.innerText = count;
			}

			function updateTotalPrice() {
				let total = 0;
				cartItems.querySelectorAll('.cart-item').forEach(item => {
					const area = parseFloat(item.dataset.area);
					const price = parseFloat(item.dataset.price);
					total += area * price;
				});
				totalPrice.innerText = total.toFixed(2);
			}

			document.querySelectorAll('.add-to-cart').forEach(button => {
				button.addEventListener('click', function() {
					document.querySelector('.cart-container').style.display = 'block';

					const id = this.dataset.id;
					const name = this.dataset.name;
					const area = this.dataset.area;
					const price = this.dataset.price;
					const productId = this.dataset.productId;

					if (document.getElementById('cart-item-' + id)) return;

					const totalItemPrice = parseFloat(area) * parseFloat(price);

					const item = document.createElement('div');
					item.className = 'cart-item d-flex justify-content-between align-items-center border p-2 mb-2 rounded';
					item.id = 'cart-item-' + id;
					item.dataset.id = id;
					item.dataset.name = name;
					item.dataset.area = area;
					item.dataset.price = price;
					item.dataset.productId = productId;

					item.innerHTML = `
				<div class="info">
					<strong>${name}</strong><br>
					<small>${area} sqft × ₹ ${price} = ₹ ${totalItemPrice.toFixed(2)}</small>
				</div>
				<button class="btn btn-sm btn-danger remove">&times;</button>
			`;

					item.querySelector('.remove').addEventListener('click', function() {
						item.remove();
						updateCartCount();
						updateTotalPrice();
					});

					cartItems.appendChild(item);
					updateCartCount();
					updateTotalPrice();
				});
			});




			cartForm.addEventListener("submit", function(e) {
				e.preventDefault(); // stop normal form submit for now

				const cart = [];
				cartItems.querySelectorAll(".cart-item").forEach(item => {
					cart.push({
						id: item.dataset.id,
						name: item.dataset.name,
						area: item.dataset.area,
						price: item.dataset.price,
						productId: item.dataset.productId
					});
				});

				// set hidden input for fallback normal submit
				cartDataInput.value = JSON.stringify(cart);

				// send to server via AJAX
				fetch("ajax/add_to_cart.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						body: "product_id_cart=" + encodeURIComponent(JSON.stringify(cart))
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							console.log("Cart updated:", data.cart);
							// redirect to payment page
							window.location = "payment.php";
						} else {
							alert(data.message);
						}
					})
					.catch(err => console.error(err));
			});

			// // Serialize cart data before form submit
			// cartForm.addEventListener('submit', function(e) {
			// 	const cart = [];
			// 	cartItems.querySelectorAll('.cart-item').forEach(item => {
			// 		cart.push({
			// 			id: item.dataset.id,
			// 			name: item.dataset.name,
			// 			area: item.dataset.area,
			// 			price: item.dataset.price,
			// 			productId: item.dataset.productId
			// 		});
			// 	});

			// 	cartDataInput.value = JSON.stringify(cart); // Convert to JSON string for POST
			// });
			// cartForm.addEventListener('submit', function(e) {
			// 	// e.preventDefault(); // stop normal form submit

			// 	const cart = [];
			// 	cartItems.querySelectorAll('.cart-item').forEach(item => {
			// 		cart.push({
			// 			id: item.dataset.id,
			// 			name: item.dataset.name,
			// 			area: item.dataset.area,
			// 			price: item.dataset.price,
			// 			productId: item.dataset.productId
			// 		});
			// 	});
			// 	// Send cart data to PHP via AJAX

			// 	// console.log(cart);
			// 	// debugger;
			// 	fetch("ajax/add_to_cart.php", {
			// 			method: "POST",
			// 			headers: {
			// 				"Content-Type": "application/x-www-form-urlencoded"
			// 			},
			// 			body: "product_id_cart=" + encodeURIComponent(JSON.stringify(cart))
			// 		})
			// 		.then(response => response.json())
			// 		.then(data => {
			// 			if (data.success) {
			// 				console.log("Cart updated:", data.cart);
			// 				// redirect to payment page
			// 				// window.location = "payment.php";
			// 			} else {
			// 				alert(data.message);
			// 			}
			// 		})
			// 		.catch(err => console.error(err));
			// });

		});
	</script>