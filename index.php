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
				<!-- <div class="home_slider_background" style="background-image:url(split-img//banner.png)"> -->
				<div class="home_slider_background" style="">
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
												<input type="search" id="property_search"  class="home_search_input property_search" placeholder="Enter Your Society or Building Name" required>
												<ul id="autocomplete-results" class="autocomplete-results"></ul>
											</div>
											<select class="dropdown_item_select home_search_input">
												<!-- <option>Select BHK</option>
												<option>1 BHK</option>
												<option>2 BHK</option>
												<option>3 BHK</option>
												<option>4 BHK</option>
												<option>Penthouse Or Villa</option> -->
											</select>
											<button type="submit" class="home_search_button">Search</button>
										</div>
									</form>
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
<div class="features">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h2 class="section_title">Welcome to Splitfloor</h2>
					<div class="section_subtitle">
						<p>Pre finalized trending designs & combination of tiles by leading Architects.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="auto-scroll-wrapper">
			<div class="scroll-content">
				<!-- Repeatable Feature Section -->
				<div class="feature-item text-center">
					<img src="images/icon_1.png" alt="Bathroom" class="feature_icon">
					<h3 class="feature_title">Bathroom</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
				<div class="feature-item text-center">
					<img src="images/icon_2.png" alt="Kitchen" class="feature_icon">
					<h3 class="feature_title">Kitchen</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
				<div class="feature-item text-center">
					<img src="images/icon_3.png" alt="Bedroom" class="feature_icon">
					<h3 class="feature_title">Bedroom</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
				<div class="feature-item text-center">
					<img src="images/icon_4.png" alt="Living Room" class="feature_icon">
					<h3 class="feature_title">Living Room</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>

				<!-- Duplicate for infinite loop effect -->
				<div class="feature-item text-center">
					<img src="images/icon_1.png" alt="Bathroom" class="feature_icon">
					<h3 class="feature_title">Bathroom</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
				<div class="feature-item text-center">
					<img src="images/icon_2.png" alt="Kitchen" class="feature_icon">
					<h3 class="feature_title">Kitchen</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
				<div class="feature-item text-center">
					<img src="images/icon_3.png" alt="Bedroom" class="feature_icon">
					<h3 class="feature_title">Bedroom</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
				<div class="feature-item text-center">
					<img src="images/icon_4.png" alt="Living Room" class="feature_icon">
					<h3 class="feature_title">Living Room</h3>
					<!--<p class="feature_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- End Here -->

<!-- Popular Courses -->

<div class="courses">
	<div class="section_background parallax-window" data-parallax="scroll" data-image-src="images/courses_background.jpg" data-speed="0.8"></div>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h3 class="section_title">Popular Packages | Trending Designs</h3>
					<div class="section_subtitle">
						<p>No decision or selection fatigue to customer.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row courses_row">

			<!-- Course -->
			<div class="col-lg-4 course_col">
				<div class="course">
					<div class="course_image"><img src="split-img/bathroom.jpeg" alt="Bathroom"></div>
					<div class="course_body">
						<h3 class="course_title"><a href="course.php">Software Training</a></h3>
						<div class="course_teacher">Mr. John Taylor</div>
						<div class="course_text">
							<p>Lorem ipsum dolor sit amet, consectetur adipi elitsed do eiusmod tempor</p>
						</div>
					</div>
					<div class="course_footer">
						<div class="course_footer_content d-flex flex-row align-items-center justify-content-start">
							<div class="course_price"><button type="button" class="btn btn-primary">Read More</button></div>
							<div class="course_price ml-auto"><button type="button" class="btn btn-primary">Book Now</button></div>
						</div>
					</div>
				</div>
			</div>

			<!-- Course -->
			<div class="col-lg-4 course_col">
				<div class="course">
					<div class="course_image"><img src="split-img/bathroom-1.jpeg" alt="bathroom-1"></div>
					<div class="course_body">
						<h3 class="course_title"><a href="course.php">Developing Mobile Apps</a></h3>
						<div class="course_teacher">Ms. Lucius</div>
						<div class="course_text">
							<p>Lorem ipsum dolor sit amet, consectetur adipi elitsed do eiusmod tempor</p>
						</div>
					</div>
					<div class="course_footer">
						<div class="course_footer_content d-flex flex-row align-items-center justify-content-start">
							<div class="course_price"><button type="button" class="btn btn-primary">Read More</button></div>
							<div class="course_price ml-auto"><button type="button" class="btn btn-primary">Book Now</button></div>
						</div>
					</div>
				</div>
			</div>

			<!-- Course -->
			<div class="col-lg-4 course_col">
				<div class="course">
					<div class="course_image"><img src="split-img/bathroom.jpeg" alt="bathroom"></div>
					<div class="course_body">
						<h3 class="course_title"><a href="course.php">Starting a Startup</a></h3>
						<div class="course_teacher">Mr. Charles</div>
						<div class="course_text">
							<p>Lorem ipsum dolor sit amet, consectetur adipi elitsed do eiusmod tempor</p>
						</div>
					</div>
					<div class="course_footer">
						<div class="course_footer_content d-flex flex-row">
							<div class="course_price"><button type="button" class="btn btn-primary">Read More</button></div>
							<div class="course_price ml-auto"><button type="button" class="btn btn-primary">Book Now</button></div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Counter -->

