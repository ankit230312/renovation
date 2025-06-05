<div class="newsletter">
	<div class="newsletter_background parallax-window" data-parallax="scroll"
		data-image-src="images/newsletter.jpg" data-speed="0.8"></div>
	<div class="container">
		<div class="row">
			<div class="col">
				<div
					class="newsletter_container d-flex flex-lg-row flex-column align-items-center justify-content-start">

					<!-- Newsletter Content -->
					<div class="newsletter_content text-lg-left text-center">
						<div class="newsletter_title">sign up for news and offers</div>
						<div class="newsletter_subtitle">Subcribe to lastest smartphones news & great deals we
							offer</div>
					</div>

					<!-- Newsletter Form -->
					<div class="newsletter_form_container ml-lg-auto">
						<form action="#" id="newsletter_form"
							class="newsletter_form d-flex flex-row align-items-center justify-content-center">
							<input type="email" class="newsletter_input" placeholder="Your Email"
								required="required">
							<button type="submit" class="newsletter_button">subscribe</button>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Footer -->

<footer class="footer">
	<div class="footer_background" style="background-image:url(images/footer_background.png)"></div>
	<div class="container">
		<div class="row footer_row">
			<div class="col">
				<div class="footer_content">
					<div class="row">

						<div class="col-lg-3 footer_col">

							<!-- Footer About -->
							<div class="footer_section footer_about">
								<div class="footer_logo_container">
									<a href="index.php">
										<div class="logo_text">
											<img src="split-img/logo.jpg" width="200" alt="Header Logo" title="Header Logo">
										</div>
									</a>
								</div>
								<div class="footer_about_text">
									<p>Lorem ipsum dolor sit ametium, consectetur adipiscing elit.</p>
								</div>
								<div class="footer_social">
									<ul>
										<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
										</li>
										<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
										</li>
										<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
										</li>
										<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
										</li>
									</ul>
								</div>
							</div>

						</div>

						<div class="col-lg-3 footer_col">

							<!-- Footer Contact -->
							<div class="footer_section footer_contact">
								<div class="footer_title">Contact Us</div>
								<div class="footer_contact_info">
									<ul>
										<li>Email: info.splitfloor@gmail.com</li>
										<li>Phone: +(88) 111 555 666</li>
										<li>40 Baria Sreet 133/2 New York City, United States</li>
									</ul>
								</div>
							</div>

						</div>

						<div class="col-lg-3 footer_col">

							<!-- Footer links -->
							<div class="footer_section footer_links">
								<div class="footer_title">Contact Us</div>
								<div class="footer_links_container">
									<ul>
										<li><a href="index.php">Home</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="courses.php">Services</a></li>
										<li><a href="faqs.php">FAQs</a></li>
									</ul>
								</div>
							</div>

						</div>

						<div class="col-lg-3 footer_col clearfix">

							<!-- Footer links -->
							<div class="footer_section footer_mobile">
								<div class="footer_title">Payment Gateway</div>
								<div class="footer_mobile_content">
									<div class="footer_image">
										<a href="#">
											<img src="images/mobile_1.png" alt="">
										</a>
									</div>
									<div class="footer_image">
										<a href="#">
											<img src="images/mobile_2.png" alt="">
										</a>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row copyright_row">
			<div class="col">
				<div class="copyright d-flex flex-lg-row flex-column align-items-center justify-content-start">
					<div class="cr_text">
						Copyright &copy;
						<script>
							document.write(new Date().getFullYear());
						</script> All rights reserved | Designed <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
							href="https://saurabhcreative.in" target="_blank">SaurabhCreative</a>
					</div>
					<div class="ml-lg-auto cr_links">
						<ul class="cr_list">
							<li><a href="#">FAQs</a></li>
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>


</footer>

<!-- <div class="custom_grid">
	<div class="inner_block">
		<a href="#" id="openPopup">Check Manually</a>
	</div>
</div> -->

<div class="popu_up" id="popupOverlay">
	<div class="popup_content">
		<span class="close_btn" id="closePopup">&times;</span>
		<h2>Product List</h2>
		<p>Here are the products...</p>

		<form id="dimensionForm">
			<label for="length1">Length 1:</label><br />
			<input type="number" id="length1" name="length1" required><br />

			<label for="breadth1">Breadth 1:</label><br />
			<input type="number" id="breadth1" name="breadth1" required><br />

			<button type="submit">Submit</button>
		</form>
	</div>
</div>


<div class="card_pop_overlay" id="cardOverlay" style="display: none;">
	<div class="card_pop">
		<div class="card_item">
			<img src="https://placehold.co/300x130" alt="Card 1 Image" class="card_img">
			<h3>Tiles 1</h3>
			<p>Price :- 300/PC</p>
			<button>Explore</button>
		</div>

		<div class="card_item">
			<img src="https://placehold.co/300x130" alt="Card 2 Image" class="card_img">
			<h3>Tiles 2</h3>
			<p>Price :- 340/PC</p>
			<button>Explore</button>
		</div>

		<div class="card_item">
			<img src="https://placehold.co/300x130" alt="Card 3 Image" class="card_img">
			<h3>Tiles 3</h3>
			<p>Price :- 370/PC.</p>
			<button>Explore</button>
		</div>
	</div>
</div>






</div>



<?php if ($page === 'index'): ?>
	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="plugins/greensock/TweenMax.min.js"></script>
	<script src="plugins/greensock/TimelineMax.min.js"></script>
	<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
	<script src="plugins/greensock/animation.gsap.min.js"></script>
	<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="js/custom.js"></script>
<?php endif; ?>

<?php if ($page === 'blog'): ?>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/masonry/masonry.js"></script>
	<script src="plugins/video-js/video.min.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="js/blog.js"></script>
<?php endif; ?>



<?php
if ($page == 'course'): ?>
	<!-- 
<script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<script src="js/course.js"></script>

<?php endif; ?>

<?php
if ($page == 'course1'): ?>
	<!-- 
<script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<script src="js/course.js"></script>

<?php endif; ?>

<?php
if ($page == 'product'): ?>

	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<script src="js/courses.js"></script>

<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="custom_js.js"></script>
<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 30,
    loop: false,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: { slidesPerView: 2 },
      480: { slidesPerView: 1 }
    }
  });
</script>



</body>

</html>