<?php include "common/header.php"; ?>

<style>
	.home {
		width: 100%;
		height: 65px;
		background: #f2f4f5;
		border-bottom: solid 1px #edeff0;
	}

	.contact {
		width: 100%;
		padding-bottom: 0px;
	}

	.contact_banner {
		width: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
		overflow: hidden;
		padding: 20px;
		animation: fadeInUp 1.2s ease-out;
	}

	.contact_banner img {
		width: 100%;
		/* max-width: 1000px; */
		height: auto;
		border-radius: 12px;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
		transition: transform 0.4s ease, box-shadow 0.4s ease;
	}

	.contact_banner img:hover {
		transform: scale(1.03);
		box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
	}

	/* Animation keyframes */
	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(40px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	/* Responsive tweaks for smaller screens */
	@media (max-width: 768px) {
		.contact_banner {
			padding: 10px;
		}

		.contact_banner img {
			width: 100%;
			border-radius: 8px;
		}
	}

	.map {
		width: 100%;
		padding: 20px;
		box-sizing: border-box;
	}

	.google_map {
		position: relative;
		padding-bottom: 56.25%;
		/* 16:9 aspect ratio */
		height: 0;
		overflow: hidden;
		border-radius: 12px;
		box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
		animation: fadeIn 1.2s ease-out;
	}

	.google_map iframe {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		border: 0;
	}

	/* Animation */
	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(30px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
</style>
<!-- Home -->

<div class="home">
	<div class="breadcrumbs_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="breadcrumbs">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li>Contact</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Contact -->

<div class="contact">

	<!-- Contact Map -->

	<div class="contact_map">

		<div class="contact_banner">
			<img src="split-img/wert.jpg" alt="Contact Banner Image">
		</div>
	</div>

	<!-- Contact Info -->
	<div class="contact_info_container py-5" style="background-color: #f8f9fa;">
		<div class="container">
			<div class="row">

				<!-- Contact Form -->
				<div class="col-lg-6 mb-4">
					<div class="contact_form border rounded shadow-sm p-4 bg-white h-100" data-aos="fade-right" data-aos-duration="1000">
						<div class="contact_info_title h4 mb-4">Connect with Us!</div>
						<form action="#" class="comment_form">
							<div class="mb-3">
								<label class="form_title mb-1">Name</label>
								<input type="text" name="name" placeholder="Enter Your Name" class="form-control comment_input" required>
							</div>
							<div class="mb-3">
								<label class="form_title mb-1">Email-Id</label>
								<input type="email" name="email" placeholder="Enter Your Email-Id" class="form-control comment_input" required>
							</div>
							<div class="mb-3">
								<label class="form_title mb-1">Phone</label>
								<input type="tel" name="phone" placeholder="Enter Your Phone Number" class="form-control comment_input" required>
							</div>
							<div class="mb-3">
								<label class="form_title mb-1">Message</label>
								<input type="text" name="message" placeholder="Enter Your Message" class="form-control comment_input" required>
							</div>
							<button type="submit" style="background-color: #014e79; color:white" class="btn  w-100">Submit Now</button>
						</form>
					</div>
				</div>

				<!-- Contact Info -->
				<div class="col-lg-6">
					<div class="contact_info rounded shadow p-4 text-white d-flex flex-column justify-content-between" style="background: #014e79;" data-aos="fade-left" data-aos-duration="1000">
						<div>
							<div class="contact_info_title h4 mb-3" style="font-size: 30px; color:#fff;">We’re Here to Help You Connect!</div>
							<div class="contact_info_text mb-4">
								<p class="text-white">Have questions about our properties, investment opportunities, or floor plan details? Our team at <strong>Splitfloor</strong> is ready to assist you. Whether you're looking to schedule a site visit, request a brochure, or simply want more information — just reach out. We're committed to providing personalized assistance every step of the way.</p>
							</div>
						</div>

						<!-- Office Info Boxes -->
						<div class="row g-3" style="padding-bottom: 15%">

							<!-- Head Office -->
							<div class="col-md-6">
								<div class="contact_info_location border rounded shadow-sm bg-light">
									<div class="contact_info_location_title h6 p-3 border-bottom mb-0 bg-white">Head Office</div>
									<ul class="list-unstyled text-dark m-0 p-3">
										<li class="mb-1">A22 Sector 2, Noida</li>
										<li class="mb-1">+91-9643873151</li>
										<li>info.splitfloor@gmail.com</li>
									</ul>
								</div>
							</div>

							<!-- Delhi Office -->
							<div class="col-md-6">
								<div class="contact_info_location border rounded shadow-sm bg-light">
									<div class="contact_info_location_title h6 p-3 border-bottom mb-0 bg-white">Delhi Office</div>
									<ul class="list-unstyled text-dark m-0 p-3">
										<li class="mb-1">New Delhi</li>
										<li class="mb-1">+91-9643873151</li>
										<li>info.splitfloor@gmail.com</li>
									</ul>
								</div>
							</div>

						</div> <!-- End office row -->

					</div> <!-- End contact_info -->
				</div> <!-- End col-lg-6 -->

			</div> <!-- End row -->
		</div> <!-- End container -->
	</div> <!-- End contact_info_container -->



	<!-- Google Map -->

	<div class="map">
		<div id="google_map" class="google_map">
			<iframe
				src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224408.04433464078!2d77.2206201935625!3d28.498342384806577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cea64b8f89aef%3A0xec0ccabb5317962e!2sGreater%20Noida%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1747731679862!5m2!1sen!2sin"
				allowfullscreen=""
				loading="lazy"
				referrerpolicy="no-referrer-when-downgrade">
			</iframe>
		</div>
	</div>
	<!-- End -->

	<!-- Footer -->


</div>


<?php include "common/footer.php"; ?>