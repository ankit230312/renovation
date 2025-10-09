<?php include "db.php";


$cartCount = isset($_SESSION['single_cart_product']) ? 1 : 0; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>SplitFloor - Renovation Service Website </title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Split Floor  project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="manifest" href="/splitfloor/manifest.json">
	<meta name="theme-color" content="#007bff">


	<?php
	$page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

	// echo $page;
	// die;


	if ($page == 'index' || $page == 'splitfloor' || $page == 'temp' || $page == 'payment' || $page == 'payment_success' || $page == 'payment_failed' || $page == 'type') { ?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
		<link rel="stylesheet" type="text/css" href="styles/responsive.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
		<link rel="shortcut icon" href="split-img/logo.jpg" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="style.css">
	<?php } else if ($page ==  'course' || $page == 'product_detail' || $page == 'payment_temp') { ?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet"> -->

		<!-- Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

<!-- Lightbox2 JS -->


		

		<link rel="stylesheet" type="text/css" href="styles/course.css">
		<link rel="stylesheet" type="text/css" href="styles/course_responsive.css">
	<?php } else if ($page ==  'course1') { ?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="styles/course.css">
		<link rel="stylesheet" type="text/css" href="styles/course_responsive.css">
	<?php } else if ($page ==  'course2') { ?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="styles/course.css">
		<link rel="stylesheet" type="text/css" href="styles/course_responsive.css">

	<?php } else if ($page ==  'course3') { ?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="styles/course.css">
		<link rel="stylesheet" type="text/css" href="styles/course_responsive.css">

	<?php } else if ($page ==  'product') { ?>


		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link rel="stylesheet" type="text/css" href="styles/courses.css">
		<link rel="stylesheet" type="text/css" href="styles/courses_responsive.css">


	<?php } else if ($page ==  'about') {
	?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link rel="stylesheet" type="text/css" href="styles/about.css">
		<link rel="stylesheet" type="text/css" href="styles/about_responsive.css">

	<?php } else if ($page ==  'contact') {
	?>
	<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
	<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="styles/contact.css">
	<link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">
	<link rel="shortcut icon" href="split-img/logo.jpg" type="image/x-icon">
	<!-- Include AOS Animation Library in <head> -->
	<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
	<?php } ?>




	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="styles/custom_cc.cssv=<?php echo time(); ?>">

	<script src="https://sdk.cashfree.com/js/ui/2.0.0/cashfree.prod.js"></script>
	<style>
		/* Autocomplete dropdown container */
		#autocomplete-results {
			position: absolute;
			top: 45px;
			/* Adjust based on your input's position */
			left: 0;
			right: 0;
			width: 136%;
			max-height: 250px;
			overflow-y: auto;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
			z-index: 9999;
			list-style: none;
			padding: 0;
			margin: 0;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
		}

		/* Each suggestion item */
		.autocomplete-item {
			padding: 10px 12px;
			text-align: left;
			cursor: pointer;
			border-bottom: 1px solid #eee;
			transition: background-color 0.2s ease;
		}

		/* Last item (remove border) */
		.autocomplete-item:last-child {
			border-bottom: none;
		}

		/* Hover effect */
		.autocomplete-item:hover {
			background-color: #f5f5f5;
		}

		/* Optional: Style for "No results found" message */
		#autocomplete-results li {
			padding: 10px 12px;
			color: black;
			font-style: italic;
		}

		#ff-77 {
			display: none !important;
		}

		.new_cls {
			margin-top: 57px;
		}
	</style>

	<style>
		.logo {
			width: 120px;


		}

		.location {
			margin-left: 16px;
			color: black
		}

		.location a {
			color: black;
		}

		.cart-badge {
			position: absolute;
			top: -8px;
			right: -10px;
			background: red;
			color: white;
			border-radius: 50%;
			padding: 2px 6px;
			font-size: 12px;
		}

		.fa.fa-shopping-cart {
			font-size: 30px;
		}

		.amazon-header {
			background: #ffffffff;
			color: white;
			font-family: Arial, sans-serif;
			font-size: 14px;
		}

		.amazon-header a {
			color: black;
			text-decoration: none;
			margin: 0 10px;
		}

		.top-bar {
			padding: 10px;
		}

		.search-bar {
			flex: 1;
			margin: 0 20px;
			border: 1px solid black;
		}

		.search-select {
			padding: 5px;
			border-right: 1px solid black;
		}

		.account {
			color: black;
		}

		.search-input {
			flex: 40%;
			padding: 8px;
			border: none;
		}

		.search-btn {
			background: #568143;
			border: none;
			padding: 8px 12px;
			cursor: pointer;
			color: white;
		}

		.cart-badge {
			position: absolute;
			top: 0;
			right: -8px;
			background: #568143;
			color: black;
			font-weight: bold;
			border-radius: 50%;
			padding: 2px 6px;
			color: white;
		}

		.bottom-nav {
			background: #014e79;
			padding: 10px;
		}

		.bottom-nav a {
			color: white;
			margin-right: 15px;
		}

		body,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: "Roboto", sans-serif;
			font-optical-sizing: auto;

			font-style: normal;

		}
	</style>




	<style>
		/* Mobile Drawer (hidden by default) */
		.mobile-drawer {
			position: fixed;
			top: 0;
			left: -100%;
			/* hidden outside screen */
			width: 75%;
			/* drawer width */
			height: 100%;
			background: #fff;
			padding: 20px;
			box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
			z-index: 9999;
			transition: left 0.3s ease-in-out;
			overflow-y: auto;
		}

		/* When open */
		.mobile-drawer.open {
			left: 0;
		}

		/* Location Section */
		.mobile-drawer .location {
			margin-bottom: 15px;
			font-size: 14px;
		}

		.mobile-drawer .location a {
			font-size: 13px;
			color: #007185;
			text-decoration: none;
		}

		.mobile-drawer .location a:hover {
			text-decoration: underline;
		}

		/* Search bar */
		.mobile-drawer .search-bar {
			margin: 15px 0;
		}

		.mobile-drawer .search-bar input {
			width: 100%;
			padding: 8px 12px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
		}

		/* Account section */
		.mobile-drawer .account {
			margin: 15px 0;
			font-size: 14px;
		}

		.mobile-drawer .account a {
			color: #007185;
			font-weight: bold;
			text-decoration: none;
		}

		.mobile-drawer .account a:hover {
			text-decoration: underline;
		}

		/* Cart section */
		.mobile-drawer .cart {
			margin: 15px 0;
		}

		.mobile-drawer .cart a {
			color: #111;
			font-size: 16px;
			display: flex;
			align-items: center;
			text-decoration: none;
		}

		.mobile-drawer .cart i {
			margin-right: 8px;
		}

		/* Navigation links */
		.mobile-drawer nav {
			margin-top: 20px;
			display: flex;
			flex-direction: column;
		}

		.mobile-drawer nav a {
			padding: 10px 0;
			font-size: 15px;
			color: #111;
			text-decoration: none;
			border-bottom: 1px solid #eee;
		}

		.mobile-drawer nav a:hover {
			color: #e47911;
			/* Amazon-style orange */
		}

		/* Desktop default */
		.desktop-only {
			display: block;
		}

		.mobile-only {
			display: none;
		}

		.mobile-drawer {
			display: none;
		}

		/* Tablet & Mobile */
		@media (max-width: 992px) {
			.desktop-only {
				display: none !important;
			}

			.mobile-only {
				display: block;
			}

			.mobile-drawer {
				position: fixed;
				top: 0;
				left: -100%;
				width: 75%;
				height: 100%;
				background: #fff;
				padding: 20px;
				box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
				z-index: 9999;
				transition: left 0.3s ease-in-out;
				overflow-y: auto;
				display: block;
			}

			.mobile-drawer.open {
				left: 0;
			}
		}
	</style>


	<style>
		.search-bar {
			position: relative;
			width: 66%;
			/* adjust */
		}

		.search-input {
			width: 100%;
			padding: 8px;
			padding-left: 10px;
		}

		.placeholder-wrapper {
			position: relative;
			flex: 1;
		}

		.placeholder-text {
			position: absolute;
			left: 12px;
			top: 50%;
			transform: translateY(-50%);
			pointer-events: none;
			color: #888;
			transition: transform 0.5s ease, opacity 0.5s ease;
		}

		.results-box {
			position: absolute;
			background: #fff;
			border: 1px solid #ccc;
			max-height: 416px;
			overflow-y: auto;
			width: 100%;
			z-index: 999;
			padding: 10px;
			top: 114%;
			border-radius: 3px;
			overflow-x: hidden;
		}

		#resultsList li {
			padding: 8px;
			cursor: pointer;
			border-bottom: 1px solid #eee;
			font-weight: 600;
			color: black;
		}

		#resultsList li:hover {
			background: #014e79;
			color: white;
			border-radius: 5px;
			/* box-shadow: 0px 0px 9px #0790dd; */
		}

		#previewBox {
			border-left: 1px solid #ddd;
			padding-left: 15px;
			min-height: 200px;
		}

		#previewBox h5 {
			margin-bottom: 20px;
		}

		.search-bar {
			flex: unset;
			margin: 0 20px;
			border: 1px solid black;
		}

		.account a {
			margin: 0;
		}


		@media (max-width: 992px) {
			.mobile-only {
				display: block;
			}

			.hamburger {

				cursor: pointer;
				padding: 13px;
				border: 1px sol black;
				background: none;
				border-radius: 4px;
			}

		}
	</style>





	<style>
		footer {
			margin-top: 50px;
			color: #fff;
		}

		/* CTA bar */
		.cta-bar {
			background: linear-gradient(to right, #1d5e82, #39505e);
			color: #fff;
			padding: 25px 40px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-radius: 12px;
			margin: 0 auto;
			max-width: 1100px;
			transform: translateY(50%);
			position: relative;
			z-index: 2;
			border: 1px solid;
		}

		.cta-text {
			font-size: 1.5rem;
			font-weight: bold;
		}

		.cta-action span {
			margin-right: 10px;
			font-weight: 600;
		}

		.cta-action .btn {
			background: linear-gradient(to right, #ff7e5f, #feb47b);
			color: #fff;
			padding: 10px 20px;
			border-radius: 25px;
			text-decoration: none;
			font-weight: bold;
		}

		/* Footer main */
		.footer-main {
			background: #014e79;
			display: flex;
			justify-content: space-between;
			flex-wrap: wrap;
			padding: 100px 40px 50px;
		}

		.footer-logo {
			flex: 1 1 200px;
			display: flex;
			align-items: center;
			margin-bottom: 20px;
		}

		.footer-logo img {
			height: 40px;
			margin-right: 10px;
		}

		.footer-logo .logo-text {
			font-size: 1.2rem;
			font-weight: bold;
		}

		.footer-column {
			flex: 1 1 200px;
			margin: 10px;
		}

		.footer-column h4 {
			margin-bottom: 15px;
			font-size: 1rem;
			color: white;
		}

		.footer-column ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.footer-column ul li {
			margin-bottom: 8px;
		}

		.footer-column ul li a {
			text-decoration: none;
			color: #fff;
			font-size: 0.9rem;
		}

		.footer-column ul li a:hover {
			text-decoration: underline;
		}

		/* Social */
		.social-icons {
			margin-bottom: 20px;
		}

		.social-icons a {
			color: #fff;
			margin-right: 12px;
			font-size: 1.2rem;
		}

		/* Subscribe */
		.subscribe p {
			font-size: 0.9rem;
			margin-bottom: 10px;
		}

		.subscribe form {
			display: flex;
			margin-top: 10px;
		}

		.subscribe input {
			padding: 10px;
			border: none;
			border-radius: 25px 0 0 25px;
			outline: none;
			flex: 1;
		}

		.subscribe button {
			padding: 10px 20px;
			border: none;
			background: linear-gradient(to right, #ff7e5f, #feb47b);
			color: #fff;
			border-radius: 0 25px 25px 0;
			cursor: pointer;
			font-weight: bold;
		}

		/* Bottom bar */
		.footer-bottom {
			background: #014e79;
			border-top: 1px solid rgba(255, 255, 255, 0.2);
			padding: 15px 40px;
			display: flex;
			justify-content: space-between;
			flex-wrap: wrap;
			font-size: 0.85rem;
		}

		.footer-links a {
			margin-right: 15px;
			text-decoration: none;
			color: #fff;
		}

		.footer-links a:hover {
			text-decoration: underline;
		}

		/* Responsive Design */

		/* Tablets */
		@media (max-width: 992px) {
			.cta-bar {
				flex-direction: column;
				text-align: center;
				gap: 15px;
				padding: 20px;
			}

			.cta-text {
				font-size: 1.2rem;
			}

			.cta-action span {
				display: block;
				margin-bottom: 8px;
			}

			.footer-main {
				flex-direction: column;
				text-align: center;
				padding: 80px 20px 40px;
			}

			.footer-logo {
				justify-content: center;
			}

			.footer-column {
				margin: 20px 0;
			}

			.social-icons {
				justify-content: center;
			}

			.subscribe form {
				flex-direction: column;
			}

			.subscribe input,
			.subscribe button {
				border-radius: 25px;
				margin: 5px 0;
				width: 100%;
			}
		}

		/* Mobile */
		@media (max-width: 576px) {
			.cta-bar {
				padding: 15px;
				font-size: 0.9rem;
			}

			.cta-text {
				font-size: 1rem;
			}

			.cta-action .btn {
				display: inline-block;
				padding: 8px 16px;
				font-size: 0.85rem;
			}

			.footer-main {
				padding: 60px 15px 30px;
			}

			.footer-column h4 {
				font-size: 0.95rem;
			}

			.footer-column ul li a {
				font-size: 0.85rem;
			}

			.footer-bottom {
				flex-direction: column;
				text-align: center;
				padding: 15px;
			}

			.footer-links {
				margin-bottom: 10px;
			}

			.footer-links a {
				display: block;
				margin: 5px 0;
			}
		}
	</style>

	<?php
	$request = $_SERVER['REQUEST_URI'];

	// Remove base directory if you're in a subfolder
	// $request = str_replace('/your-subdirectory/', '', $request); // optional

	// Remove query string
	$request = explode('?', $request)[0];

	// Route: Check if it starts with 'product/'
	if (preg_match('#^product/([0-9]+)-#', $request, $matches)) {
		$_GET['proId'] = $matches[1];
		include 'product_detail.php';
		exit;
	}
	?>


</head>

<body>

	<div class="super_container">

		<!-- Header -->

		<header class="amazon-header">
			<!-- Top Row -->
			<div class="top-bar d-flex align-items-center justify-content-between">
				<!-- Logo -->
				<div class="logo">
					<a href="index.php">
						<img src="split-img/Logo.png" alt="Logo" style="height:40px;">
					</a>
				</div>

				<!-- Location (desktop only) -->
				<div class="location desktop-only">
					<i class="fas fa-location-arrow me-1"></i>
					<span class="small" id="user-location">
						Detecting location...
					</span>
					<br>
					<a href="#" id="update-location">
						Update location
					</a>
				</div>


				<!-- Search (desktop only) -->
				<div class="search-bar d-flex desktop-only">
					<div class="placeholder-wrapper">
						<input type="text" class="search-input" id="searchInput" autocomplete="off" placeholder="Search For Society">
						<div class="results-box" id="resultsBox" style="display:none;">
							<div class="row">
								<div id="searchResults" class="col-md-12">
									<ul id="resultsList" class="list-unstyled mb-0"></ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Right: Account + Cart (desktop only) -->
				<div class="nav-right d-flex align-items-center desktop-only">
					<div class="account">
						<span>Hello, sign in</span> <br>
						<a href="#">Account & Lists</a>
					</div>
					<div class="cart">
						<a href="cart.php" style="position: relative;">
							<i class="fas fa-shopping-cart fa-2x"></i>
							<span id="cart-badge" class="cart-badge">0</span>
						</a>
					</div>
				</div>

				<!-- Hamburger (mobile only) -->
				<button class="hamburger mobile-only" id="hamburgerBtn">☰</button>
			</div>

			<!-- Bottom Navigation (desktop only) -->
			<nav class="bottom-nav d-flex desktop-only">
				<a href="#">Home</a>
				<a href="about.php">About</a>
				<a href="product.php">Product</a>
				<a href="contact.php">Contact Us</a>
				<a href="partner-with-us.html">Partner With Us</a>
			</nav>

			<!-- Mobile Drawer -->
			<div id="mobileNav" class="mobile-drawer">
				<div class="location">
					<span id="user-location">Detecting location...</span><br>
					<a href="#" id="update-location">Update location</a>
				</div>

				<div class="search-bar">
					<div class="placeholder-wrapper">
						<input type="text" class="search-input" id="searchInput" autocomplete="off" placeholder="Search For Society">
						<div class="results-box" id="resultsBox" style="display:none;">
							<div class="row">
								<div id="searchResults" class="col-md-12">
									<ul id="resultsList" class="list-unstyled mb-0"></ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="account">
					<span>Hello, sign in</span><br>
					<a href="#">Account & Lists</a>
				</div>

				<div class="cart">
					<a href="cart.php">
						<i class="fas fa-shopping-cart fa-2x"></i>
						<span id="cart-badge" class="cart-badge">0</span>
					</a>
				</div>

				<nav>
					<a href="#">Home</a>
					<a href="about.php">About</a>
					<a href="product.php">Product</a>
					<a href="contact.php">Contact Us</a>
					<a href="partner-with-us.html">Partner With Us</a>
				</nav>
			</div>
		</header>
		<script>
			const placeholders = ["Search for society", "Search for product"];
			let i = 0;

			const input = document.getElementById("searchInput");
			const placeholderText = document.getElementById("placeholderText");

			// Initialize first text
			placeholderText.textContent = placeholders[i];

			setInterval(() => {
				// Animate upward fade
				placeholderText.style.transform = "translateY(-150%)";
				placeholderText.style.opacity = "0";

				setTimeout(() => {
					// Change text after animation
					i = (i + 1) % placeholders.length;
					placeholderText.textContent = placeholders[i];

					// Reset to below
					placeholderText.style.transform = "translateY(150%)";
					placeholderText.style.opacity = "0";

					// Animate back to center
					setTimeout(() => {
						placeholderText.style.transform = "translateY(-50%)";
						placeholderText.style.opacity = "1";
					}, 50);
				}, 500);
			}, 3000);
		</script>
		<!-- Menu -->
		<script>
			// function to get user location
			function getUserLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
				} else {
					document.getElementById("user-location").innerText = "Geolocation not supported.";
				}
			}

			// success
			function successCallback(position) {
				let lat = position.coords.latitude;
				let lon = position.coords.longitude;

				// Use a free reverse geocoding API to get city/pincode
				fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
					.then(response => response.json())
					.then(data => {
						let city = data.address.city || data.address.town || data.address.village || "";
						let postcode = data.address.postcode || "";
						document.getElementById("user-location").innerText = `Search in ${city} , ${postcode}`;
					})
					.catch(() => {
						document.getElementById("user-location").innerText = "Unable to fetch location name.";
					});
			}

			// error
			function errorCallback(error) {
				document.getElementById("user-location").innerText = "Location access denied.";
			}

			// load location on page load
			window.onload = getUserLocation;

			// also update when clicking the link
			document.getElementById("update-location").addEventListener("click", function(e) {
				e.preventDefault();
				getUserLocation();
			});




			// store selected product ID
			let selectedProductId = null;

			document.getElementById("searchInput").addEventListener("keyup", function() {
				let q = this.value.trim();
				let resultsBox = document.getElementById("resultsBox");
				let resultsList = document.getElementById("resultsList");

				if (q.length > 2) {
					fetch("ajax/search.php?q=" + encodeURIComponent(q))
						.then(res => res.json())
						.then(data => {
							resultsList.innerHTML = "";

							if (data.length === 0) {
								resultsBox.style.display = "none";
								return;
							}

							resultsBox.style.display = "block";

							data.forEach(item => {
								let li = document.createElement("li");
								li.textContent = item.product_name;

								li.addEventListener("click", () => {
									document.getElementById("searchInput").value = item.product_name;
									selectedProductId = item.productID; // save ID
									resultsBox.style.display = "none";
									window.location.href = "type.php?id=" + selectedProductId;
								});

								resultsList.appendChild(li);
							});
						})
						.catch(err => {
							console.error(err);
							resultsBox.style.display = "none";
						});
				} else {
					resultsBox.style.display = "none";
				}
			});

			// Search button click → redirect with productID
			// document.querySelector(".search-btn").addEventListener("click", function(e) {
			// 	e.preventDefault();
			// 	if (selectedProductId) {
			// 		window.location.href = "type.php?id=" + selectedProductId;
			// 	} else {
			// 		alert("Please select a product from the list first!");
			// 	}
			// });
		</script>

		<script>
			const hamburgerBtn = document.getElementById("hamburgerBtn");
			const mobileNav = document.getElementById("mobileNav");

			hamburgerBtn.addEventListener("click", () => {
				mobileNav.classList.toggle("open");
			});
		</script>
		<!-- Home -->