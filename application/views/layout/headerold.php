<?php

//$carts = array();

isset($search_key) ? "" : $search_key = "";

$site_settings = $this->db->get_where('settings')->row();


// if (isset($_SESSION['loginUserID']) &&  $_SESSION['loginUserID'] == TRUE && $_SESSION['loginUserID'] != ''){

//   $cart_products = '';

//   $userID = $_SESSION['loginUserID'];

//   $userInfo =  $this->db->query("select * from users where ID='$userID' and status='Y'")->row();

//   $carts = $this->db->query("SELECT `users`.`ID` as userID, COALESCE(SUM(`qty`),0) as items FROM `product_cart` LEFT JOIN `users` ON `product_cart`.`userID` = `users`.`ID` WHERE `product_cart`.`userID`='$userID'")->row();

//   if (!empty($carts)) {

//    if (!empty($_SESSION['loginUserID'])){

//      $cart_products = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`,`product_cart`.`variantID`, `product_cart`.`qty`, `products_variant`.`price`, `products_variant`.`retail_price`,`products_variant`.`unit`, `products_variant`.`unit_value`,`products_variant`.`variant_image`,`products`.`product_name`,`products`.`product_image`

//       FROM `product_cart` LEFT JOIN `products_variant` 

//       ON  `product_cart`.`variantID` = `products_variant`.`id` join `products`

//       ON `products`.`productID`=`product_cart`.`productID`

//       WHERE `product_cart`.`userID`='$userID'")->result();

//   }else{

//     $cart_products = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`,`product_cart`.`variantID`, `product_cart`.`qty`, `products_variant`.`price`, `products_variant`.`retail_price`,`products_variant`.`unit`, `products_variant`.`unit_value`,`products_variant`.`variant_image`,`products`.`product_name`,`products`.`product_image` FROM `product_cart` LEFT JOIN `products_variant` ON  `product_cart`.`variantID` = `products_variant`.`id` join `products` on `product_cart`.`productID`=`products`.`productID` WHERE `product_cart`.`userID`='$userID'")->result();

//   }

//   $carts->products = $cart_products;

// }

// }
//print_r($carts); exit;

//print_r($carts);

