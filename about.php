<?php include 'common/header.php'; ?>

<style>
    .about {
  background: rgba(1, 78, 121, 0.1);
}

.section_title {
  font-size: 2.2rem;
  font-weight: 700;
  color: var(--primary-color, #333);
}

.section_subtitle p {
  font-size: 1rem;
  color: #555;
  line-height: 1.7;
}

.about_item {
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
  transition: all 0.4s ease;
  overflow: hidden;
  position: relative;
}

.about_item:hover {
  transform: translateY(-8px);
  box-shadow: 0 10px 30px rgba(102, 126, 234, 0.25);
}

.about_item_image img {
  transition: all 0.4s ease;
}

.about_item:hover img {
  transform: scale(1.05);
}

.about_item_title {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--primary-color, #333);
}

.about_item_text {
  font-size: 0.95rem;
  color: #666;
  line-height: 1.7;
}

/* Responsive Tweaks */
@media (max-width: 992px) {
  .section_title {
    font-size: 1.9rem;
  }
  .about_item {
    padding: 1.8rem;
  }
}

@media (max-width: 576px) {
  .section_title {
    font-size: 1.6rem;
  }
  .about_item_title {
    font-size: 1.15rem;
  }
  .about_item_text {
    font-size: 0.9rem;
  }
}

</style>

<!-- About -->

<div class="about py-5">
  <div class="container">
    <!-- Section Title -->
    <div class="row mb-4">
      <div class="col text-center">
        <h2 class="section_title mb-3">Welcome To Splitfloor</h2>
        <div class="section_subtitle mx-auto" style="max-width: 850px;">
          <p>
            <b> Splitfloor</b> offers comprehensive home renovation and upgrade solutions through
            its platform by providing pre-designed renovation and upgradation models. Additionally,
            we help customers obtain accurate cost estimates by offering detailed apartment layouts
            and maps — ensuring complete transparency and convenience.
          </p>
        </div>
      </div>
    </div>

    <!-- About Items -->
    <div class="row about_row g-4">
      <!-- About Item 1 -->
      <div class="col-lg-6 col-md-6">
        <div class="about_item text-center p-4 h-100">
          <div class="about_item_image mb-3">
            <img src="images/about_1.jpg" alt="About Splitfloor" class="img-fluid rounded-3 shadow-sm">
          </div>
          <h4 class="about_item_title mb-3">Mission</h4>
          <p class="about_item_text">
           <b>At Splitfloor</b> , our mission is to accelerate household renovations by delivering meticulously pre-curated design solutions that inspire and simplify the transformation process. We empower our customers with seamless budget estimation through an integrated platform featuring comprehensive layout data which ensure cost transparency and facilitate in swift & confident decision-making. 
          </p>
        </div>
      </div>

      <!-- About Item 2 -->
      <div class="col-lg-6 col-md-6">
        <div class="about_item text-center p-4 h-100">
          <div class="about_item_image mb-3">
            <img src="images/about_2.jpg" alt="Our Mission" class="img-fluid rounded-3 shadow-sm">
          </div>
          <h4 class="about_item_title mb-3">Vision</h4>
          <p class="about_item_text">
           <b>At Splitfloor</b>, we aspire to be the premier destination for homeowners embarking on renovation journeys. 
          </p>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- Feature -->

<!--<div class="feature">-->
<!--	<div class="feature_background" style="background-image:url(images/courses_background.jpg)"></div>-->
<!--	<div class="container">-->
<!--		<div class="row">-->
<!--			<div class="col">-->
<!--				<div class="section_title_container text-center">-->
<!--					<h2 class="section_title">Why Choose Us</h2>-->
<!--					<div class="section_subtitle">-->
<!--						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="row feature_row">-->

			<!-- Feature Content -->
<!--			<div class="col-lg-6 feature_col">-->
<!--				<div class="feature_content">-->
					<!-- Accordions -->
<!--					<div class="accordions">-->

<!--						<div class="elements_accordions">-->

<!--							<div class="accordion_container">-->
<!--								<div class="accordion d-flex flex-row align-items-center">-->
<!--									<div>Award for Best School 2017</div>-->
<!--								</div>-->
<!--								<div class="accordion_panel">-->
<!--									<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--								</div>-->
<!--							</div>-->

<!--							<div class="accordion_container">-->
<!--								<div class="accordion d-flex flex-row align-items-center active">-->
<!--									<div>You’re Split Floor from the best.</div>-->
<!--								</div>-->
<!--								<div class="accordion_panel">-->
<!--									<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--								</div>-->
<!--							</div>-->

<!--							<div class="accordion_container">-->
<!--								<div class="accordion d-flex flex-row align-items-center">-->
<!--									<div>Our degrees are recognized worldwide.</div>-->
<!--								</div>-->
<!--								<div class="accordion_panel">-->
<!--									<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--								</div>-->
<!--							</div>-->

<!--							<div class="accordion_container">-->
<!--								<div class="accordion d-flex flex-row align-items-center">-->
<!--									<div>We encourage our students to go global.</div>-->
<!--								</div>-->
<!--								<div class="accordion_panel">-->
<!--									<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--								</div>-->
<!--							</div>-->

<!--						</div>-->

<!--					</div>-->
					<!-- Accordions End -->
<!--				</div>-->
<!--			</div>-->

			<!-- Feature Video -->
<!--			<div class="col-lg-6 feature_col">-->
<!--				<div class="feature_video d-flex flex-column align-items-center justify-content-center">-->
<!--					<div class="feature_video_background" style="background-image:url(images/video.jpg)"></div>-->
<!--					<a class="vimeo feature_video_button" href="https://player.vimeo.com/video/99340873?title=0" title="OH, PORTUGAL - IN 4K - Basti Hansen - Stock Footage">-->
<!--						<img src="images/play.png" alt="">-->
<!--					</a>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->

<!-- Team -->

<!--<div class="team">-->
<!--	<div class="container">-->
<!--		<div class="row">-->
<!--			<div class="col">-->
<!--				<div class="section_title_container text-center">-->
<!--					<h2 class="section_title">The Best Tutors in Town</h2>-->
<!--					<div class="section_subtitle">-->
<!--						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="row team_row">-->

			<!-- Team Item -->
<!--			<div class="col-lg-3 col-md-6 team_col">-->
<!--				<div class="team_item">-->
<!--					<div class="team_image"><img src="images/team_1.jpg" alt=""></div>-->
<!--					<div class="team_body">-->
<!--						<div class="team_title"><a href="#">Jacke Masito</a></div>-->
<!--						<div class="team_subtitle">Marketing & Management</div>-->
<!--						<div class="social_list">-->
<!--							<ul>-->
<!--								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
<!--							</ul>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->

			<!-- Team Item -->
<!--			<div class="col-lg-3 col-md-6 team_col">-->
<!--				<div class="team_item">-->
<!--					<div class="team_image"><img src="images/team_2.jpg" alt=""></div>-->
<!--					<div class="team_body">-->
<!--						<div class="team_title"><a href="#">William James</a></div>-->
<!--						<div class="team_subtitle">Designer & Website</div>-->
<!--						<div class="social_list">-->
<!--							<ul>-->
<!--								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
<!--							</ul>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->

			<!-- Team Item -->
<!--			<div class="col-lg-3 col-md-6 team_col">-->
<!--				<div class="team_item">-->
<!--					<div class="team_image"><img src="images/team_3.jpg" alt=""></div>-->
<!--					<div class="team_body">-->
<!--						<div class="team_title"><a href="#">John Tyler</a></div>-->
<!--						<div class="team_subtitle">Quantum mechanics</div>-->
<!--						<div class="social_list">-->
<!--							<ul>-->
<!--								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
<!--							</ul>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->

			<!-- Team Item -->
<!--			<div class="col-lg-3 col-md-6 team_col">-->
<!--				<div class="team_item">-->
<!--					<div class="team_image"><img src="images/team_4.jpg" alt=""></div>-->
<!--					<div class="team_body">-->
<!--						<div class="team_title"><a href="#">Veronica Vahn</a></div>-->
<!--						<div class="team_subtitle">Math & Physics</div>-->
<!--						<div class="social_list">-->
<!--							<ul>-->
<!--								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>-->
<!--								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
<!--							</ul>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->

<!--		</div>-->
<!--	</div>-->
<!--</div>-->

<!-- Counter -->

<!--<div class="counter">-->
<!--	<div class="counter_background" style="background-image:url(images/counter_background.jpg)"></div>-->
<!--	<div class="container">-->
<!--		<div class="row">-->
<!--			<div class="col-lg-6">-->
<!--				<div class="counter_content">-->
<!--					<h2 class="counter_title">Register Now</h2>-->
<!--					<div class="counter_text">-->
<!--						<p>Simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dumy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
<!--					</div>-->

					<!-- Milestones -->

<!--					<div class="milestones d-flex flex-md-row flex-column align-items-center justify-content-between">-->

						<!-- Milestone -->
<!--						<div class="milestone">-->
<!--							<div class="milestone_counter" data-end-value="15">0</div>-->
<!--							<div class="milestone_text">years</div>-->
<!--						</div>-->

						<!-- Milestone -->
<!--						<div class="milestone">-->
<!--							<div class="milestone_counter" data-end-value="120" data-sign-after="k">0</div>-->
<!--							<div class="milestone_text">years</div>-->
<!--						</div>-->

						<!-- Milestone -->
<!--						<div class="milestone">-->
<!--							<div class="milestone_counter" data-end-value="670" data-sign-after="+">0</div>-->
<!--							<div class="milestone_text">years</div>-->
<!--						</div>-->

						<!-- Milestone -->
<!--						<div class="milestone">-->
<!--							<div class="milestone_counter" data-end-value="320">0</div>-->
<!--							<div class="milestone_text">years</div>-->
<!--						</div>-->

<!--					</div>-->
<!--				</div>-->

<!--			</div>-->
<!--		</div>-->

<!--		<div class="counter_form">-->
<!--			<div class="row fill_height">-->
<!--				<div class="col fill_height">-->
<!--					<form class="counter_form_content d-flex flex-column align-items-center justify-content-center" action="#">-->
<!--						<div class="counter_form_title">courses now</div>-->
<!--						<input type="text" class="counter_input" placeholder="Your Name:" required="required">-->
<!--						<input type="tel" class="counter_input" placeholder="Phone:" required="required">-->
<!--						<select name="counter_select" id="counter_select" class="counter_input counter_options">-->
<!--							<option>Choose Subject</option>-->
<!--							<option>Subject</option>-->
<!--							<option>Subject</option>-->
<!--							<option>Subject</option>-->
<!--						</select>-->
<!--						<textarea class="counter_input counter_text_input" placeholder="Message:" required="required"></textarea>-->
<!--						<button type="submit" class="counter_form_button">submit now</button>-->
<!--					</form>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->

<!--	</div>-->
<!--</div>-->

<!-- Partners -->

<!--<div class="partners">-->
<!--	<div class="container">-->
<!--		<div class="row">-->
<!--			<div class="col">-->
<!--				<div class="partners_slider_container">-->
<!--					<div class="owl-carousel owl-theme partners_slider">-->

						<!-- Partner Item -->
<!--						<div class="owl-item partner_item"><img src="images/partner_1.png" alt=""></div>-->

						<!-- Partner Item -->
<!--						<div class="owl-item partner_item"><img src="images/partner_2.png" alt=""></div>-->

						<!-- Partner Item -->
<!--						<div class="owl-item partner_item"><img src="images/partner_3.png" alt=""></div>-->

						<!-- Partner Item -->
<!--						<div class="owl-item partner_item"><img src="images/partner_4.png" alt=""></div>-->

						<!-- Partner Item -->
<!--						<div class="owl-item partner_item"><img src="images/partner_5.png" alt=""></div>-->

						<!-- Partner Item -->
<!--						<div class="owl-item partner_item"><img src="images/partner_6.png" alt=""></div>-->

<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->

<!-- Footer -->
<?php include 'common/footer.php'; ?>