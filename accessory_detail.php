	<?php


	include 'common/header.php';

	$proId = $_GET['proId'];
	$itemsQuery = "SELECT * FROM accessories WHERE status = 'active' AND accessoryID = '$proId'";
	$itemsResult = mysqli_query($conn, $itemsQuery);
	$itemsData = mysqli_fetch_assoc($itemsResult);
	// echo "<pre>";

	// 	print_r($itemsData);die; C:\xampp\htdocs\splitfloor\accessory_detail.php
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.min.css">

	<style>
		.tab_panel {
			display: none !important;
			width: 100%;
			height: 100%;
			-webkit-animation: fadeEffect 1s;
			animation: fadeEffect 1s;
			border: solid 1px #ebebeb;
			padding-left: 30px;
			padding-right: 30px;
			padding-top: 20px;
			padding-bottom: 25px;
		}

		.tab_panel ul {
			list-style: disc;
		}

		.tab_panel h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-size: 30px;
			margin-bottom: 4%;
		}

		.accessory-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
			gap: 20px;
		}

		/* Card */
		.accessory-card {
			background: #ffffff;
			border-radius: 14px;
			overflow: hidden;
			border: 2px solid transparent;
			box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
			transition: all 0.25s ease;
			cursor: pointer;
		}

		/* Hover */
		.accessory-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
		}

		/* Selected */
		.accessory-card.selected {
			border-color: #014e79;
			box-shadow: 0 10px 30px #014e7963
		}

		/* Image */
		.accessory-image img {
			width: 100%;
			height: 160px;
			object-fit: cover;
			display: block;
		}

		/* Body */
		.accessory-body {
			padding: 12px 16px;
		}

		/* Header row */
		.accessory-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		/* Title */
		.accessory-header h4 {
			margin: 0;
			font-size: 15px;
			font-weight: 600;
			color: #333;
		}

		/* Checkbox */
		.accessory-header input[type="checkbox"] {
			width: 18px;
			height: 18px;
			cursor: pointer;
		}
	</style>


	<div class="course">
		<div class="container">
			<div class="row">

				<!-- Course -->
				<div class="col-lg-4 mt-5">
					<div class="course_container  mt-5">
						<!-- <div class="course_title"><?= $itemsData['product_name']; ?></div> -->

						<!-- Course Image -->
						<?php
						$productImages = explode(',', $itemsData['product_image']); // Assuming $itemsData is already fetched
						?>
						<div class="course_image">
							<div id="courseImageCarousel" class="carousel slide" data-bs-ride="carousel">
								<div class="carousel-inner">
									<?php foreach ($productImages as $index => $img): ?>
										<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
											<a href="admin/uploads/accessories/<?= htmlspecialchars(trim($img)) ?>"
												data-lightbox="product-gallery"
												data-title="Product Image <?= $index + 1 ?>">
												<img style="height: 300px; cursor: zoom-in;"
													src="admin/uploads/accessories/<?= htmlspecialchars(trim($img)) ?>"
													class="d-block w-100"
													alt="Product Image <?= $index + 1 ?>">
											</a>
										</div>
									<?php endforeach; ?>
								</div>

								<button class="carousel-control-prev" type="button" data-bs-target="#courseImageCarousel" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</button>
								<button class="carousel-control-next" type="button" data-bs-target="#courseImageCarousel" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</button>
							</div>
						</div>


						<!-- Course Tabs -->

					</div>
					<div class="row mt-5">
						<!-- <button class="btn btn-block btn-primary" onclick="sendId(<?= $proId ?>)">Add Item</button> -->
					</div>
				</div>

				<div class="col-md-8 mt-5" style="">

					<div class="course_title mt-5"><?= $itemsData['accessory_name']; ?></div>
					<div class="course_tabs_container">
						<div class="tabs d-flex flex-row align-items-center justify-content-start">

						</div>
						<div class="tab_panels">




							<!-- Description -->
							<div class="tab_panel active" id="description">



								<?= html_entity_decode($itemsData['long_desc']); ?>


							</div>
						</div>




					</div>
				</div>
			</div>


		</div>
	</div>
	</div>






	<?php include 'common/footer.php'; ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/js/jquery.magnify.min.js"></script>
	<script>
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true,
			'alwaysShowNavOnTouchDevices': true
		})
	</script>
	<script>
		function sendId(proId) {
			window.location.href = `payment_temp.php?proId=${proId}`;
		}
	</script>

	<script>
		$(document).on('click', '.accessory-card', function(e) {

			if ($(e.target).is('input')) return;

			let checkbox = $(this).find('input[type="checkbox"]');
			checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
		});

		$(document).on('change', '.accessory-header input[type="checkbox"]', function() {
			$(this).closest('.accessory-card')
				.toggleClass('selected', this.checked);
		});
	</script>

	