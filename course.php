	<?php
	include 'common/header.php';  ?>



	<?php
	$proID = base64_decode($_GET['floor_id']);


	$product = [];

	if ($proID) {
		$proID = (int)$proID; // Sanitize the input
		$sql = "SELECT * FROM floor_type WHERE floor_id = $proID";
		$result = $conn->query($sql);

		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc(); // Only fetch the first result
			$product = $row;
		} else {
			echo "No products found.";
		}
	} else {
		echo "Invalid product ID.";
	}


	$productPro = [];
	if (!empty($product)) {
		$prod_id = $product['property_id'];
		$sqlPro = "SELECT * FROM products WHERE productID = $prod_id";
		$resultPro = $conn->query($sqlPro);

		if ($resultPro && $resultPro->num_rows > 0) {
			$row = $resultPro->fetch_assoc(); // Only fetch the first result
			$productPro = $row;
		} else {
			echo "No products found.";
		}
		// print_r($productPro);
	}
	// $conn->close();

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


		@media only screen and (max-width: 767px) {
			.home {
				height: 55px;
			}
		}

		.course_main {
			background: rgba(1, 78, 121, 0.1);
		}

		.team_body {
			width: 250px;
			height: 120px;

			background: #FFFFFF;
			border-radius: 6px;
			box-shadow: 0px 1px 10px rgba(29, 34, 47, 0.1);
			-webkit-transition: all 200ms ease;
			-moz-transition: all 200ms ease;
			-ms-transition: all 200ms ease;
			-o-transition: all 200ms ease;
			transition: all 200ms ease;
			padding: 20px;
		}

		.area_sq_ft {
			display: flex;
			justify-content: space-between;
			margin-top: 10px;
			font-size: 16px;
			font-weight: bold;
		}

		/* Bubble Effect + Your Gradient Card */
		.team_body {
			--c1: #ffffff;
			/* Text color after bubble */
			--c2: #2E5B1A;
			/* Bubble color */
			--size-letter: 32px;

			width: 100%;
			height: 100%;
			padding: 20px;
			border-radius: 18px;
			cursor: pointer;
			position: relative;
			overflow: hidden;

			/* Your original gradient background */
			/* background: linear-gradient(90deg, #05476D, #2E5B1A); */
			border: calc(var(--size-letter) / 8) solid var(--c2);

			transition: 300ms cubic-bezier(0.83, 0, 0.17, 1);
			box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);

			display: block;
			border: none;
		}


		/* Text inside */
		.team_body .team_title,
		.team_body .value {
			position: relative;
			z-index: 2;
			font-weight: 700;
			color: black;
		}

		.team_body .team_title a,
		.team_body .area_sq_ft p {
			transition: color 0.5s ease-in-out;
			/* smooth effect */
			transition-delay: 0.3s;
			/* delay before change */
		}

		.team_body:hover .team_title a {

			color: white;
		}

		.area_sq_ft p {
			color: black;
			margin-left: 10px;
			z-index: 2;
			position: relative;
		}

		.team_body:hover .area_sq_ft p {
			color: white;

		}

		/* Bubble elements */
		.team_body::before,
		.team_body::after {
			content: "";
			width: 150%;
			aspect-ratio: 1 / 1;
			scale: 0;
			background-color: var(--c2);
			border-radius: 50%;

			position: absolute;
			translate: -50% -50%;
			transition: 1000ms cubic-bezier(0.76, 0, 0.24, 1);
		}

		.team_body::before {
			top: 0;
			left: 0;
		}

		.team_body::after {
			top: 100%;
			left: 100%;
		}


		/* Hover Effects */
		.team_body:hover {
			transform: scale(1.03);
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
		}

		.team_body:hover::before,
		.team_body:hover::after {
			scale: 1;
		}
	</style>
	<!-- <div class="home">
		<div class="breadcrumbs_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumbs">
							<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="courses.php">Courses</a></li>
								<li>Course Details</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->

	<!-- Course -->

	<div class="course course_main">
		<div class="container">
			<div class="row">

				<!-- Course -->
				<div class="col-lg-12">

					<div class="course_container">
						<!-- <div class="course_title">Software Training</div> -->
						<div class="course_title"><?php echo $product['floor_type'] ?></div>
						<!-- <div class="course_info d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">


							<div class="course_info_item">
								<div class="course_info_title">Teacher:</div>
								<div class="course_info_text"><a href="#">Jacke Masito</a></div>
							</div>


							<div class="course_info_item">
								<div class="course_info_title">Reviews:</div>
								<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
							</div>


							<div class="course_info_item">
								<div class="course_info_title">Categories:</div>
								<div class="course_info_text"><a href="#">Languages</a></div>
							</div>

						</div> -->

						<!-- Course Image -->
						<!-- C:\xampp\htdocs\splitfloor\admin\uploads\products\product1748878661.jpg -->
						<div class="course_image"><img src="admin/uploads/property_type/<?php echo $product['type_image'] ?>" width="800" alt="2BHK + 2 T"></div>

						<!-- Course Tabs -->
						<div class="course_tabs_container">
							<div class="tabs d-flex flex-row align-items-center justify-content-start">
								<!-- <div class="tab active">description</div> -->
								<!-- <div class="tab">curriculum</div>
								<div class="tab">reviews</div> -->
							</div>
							<div class="tab_panels">

								<!-- Description -->
								<div class="tab_panel active">
									<!-- <div class="tab_panel_title">Edana </div> -->
									<div class="tab_panel_content">
										<!-- <div class="tab_panel_text">
											<p>
												<?php echo $productPro['product_description'] ?>
											</p>
										</div> -->
										<!-- <div class="tab_panel_section">
											<div class="tab_panel_subtitle">Use</div>
											<ul class="tab_panel_bullets">
												<li>GREATER NOIDA</li>
											</ul>
										</div> -->

										<div class="tab_panel_faq">
											<div class="tab_panel_title"></div>

											<!-- Accordions -->
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
								AND property_type_id = {$proID}
								
								ORDER BY `room_type` ASC";
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
																	'dimension_id' => $floorDimensionId,
																	'area_sqft' => $row['area_sqft'],
																	'room_type' => $floorName
																];
														?>
																<div class="col-md-4 mb-3">
																	<div class="team_item">
																		<div class="team_body">


																			<div class="area_sq_ft">
																				<div class="team_title" style="font-weight: bold; font-size: 16px;">
																					<a href="#" class="toggle-ff" data-target="<?= $floorId ?>" style="text-decoration: none;">
																						<?= $floorName ?>
																					</a>
																				</div>
																				<div>
																					<p class="value"><?= htmlspecialchars(intval($row['area_sqft'])) ?> SQFT</p>
																				</div>
																			</div>
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

													<?php
													// Loop through stored floor list to show products below

													foreach ($floorList as $floor) {
														$floorId = $floor['id'];
														$floorDimensionId = $floor['dimension_id'];
														$area_sqft = $floor['area_sqft'];
														$floorNameSelected = $floor['room_type'];

														// 🔹 Fetch products with any linked offer
														$sqlProducts = "
		SELECT 
			p.*, 
			o.offer_code, 
			o.offer_type, 
			o.offer_value, 
			o.end_date,
			o.description
		FROM products_item p
		LEFT JOIN offer_products op ON op.product_id = p.productID
		LEFT JOIN offers o ON o.offerID = op.offer_id 
			AND o.is_active = 'Y' 
			AND CURDATE() BETWEEN o.start_date AND o.end_date
		WHERE p.status = 'active'
			AND p.society_id = {$product['property_id']}
			AND p.property_type_id = {$proID}
			AND FIND_IN_SET($floorDimensionId, p.property_feature_id)
	";
														$resultProducts = $conn->query($sqlProducts);
													?>
														<div class="row">
															<div class="col-12" id="<?= $floorId ?>" style="display: none;">
																<div class="row">
																	<?php if ($resultProducts && $resultProducts->num_rows > 0) {
																		while ($productItem = $resultProducts->fetch_assoc()) {
																			$productId = $productItem['productID'];
																			$imageList = explode(',', $productItem['product_image']);
																			$carouselId = 'carousel_' . $productId;

																			// ✅ Offer logic
																			$finalPrice = $productItem['price'];
																			$offerText = '';
																			$hasOffer = false;

																			if (!empty($productItem['offer_code'])) {
																				$hasOffer = true;

																				if ($productItem['offer_type'] === 'PERCENTAGE') {
																					$discount = ($productItem['price'] * $productItem['offer_value']) / 100;
																					$finalPrice = $productItem['price'] - $discount;
																					$offerText = "{$productItem['offer_value']}% Off";
																				} elseif ($productItem['offer_type'] === 'FIXED') {
																					$finalPrice = $productItem['price'] - $productItem['offer_value'];
																					$offerText = "₹{$productItem['offer_value']} Off";
																				} elseif (strpos($productItem['offer_type'], 'CASHBACK') !== false) {
																					$offerText = "Get ₹{$productItem['offer_value']} Cashback";
																				}
																			}

																			$totalPrice = $area_sqft * $finalPrice;
																	?>
																			<div class="col-md-4 mb-4">
																				<div class="card shadow-sm h-100" style="border-radius: 10px;">
																					<div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
																						<div class="carousel-inner">
																							<?php foreach ($imageList as $index => $img): ?>
																								<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
																									<a href="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
																										data-lightbox="product-gallery-<?= $productId ?>"
																										data-title="<?= htmlspecialchars($productItem['product_name']) ?>">
																										<img src="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
																											alt="<?= htmlspecialchars($productItem['product_name']) ?>"
																											class="d-block w-100"
																											style="height: 200px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
																									</a>



																								</div>
																							<?php endforeach; ?>
																						</div>

																						<!-- ✅ Carousel Controls (if more than 1 image) -->
																						<?php if (count($imageList) > 1): ?>
																							<button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
																								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
																								<span class="visually-hidden">Previous</span>
																							</button>
																							<button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
																								<span class="carousel-control-next-icon" aria-hidden="true"></span>
																								<span class="visually-hidden">Next</span>
																							</button>
																						<?php endif; ?>
																					</div>

																					<div class="card-body d-flex flex-column justify-content-between">
																						<div class="row my-3">
																							<div class="col-md-6">
																								<a href="product_detail.php?proId=<?= $productId ?>"><h5 class="card-title"><?= htmlspecialchars($productItem['product_name']) ?></h5></a>
																								<?php if ($hasOffer): ?>
																									<p class="mb-1">
																										<span class="fw-bold badge bg-success"><?= htmlspecialchars($offerText) ?></span><br>
																										<small class="text-muted">Valid till <?= date('d M Y', strtotime($productItem['end_date'])) ?></small>
																									</p>
																									<p class="text-muted mb-0">
																										<del>₹<?= number_format($productItem['price'], 2) ?></del>
																										<span class="text-danger fw-bold ms-2">₹<?= number_format($finalPrice, 2) ?></span>
																									</p>
																								<?php else: ?>
																									<p class="card-text text-muted mb-0">₹<?= number_format($productItem['price'], 2) ?></p>
																								<?php endif; ?>
																							</div>

																							<div class="col-md-6 text-end">
																								<h6 class="mt-2">Total Price</h6>
																								<p class="text-muted mb-0">
																									<?= $area_sqft ?> × ₹<?= number_format($finalPrice, 2) ?> =
																									<b>₹<?= number_format($totalPrice, 2) ?></b>
																								</p>
																							</div>
																						</div>

																						<button class="btn btn-primary w-100 add-to-cart-btn"
																							data-id="<?= $floorDimensionId ?>"
																							data-name="<?= htmlspecialchars($floorNameSelected) ?>"
																							data-price="<?= $finalPrice ?>"
																							data-original-price="<?= $productItem['price'] ?>"
																							data-offer="<?= htmlspecialchars($offerText) ?>"
																							data-area-sqft="<?= $area_sqft ?>"
																							data-productId="<?= $productId ?>">
																							Add to Cart
																						</button>
																					</div>
																				</div>
																			</div>
																		<?php }
																	} else { ?>
																		<div class="col-12">
																			<p>No product items found for this feature.</p>
																		</div>
																	<?php } ?>
																</div>
															</div>
														</div>
													<?php } ?>


													<?php $conn->close(); ?>
												</div>
											</div>

										</div>
									</div>

									<!-- Floating Cart Summary -->

								</div>



							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

	<!-- Newsletter -->



	<!-- Footer -->

	<?php
	$page = 'course';
	include 'common/footer.php'; ?>


	<script>
		document.addEventListener("click", function(e) {
			if (e.target.classList.contains("add-to-cart-btn")) {
				let id = e.target.dataset.id;
				let productName = e.target.dataset.name;
				let productPrice = e.target.dataset.price;
				let area = e.target.dataset.areaSqft;
				let productId = e.target.dataset.productid;

				let product = {
					id: id,
					name: productName,
					price: productPrice,
					area: area,
					productId: productId
				};

				// Send selected product to backend
				fetch("ajax/add_to_cart.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						body: "product_id_cart=" + encodeURIComponent(JSON.stringify(product))
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							console.log("Cart updated:", data.cart);
							alert(productName + " added to cart!");
							// redirect if needed
							window.location = "payment.php";
						} else {
							alert(data.message);
						}
					})
					.catch(err => console.error(err));
			}
		});
	</script>