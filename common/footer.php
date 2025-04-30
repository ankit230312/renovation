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
</div>



<?php if ($page === 'home'): ?>
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

<script>
	$(document).ready(function() {
	
    var $searchInput = $('#property_search');
    var $resultsList = $('#autocomplete-results');

    $searchInput.on('input', function() {

		console.log("ckh");
        var query = $searchInput.val();

        if (query.length >= 1) { // Start searching after 1 character
            $.ajax({
                url: 'ajax/search_property.php', // URL to your PHP endpoint
                type: 'GET',
                dataType: 'json',
                data: { term: query }, // Send the search term to the server
                success: function(data) {
                    if (data.length > 0) {
                        var suggestions = data.map(function(item) {
                            return '<li class="autocomplete-item">' + item.product_name + '</li>';
                        });
                        $resultsList.html(suggestions.join('')).show();
                    } else {
                        $resultsList.html('<li>No results found</li>').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error: ' + status + ' - ' + error);
                }
            });
        } else {
            $resultsList.hide(); // Hide the results list when there's no input
        }
    });

    // Hide results list when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#property_search').length) {
            $resultsList.hide();
        }
    });

    // Handle item selection
    $(document).on('click', '.autocomplete-item', function() {
        $searchInput.val($(this).text()); // Set the input field to the selected suggestion
        $resultsList.hide(); // Hide the results list
    });
});

</script>

</body>

</html>