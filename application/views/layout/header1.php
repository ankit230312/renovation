<?php

//$carts = array();

isset($search_key) ? "" : $search_key = "";

$site_settings = $this->db->get_where('settings')->row();

if (isset($_SESSION['loginUserID']) &&  $_SESSION['loginUserID'] == TRUE && $_SESSION['loginUserID'] != ''){
	$userID = $_SESSION['loginUserID'];
	$carts = $this->db->query("SELECT * FROM `product_cart` WHERE `userID`='$userID'")->result();
}else{
	$carts = [];
}


?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link rel="icon" href="<?=base_url('/');?>assets/images/favicon.png" type="image/png" sizes="16x16">
	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.gstatic.com/">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
	<!-- font-awesome icons-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
	<!-- Bootstrap CSS -->
	<link href="<?=base_url('/');?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url('/');?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?=base_url('/');?>assets/css/style1.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?=base_url('/');?>assets/css/style.css">
		<link rel="stylesheet" href="<?=base_url('/');?>assets/css/style45.css">
	<!-- <link rel="stylesheet" href="<?=base_url('/');?>assets/css/style-new.css"> -->

	<link rel="stylesheet" href="<?=base_url('/');?>assets/css/owl.carousel.css">
	<link rel="stylesheet" href="<?=base_url('/');?>assets/css/owl.carousel.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
	<title>Gowise Kart</title>

	<style type="text/css">
		.carousel-control-prev {
			left: 0px;
			opacity: 1 !important;
		}

		.carousel-control-next {
			right: 0px;
			opacity: 1 !important;
		}

		.prev__ {
			left: -40px;
		}

		.next__ {
			right: -28px;
		}
			
		
		.sticky {
			top: 0;
			position: fixed;
			width: 100%;
			z-index: 33;
			/* background-color: #fff;
			box-shadow: 0 2px 8px rgb(0 0 0 / 12%); */
		}
		@media (max-width: 768px){
			.sticky {
				position: relative;
			}   
		}

		.sticky + .content {
  padding-top: 60px;
}

		.navbar-nav .dropdown:hover .dropdown-menu {
			display: block;
			margin-top: 0;
		}

		.dropdown-toggle::after {
			display: inline-block;
			margin-left: 0.255em;
			vertical-align: 0.255em;
			content: "";
			border-top: 0.3em solid;
			border-right: 0.3em solid transparent;
			border-bottom: 0;
			border-left: 0.3em solid transparent;
		}

		.dropdown-item.active {
			color: #fff;
			text-decoration: none;
			background-color: teal;
		}

		.dropdown-item:hover {
			color: #fff;
			text-decoration: none;
			background-color: teal;
		}

		.dropdown-item {
			font-size: 13px;
			font-weight: 500;
		}
	</style>
	<style type="text/css">
		.controls .right {
			position: absolute;
			top: 50%;
			right: 10%;
		}

		.controls .left {
			position: absolute;
			top: 50%;
			left: 10%;
		}

		.fruits_store img {
			border-radius: 100%;
		}

		.fruits_store .product-thumb {
			border: none;
		}

		.slider__ .item {
			margin-right: 10px;
			width: 219px;
		}

		.slider {
			width: 100%;
			height: 148px;
			position: relative;
			margin: 0px 55px;
			overflow-x: scroll;
			overflow-y: hidden;
		}

		.slider::-webkit-scrollbar {
			display: none;
		}

		.slider .slide {
			display: flex;
			position: absolute;
			left: 0;
			transition: 0.3s left ease-in-out;
		}




		.slider .item {
			margin-right: 10px;
			width: 248px;
		}
		@media (max-width: 768px) {
			.slider .item {
				width: 201px;
			}
		}

		.slider .item:last-child {
			margin-right: 0;
		}

		.ctrl {
			text-align: center;
			margin-top: 5px;
		}

		.ctrl-btn {
			padding: 0;
			width: 30px;
			height: 30px;
			border-radius: 100%;
			background: #6c9927;
			border: none;
			font-weight: 600;
			text-align: center;
			cursor: pointer;
			font-size: 14px;
			outline: none;
			color: #fff;
			position: absolute;
			top: 50%;
			margin-top: -27.5px;
		}

		.ctrl-btn.pro-prev {
			left: 3px;
			z-index: 33;
		}

		.ctrl-btn.pro-next {
			right: 3px;
			z-index: 33;
		}

		@media (max-width: 768px) {
			.ctrl-btn.pro-prev {
				left: 0;
			}

			.ctrl-btn.pro-next {
				right: 0;
			}
		}
	</style>
	<style type="text/css">
		#button {
			display: inline-block;
			background-color: #FF9800;
			width: 40px;
			height: 40px;
			text-align: center;
			border-radius: 4px;
			position: fixed;
			bottom: 30px;
			right: 30px;
			transition: background-color .3s,
			opacity .5s, visibility .5s;
			opacity: 0;
			visibility: hidden;
			z-index: 1000;
		}

		#button::after {
			content: "\f077";
			font-family: FontAwesome;
			font-weight: normal;
			font-style: normal;
			font-size: 18px;
			line-height: 40px;
			color: teal;
		}

		#button:hover {
			cursor: pointer;
			background-color: yellowgreen;
			text-decoration: none;
		}

		#button:active {
			background-color: #555;
		}

		#button.show {
			opacity: 1;
			visibility: visible;
		}

		.content {
			width: 77%;
			margin: 50px auto;
			font-family: 'Merriweather', serif;
			font-size: 17px;
			color: #6c767a;
			line-height: 1.9;
		}

		@media (min-width: 500px) {
			.content {
				width: 43%;
			}

			#button {
				margin: 30px;
			}
		}

		.footer ul h5 {
			color: #4f4d4d;
			font-size: 12px;
			font-weight: 600;
		}

		.footer ul li a {

			color: #4f4d4d;
			font-size: 12px;
			font-weight: 600;
		}

		.copyrights {
			border-top: 1px solid rgba(195, 195, 195, .5);
			padding: 15px;
			text-align: center;
			background-color: #679436;
			color: #ffff;
			font-size: 14px;
		}

		.footer-text {
			font-size: 12px;
			text-align: justify;
			line-height: 22px;
			font-weight: 600;
		}

		.social-list li {
			background: teal;
			color: #fff;
			height: 30px;
			width: 31px;
			text-align: center;
			border-radius: 100%;
			font-size: 14px;
			box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%) !important;
		}

		.social-list li span {
			color: #fff;
		}
	</style>
