	<?php


	include 'common/header.php';

	$proId = $_GET['proId'];
	$itemsQuery = "SELECT * FROM products_item WHERE status = 'active' AND productID = '$proId'";
	$itemsResult = mysqli_query($conn, $itemsQuery);
	$itemsData = mysqli_fetch_assoc($itemsResult);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.min.css">


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
						<button class="btn btn-block btn-primary"> Add Item </button>
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
								<div class="tab_panel_title">Item</div>
								<div class="tab_panel_content">
									<div class="tab_panel_text">
										<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosquad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Lorem Ipsn gravida nibh vel velit auctor aliquet. Class aptent taciti sociosquad litora torquent per conubia nostra, per inceptos himenaeos.</p>
									</div>
									<div class="tab_panel_section">
										<div class="tab_panel_subtitle">Requirements</div>
										<ul class="tab_panel_bullets">
											<li>Lorem Ipsn gravida nibh vel velit auctor aliquet. Class aptent taciti sociosquad litora torquent.</li>
											<li>Cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a.</li>
											<li>Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat.</li>
											<li>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</li>
										</ul>
									</div>
									<div class="tab_panel_section">
										<div class="tab_panel_subtitle">What is the target audience?</div>
										<div class="tab_panel_text">
											<p>This course is intended for anyone interested in learning to master his or her own body.This course is aimed at beginners, so no previous experience with hand balancing skillts is necessary Aenean viverra tincidunt nibh, in imperdiet nunc. Suspendisse eu ante pretium, consectetur leo at, congue quam. Nullam hendrerit porta ante vitae tristique. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>
										</div>
									</div>



									<div class="row">
										<div class="col-md-12">
											<div class="tab_panel_title">Course Review</div>

											<!-- Rating -->
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

												<!-- Accordions -->
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
									</div>
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