<div class="counter">
	<div class="counter_background" style="background-image:url(images/counter_background.jpg)"></div>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="counter_content">
					<h2 class="counter_title">Why Choose Us!</h2>
					<div class="counter_text">
						<p>Simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dumy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
					</div>

					<!-- Milestones -->

					<div class="milestones d-flex flex-md-row flex-column align-items-center justify-content-between">

						<!-- Milestone -->
						<div class="milestone">
							<div class="milestone_counter" data-end-value="15">0</div>
							<div class="milestone_text">years</div>
						</div>

						<!-- Milestone -->
						<div class="milestone">
							<div class="milestone_counter" data-end-value="120" data-sign-after="k">0</div>
							<div class="milestone_text">years</div>
						</div>

						<!-- Milestone -->
						<div class="milestone">
							<div class="milestone_counter" data-end-value="670" data-sign-after="+">0</div>
							<div class="milestone_text">years</div>
						</div>

						<!-- Milestone -->
						<div class="milestone">
							<div class="milestone_counter" data-end-value="320">0</div>
							<div class="milestone_text">years</div>
						</div>

					</div>
				</div>

			</div>
		</div>

		<div class="counter_form">
			<div class="row fill_height">
				<div class="col fill_height">
					<form class="counter_form_content d-flex flex-column align-items-center justify-content-center" action="#">
						<div class="counter_form_title">Enquire now</div>
						<input type="text" class="counter_input" placeholder="Your Name:" required="required">
						<input type="tel" class="counter_input" placeholder="Phone:" required="required">
						<select name="counter_select" id="counter_select" class="counter_input counter_options">
							<option>Choose Subject</option>
							<option>Subject</option>
							<option>Subject</option>
							<option>Subject</option>
						</select>
						<textarea class="counter_input counter_text_input" placeholder="Message:" required="required"></textarea>
						<button type="submit" class="counter_form_button">submit now</button>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- Events -->

<div class="events">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h2 class="section_title">Upcoming SplitFloor <br> Designs & Features!</h2>
					<div class="section_subtitle">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row events_row">

			<!-- Event -->
			<div class="col-lg-4 event_col">
				<div class="event event_left">
					<div class="event_image"><img src="images/event_1.jpg" alt=""></div>
					<div class="event_body d-flex flex-row align-items-start justify-content-start">
						<div class="event_date">
							<div class="d-flex flex-column align-items-center justify-content-center trans_200">
								<div class="event_day trans_200">21</div>
								<div class="event_month trans_200">Aug</div>
							</div>
						</div>
						<div class="event_content">
							<div class="event_title"><a href="#">Which Country Handles Student Debt?</a></div>
							<div class="event_info_container">
								<div class="event_info"><i class="fa fa-clock-o" aria-hidden="true"></i><span>15.00 - 19.30</span></div>
								<div class="event_info"><i class="fa fa-map-marker" aria-hidden="true"></i><span>25 New York City</span></div>
								<div class="event_text">
									<p>Policy analysts generally agree on a need for reform, but not on which path...</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Event -->
			<div class="col-lg-4 event_col">
				<div class="event event_mid">
					<div class="event_image"><img src="images/event_2.jpg" alt=""></div>
					<div class="event_body d-flex flex-row align-items-start justify-content-start">
						<div class="event_date">
							<div class="d-flex flex-column align-items-center justify-content-center trans_200">
								<div class="event_day trans_200">27</div>
								<div class="event_month trans_200">Aug</div>
							</div>
						</div>
						<div class="event_content">
							<div class="event_title"><a href="#">Repaying your student loans (Winter 2017-2018)</a></div>
							<div class="event_info_container">
								<div class="event_info"><i class="fa fa-clock-o" aria-hidden="true"></i><span>09.00 - 17.30</span></div>
								<div class="event_info"><i class="fa fa-map-marker" aria-hidden="true"></i><span>25 Brooklyn City</span></div>
								<div class="event_text">
									<p>This Consumer Action News issue covers topics now being debated before...</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Event -->
			<div class="col-lg-4 event_col">
				<div class="event event_right">
					<div class="event_image"><img src="images/event_3.jpg" alt=""></div>
					<div class="event_body d-flex flex-row align-items-start justify-content-start">
						<div class="event_date">
							<div class="d-flex flex-column align-items-center justify-content-center trans_200">
								<div class="event_day trans_200">01</div>
								<div class="event_month trans_200">Sep</div>
							</div>
						</div>
						<div class="event_content">
							<div class="event_title"><a href="#">Alternative data and financial inclusion</a></div>
							<div class="event_info_container">
								<div class="event_info"><i class="fa fa-clock-o" aria-hidden="true"></i><span>13.00 - 18.30</span></div>
								<div class="event_info"><i class="fa fa-map-marker" aria-hidden="true"></i><span>25 New York City</span></div>
								<div class="event_text">
									<p>Policy analysts generally agree on a need for reform, but not on which path...</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Team -->

