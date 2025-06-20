	<?php
	include 'common/db.php';
	include 'common/header.php'; ?>



	<?php
	$proID = base64_decode($_GET['floor_id']);



	// echo $proID;
	// die;
	$product = [];

	if ($proID) {
		$proID = (int)$proID; // Sanitize the input
		$sql = "SELECT * FROM floor_type WHERE floor_id = $proID";
		$result = $conn->query($sql);

		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc(); // Only fetch the first result
			$product = $row;
		} else {
			echo "No products found.";
		}
	} else {
		echo "Invalid product ID.";
	}


	$productPro = [];
	if (!empty($product)) {
		$prod_id = $product['property_id'];
		$sqlPro = "SELECT * FROM products WHERE productID = $prod_id";
		$resultPro = $conn->query($sqlPro);

		if ($resultPro && $resultPro->num_rows > 0) {
			$row = $resultPro->fetch_assoc(); // Only fetch the first result
			$productPro = $row;
		} else {
			echo "No products found.";
		}
		// print_r($productPro);
	}
	// $conn->close();

	?>
	<style>

		.team{
			padding-top: 0;
		}
	</style>
	<div class="home">
		<div class="breadcrumbs_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumbs">
							<ul>
								<!-- <li><a href="index.php">Home</a></li>
								<li><a href="courses.php">Courses</a></li>
								<li>Course Details</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Course -->

	<div class="course">
		<div class="container">
			<div class="row">

				<!-- Course -->
				<div class="col-lg-12">

					<div class="course_container">
						<!-- <div class="course_title">Software Training</div> -->
						<div class="course_title"><?php echo $product['floor_type'] ?></div>
						<!-- <div class="course_info d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">


							<div class="course_info_item">
								<div class="course_info_title">Teacher:</div>
								<div class="course_info_text"><a href="#">Jacke Masito</a></div>
							</div>


							<div class="course_info_item">
								<div class="course_info_title">Reviews:</div>
								<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
							</div>


							<div class="course_info_item">
								<div class="course_info_title">Categories:</div>
								<div class="course_info_text"><a href="#">Languages</a></div>
							</div>

						</div> -->

						<!-- Course Image -->
						<!-- C:\xampp\htdocs\splitfloor\admin\uploads\products\product1748878661.jpg -->
						<div class="course_image"><img src="admin/uploads/property_type/<?php echo $product['type_image'] ?>" alt=""></div>

						<!-- Course Tabs -->
						<div class="course_tabs_container">
							<div class="tabs d-flex flex-row align-items-center justify-content-start">
								<!-- <div class="tab active">description</div> -->
								<!-- <div class="tab">curriculum</div>
								<div class="tab">reviews</div> -->
							</div>
							<div class="tab_panels">

								<!-- Description -->
								<div class="tab_panel active">
									<!-- <div class="tab_panel_title">Edana </div> -->
									<div class="tab_panel_content">
										<!-- <div class="tab_panel_text">
											<p>
												<?php echo $productPro['product_description'] ?>
											</p>
										</div> -->
										<!-- <div class="tab_panel_section">
											<div class="tab_panel_subtitle">Use</div>
											<ul class="tab_panel_bullets">
												<li>GREATER NOIDA</li>
											</ul>
										</div> -->

										<div class="tab_panel_faq">
											<div class="tab_panel_title"></div>

											<!-- Accordions -->
											<div class="team">
												<div class="team_background parallax-window" data-parallax="scroll"
													data-image-src="images/team_background.jpg" data-speed="0.8"></div>
												<div class="container">
													<div class="row">
														<div class="col">
															<div class="section_title_container text-center">
																<!-- <h2 class="section_title">Property Floor</h2> -->

															</div>
														</div>
													</div>

													<div class="row team_row">
														<!-- <div class="swiper-container">
															<div class="swiper-wrapper"> -->
														<?php
														$sql = "SELECT * FROM `floor_dimensions` WHERE  property_id = {$product['property_id']} and property_type_id = {$proID}";
														$result = $conn->query($sql);

														if ($result->num_rows > 0) {
															$floorIndex = 1;
															while ($row = $result->fetch_assoc()) {
																$floorName = htmlspecialchars($row['room_type']); // e.g., "MASTER BEDROOM TOILET"
																$floorId = 'ff-' . $floorIndex;

																echo '<div class="">'; // Start slide

																echo '<div id="floor-content-' . $floorName . '" class="floor-content">';
																echo '  <div class="team_col">
						<div class="team_item" style="max-width: 320px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
							<div class="team_body" style="margin-top: 10px;">
								<div class="team_title" style="font-weight: bold; font-size: 16px;">
									<a href="#" class="toggle-ff" data-target="' . $floorId . '" style="text-decoration: none; color: #333;">' . $floorName . '</a>
									
									</div>
								
									<div style="text-align: left;">
									<span class="label">Area Sq Ft</span>
								<span class="value">' . htmlspecialchars($row['area_sqft']) . '</span>
								</div>
							</div>
						</div>
					</div>';

																// Hidden row block
																echo '<div class="row" id="' . $floorId . '" style="display: none;">
					<div class="col-md-9">
						<div class="team_card">
							<img src="https://placehold.co/300x200" alt="Property Image" class="team_img" />
							<div class="team_title">
								<span class="label">Price</span>
								<span class="value"> ₹100</span>
							</div>
							<a href="#" class="toggle-ff btn btn-primary" data-target="ff-inner-' . $floorIndex . '">Show Price</a>
						</div>
					</div>
				</div>'; // End row block

																echo '</div>'; // end of floor-content
																echo '</div>'; // end of swiper-slide

																$floorIndex++;
															}
														} else {
															echo '<div class="swiper-slide"><p>No floor data found.</p></div>';
														}

														$conn->close();
														?> <!-- <div id="floor-content-7" class="floor-content">
															<div class="col-lg-5 col-md-6 team_col">
																<div class="team_item" style="max-width: 320px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">

																	<div class="team_body" style="margin-top: 10px;">
																		<div class="team_title" style="font-weight: bold; font-size: 16px;">
																			<a href="#" class="toggle-ff" data-target="ff-77" style="text-decoration: none; color: #333;">MASTER BEDROOM TOILET</a>
																		</div>
																	</div>
																</div>

															</div>
															<div class="row" id="ff-77" style="display: none;">
																<div class="col-md-4">
																	<div class="team_card ">
																		<img src="https://placehold.co/300x200" alt="Property Image" class="team_img" />
																		<div class="team_title">
																			<span class="label">Area Sq Ft</span>
																			<span class="value">38.44</span>
																		</div>
																		<a href="#" class="toggle-ff btn btn-primary" data-target="ff-1">Show Price</a>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="team_card">
																		<img src="https://placehold.co/300x200" alt="Property Image" class="team_img" />
																		<div class="team_title">
																			<span class="label">Area Sq Ft</span>
																			<span class="value">38.44</span>
																		</div>
																		<a href="#" class="toggle-ff btn btn-primary" data-target="ff-2">Show Price</a>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="team_card">
																		<img src="https://placehold.co/300x200" alt="Property Image" class="team_img" />
																		<div class="team_title">
																			<span class="label">Area Sq Ft</span>
																			<span class="value">38.44</span>
																		</div>
																		<a href="#" class="toggle-ff btn btn-primary" data-target="ff-3">Show Price</a>
																	</div>
																</div>
															</div>
														</div> -->

														<!-- </div>
														</div>


														Swiper Pagination/Navigation (optional)
														<div class="swiper-pagination"></div>
														<div class="swiper-button-prev"></div>
														<div class="swiper-button-next"></div> -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Curriculum -->
								<!-- <div class="tab_panel tab_panel_2">
									<div class="tab_panel_content">
										<div class="tab_panel_title">Software Training</div>
										<div class="tab_panel_content">
											<div class="tab_panel_text">
												<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>
											</div>

										
											<ul class="dropdowns">
												<li class="has_children">
													<div class="dropdown_item">
														<div class="dropdown_item_title"><span>Lecture 1:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
														<div class="dropdown_item_text">
															<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
														</div>
													</div>
													<ul>
														<li>
															<div class="dropdown_item">
																<div class="dropdown_item_title"><span>Lecture 1.1:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
																<div class="dropdown_item_text">
																	<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
																</div>
															</div>
														</li>
														<li>
															<div class="dropdown_item">
																<div class="dropdown_item_title"><span>Lecture 1.2:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
																<div class="dropdown_item_text">
																	<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
																</div>
															</div>
														</li>
													</ul>
												</li>
												<li class="has_children">
													<div class="dropdown_item">
														<div class="dropdown_item_title"><span>Lecture 2:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
														<div class="dropdown_item_text">
															<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
														</div>
													</div>
													<ul>
														<li>
															<div class="dropdown_item">
																<div class="dropdown_item_title"><span>Lecture 2.1:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
																<div class="dropdown_item_text">
																	<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
																</div>
															</div>
														</li>
														<li>
															<div class="dropdown_item">
																<div class="dropdown_item_title"><span>Lecture 2.2:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
																<div class="dropdown_item_text">
																	<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
																</div>
															</div>
														</li>
													</ul>
												</li>
												<li>
													<div class="dropdown_item">
														<div class="dropdown_item_title"><span>Lecture 3:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
														<div class="dropdown_item_text">
															<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
														</div>
													</div>
												</li>
												<li>
													<div class="dropdown_item">
														<div class="dropdown_item_title"><span>Lecture 4:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
														<div class="dropdown_item_text">
															<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
														</div>
													</div>
												</li>
												<li>
													<div class="dropdown_item">
														<div class="dropdown_item_title"><span>Lecture 5:</span> Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
														<div class="dropdown_item_text">
															<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</p>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div> -->

								<!-- Reviews -->
								<div class="tab_panel tab_panel_3">
									<div class="tab_panel_title">Course Review</div>

									<!-- Rating -->
									<div class="review_rating_container">
										<div class="review_rating">
											<div class="review_rating_num">4.5</div>
											<div class="review_rating_stars">
												<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
											</div>
											<div class="review_rating_text">(28 Ratings)</div>
										</div>
										<div class="review_rating_bars">
											<ul>
												<li><span>5 Star</span>
													<div class="review_rating_bar">
														<div style="width:90%;"></div>
													</div>
												</li>
												<li><span>4 Star</span>
													<div class="review_rating_bar">
														<div style="width:75%;"></div>
													</div>
												</li>
												<li><span>3 Star</span>
													<div class="review_rating_bar">
														<div style="width:32%;"></div>
													</div>
												</li>
												<li><span>2 Star</span>
													<div class="review_rating_bar">
														<div style="width:10%;"></div>
													</div>
												</li>
												<li><span>1 Star</span>
													<div class="review_rating_bar">
														<div style="width:3%;"></div>
													</div>
												</li>
											</ul>
										</div>
									</div>

									<!-- Comments -->
									<div class="comments_container">
										<ul class="comments_list">
											<li>
												<div class="comment_item d-flex flex-row align-items-start jutify-content-start">
													<div class="comment_image">
														<div><img src="images/comment_1.jpg" alt=""></div>
													</div>
													<div class="comment_content">
														<div class="comment_title_container d-flex flex-row align-items-center justify-content-start">
															<div class="comment_author"><a href="#">Milley Cyrus</a></div>
															<div class="comment_rating">
																<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
															</div>
															<div class="comment_time ml-auto">1 day ago</div>
														</div>
														<div class="comment_text">
															<p>There are many variations of passages of Lorem Ipsum available, but the majority have alteration in some form, by injected humour.</p>
														</div>
														<div class="comment_extras d-flex flex-row align-items-center justify-content-start">
															<div class="comment_extra comment_likes"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i><span>15</span></a></div>
															<div class="comment_extra comment_reply"><a href="#"><i class="fa fa-reply" aria-hidden="true"></i><span>Reply</span></a></div>
														</div>
													</div>
												</div>
												<ul>
													<li>
														<div class="comment_item d-flex flex-row align-items-start jutify-content-start">
															<div class="comment_image">
																<div><img src="images/comment_2.jpg" alt=""></div>
															</div>
															<div class="comment_content">
																<div class="comment_title_container d-flex flex-row align-items-center justify-content-start">
																	<div class="comment_author"><a href="#">John Tyler</a></div>
																	<div class="comment_rating">
																		<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
																	</div>
																	<div class="comment_time ml-auto">1 day ago</div>
																</div>
																<div class="comment_text">
																	<p>There are many variations of passages of Lorem Ipsum available, but the majority have alteration in some form, by injected humour.</p>
																</div>
																<div class="comment_extras d-flex flex-row align-items-center justify-content-start">
																	<div class="comment_extra comment_likes"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i><span>15</span></a></div>
																	<div class="comment_extra comment_reply"><a href="#"><i class="fa fa-reply" aria-hidden="true"></i><span>Reply</span></a></div>
																</div>
															</div>
														</div>
													</li>
												</ul>
											</li>
											<li>
												<div class="comment_item d-flex flex-row align-items-start jutify-content-start">
													<div class="comment_image">
														<div><img src="images/comment_3.jpg" alt=""></div>
													</div>
													<div class="comment_content">
														<div class="comment_title_container d-flex flex-row align-items-center justify-content-start">
															<div class="comment_author"><a href="#">Milley Cyrus</a></div>
															<div class="comment_rating">
																<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
															</div>
															<div class="comment_time ml-auto">1 day ago</div>
														</div>
														<div class="comment_text">
															<p>There are many variations of passages of Lorem Ipsum available, but the majority have alteration in some form, by injected humour.</p>
														</div>
														<div class="comment_extras d-flex flex-row align-items-center justify-content-start">
															<div class="comment_extra comment_likes"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i><span>15</span></a></div>
															<div class="comment_extra comment_reply"><a href="#"><i class="fa fa-reply" aria-hidden="true"></i><span>Reply</span></a></div>
														</div>
													</div>
												</div>
											</li>
										</ul>
										<div class="add_comment_container">
											<div class="add_comment_title">Add a review</div>
											<div class="add_comment_text">You must be <a href="#">logged</a> in to post a comment.</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

			
			</div>
		</div>
	</div>

	<!-- Newsletter -->



	<!-- Footer -->

	<?php
	$page = 'course';
	include 'common/footer.php'; ?>

	<script>