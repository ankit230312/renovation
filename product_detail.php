	<?php


	include 'common/header.php';

	$proId = $_GET['proId'];
	$itemsQuery = "SELECT * FROM products_item WHERE status = 'active' AND productID = '$proId'";
	$itemsResult = mysqli_query($conn, $itemsQuery);
	$itemsData = mysqli_fetch_assoc($itemsResult);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.min.css">

	<style>
		.tab_panel {
			display: none !important;
			width: 100%;
			height: 100%;
			-webkit-animation: fadeEffect 1s;
			animation: fadeEffect 1s;
			border: solid 1px #ebebeb;
			padding-left: 30px;
			padding-right: 30px;
			padding-top: 20px;
			padding-bottom: 25px;
		}

		.tab_panel ul {
			list-style: disc;
		}

		.tab_panel h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-size: 30px;
			margin-bottom: 4%;
		}
	</style>


	<div class="course">
		<div class="container">
			<div class="row">

				<!-- Course -->
				<div class="col-lg-4 mt-5">
					<div class="course_container  mt-5">
						<!-- <div class="course_title"><?= $itemsData['product_name']; ?></div> -->

						<!-- Course Image -->
						<?php
						$productImages = explode(',', $itemsData['product_image']); // Assuming $itemsData is already fetched
						?>
						<div class="course_image">
							<div id="courseImageCarousel" class="carousel slide" data-bs-ride="carousel">
								<div class="carousel-inner">
									<?php foreach ($productImages as $index => $img): ?>
										<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
											<a href="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
												data-lightbox="product-gallery"
												data-title="Product Image <?= $index + 1 ?>">
												<img style="height: 300px; cursor: zoom-in;"
													src="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>"
													class="d-block w-100"
													alt="Product Image <?= $index + 1 ?>">
											</a>
										</div>
									<?php endforeach; ?>
								</div>

								<button class="carousel-control-prev" type="button" data-bs-target="#courseImageCarousel" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</button>
								<button class="carousel-control-next" type="button" data-bs-target="#courseImageCarousel" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</button>
							</div>
						</div>


						<!-- Course Tabs -->

					</div>
					<div class="row mt-5">
						<button class="btn btn-block btn-primary" onclick="sendId(<?= $proId ?>)">Add Item</button>
					</div>
				</div>

				<div class="col-md-8 mt-5" style="overflow-y: scroll; height: 900px; scrollbar-width: none; -ms-overflow-style: none;">

					<div class="course_title mt-5"><?= $itemsData['product_name']; ?></div>
					<div class="course_tabs_container">
						<div class="tabs d-flex flex-row align-items-center justify-content-start">
							<!-- <div class="tab active">description</div>
							<div class="tab">Feature</div>
							<div class="tab">Reviews</div> -->
						</div>
						<div class="tab_panels">

							<!-- Description -->
							<div class="tab_panel active">
								<?= html_entity_decode($itemsData['long_desc']); ?>

								<!-- <div class="row">
									<div class="col-md-12">
										<div class="tab_panel_title">Course Review</div>

									
										<div class="review_rating_container">
											<div class="review_rating">
												<div class="review_rating_num">4.5</div>
												<div class="review_rating_stars">
													<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
												</div>
												<div class="review_rating_text">(28 Ratings)</div>
											</div>
											<div class="review_rating_bars">
												<ul>
													<li><span>5 Star</span>
														<div class="review_rating_bar">
															<div style="width:90%;"></div>
														</div>
													</li>
													<li><span>4 Star</span>
														<div class="review_rating_bar">
															<div style="width:75%;"></div>
														</div>
													</li>
													<li><span>3 Star</span>
														<div class="review_rating_bar">
															<div style="width:32%;"></div>
														</div>
													</li>
													<li><span>2 Star</span>
														<div class="review_rating_bar">
															<div style="width:10%;"></div>
														</div>
													</li>
													<li><span>1 Star</span>
														<div class="review_rating_bar">
															<div style="width:3%;"></div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-md-12">
										<div class="tab_panel_faq">
											<div class="tab_panel_title">FAQ</div>

											
											<div class="accordions">

												<div class="elements_accordions">

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center active">
															<div>I'm not interested in the entire Specialization?</div>
														</div>
														<div class="accordion_panel">
															<p>Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.</p>
														</div>
													</div>

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center">
															<div>What is the refund policy?</div>
														</div>
														<div class="accordion_panel">
															<p>Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.</p>
														</div>
													</div>

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center">
															<div>What background knowledge is necessary?</div>
														</div>
														<div class="accordion_panel">
															<p>Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.</p>
														</div>
													</div>



												</div>

											</div>
										</div>
									</div>
								</div> -->
							</div>
						</div>




					</div>
				</div>
			</div>


		</div>
	</div>
	</div>






	<?php include 'common/footer.php'; ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/js/jquery.magnify.min.js"></script>
	<script>
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true,
			'alwaysShowNavOnTouchDevices': true
		})
	</script>
	<script>
		function sendId(proId) {
			window.location.href = `payment_temp.php?proId=${proId}`;
		}
	</script>