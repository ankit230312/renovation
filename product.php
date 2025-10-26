<?php
if (!isset($_GET['page'])) {
	header("Location: ?page=1");
	exit;
}

include "common/header.php";

$paginationItemsLimit = 6;
$paginationItemsPage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
$paginationItemsOffset = ($paginationItemsPage - 1) * $paginationItemsLimit;

$totalItemsQuery = "SELECT COUNT(*) as total FROM products_item WHERE status = 'active'";
$totalItemsResult = $conn->query($totalItemsQuery);
$totalItems = $totalItemsResult ? $totalItemsResult->fetch_assoc()['total'] : 0;
$totalPages = ceil($totalItems / $paginationItemsLimit);

$itemsQuery = "SELECT * FROM products_item WHERE status = 'active' ORDER BY productID DESC LIMIT $paginationItemsLimit OFFSET $paginationItemsOffset";
$paginationItemsResult = $conn->query($itemsQuery);
?>

<style>
	.course_image {
		width: 100%;
		height: 200px;
		border-top-left-radius: 6px;
		border-top-right-radius: 6px;
		overflow: hidden;
	}

	.course_image img {
		width: 100%;
		height: 200px;
		object-fit: cover;
	}

	.courses {
		width: 100%;
		padding-top: 0;
		padding-bottom: 100px;
		background: rgba(1, 78, 121, 0.1);
	}

	.card {
		border-radius: 8px;
		border: 1px solid #dee2e6;
		
	}

	label {
		color: #333;
		font-weight: 500;
	}

	.form-control,
	.form-check-input {
		border-radius: 4px;
	}

	.btn-primary {
		font-weight: 500;
	}

	.form-check-label {
		margin-left: 5px;
		color: #555;
	}

	.side-img {
		margin-top: 10%;
		height: 500px;
		/* fixed height for slider */
		overflow-y: scroll;
		/* scroll vertically */
		scroll-snap-type: y mandatory;
	}

	.side-img img {
		width: 100%;
		border-radius: 10px;
		height: 500px;
		/* full height per slide */
		object-fit: fill;
		scroll-snap-align: start;
	}

	.mySwiper {
		height: 500px;
		width: 100%;

	}

	.mySwiper img {
		width: 100%;
		border-radius: 10px;
		height: 500px;
		/* full height per slide */
		object-fit: fill;
		scroll-snap-align: start;
	}

	.home {
		width: 100%;
		height: 73px;
		background: rgba(1, 78, 121, 0.1);
		border-bottom: solid 1px #edeff0;
	}


	@media (max-width: 768px) {
		.strt {
			margin-top: -70%;
		}

		.firt {
			visibility: hidden;
		}
	}
</style>

