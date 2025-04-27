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
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <link rel="icon" href="https://gowisekart.com/assets/images/favicon.png" type="image/png" sizes="16x16">
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
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>owl.carousel.css">
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>owl.carousel.min.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
  <link rel="icon" href="https://gowisekart.com/assets/images/favicon.png" type="image/png" sizes="16x16">
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
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>owl.carousel.css">
  <link rel="stylesheet" href="<?=base_url('assets/css/'); ?>owl.carousel.min.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

  <title>Gowise Kart</title>

  <style type="text/css">
    .fa-whatsapp:before {
    content: "\f232";
    font-family: 'FontAwesome';
}
  	#navbar{
  		height: 100%;
  	}
    .sticky{
      top: 0;
      position: fixed;
      width: 100%;
      z-index: 33;
      background-color: #fff;
      box-shadow: 0 2px 8px rgb(0 0 0 / 12%);
      height: 71px;
    }
  .navbar-nav .dropdown:hover .dropdown-menu{
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
  .dropdown-item.active{
    color: #fff;
    text-decoration: none;
    background-color: teal;
  }
  .dropdown-item:hover{
    color: #fff;
    text-decoration: none;
    background-color: teal;
  }
  .dropdown-item{
    font-size: 13px;
    font-weight: 500;
  }
</style>
</head>
<body>
  <!-- Top Bar Section -->
  
  <header class="top-header">
    <!-- contact content -->
    <div class="top-bar">
      <div class="container">
        <div class="header-top py-1">
          <div class="row align-items-center">
            <div class="col-md-6 col-xs-12 col-sm-12 col-lg-4">
              <ul class="header-top-left pull-left">
                <li>

                  <!-- <img src="images/WhatsApp.png" alt="" width="20"> -->

                  <img src="<?=base_url('assets/www.png')?>" alt="" width="20">
                  <span>
                    +91 9719466785
                  </span>
                </li>
                  <li>
                   <i class="fa fa-envelope" aria-hidden="true" style="color: #ffff;"></i>
                    <span>email@email.com</span>

                  </li>

                  </ul>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                  <ul class="header-top-left pull-left">
                    <li style="color: #ffff; font-size: 14px;">

                      Shop For 200/- & get 200/- Cashback <b style="color: #ffc107;">Use Code: GOCASH200</b>


                    </li>
                  </ul>
                  </div>

                    <div class=" col-md-6 col-xs-12 col-sm-12 col-lg-2">
                      <div class="header-top-right pull-right">
                        <ul class="header-top-right">
                          <li>
                            <a href="https://play.google.com/store/apps/details?id=com.gowisekart" target="_blank">
                            <img src="<?=base_url('assets/gp.png')?>" alt="" width="80">
                          </a>
                          </li>
                        </ul>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / contact content -->
          <!-- id="navbar" -->
         <!--  <div id="navbar"> -->
          <div class="Main-menu" >

            <div class="logo">

              <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/')?>images/logo.png" alt="logo.png"></a>

            </div>
            <form class="d-flex pincode-div" id="pincode_submit" method="post" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
             <div class=" user show location-div" >
              <a href="#">

                <i class="fas fa-map-marker-alt" style="font-size: 14px; line-height: 32px;"></i>

              </a>

              <ul class="dropdown-menu pincode-dropdown-menu user-menu">

                <div class="jio_traingle"></div>

                <span class="location">

                  <input type="text" id="pincode" name="pincode" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  maxlength="6" placeholder="Enter Your Pincode" class="location-search form-control"><i class="fas fa-map-marker-alt"></i> 

                  <button class="btn p-0" id="pincode_button" style="color: red;font-weight: bold;">Apply</button>

                </span>

              </ul>

            </div>
            <div>
             <div class="picode-del">
              <b style="font-size: 12px; white-space: nowrap;"> Deliver to </b>
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
              <span style="font-size: 12px;"><?=$pincode?></span>
            </div>
          </div>
        </div>
      </form>
      <form action="<?php echo site_url('home/product_search'); ?>" method="post" autocomplete="off">

        <label class="open-search" for="open-search">
          <!-- <i class="fas fa-search"></i> -->
          <!-- <input class="input-open-search" id="open-search" type="checkbox" name="menu" /> -->
          <div class="search">
            <button class="button-search" type="submit"><i class="fa fa-search"></i></button>
            <input type="text" placeholder="Search For Products" class="input-search" value="<?=$search_key?>" name="search_key" />
          </div>
        </label>
      </form>



      <?php  if(!empty($this->session->userdata('user_login')) && $_SESSION['loginUserID']!='') {?>
        <div class="mr-3">
          <ul class="right-icon">
            <li class="dropdown user mt-1">
              <a href="" class="dropdown-toggle"  data-toggle="dropdown">
            
               <svg version="1.1" width="20" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <g>
                  <g>
                    <path d="M333.187,237.405c32.761-23.893,54.095-62.561,54.095-106.123C387.282,58.893,328.389,0,256,0
                    S124.718,58.893,124.718,131.282c0,43.562,21.333,82.23,54.095,106.123C97.373,268.57,39.385,347.531,39.385,439.795
                    c0,39.814,32.391,72.205,72.205,72.205H400.41c39.814,0,72.205-32.391,72.205-72.205
                    C472.615,347.531,414.627,268.57,333.187,237.405z M164.103,131.282c0-50.672,41.225-91.897,91.897-91.897
                    s91.897,41.225,91.897,91.897S306.672,223.18,256,223.18S164.103,181.954,164.103,131.282z M400.41,472.615H111.59
                    c-18.097,0-32.82-14.723-32.82-32.821c0-97.726,79.504-177.231,177.231-177.231s177.231,79.504,177.231,177.231
                    C433.231,457.892,418.508,472.615,400.41,472.615z"></path>
                  </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
              </svg>
            </a>
            <ul class="dropdown-menu user-menu">

              <li><a href="<?=base_url('home/profile');?>">Profile</a></li>
              <li><a href="<?=base_url('home/order');?>">Order </a></li>
              <li><a href="#" onclick="logout_user(event)">Logout</a></li>

            </ul>

          </li>

          <li class="mt-1">
            <a href="#">
             <!-- <i class="fas fa-shopping-cart"></i></a> -->
             <svg onclick="open_cart()" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 450.391 450.391" style="enable-background:new 0 0 450.391 450.391;" xml:space="preserve">
              <g>
                <g>
                  <g>
                    <path d="M143.673,350.322c-25.969,0-47.02,21.052-47.02,47.02c0,25.969,21.052,47.02,47.02,47.02
                    c25.969,0,47.02-21.052,47.02-47.02C190.694,371.374,169.642,350.322,143.673,350.322z M143.673,423.465
                    c-14.427,0-26.122-11.695-26.122-26.122c0-14.427,11.695-26.122,26.122-26.122c14.427,0,26.122,11.695,26.122,26.122
                    C169.796,411.77,158.1,423.465,143.673,423.465z"></path>
                    <path d="M342.204,350.322c-25.969,0-47.02,21.052-47.02,47.02c0,25.969,21.052,47.02,47.02,47.02s47.02-21.052,47.02-47.02
                    C389.224,371.374,368.173,350.322,342.204,350.322z M342.204,423.465c-14.427,0-26.122-11.695-26.122-26.122
                    c0-14.427,11.695-26.122,26.122-26.122s26.122,11.695,26.122,26.122C368.327,411.77,356.631,423.465,342.204,423.465z"></path>
                    <path d="M448.261,76.037c-2.176-2.377-5.153-3.865-8.359-4.18L99.788,67.155L90.384,38.42
                    C83.759,19.211,65.771,6.243,45.453,6.028H10.449C4.678,6.028,0,10.706,0,16.477s4.678,10.449,10.449,10.449h35.004
                    c11.361,0.251,21.365,7.546,25.078,18.286l66.351,200.098l-5.224,12.016c-5.827,15.026-4.077,31.938,4.702,45.453
                    c8.695,13.274,23.323,21.466,39.184,21.943h203.233c5.771,0,10.449-4.678,10.449-10.449c0-5.771-4.678-10.449-10.449-10.449
                    H175.543c-8.957-0.224-17.202-4.936-21.943-12.539c-4.688-7.51-5.651-16.762-2.612-25.078l4.18-9.404l219.951-22.988
                    c24.16-2.661,44.034-20.233,49.633-43.886l25.078-105.012C450.96,81.893,450.36,78.492,448.261,76.037z M404.376,185.228
                    c-3.392,15.226-16.319,26.457-31.869,27.69l-217.339,22.465L106.58,88.053l320.261,4.702L404.376,185.228z"></path>
                  </g>
                </g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
            </svg>

            <span class="cart-count" id="total_cart_value"><?=count($carts)?></span>
          </li>

        </ul>
      </div>
    <?php }else{?>

     <div class="mr-5">
      <ul class="right-icon">
        <li class="dropdown user">
          <a href="" class="dropdown-toggle" data-toggle="modal" data-target="#login_modal">

            <svg version="1.1" width="20" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
              <g>
                <g>
                  <path d="M333.187,237.405c32.761-23.893,54.095-62.561,54.095-106.123C387.282,58.893,328.389,0,256,0
                  S124.718,58.893,124.718,131.282c0,43.562,21.333,82.23,54.095,106.123C97.373,268.57,39.385,347.531,39.385,439.795
                  c0,39.814,32.391,72.205,72.205,72.205H400.41c39.814,0,72.205-32.391,72.205-72.205
                  C472.615,347.531,414.627,268.57,333.187,237.405z M164.103,131.282c0-50.672,41.225-91.897,91.897-91.897
                  s91.897,41.225,91.897,91.897S306.672,223.18,256,223.18S164.103,181.954,164.103,131.282z M400.41,472.615H111.59
                  c-18.097,0-32.82-14.723-32.82-32.821c0-97.726,79.504-177.231,177.231-177.231s177.231,79.504,177.231,177.231
                  C433.231,457.892,418.508,472.615,400.41,472.615z"></path>
                </g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
              <g>
              </g>
            </svg>
          </a>
        </li>
      </ul>
    </div>


  <?php }?>

</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light p-0 menu-bar mb-0">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <!-- <span class="navbar-toggler-icon"></span> -->
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

    /*if(!empty($category)){
      $i=0;
      foreach($category as $k => $c){
        if($i == 6) break;
        ?>
         <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <?=$c->title?>
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      
           <a class="dropdown-item" href="<?=base_url('home/category_products/').$c->categoryID?>">Test</a>
          
       </div>
     </li>

         <?php }}?>

*/?>
<?php 
if(!empty($category)){
 $i=0;
 foreach ($category as $k => $c) {
  if($i == 6) break;
  ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="<?=base_url('home/category_products/').$c->categoryID?>" id="navbarDropdown" role="button"
      aria-haspopup="true" aria-expanded="false">
      <?=$c->title?>
    </a>
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
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
      aria-haspopup="true" aria-expanded="false">
      More
    </a>
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

// $(function(){
//     $('.dropdown').hover(function() {
//         $(this).addClass('open');
//     },
//     function() {
//         $(this).removeClass('open');
//     });
// });

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