<div class="team">
	<div class="team_background parallax-window" data-parallax="scroll" data-image-src="images/team_background.jpg" data-speed="0.8"></div>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h2 class="section_title">SplitFloor Teams</h2>
					<div class="section_subtitle">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row team_row">

			<!-- Team Item -->
			<div class="col-lg-3 col-md-6 team_col">
				<div class="team_item">
					<div class="team_image"><img src="images/team_1.jpg" alt=""></div>
					<div class="team_body">
						<div class="team_title"><a href="#">Jacke Masito</a></div>
						<div class="team_subtitle">Marketing & Management</div>
						<div class="social_list">
							<ul>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Team Item -->
			<div class="col-lg-3 col-md-6 team_col">
				<div class="team_item">
					<div class="team_image"><img src="images/team_2.jpg" alt=""></div>
					<div class="team_body">
						<div class="team_title"><a href="#">William James</a></div>
						<div class="team_subtitle">Designer & Website</div>
						<div class="social_list">
							<ul>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Team Item -->
			<div class="col-lg-3 col-md-6 team_col">
				<div class="team_item">
					<div class="team_image"><img src="images/team_3.jpg" alt=""></div>
					<div class="team_body">
						<div class="team_title"><a href="#">John Tyler</a></div>
						<div class="team_subtitle">Quantum mechanics</div>
						<div class="social_list">
							<ul>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Team Item -->
			<div class="col-lg-3 col-md-6 team_col">
				<div class="team_item">
					<div class="team_image"><img src="images/team_4.jpg" alt=""></div>
					<div class="team_body">
						<div class="team_title"><a href="#">Veronica Vahn</a></div>
						<div class="team_subtitle">Math & Physics</div>
						<div class="social_list">
							<ul>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Latest News -->

<!-- Testimonials Start Here-->
<div class="testimonials">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<div class="section_title_container">
					<h2 class="section_title">What Our Customers Say!</h2>
					<div class="section_subtitle">
						<p>Hear from real people who transformed their homes with SplitFloor’s renovation services.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="testimonial_scroll_wrapper">
			<div class="testimonial_scroll_content">
				<!-- Testimonial 1 -->
				<div class="testimonial_box p-4 text-center shadow-sm rounded bg-white">
					<div class="testimonial_image mb-3">
						<img src="split-img/testimonial.jpeg" alt="User 1" class="rounded-circle" width="80">
					</div>
					<h5 class="mb-1">Rohit Sharma</h5>
					<p class="text-muted">Mumbai</p>
					<p class="testimonial_text">"SplitFloor gave our kitchen a complete makeover. The team was professional, on-time, and highly skilled."</p>
				</div>

				<!-- Testimonial 2 -->
				<div class="testimonial_box p-4 text-center shadow-sm rounded bg-white">
					<div class="testimonial_image mb-3">
						<img src="split-img/testimonial.jpeg" alt="User 2" class="rounded-circle" width="80">
					</div>
					<h5 class="mb-1">Ananya Verma</h5>
					<p class="text-muted">Delhi</p>
					<p class="testimonial_text">"Absolutely loved how they redesigned our bathroom! Affordable and elegant results. Highly recommend."</p>
				</div>

				<!-- Testimonial 3 -->
				<div class="testimonial_box p-4 text-center shadow-sm rounded bg-white">
					<div class="testimonial_image mb-3">
						<img src="split-img/testimonial.jpeg" alt="User 3" class="rounded-circle" width="80">
					</div>
					<h5 class="mb-1">Nikhil Patel</h5>
					<p class="text-muted">Ahmedabad</p>
					<p class="testimonial_text">"I was impressed by their professionalism and attention to detail. My living room looks stunning now."</p>
				</div>

				<!-- Duplicate again for smooth endless scroll -->
				<div class="testimonial_box p-4 text-center shadow-sm rounded bg-white">
					<div class="testimonial_image mb-3">
						<img src="split-img/testimonial.jpeg" alt="User 1" class="rounded-circle" width="80">
					</div>
					<h5 class="mb-1">Rohit Sharma</h5>
					<p class="text-muted">Mumbai</p>
					<p class="testimonial_text">"SplitFloor gave our kitchen a complete makeover. The team was professional, on-time, and highly skilled."</p>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- End Here -->



<?php


?>
<?php include 'common/footer.php' ?>