<div class="home">
	<div class="breadcrumbs_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="breadcrumbs">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li>Product</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="courses">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2 mt-4 firt">
				<div class="card shadow-sm p-3">
					<div class="form-group mb-3">
						<label for="filterSociety">Society</label>
						<select class="form-control" id="filterSociety" name="product_id">
							<option value="">All Societies</option>
							<?php
							$propertyFilter  = "SELECT * FROM `products`";
							$resultFilter = mysqli_query($conn, $propertyFilter);
							if ($resultFilter && mysqli_num_rows($resultFilter) > 0) {
								while ($rowFilter = mysqli_fetch_assoc($resultFilter)) {
									echo '<option value="' . $rowFilter['productID'] . '">' . htmlspecialchars($rowFilter['product_name']) . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="form-group mb-3">
						<label for="filterPropertyType">Property Type</label>
						<select class="form-control" id="filterPropertyType" name="floor_type">
							<option value="">All Types</option>
						</select>
					</div>
					<div class="mb-3">
						<label class="d-block mb-2">Features</label>
						<div id="featuresWrapper">
							<small class="text-muted">Select society and property type to load features</small>
						</div>
					</div>
					<div class="d-grid">
						<button type="button" class="btn btn-primary" id="applyFilterBtn">Apply</button>

					</div>
				</div>
			</div>
			<div class="col-lg-8 p-3 strt" style="overflow-y: auto; height:100vh">
				<div class="courses_container">
					<div class="row">
						<div id="productList" class="mt-4">
							<!-- Products will be loaded here -->
						</div>

					</div>
					<!-- <div class="row courses_row">
						<?php
						if ($paginationItemsResult && $paginationItemsResult->num_rows > 0) {
							while ($item = $paginationItemsResult->fetch_assoc()) {
								$name = $item['product_name'];
								$images = explode(',', $item['product_image']);
								$desc = $item['product_description'];
								$price = $item['price'];
						?>
								<div class="col-lg-4 course_col">
									<div class="course">
										<div class="course_image">
											<div id="carousel-<?= $item['productID'] ?>" class="carousel slide" data-bs-ride="carousel">
												<div class="carousel-inner">
													<?php foreach ($images as $index => $img): ?>
														<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
															<img src="admin/uploads/items/<?= htmlspecialchars(trim($img)) ?>" class="d-block w-100" alt="<?= htmlspecialchars($name) ?>" style="max-height: 300px; object-fit: cover;">
														</div>
													<?php endforeach; ?>
												</div>
												<?php if (count($images) > 1): ?>
													<button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $item['productID'] ?>" data-bs-slide="prev">
														<span class="carousel-control-prev-icon" aria-hidden="true"></span>
														<span class="visually-hidden">Previous</span>
													</button>
													<button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $item['productID'] ?>" data-bs-slide="next">
														<span class="carousel-control-next-icon" aria-hidden="true"></span>
														<span class="visually-hidden">Next</span>
													</button>
												<?php endif; ?>
											</div>
										</div>

										<div class="course_body">
											<h3 class="course_title">
												<a href="product_detail.php?proId=<?php echo $item['productID'] ?>"><?= htmlspecialchars($name) ?></a>
											</h3>
											<div class="course_text"><?= htmlspecialchars(substr($desc, 0, 100)) ?>...</div>
											<div class="course_footer">
												<div class="course_price">&#x20B9; <?= number_format($price, 2) ?></div>
											</div>
										</div>
									</div>
								</div>
						<?php
							}
						} else {
							echo "<div class='col-12 text-center'><p>No products found.</p></div>";
						}
						?>
					</div> -->
					<div class="row pagination_row">
						<div class="col">
							<div class="pagination_container d-flex flex-row align-items-center justify-content-start">
								<ul class="pagination_list">
									<?php
									for ($i = 1; $i <= $totalPages; $i++) {
										echo '<li' . ($i == $paginationItemsPage ? ' class="active"' : '') . '><a href="?page=' . $i . '">' . $i . '</a></li>';
									}
									if ($paginationItemsPage < $totalPages) {
										echo '<li><a href="?page=' . ($paginationItemsPage + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
									}
									?>
								</ul>
								<div class="courses_show_container ml-auto clearfix">
									<div class="courses_show_text">Showing <span class="courses_showing"><?= ($paginationItemsOffset + 1) ?>-<?= min($paginationItemsOffset + $paginationItemsLimit, $totalItems) ?></span> of <span class="courses_total"><?= $totalItems ?></span> results:</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<!-- <div class="side-img">
					<img src="split-img/side.png" alt="">
					<img src="split-img/side.png" alt="">
					<img src="split-img/side.png" alt="">
				</div> -->
				<div class="swiper mySwiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img src="split-img/side.png" alt=""></div>
						<div class="swiper-slide"><img src="split-img/side.png" alt=""></div>
						<div class="swiper-slide"><img src="split-img/side.png" alt=""></div>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>

<?php include 'common/footer.php'; ?>


<script>
	$(document).ready(function() {
		function loadPropertyTypes(productId) {
			$('#filterPropertyType').html('<option value="">Loading...</option>');
			$.post('ajax/get_floor_types_filter.php', {
				product_id: productId
			}, function(data) {
				$('#filterPropertyType').html(data);
				$('#featuresWrapper').html('<small class="text-muted">Select property type to load features</small>');
			});
		}

		function loadFeatures(productId, floorType) {
			$('#featuresWrapper').html('<small>Loading features...</small>');
			$.post('ajax/get_features_filter.php', {
				product_id: productId,
				floor_type: floorType
			}, function(data) {
				$('#featuresWrapper').html(data);
			});
		}

		$('#filterSociety').change(function() {
			const productId = $(this).val();
			if (productId) {
				loadPropertyTypes(productId);
			} else {
				$('#filterPropertyType').html('<option value="">All Types</option>');
				$('#featuresWrapper').html('<small class="text-muted">Select society and property type to load features</small>');
			}
		});

		$('#filterPropertyType').change(function() {
			const productId = $('#filterSociety').val();
			const floorType = $(this).val();
			if (productId && floorType) {
				loadFeatures(productId, floorType);
			} else {
				$('#featuresWrapper').html('<small class="text-muted">Select society and property type to load features</small>');
			}
		});
	});
</script>

<script>
	$(document).ready(function() {
		// Handle Apply Button Click
		$('#applyFilterBtn').click(function() {
			let productId = $('#filterSociety').val();
			let floorType = $('#filterPropertyType').val();
			let features = [];

			// Get all checked features
			$('#featuresWrapper input[type="checkbox"]:checked').each(function() {
				features.push($(this).val());
			});

			// Send AJAX request
			$.ajax({
				url: 'ajax/get_filtered_products.php',
				type: 'POST',
				data: {
					product_id: productId,
					floor_type: floorType,
					features: features
				},
				success: function(data) {
					$('#productList').html(data);
				},
				error: function() {
					$('#productList').html('<div class="text-danger">Error loading products.</div>');
				}
			});
		});

		// Load all products by default on page load
		$('#applyFilterBtn').trigger('click');
	});
</script>

<script>
	$(document).on('click', '.add-to-cart', function() {
		const productId = $(this).data('id');
		var productType = $(this).data('feature');

		$.post('ajax/add_to_cart.php', {
			product_id: productId

		}, function(response) {
			console.log(response)
			if (response.success) {

				$('#cart-badge').text('1');
				alert('Product selected!');
				window.location = "payment_temp.php";

			} else {
				alert('Failed to select product.');
			}
		}, 'json');
	});
</script>

<script>
	var swiper = new Swiper(".mySwiper", {
		direction: "vertical",
		loop: true,
		autoplay: {
			delay: 5000, // change every 2 seconds
			disableOnInteraction: false
		},
	});
</script>