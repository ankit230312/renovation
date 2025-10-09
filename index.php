<?php include 'common/header.php'; ?>

<style>
	.testimonial_scroll_wrapper {
		width: 100%;
		overflow: hidden;
		margin-top: 30px;
		position: relative;
	}

	.testimonial_scroll_content {
		display: flex;
		width: max-content;
		animation: scrollLeft 25s linear infinite;
		gap: 30px;
	}

	.home {
		width: 100%;
		height: 400px;
	}

	.testimonial_box {
		min-width: 300px;
		background: #ffffff;
		border: 1px solid #eee;
		border-radius: 12px;
		padding: 20px;
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
		flex-shrink: 0;
	}

	.testimonial_image img {
		border: 3px solid #eee;
	}

	/* Scroll Animation */
	@keyframes scrollLeft {
		0% {
			transform: translateX(0);
		}

		100% {
			transform: translateX(-50%);
		}
	}

	/* Responsive */
	@media (max-width: 768px) {
		.testimonial_box {
			min-width: 250px;
			padding: 15px;
		}
	}

	@media (max-width: 480px) {
		.testimonial_box {
			min-width: 220px;
		}

		.home {
			width: 100%;
			height: 164px;
		}
	}

	.search-container {
		margin-right: 9px;
		width: 350px;
		background-color: white;

	}

	.property_search {
		width: 100%;
		height: 100%;
	}

	.bhkSelectBG {
		background-color: white;
		width: 200px;
	}

	.bhkSelect {
		width: 100%;
		height: 100%;
	}

	.bhkSelectBGBT {
		width: 136px;
	}



	.home_slider_background {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-repeat: no-repeat;
		background-size: 100% 100%;
		background-position: center center;
	}

	.feature_icon {
		width: 100%;
		height: 30%;
		margin-bottom: 10px;
		text-align: center;
	}

	.features {
		width: 100%;
		background: #F8F8F8;
		;
		padding-top: 0;
		padding-bottom: 103px;
	}

	.feature {
		width: 100%;
		padding-top: 30px;
		padding-bottom: 28px;
		padding-left: 15px;
		padding-right: 15px;
		background: #FFFFFF;
		border-radius: 10px;
	}

	.prodImage {
		height: 300px;
		border-radius: 10px;
	}

	.para {
		font-family: Tahoma, sans-serif;
		padding: 1rem;
		margin: 0 auto;
		font-weight: 500;
	}

	.service-card {
		transition: transform 0.3s ease, box-shadow 0.3s ease;
		background: #fff;
		border: 1px solid #014E79;
		border-radius: 15px;
		overflow: hidden;
		position: relative;
	}

	.service-card:hover {
		transform: translateY(-8px) scale(1.02);
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
	}

	.service-card i {
		transition: transform 0.4s ease, color 0.4s ease;
		display: inline-block;
		margin-bottom: 15px;
	}

	.service-card:hover i {
		transform: rotate(10deg) scale(1.2);
		color: #014E79;
		/* Bootstrap primary */
	}

	.para {
		font-size: 1.2rem;
		color: #444;
	}

	@media (max-width: 768px) {
		.features_row {
			margin-top: 18px;
		}
	}

	.carousel-control-next,
	.carousel-control-prev {
		position: absolute;
		top: 0;
		bottom: 0;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-align: center;
		align-items: center;
		-ms-flex-pack: center;
		justify-content: center;
		width: 15%;
		color: #fff;
		text-align: center;
		opacity: .5;
		background: transparent;
		border: none;
	}

	.carousel-control-next span:nth-child(2),
	.carousel-control-prev span:nth-child(2) {
		display: none;
	}

	.head1 a {
		font-weight: 600;
		font-size: 1.5rem;
	}
</style>

<div class="home">
	<div class="home_slider_container">

		<!-- Home Slider -->
		<div class="owl-carousel owl-theme home_slider">

			<!-- Home Slider Item -->
			<div class="owl-item">
				<div class="home_slider_background" style="background-image:url(split-img/1.jpeg)">
				</div>
				<div class="home_slider_content">
					<div class="container">
						<div class="row">
							<div class="col text-center">
								<div class="home_slider_title text-dark"></div>
								<div class="home_slider_form_container">
									<!-- <form action="#" id="home_5search_form_1"
										class="home_search_form d-flex flex-lg-row flex-column align-items-center justify-content-between">
										<div class="d-flex flex-row align-items-center justify-content-start">
											<div class="search-container" style="position: relative;">
												<input type="search" id="property_search" class="home_search_input property_search" placeholder="Enter Your Society or Building Name" required>
												<ul id="autocomplete-results" class="autocomplete-results"></ul>
											</div>
											<div class="bhkSelectBG">

												<select id="bhkSelect" class="dropdown_item_select bhkSelect home_search_input">
													<option value="">Select Floor Type</option>

												</select>
											</div>

											<div class="bhkSelectBGBT">

												<button type="submit" class="home_search_button">Search</button>
											</div>
										</div>
									</form> -->
								</div>
								<!-- <div class="d-grid my-4">

									<a href="#" id="openPopup" class="btn btn-primary" style="
						width: 300px;
						/* height: 500px; */
						text-align: center;
					">Check Manually</a>
								</div> -->
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Home Slider Nav -->
</div>

<!-- Start Here -->

<!-- Features -->

