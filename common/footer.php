<!-- Footer -->
<footer>
	<!-- Call-to-action bar -->
	<div class="cta-bar">
		<div class="cta-text">Take good design today</div>
		<div class="cta-action">
			<span>Let's do it! —</span>
			<a href="#" class="btn">Get started</a>
		</div>
	</div>

	<!-- Main footer -->
	<div class="footer-main">
		<!-- Logo -->
		<div class="footer-logo">
			<img src="split-img/Logo.png" alt="Site Logo">
			
		</div>

		<!-- Use Cases -->
		<div class="footer-column">
			<h4>Use Cases</h4>
			<ul>
				<li><a href="#">Web-designers</a></li>
				<li><a href="#">Marketers</a></li>
				<li><a href="#">Small Business</a></li>
				<li><a href="#">Website Builder</a></li>
			</ul>
		</div>

		<!-- Company -->
		<div class="footer-column">
			<h4>Company</h4>
			<ul>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Careers</a></li>
				<li><a href="#">FAQs</a></li>
				<li><a href="#">Teams</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
		</div>

		<!-- Social & Subscribe -->
		<div class="footer-column">
			<h4>Let's do it!</h4>
			<div class="social-icons">
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-instagram"></i></a>
				<a href="#"><i class="fa fa-github"></i></a>
			</div>

			<div class="subscribe" >
				<h4 style="color: white;">Subscribe</h4>
				<p style="color: white;">Subscribe to stay tuned for new web design and latest updates. Let's do it!</p>
				<form>
					<input type="email" placeholder="Enter your email Address">
					<button type="submit">Subscribe</button>
				</form>
			</div>
		</div>
	</div>

	<!-- Bottom bar -->
	<div class="footer-bottom">
		<div class="footer-links">
			<a href="#">Privacy Policy</a>
			<a href="#">Terms of Use</a>
			<a href="#">Sales and Refunds</a>
			<a href="#">Legal</a>
			<a href="#">Site Map</a>
		</div>
		<div class="footer-copy">
			© 2021 All Rights Reserved
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
	<script src="js/courses.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
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