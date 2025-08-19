<?php include "db.php";


$cartCount = isset($_SESSION['single_cart_product']) ? 1 : 0;?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>SplitFloor - Renovation Service Website </title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Split Floor  project">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php
	$page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

	// echo $page;
	// die;


	if ($page == 'index' || $page == 'splitfloor' || $page == 'temp' || $page == 'payment' || $page == 'payment_success' || $page == 'payment_failed') { ?>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
		<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
		<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
		<link rel="stylesheet" type="text/css" href="styles/responsive.css">
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
		<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

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


	<?php } ?>
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="styles/custom_cc.css">
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

		<header class="header">

			<!-- Top Bar -->
			<div class="top_bar">
				<div class="top_bar_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
									<ul class="top_bar_contact_list">
										<li>
											<div class="question">Chat with us?</div>
										</li>
										<li>
											<i class="fa fa-phone" aria-hidden="true"></i>
											<div>9643873151</div>
										</li>
										<li>
											<i class="fa fa-envelope-o" aria-hidden="true"></i>
											<div>info.splitfloor@gmail.com</div>
										</li>
									</ul>
									<div class="top_bar_login ml-auto">
										<!-- <div class="login_button"><a href="login.php">Register or Login</a></div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Header Content -->
			<div class="header_container">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="header_content d-flex flex-row align-items-center justify-content-start">
								<div class="logo_container">
									<a href="index.php">
										<div class="logo_text">
											<img src="split-img/logo.jpg" width="200" alt="Header Logo" title="Header Logo">
										</div>
									</a>
								</div>
								<nav class="main_nav_contaner ml-auto">
									<ul class="main_nav">
										<li class="active"><a href="index.php">Home</a></li>
										<li><a href="#">About</a></li>
										<!-- <li><a href="product.php">Product</a></li> -->
										<li><a href="product.php">Product</a></li>
										<li><a href="contact.php">Contact</a></li>

										<li class="menu_mm">
											<a href="payment_temp.php" style="position: relative;">
												<i class="fa fa-shopping-cart"></i>
												<span id="cart-badge" class="cart-badge"><?= $cartCount ?></span>
											</a>
										</li>
										<!-- <li><a href="#" id="openPopup">Check Manually</a></li> -->
									</ul>
									<!-- <div class="search_button"><i class="fa fa-user" aria-hidden="true"> My Account</i> </div> -->

									<!-- Hamburger -->

									<!-- <div class="shopping_cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
									</div> -->
									<div class="hamburger menu_mm">
										<i class="fa fa-bars menu_mm" aria-hidden="true"></i>
									</div>
								</nav>

							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Header Search Panel -->
			<div class="header_search_container">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="header_search_content d-flex flex-row align-items-center justify-content-end">
								<form action="#" class="header_search_form">
									<input type="search" class="search_input" placeholder="Search" required="required">
									<button
										class="header_search_button d-flex flex-column align-items-center justify-content-center">
										<i class="fa fa-search" aria-hidden="true"></i>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<!-- Menu -->

		<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
			<div class="menu_close_container">
				<div class="menu_close">
					<div></div>
					<div></div>
				</div>
			</div>
			<div class="search">
				<form action="#" class="header_search_form menu_mm">
					<input type="search" class="search_input menu_mm" placeholder="Search" required="required">
					<button
						class="header_search_button d-flex flex-column align-items-center justify-content-center menu_mm">
						<i class="fa fa-search menu_mm" aria-hidden="true"></i>
					</button>
				</form>
			</div>
			<nav class="menu_nav">
				<ul class="menu_mm">
					<li class="menu_mm"><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li>
					<li><a href="courses.php">Services</a></li>
					<li><a href="blog.php">Blog</a></li>
					<li><a href="articles.php">Articles</a></li>
					<li><a href="contact.php">Contact</a></li>
					<li class="menu_mm">
						<a href="cart.php" style="position: relative;">
							<i class="fas fa-shopping-cart"></i>
							<span id="cart-badge" class="cart-badge">0</span>
						</a>
					</li>
				</ul>
			</nav>

		</div>

		<!-- Home -->