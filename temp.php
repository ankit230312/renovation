<?php include 'common/header.php'; ?>



<style>
	nav>.nav.nav-tabs {

		border: none;
		color: #fff;
		background: #272e38;
		border-radius: 0;

	}

	nav>div a.nav-item.nav-link {
		border: none;
		padding: 18px 25px;
		color: #fff;
		background: rgb(199, 204, 211);
		border-radius: 0;
		color: black;
	}

	nav>div a.nav-item.nav-link.active {
		border: none;
		padding: 18px 25px;
		color: #fff;
		background: #272e38;
		border-radius: 0;
	}

	nav>div a.nav-item.nav-link.active:after {
		content: "";
		position: relative;
		bottom: -60px;
		left: -10%;
		border: 15px solid transparent;

	}

	.tab-content {
		background: #fdfdfd;
		line-height: 25px;
		border: 1px solid #ddd;


		padding: 30px 25px;
	}

	nav>div a.nav-item.nav-link:hover,
	nav>div a.nav-item.nav-link:focus {
		border: none;
		background: #14BDEE;
		color: black;
		border-radius: 0;
		transition: background 0.20s linear;
	}
</style>
<div class="features">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center new_cls">
					<h2 class="section_title">Cart Page</h2>

				</div>
			</div>
		</div>
		<div class="row features_row">

			<!-- Features Item -->
			<div class="col-lg-12 feature_col">
				<div class="feature text-center trans_400">


					<div class="row ">
						<div class="col-12">



							<nav>
								<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-so"
										role="tab" aria-controls="nav-home" aria-selected="true">Society </a>
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-cus"
										role="tab" aria-controls="nav-profile" aria-selected="false">Custom</a>
								</div>
							</nav>

							<!-- Tab content -->
							<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-so" role="tabpanel" aria-labelledby="nav-home-tab">
									<div class="row mb-4 p-1">
										<div class="col-md-3">

											<select id="inputSociety" class="form-control select2">
												<option selected disabled>Choose Society</option>
												<option value="society1">Green Valley</option>
												<option value="society2">Palm Heights</option>
												<option value="society3">Sunshine Residency</option>
												<option value="society4">Urban Nest</option>
											</select>
										</div>
										<div class="col-md-3">
											<select id="inputState" class="form-control">
												<option selected>Choose property type</option>
												<option>...</option>
											</select>
										</div>
										<div class="col-md-3">
											<select id="inputState" class="form-control">
												<option selected>Choose property Feature</option>
												<option>...</option>
											</select>
										</div>


									</div>
									<div class="row">
										<div class="col-md-7">
											<table class="table">
												<thead class="thead-dark">
													<tr>
														<th scope="col">#</th>
														<th scope="col">Product name</th>
														<th scope="col">Price</th>

													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Product 1</td>
														<td>34</td>

													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Product 1</td>
														<td>45</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Product 1</td>
														<td>56</td>
													</tr>
												</tbody>
											</table>


										</div>
										<div class="col-md-5">
											<div class="card">
												<div class="row"></div>

												<div class="card-body">
													<h5 class="card-title">Calculate Your Measurment</h5>
													<table class="table">
														<tbody>
															<tr>
																<td style="text-align: left;">Length</td>
																<td>
																	<input class="form-control" type="text" id="lengthInput" placeholder="Enter Length">
																</td>
															</tr>
															<tr>
																<td style="text-align: left;">Breadth</td>
																<td>
																	<input class="form-control" type="text" id="breadthInput" placeholder="Enter Breadth">
																</td>
															</tr>
															<tr>
																<td style="text-align: left;">Area Square Feet</td>
																<td style="text-align: right;" id="areaSqft">0</td>
															</tr>
															<tr>
																<td style="text-align: left;">Price</td>
																<td style="text-align: right;">
																	<span>Rs </span><span id="priceValue">0</span>
																</td>
															</tr>
															<tr>
																<td colspan="2" style="text-align: left;">
																	<button class="btn btn-primary btn-block">Proceed to Pay</button>
																</td>
															</tr>
														</tbody>

													</table>

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="nav-cus" role="tabpanel" aria-labelledby="nav-profile-tab">
									<div class="row">
										<div class="col-md-7">
											<table class="table">
												<thead class="thead-dark">
													<tr>
														<th scope="col">#</th>
														<th scope="col">Product name</th>
														<th scope="col">Price</th>

													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Product 1</td>
														<td>34</td>

													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Product 1</td>
														<td>45</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Product 1</td>
														<td>56</td>
													</tr>
												</tbody>
											</table>


										</div>
										<div class="col-md-5">
											<div class="card">
												<div class="row"></div>

												<div class="card-body">
													<h5 class="card-title">Calculate Your Measurment</h5>
													<table class="table">
														<tbody>
															<tr>
																<td style="text-align: left;">length</td>
																<td><input class="form-control" type="text" placeholder="Enter Length"></td>
															</tr>
															<tr>
																<td style="text-align: left;">Breadth</td>
																<td><input class="form-control" type="text" placeholder="Enter Breadth"></td>
															</tr>
															<tr>
																<td style="text-align: left;">Area Square Feet</td>
																<td style="text-align: right;">645</td>
															</tr>
															<tr>
																<td style="text-align: left;">Price</td>
																<td style="text-align: right;"> <span>Rs</span> 645</td>
															</tr>
															<tr>
																<td colspan="2" style="text-align: left;"><button class="btn btn-primary btn-block"> Proceed to Pay</button></td>

															</tr>
														</tbody>
													</table>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-7">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Product name</th>
									<th scope="col">Price</th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">1</th>
									<td>Product 1</td>
									<td>34</td>

								</tr>
								<tr>
									<th scope="row">2</th>
									<td>Product 1</td>
									<td>45</td>
								</tr>
								<tr>
									<th scope="row">3</th>
									<td>Product 1</td>
									<td>56</td>
								</tr>
							</tbody>
						</table>


					</div>
					<div class="col-md-5">
						<div class="card">
							<div class="row"></div>

							<div class="card-body">
								<h5 class="card-title">Calculate Your Measurment</h5>
								<table class="table">
									<tbody>
										<tr>
											<td style="text-align: left;">length</td>
											<td><input class="form-control" type="text" placeholder="Enter Length"></td>
										</tr>
										<tr>
											<td style="text-align: left;">Breadth</td>
											<td><input class="form-control" type="text" placeholder="Enter Breadth"></td>
										</tr>
										<tr>
											<td style="text-align: left;">Area Square Feet</td>
											<td style="text-align: right;">645</td>
										</tr>
										<tr>
											<td style="text-align: left;">Price</td>
											<td style="text-align: right;"> <span>Rs</span> 645</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: left;"><button class="btn btn-primary btn-block"> But Now</button></td>

										</tr>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>

	</div>
</div>
</div>
<?php include 'common/footer.php'; ?>


<script>
	$(document).ready(function() {
		$('#inputSociety').select2({
			placeholder: "Select a Society",
			allowClear: true
		});
	});
</script>

<script>
  // Run this after the DOM loads
  document.addEventListener('DOMContentLoaded', function () {
    const lengthInput = document.getElementById('lengthInput');
    const breadthInput = document.getElementById('breadthInput');
    const areaSqft = document.getElementById('areaSqft');
    const priceValue = document.getElementById('priceValue');

    // You can set price per sqft here if needed
    const pricePerSqft = 1; // Rs.1 per sqft as per your sample

    function calculateAreaAndPrice() {
      const length = parseFloat(lengthInput.value) || 0;
      const breadth = parseFloat(breadthInput.value) || 0;
      const area = length * breadth;
      const price = (area * pricePerSqft) * 100;

      areaSqft.textContent = area;
      priceValue.textContent = price.toFixed(2);
    }

    // Trigger calculation when either input is updated
    lengthInput.addEventListener('input', calculateAreaAndPrice);
    breadthInput.addEventListener('input', calculateAreaAndPrice);
  });
</script>
