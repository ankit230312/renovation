<style>
	.social-icons {
		display: flex;
		gap: 10px;
		padding: 10px;
	}

	.social-icons a {
		color: #fff;
		/* Default icon color */
		font-size: 24px;
		/* Size of the icons */
		transition: color 0.3s ease;
		/* Smooth transition for color change */
	}

	.social-icons a:hover {
		color: #0077b5;
		/* Change color on hover (for example, LinkedIn blue) */
	}
</style>

<!-- Footer -->
<footer>
	<!-- Call-to-action bar -->
	<!--<div class="cta-bar">-->
	<!--	<div class="cta-text">Take good design today</div>-->
	<!--	<div class="cta-action">-->
	<!--		<span>Let's do it! —</span>-->
	<!--		<a href="#" class="btn">Get started</a>-->
	<!--	</div>-->
	<!--</div>-->

	<!-- Main footer -->
	<div class="footer-main">
		<!-- Logo -->
		<div class="footer-logo">
			<div class="row">
				<div class="col-md-12">
					<img src="split-img/Logo.png" alt="Site Logo">
				</div>
				<div class="col-md-12">
					<p class="text-white" style="text-align: justify;">
						Splitfloor offers a wide variety of renovation and upgradation options designed specifically for individual rooms in homes.
					</p>
				</div>
			</div>


		</div>

		<!-- Use Cases -->
		<div class="footer-column">
			<h4>Quick Links</h4>
			<ul>
				<li><a href="product.php">Our Products</a></li>
				<li><a href="index.php">Home</a></li>
				<li><a href="about.php">About Us</a></li>
				<li><a href="contact.php">Contact Us</a></li>
			</ul>
		</div>

		<!-- Company -->
		<div class="footer-column">
			<h4>Company</h4>
			<ul>
				<li><a href="partner-with-us.php">Partner With Us</a></li>
				<li><a href="#">Careers</a></li>
				<li><a href="#">FAQs</a></li>
			</ul>
		</div>

		<!-- Social & Subscribe -->
		<div class="footer-column">
			<h4>Let's do it!</h4>
			<div class="social-icons">
				<a href="https://m.facebook.com/61580851442530/" target="_blank"><i class="fab fa-facebook"></i></a>
				<a href="https://x.com/splitfloor?s=11" target="_blank"><i class="fab fa-twitter"></i></a>
				<a href="https://www.instagram.com/imsplitfloor/" target="_blank"><i class="fab fa-instagram"></i></a>
				<a href="https://www.linkedin.com/company/splitfloor/" target="_blank"><i class="fab fa-linkedin"></i></a>
			</div>
		</div>
	</div>

	<!-- Bottom bar -->
	<div class="footer-bottom">
		<div class="footer-links">
			<a href="#">Privacy Policy</a>
			<a href="#">Terms of Use</a>

			<a href="#">Site Map</a>
		</div>
		<div class="footer-copy">
			© 2025 All Rights Reserved
		</div>
	</div>
</footer>


</div>



<?php if ($page === 'index' || $page == 'splitfloor'  || $page == 'temp' || $page == 'payment'): ?>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
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
if ($page == 'course' || $page == 'product_detail' || $page == 'payment_temp'): ?>
	<!-- 
<script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>

	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script> -->
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
if ($page == 'product' || $page == 'glass'): ?>

	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<script src="js/courses.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<?php endif; ?>

<?php if ($page == 'about'): ?>

	<script src="js/jquery-3.2.1.min.js"></script>
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
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<script src="js/about.js"></script>
<?php endif; ?>


<?php if ($page == 'contact'): ?>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
	<script src="plugins/marker_with_label/marker_with_label.js"></script>
	<script src="js/contact.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
			768: {
				slidesPerView: 2
			},
			480: {
				slidesPerView: 1
			}
		}
	});


	$('.home_slider').owlCarousel({
		loop: false,
		rewind: false,
		items: 1
	});
</script>

<script>
	if ("serviceWorker" in navigator) {
		window.addEventListener("load", function() {
			navigator.serviceWorker
				.register("/splitfloor/service-worker.js")
				.then(reg => console.log("Service Worker registered", reg))
				.catch(err => console.log("Service Worker failed", err));
		});
	}
</script>

</body>

</html>