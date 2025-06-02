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
	}
</style>

<div class="home">
	<div class="home_slider_container">

		<!-- Home Slider -->
		<div class="owl-carousel owl-theme home_slider">

			<!-- Home Slider Item -->
			<div class="owl-item">
				<div class="home_slider_background" style="background-image:url(split-img/default-post-img.jpg)">
				</div>
				<div class="home_slider_content">
					<div class="container">
						<div class="row">
							<div class="col text-center">
								<div class="home_slider_title text-dark"></div>
								<div class="home_slider_form_container">
									<form action="#" id="home_5search_form_1"
										class="home_search_form d-flex flex-lg-row flex-column align-items-center justify-content-between">
										<div class="d-flex flex-row align-items-center justify-content-start">
											<div class="search-container" style="position: relative;">
												<input type="search" id="property_search" class="home_search_input property_search" placeholder="Enter Your Society or Building Name" required>
												<ul id="autocomplete-results" class="autocomplete-results"></ul>
											</div>
											<select id="bhkSelect" class="dropdown_item_select bhkSelect home_search_input">
												<option value="">Select BHK</option>
												<option value="course.php">TYPE A 1100 SQFT (2BHK + 2T)</option>
												<option value="course1.php">TYPE B 1290 SQFT (2BHK + 2T + STUDY)</option>
												<option value="course2.php">TYPE C 1545 SQFT (3BHK + 2T + POOJA)</option>
												<option value="course3.php">TYPE D 1715 SQFT (3BHK + 3T + POOJA)</option>
											</select>
											<button type="submit" class="home_search_button">Search</button>
										</div>
									</form>
								</div>
								<div class="d-grid my-4">

									<a href="#" id="openPopup" class="btn btn-primary">Check Manually</a>
								</div>
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


<!-- End Here -->

<!-- Popular Courses -->



<!-- Counter -->


<!-- Events -->


<!-- Team -->



<!-- Latest News -->

<!-- Testimonials Start Here-->

<!-- End Here -->



<?php


?>
<?php include 'common/footer.php' ?>