</head>



<header class="top-header">
<div class="top-bar">
      <div class="container">
        <div class="header-top py-1">
          <div class="row align-items-center">
            <div class="col-md-6 col-xs-12 col-sm-12 col-lg-4">
              <ul class="header-top-left pull-left">
                <li>

                  <!-- <img src="images/WhatsApp.png" alt="" width="20"> -->

                  <img src="<?=base_url('assets/')?>www.png" alt="" width="20">
                  <span>
                    <a href="https://wa.me/9719466785" target="_blank">+91 9719466785</a>
                  </span>
                </li>
                  <li>
                   <i class="fa fa-envelope" aria-hidden="true" style="color: #ffff;"></i>
                    <span><a href="mailto: info@gowisekart.com"> info@gowisekart.com</a></span>

                  </li>

                  </ul>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                  <ul class="header-top-left pull-left">
                    <li style="color: #ffff; font-size: 14px;">
                    	Due to covid 19 pandemic, Your Order might get delayed
                      <!-- Shop For 200/- &amp; get 200/- Cashback <b style="color: #ffc107;">Use Code: GOCASH200</b> -->


                    </li>
                  </ul>
                  </div>

                    <div class=" col-md-6 col-xs-12 col-sm-12 col-lg-2">
                      <div class="header-top-right pull-right">
                        <ul class="header-top-right">
                          <li>
                            <a href="https://play.google.com/store/apps/details?id=com.gowisekart" target="_blank">
                           
                            <img src="<?=base_url('assets/')?>gp.png" alt="" width="80">
                          </a>
                          </li>
                        </ul>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
	<!--  <div id="navbar"> -->
		<div class="Main-menu">

			<div class="logo">

				<a href="<?=base_url('/')?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png"></a>

			</div>
			<div class="dropdown">
				<form class="d-flex pincode-div" id="pincode_submit" method="post">
				<div class=" user location-div">
					<a href="#" class="dropdown-toggle"
				data-toggle="dropdown" aria-expanded="true">

						<i class="fas fa-map-marker-alt" style="font-size: 14px;"></i>

					</a>

					<ul class="dropdown-menu pincode-dropdown-menu user-menu">

						<div class="jio_traingle"></div>

						<span class="location">

							<input type="text" id="pincode" name="pincode"
							oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="6"
							placeholder="Enter Your Pincode" class="location-search form-control"><i
							class="fas fa-map-marker-alt"></i>

							<button class="btn p-0" id="pincode_button" style="color: red;font-weight: bold;">Apply</button>

						</span>

					</ul>

				</div>
				<div>
					<?php 
					if (empty($this->session->userdata('loginUserID'))) {
						$pincode = $this->session->userdata('pincode');
						if(empty($pincode)){
							$pincode = '201309';
						}
					}else{
						$userID = $this->session->userdata('loginUserID');
						$pincode1 = $this->session->userdata('pincode');
						$pincode2 = isset($pincode1) ? $pincode1 :'';
						if(!empty($pincode2)){
							$this->db->set('pincode', $pincode2);
							$this->db->where('id',$userID);
							$this->db->update('users');
						}else{
							$pincode2 = '201309';
						}
						$user =  $this->db->get_where('users',array('ID'=>$userID))->row();
						$pincode = isset($user->pincode) ? $user->pincode :$pincode2;
					}

					?>
					<div class="picode-del">
						<p style="font-size: 12px; white-space: nowrap;"> Deliver to </p>

						<p style="font-size: 12px;"><?=$pincode?></p>

					</div>
				</div>
			</form>
		</div>

			<form action="<?=base_url('home/product_search')?>" method="post" autocomplete="off">

				<label class="open-search" for="open-search">

					<div class="search">
						<button class="button-search" type="submit"><i class="fa fa-search"></i></button>
						<input type="text" placeholder="Search For Products" class="input-search"value="<?=$search_key?>" name="search_key" />
					</div>
				</label>
			</form>
			<div class="mr-5">

				<?php  if(!empty($this->session->userdata('user_login')) && $_SESSION['loginUserID']!='') {?>
					<ul class="right-icon">
						<li class="dropdown user mt">
							<a href="" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?=base_url('admin/uploads/use.png');?>" alt="" width="27">

								<span class="text">Welcome <?=$_SESSION['name']?></span>

							</a>
							<ul class="dropdown-menu user-menu">

								<li><a href="<?=base_url('home/profile')?>">Profile</a></li>
								<li><a href="<?=base_url('home/order')?>">Order </a></li>
								<li><a href="#" onclick="logout_user(event)">Logout</a></li>

							</ul>

						</li>

						<li class="mt">
							<a href="#" onclick="open_cart()">
								<img src="<?=base_url('admin/uploads/shopping-cart.png');?>" alt="" width="25">


								<span class="text">Cart</span>

								<span class="cart-count" id="total_cart_value" style="color: #fff;">1</span>
							</a>
						</li>


					</ul>

				<?php }else{?>
					<ul class="right-icon">
						<li class="dropdown user mt">
							<a href="" class="dropdown-toggle" data-toggle="modal" data-target="#login_modal">

								<img src="<?=base_url('admin/uploads/use.png');?>" alt="" width="27">

								<span class="text">Sign In/ Signup</span>

							</a>


						</li>


					</ul>

				<?php }?>
			</div>



		</div>

		<nav class="navbar navbar-expand-lg navbar-light bg-light menu-bar" id="navbar">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

				<span>Categories</span>
			</button>

			

		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav nav-row">
				<?php 
				$category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y'");
				if(!empty($category)){
					foreach($category as $val){
						$val->subcategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '$val->categoryID' && status= 'Y'");
					}
				}


				if(!empty($category)){
					$i=0;
					foreach ($category as $k => $c) {
						if($i == 6) break;
						?>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="<?=base_url('home/category_products/').$c->categoryID?>" id="navbarDropdown" role="button" aria-haspopup="true"
							aria-expanded="false">
							<?=$c->title?> </a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<?php 
								$subcategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '$c->categoryID' && status= 'Y'");
								if(!empty($subcategory)){
									foreach($subcategory as $subcat){
										?>
										<a class="dropdown-item" href="<?=base_url('home/sub_category_products/').$subcat->categoryID?>"><?=$subcat->title?></a>
									<?php }}?>
								</div>
							</li>

							<?php  ++$i;}}?>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true"
								aria-expanded="false">
							More</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<?php 
								if(!empty($category)){
									foreach ($category as $k => $c) {
										if ($k < 6) continue;
										?>
										<a class="dropdown-item" href="<?=base_url('home/category_products/').$c->categoryID?>"><?=$c->title?></a>
									<?php }}?>
								</div>
							</li>



							<li class="nav-item">
								<a class="nav-link" href="#">Contact</a>
							</li>

						</ul>
					</div>
				</nav>


			</div>
		</header>


		<!-- start login model -->
		<div id="login_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered justify-content-center " role="document">
				<div class="modal-content border-0 mx-3">
					<div class="modal-body p-0">
						<div class="row justify-content-center">
							<div class="col">
								<div class="card">
									<div class="card-header bg-white border-0 pb-3">
										<div class="row justify-content-between align-items-center">
											<div class="flex-col-auto"></div>
											<div class="col-auto text-right">

												<object type="button" class="close" data-dismiss="modal" aria-label="Close"  style="    position: absolute;
												bottom: -17px;
												background: teal;
												opacity: 1;
												color: white;
												border-radius: 100%;
												height: 37px;
												width: 37px;
												line-height: 10px;
												text-align: center;
												left: 13px;
												"> <span class="cross" aria-hidden="true">&times;</span> </object>


											</div>
										</div>
									</div>
									<div class="card-body pt-0">
										<div class="row justify-content-center pb-sm-5 pb-3">
											<div class="col-sm-8 col px-sm-0 px-4"><a href="<?=base_url();?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png" class="img-fluid"></a>
												<p class="bg-warning" id="login_error" style="background: none; color: red;"></p>   
												<div class="row">
													<div class="col">
														<label for="exampleInputEmail1">Enter Your Mobile Number</label>
														<input type="text"  id="user_mobile" onkeypress="return onlyNumberKey(event)" maxlength="10" class="form-control" name="Enter Your mobile Number" placeholder="Enter Your mobile Number"></div>
													</div>
													<br>
													<div class="row">
														<div class="col">
															<button type="button"  onclick="user_login(event)" class="btn btn-primary btn-block">Submit</button></div>
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
				</div>
				<!--end  login model -->


				<!-- start login otp  model -->

				<div id="login_otp_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered justify-content-center " role="document">
						<div class="modal-content border-0 mx-3">
							<div class="modal-body p-0">
								<div class="row justify-content-center">
									<div class="col">
										<div class="card">
											<div class="card-header bg-white border-0 pb-3">
												<div class="row justify-content-between align-items-center">
													<div class="flex-col-auto"></div>
													<div class="col-auto text-right">


														<object type="button" class="close" data-dismiss="modal" aria-label="Close"  style="    position: absolute;
														bottom: -17px;
														background: teal;
														opacity: 1;
														color: white;
														border-radius: 100%;
														height: 37px;
														width: 37px;
														line-height: 10px;
														text-align: center;
														left: 13px;
														"> <span class="cross" aria-hidden="true">&times;</span> </object>



													</div>
												</div>
											</div>
											<div class="card-body pt-0">
												<div class="row justify-content-center pb-sm-5 pb-3">
													<div class="col-sm-8 col px-sm-0 px-4"><a href="<?=base_url();?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png" class="img-fluid"></a>
														<p class="bg-warning" id="otp_error" style="background-color: none; color: red;"></p> 
														<div class="row">
															<div class="col">
																<label for="exampleInputEmail1">Enter Your OTP Code</label>
																<input type="text" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)"  id="login_otp" placeholder="Please Enter OTP">


															</div>
														</div>
														<br>
														<div class="row">
															<div class="col">
																<button type="button" onclick="otp_submit(event)" class="btn btn-primary btn-block">Submit</button></div>
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
					</div>
					<!-- end login otp  model -->
					<!-- start register otp  model -->

					<div id="register_otp_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered justify-content-center " role="document">
							<div class="modal-content border-0 mx-3">
								<div class="modal-body p-0">
									<div class="row justify-content-center">
										<div class="col">
											<div class="card">
												<div class="card-header bg-white border-0 pb-3">
													<div class="row justify-content-between align-items-center">
														<div class="flex-col-auto"></div>
														<div class="col-auto text-right">


															<object type="button" class="close" data-dismiss="modal" aria-label="Close"  style="    position: absolute;
															bottom: -17px;
															background: teal;
															opacity: 1;
															color: white;
															border-radius: 100%;
															height: 37px;
															width: 37px;
															line-height: 10px;
															text-align: center;
															left: 13px;
															"> <span class="cross" aria-hidden="true">&times;</span> </object>




														</div>
													</div>
												</div>
												<div class="card-body pt-0">
													<div class="row justify-content-center pb-sm-5 pb-3">
														<div class="col-sm-8 col px-sm-0 px-4"><a href="<?=base_url();?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png" class="img-fluid"></a>
															<p class="bg-warning" id="register_otp_error" style="background-color: none; color: red;"></p>
															<div class="row">
																<div class="col">
																	<label for="exampleInputEmail1">Enter Your OTP Code</label>
																	<input type="text" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)"  id="register_otp" placeholder="Please Enter OTP"></div>
																</div>
																<div class="row">
																	<div class="col">
																		<button type="button" onclick="register_otp_submit(event)" class="btn btn-primary btn-block">Submit</button></div>
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
							</div>
							<!-- end register otp  model -->

							<!-- start register model -->
							<div id="register_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered justify-content-center " role="document">
									<div class="modal-content border-0 mx-3">
										<div class="modal-body p-0">
											<div class="row justify-content-center">
												<div class="col">
													<div class="card">
														<div class="card-header bg-white border-0 pb-3">
															<div class="row justify-content-between align-items-center">
																<div class="flex-col-auto"></div>
																<div class="col-auto text-right">

																	<object type="button" class="close" data-dismiss="modal" aria-label="Close"  style="    position: absolute;
																	bottom: -17px;
																	background: teal;
																	opacity: 1;
																	color: white;
																	border-radius: 100%;
																	height: 37px;
																	width: 37px;
																	line-height: 10px;
																	text-align: center;
																	left: 13px;
																	"> <span class="cross" aria-hidden="true">&times;</span> </object>


																</div>
															</div>
														</div>
														<div class="card-body pt-0">
															<div class="row justify-content-center pb-sm-5 pb-3">
																<div class="col-sm-8 col px-sm-0 px-4">
																	<p class="bg-warning" id="register_error" style="background: none; color: red;"></p>
																	<a href="<?=base_url();?>">
																		<img src="<?=base_url('assets/');?>images/logo.png" alt="logo.png" class="img-fluid">
																	</a>
																	<div class="row">
																		<div class="col mb-3">
																			<label for="exampleInputEmail1">Enter Your Name</label>
																			<input type="text"  class="form-control" id="register_name" name="Enter Your name" placeholder="Enter Your name"></div>
																		</div>
																		<div class="row">
																			<div class="col mb-3">
																				<label for="exampleInputEmail1">Enter Your Mobile Number</label>
																				<input type="text" class="form-control" id="register_mobile" onkeypress="return onlyNumberKey(event)" maxlength="10"   name="Enter Your number" placeholder="Enter Your number"></div>
																			</div>
																			<div class="row">
																				<div class="col mb-3">
																					<label for="exampleInputEmail1">Select City</label>
																					<select class="form-control" id="user_city">
																						<?php $cities =  $this->home_m->get_all_table_query("SELECT * FROM city WHERE status= 'Y'");
																						if(!empty($cities)){
																							foreach($cities as $city){
																								?>
																								<option value="<?=$city->id?>"><?=$city->title?></option>
																							<?php } } ?>
																						</select>

																					</div>
																				</div>

																				<div class="row">
																					<div class="col mb-3">
																						<label for="exampleInputEmail1">Enter Your Referal Code (Optional)</label>
																						<input class="form-control" type="text" id="referral_code" name="Enter Your Referal Code" placeholder="Enter Your Referal Code"></div>
																					</div>
																					<div class="row">
																						<div class="col mb-3">
																							<button type="button"  onclick="user_register_info(event)" class="btn btn-primary btn-block">Submit</button></div>
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
												</div>

												<!-- end register model -->

<script type="text/javascript">
	function open_cart(){
  window.location.href = '<?=base_url('home/shopping_cart');?>';
}

</script>

<script>
	// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>