if (isset($_SESSION['loginUserID']) &&  $_SESSION['loginUserID'] == TRUE && $_SESSION['loginUserID'] != ''){
  $userID = $_SESSION['loginUserID'];
  $carts = $this->db->query("SELECT * FROM `product_cart` WHERE `userID`='$userID'")->result();
}else{
  $carts = [];
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- font-awesome icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

  <!-- Bootstrap CSS -->
  <link href="<?=base_url('assets/css/');?>bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>bootstrap.css">
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>style1.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>style.css">


  <!-- Owl Carousel -->
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>owl.carousel.css">
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>owl.carousel.min.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <title>Gowise Kart</title>
</head>
<body>
  <!-- Top Bar Section -->
  <header class="top-header">
    <!-- contact content -->
    <div class="top-bar">
      <div class="container">
        <div class="header-top py-1">
          <div class="row align-items-center">
            <div class="col-6 col-lg-6">
              <ul class="header-top-left pull-left">              
                <li><span><i class="fas fa-envelope-square"></i> info@gowisekart.com</span></li>

              </ul> 
            </div>
            <div class="col-6 col-lg-6">
              <div class="header-top-right pull-right">
                <?php 
                if (empty($this->session->userdata('loginUserID'))) {
                  ?>
                  <button class="btn popup_btn" data-toggle="modal" data-target="#login_modal">Login</button>
                <?php }else{?>
              <!-- <button class="btn popup_btn">My Cart</button>
              <button class="btn popup_btn">Profile</button>
              <a href="javascript:void(0)" class="btn btn-link border-none logout" onclick="logout_user(event)"><i class="mdi mdi-logout" title="Logout"> </i> Logout</a> -->


              <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                  <a href="<?=base_url('/home/profile')?>">
                    <div class="wishlist_icon"><i class="fas fa-user"></i></div></a>
                    <div class="wishlist_content">
                      <div class="wishlist_text"></div>
                    </div>
                  </div>
                  <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                    <a href="<?=base_url('home/shopping_cart');?>">
                      <div class="cart_icon"><i class="fas fa-shopping-bag"></i>
                        <div class="cart_count"><span id="total_cart_value"><?=count($carts)?></span></div>
                      </div>
                    </a>
              <!-- <div class="cart_content">
              <div class="cart_text"><a href="#">Cart</a></div>
            </div> -->

          </div> <!-- Cart -->
          <div class="cart">
            <div class="cart_container d-flex flex-row align-items-center justify-content-end">
              <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                <div class="wishlist_icon"><i class="fas fa-sign-out-alt"></i></div>
                <div class="wishlist_content">
                  <div class="wishlist_text"><a href="javascript:void(0)"  onclick="logout_user(event)">Logout</a></div>
                </div>
              </div>
            </div>

          </div>
        </div>

      <?php } ?>
      <!-- start login model -->

              <!-- <button class="btn popup_btn" data-toggle="modal" data-target="#login_otp_modal">loginotp</button>
               <button class="btn popup_btn" data-toggle="modal" data-target="#register_modal">register</button>
               <button class="btn popup_btn" data-toggle="modal" data-target="#register_otp_modal">registerotp</button> -->
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
                                <div class="col-auto text-right"><object type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="cross" aria-hidden="true">&times;</span> </object></div>
                              </div>
                            </div>
                            <div class="card-body pt-0">
                              <div class="row justify-content-center pb-sm-5 pb-3">
                                <div class="col-sm-8 col px-sm-0 px-4"><a href="<?=base_url();?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png" class="img-fluid"></a>
                                  <p class="bg-warning" id="login_error" style="background: none; color: red;"></p>   
                                  <div class="row">
                                    <div class="col">
                                      <label for="exampleInputEmail1">Enter Your Mobile Number</label>
                                      <input type="text"  id="user_mobile" onkeypress="return onlyNumberKey(event)" maxlength="10" name="Enter Your mobile Number" placeholder="Enter Your mobile Number"></div>
                                    </div>
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
                                    <div class="col-auto text-right"><object type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="cross" aria-hidden="true">&times;</span> </object></div>
                                  </div>
                                </div>
                                <div class="card-body pt-0">
                                  <div class="row justify-content-center pb-sm-5 pb-3">
                                    <div class="col-sm-8 col px-sm-0 px-4"><a href="<?=base_url();?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png" class="img-fluid"></a>
                                      <p class="bg-warning" id="otp_error" style="background-color: none; color: red;"></p> 
                                      <div class="row">
                                        <div class="col">
                                          <label for="exampleInputEmail1">Enter Your OTP Code</label>
                                          <input type="text" maxlength="6" onkeypress="return onlyNumberKey(event)"  id="login_otp" placeholder="Please Enter OTP"></div>
                                        </div>
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
                                        <div class="col-auto text-right"><object type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="cross" aria-hidden="true">&times;</span> </object></div>
                                      </div>
                                    </div>
                                    <div class="card-body pt-0">
                                      <div class="row justify-content-center pb-sm-5 pb-3">
                                        <div class="col-sm-8 col px-sm-0 px-4"><a href="<?=base_url();?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png" class="img-fluid"></a>
                                          <p class="bg-warning" id="register_otp_error" style="background-color: none; color: red;"></p>
                                          <div class="row">
                                            <div class="col">
                                              <label for="exampleInputEmail1">Enter Your OTP Code</label>
                                              <input type="text" maxlength="6" onkeypress="return onlyNumberKey(event)"  id="register_otp" placeholder="Please Enter OTP"></div>
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
                                            <div class="col-auto text-right"><object type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="cross" aria-hidden="true">&times;</span> </object></div>
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
                                                <div class="col">
                                                  <label for="exampleInputEmail1">Enter Your Name</label>
                                                  <input type="text" id="register_name" name="Enter Your name" placeholder="Enter Your name"></div>
                                                </div>
                                                <div class="row">
                                                  <div class="col">
                                                    <label for="exampleInputEmail1">Enter Your Mobile Number</label>
                                                    <input type="text" id="register_mobile" onkeypress="return onlyNumberKey(event)" maxlength="10"   name="Enter Your number" placeholder="Enter Your number"></div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col">
                                                      <label for="exampleInputEmail1">Select City</label>
                                                      <select id="user_city">
                                                        <?php $cities =  $this->home_m->get_all_table_query("SELECT * FROM city WHERE status= 'Y'");
                                                        if(!empty($cities)){
                                                          foreach($cities as $city){
                                                            ?>
                                                            <option value="<?=$city->id?>"><?=$city->title?></option>
                                                          <?php } } ?>
                                                        </select>

                                                      </div>
                                                      <div class="row">
                                                        <div class="col">
                                                          <label for="exampleInputEmail1">Enter Your Referal Code (Optional)</label>
                                                          <input type="text" id="referral_code" name="Enter Your Referal Code" placeholder="Enter Your Referal Code"></div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col">
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

                                      <!-- register otp model -->


                                      <!-- end register otp model -->






                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- / contact content -->
                        <div class="Main-menu">
                          <!-- logo -->
                          <a href="<?=base_url();?>">
                            <strong class="logo"><img src="<?=base_url('assets/images/');?>logo.png" alt="logo.png"></strong>
                          </a>
                          <i class="fas fa-map-marker-alt"></i><span class="location">
                            <select class="form-control get_cityID" onchange="get_cityID(event)" id="cityID">
                              <option value="1">Location</option>
                              <?php 
                              if (empty($this->session->userdata('cityID'))) {
                                $cityID = 1;
                              }else{
                                $cityID = $this->session->userdata('cityID');
                              }
                              $cities =  $this->home_m->get_all_table_query("SELECT * FROM city WHERE status= 'Y'");
                              if(!empty($cities)){
                                foreach($cities as $city){
                                  ?>
                                  <option value="<?=$city->id?>" <?php if($cityID==$city->id){ echo "selected"; } ?>><?=$city->title?></option>
                                <?php } } ?>
                              </select>
                            </span>
                            <!-- open nav mobile -->

                            <!--search -->
                            <label class="open-search" for="open-search">
                              <i class="fas fa-search"></i>
                              <input class="input-open-search" id="open-search" type="checkbox" name="menu" />
                              <form action="<?php echo site_url('home/product_search'); ?>" method="get" autocomplete="off">
                                <div class="search">
        <!-- <input type="hidden" name="select_category" value="">
           <input type="hidden" name="min_price" value="">

           <input type="hidden" name="max_price" value=""> -->

           <input type="text" placeholder="What are you looking for?"  type="text" name="search_key"
           value="<?=$search_key?>" required class="input-search"/>
           <button class="button-search" type="submit"><i class="fas fa-search"></i></button>
         </div>
       </form>
     </label>
     <!-- // search -->
     <nav class="nav-content">
      <!-- nav -->
      <ul class="nav-content-list">
        <li class="nav-content-item account-login">
          <label class="open-menu-login-account" for="open-menu-login-account">

            <!-- submenu -->
            <ul class="login-list">
              <li class="login-list-item"><a href="#">My account</a></li>
              <li class="login-list-item"><a href="#">Create account</a></li>
              <li class="login-list-item"><a href="#">logout</a></li>
            </label>
          </ul>
        </li>
        <!-- <li class="nav-content-item"><a class="nav-content-link" href="#"><i class="fas fa-shopping-cart"></i></a></li> -->
        <!-- call to action -->
      </ul>
    </nav>
  </div>
  <!-- nav navigation commerce -->
  <div class="navigation_content">
    <nav class="all-category-nav">
      <label class="open-menu-all" for="open-menu-all">
        <input class="input-menu-all" id="open-menu-all" type="checkbox" name="menu-open" />
        <span class="all-navigator"><i class="fas fa-bars"></i> <span>All category</span> <i class="fas fa-angle-down"></i>
        <i class="fas fa-angle-up"></i>
      </span>

      <ul class="all-category-list">
        <?php 
        $category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y'");
        if(!empty($category)){
          foreach($category as $val){
            $val->subcategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '$val->categoryID' && status= 'Y'");
          }
        }
        
        if(!empty($category)){
          foreach($category as $c){
            ?>
            <li class="all-category-list-item"><a href="<?=base_url('home/category_products/').$c->categoryID?>" class="all-category-list-link"><?=$c->title?><i class="fas fa-angle-right"></i></a></li>
          <?php } } ?>

        </ul>
      </label>

    </nav>
    <nav class="featured-category">
      <ul class="nav-row">
        <?php 
        $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y' limit 6");
        if(!empty($few_category)){
         foreach($few_category as $c){
          ?>
          <li class="nav-row-list"><a href="<?=base_url('home/category_products/').$c->categoryID?>" class="nav-row-list-link"><?=$c->title?></a></li>
        <?php } } ?>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Contact</a></li>
      </ul>
    </nav>
  </div>
</header>
<!-- header end -->

<script>

 function onlyNumberKey(evt) {



         // Only ASCII charactar in that range allowed 

         var ASCIICode = (evt.which) ? evt.which : evt.keyCode

         if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))

          return false;

        return true;

      }

    </script>