<div class="features p-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h2 class="section_title">Products</h2>
					<div class="section_subtitle">


					</div>
				</div>
			</div>
		</div>
		<?php
		$query = "SELECT * FROM products_item WHERE status='active' ORDER BY productID DESC LIMIT 6";
		$result = mysqli_query($conn, $query);
		?>

		<div class="row features_row">
			<?php while ($row = mysqli_fetch_assoc($result)): ?>
				<?php
				// handle multiple images safely
				$images = array_filter(explode(",", $row['product_image']));
				$carouselId = 'courseImageCarousel_' . $row['productID']; // unique ID for each carousel
				?>

				<div class="col-md-4 mb-4">
					<div class="card">
						<div class="course_image card shadow-sm">
							<div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
								<div class="carousel-inner">
									<?php foreach ($images as $index => $img): ?>
										<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
											<!-- ✅ Wrap the image in an anchor tag for Lightbox -->
											<a href="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
												data-lightbox="product-gallery-<?= $row['productID'] ?>"
												data-title="Product Image <?= $index + 1 ?>">
												<img
													style="height: 300px; object-fit: cover; width: 100%; cursor: zoom-in;"
													src="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
													data-magnify-src="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
													class="d-block magnify-img"
													alt="Product Image <?= $index + 1 ?>">
											</a>
										</div>
									<?php endforeach; ?>

								</div>

								<?php if (count($images) > 1): ?>
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
						</div>
						<div class="card-body">
							<div class="feature_text head1">
								<a href="product_detail.php?proId=<?php echo $row['productID']; ?>">
									<?php echo $row['product_name']; ?>
								</a>
							</div>

							<div class="feature_text">
								<p><?php echo substr($row['product_description'], 0, 50) . "..."; ?></p>
							</div>
							<div class="feature_text">
								<p>Price:- ₹ <?php echo $row['price']; ?></p>
							</div>


						</div>
					</div>

				</div>
			<?php endwhile; ?>
		</div>



		<!-- See All Button -->
		<div class="row mt-4">
			<div class="col text-center">
				<a href="product.php" class="btn btn-primary">See All</a>
			</div>
		</div>
	</div>
</div>



<div class="features p-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h2 class="section_title">Society</h2>
					<div class="section_subtitle">


					</div>
				</div>
			</div>
		</div>
		<?php


		$query = "SELECT * FROM products WHERE status='active' ORDER BY updated_on DESC LIMIT 6";
		$result = mysqli_query($conn, $query);
		?>

		<div class="row features_row">
			<?php while ($row = mysqli_fetch_assoc($result)): ?>
				<?php
				// get first image (comma separated handling)
				$images = explode(",", $row['product_image']);
				$img = "admin/uploads/products/" . trim($images[0]);
				?>
				<div class="col-lg-4 col-md-4 col-sm-6 feature_col">
					<div class="feature text-center trans_400">
						<div class="feature_icon text-center">
							<img src="<?php echo $img ?>" alt="<?php echo $row['product_name']; ?>" class="prodImage">
						</div>
						<h3 class="feature_title"><?php echo $row['product_name']; ?></h3>
						<div class="feature_text">
							<p><?php echo substr($row['product_description'], 0, 50) . "..."; ?></p>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>

		<!-- See All Button -->
		<div class="row mt-4">
			<div class="col text-center">
				<a href="#" class="btn btn-primary">See All</a>
			</div>
		</div>
	</div>
</div>
<!-- End Here -->

<!-- What we Do Section -->
<section class="services-section py-5 bg-light">
	<div class="container-fluid">
		<div class="row align-items-center text-center mb-4">
			<div class="col-md-12">
				<h2 class="fw-bold">What We Do?</h2>
			</div>
		</div>

		<div class="row g-4 text-center">
			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-tools fa-2x "></i>
					<p class="para">Splitfloor eases the flooring choices by providing a variety of pre-selected designs & well curated patterns.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-shipping-fast fa-2x "></i>
					<p class="para">Splitfloor simplifies the entire process, from removing old tiles to installing new ones.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-drafting-compass fa-2x "></i>
					<p class="para">Splitfloor offers layout plans for apartments and houses in residential to assist in budget planning.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-tools fa-2x "></i>
					<p class="para">Splitfloor streamlines the purchase of tiles and materials, eliminating hassle.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-sync-alt fa-2x "></i>
					<p class="para">Splitfloor handles the removal and reinstallation of fixtures & accessories.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-wrench fa-2x "></i>
					<p class="para">We provide essential plumbing and mechanical services tailored to your project needs.</p>
				</div>
			</div>
		</div>
	</div>
</section>




<section class="services-section py-5 bg-light">
	<div class="container-fluid">
		<div class="row align-items-center text-center mb-4">
			<div class="col-md-12">
				<h2 class="fw-bold">How It Works</h2>
			</div>
		</div>

		<div class="row g-4 text-center">
			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-globe fa-2x"></i>
					<h2 class="fw-bold mt-3">1. Open Website</h2>
					<p class="para">Locate your society, search your apartment.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-door-open fa-2x"></i>
					<h2 class="fw-bold mt-3">2. Select Room</h2>
					<p class="para">Choose your room, pick a design and add to basket.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-4">
				<div class="service-card p-4 h-100">
					<i class="fas fa-home fa-2x"></i>
					<h2 class="fw-bold mt-3">3. Renovation</h2>
					<p class="para">Experience a smooth, stress-free remodel.</p>
				</div>
			</div>
		</div>
	</div>
</section>



<!-- What we do section end -->


<!-- Counter -->


<!-- Events -->


<!-- Team -->



<!-- Latest News -->

<!-- Testimonials Start Here-->

<!-- End Here -->



<?php


?>
<?php include 'common/footer.php' ?>