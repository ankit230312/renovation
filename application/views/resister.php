<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">


  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- font-awesome icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.css">

  <!-- Owl Carousel -->
  <link rel="stylesheet" href="css/owl.carousel.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">

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
              <li><span><i class="fas fa-envelope-square"></i> Email@email.com</span></li>
              
           </ul> 
          </div>
          <div class="col-6 col-lg-6">
            <div class="header-top-right pull-right">
              <!-- Signin & Signup -->
              <button class="btn popup_btn" data-toggle="modal" data-target="#my-modal">Register</button>
              <div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                      <img src="images/logo.png" alt="logo.png" class="img-fluid">
                                                      <div class="row">
                                                          <div class="col">
                                                            <label for="exampleInputEmail1">Enter Your Name</label>
                                                            <input type="text" id ="my_input" name="Enter Your name" placeholder="Enter Your name"></div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col">
                                                          <label for="exampleInputEmail1">Enter Your Mobile Number</label>
                                                          <input type="text" id ="my_input" name="Enter Your number" placeholder="Enter Your number"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                          <label for="exampleInputEmail1">Enter Your Referal Code (Optional)</label>
                                                          <input type="text" id ="my_input" name="Enter Your Referal Code" placeholder="Enter Your Referal Code"></div>
                                                    </div>
                                                      <div class="row">
                                                          <div class="col">
                                                            <button type="button" class="btn btn-primary btn-block">Submit</button></div>
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
      <strong class="logo"><img src="images/logo.png" alt="logo.png"></strong>
      <i class="fas fa-map-marker-alt"></i><span class="location"><select class="form-control">
              <option value="Location">Location</option>
              <option value="saab">Noida</option>
              <option value="saab">Delhi</option>
              <option value="saab">Modinagar</option>
              <option value="saab">Gururam</option>
            </select></span>
      <!-- open nav mobile -->

      <!--search -->
      <label class="open-search" for="open-search">
        <i class="fas fa-search"></i>
        <input class="input-open-search" id="open-search" type="checkbox" name="menu" />
        <div class="search">
          <button class="button-search"><i class="fas fa-search"></i></button>
          <input type="text" placeholder="What are you looking for?" class="input-search"/>
        </div>
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
          <li class="nav-content-item"><a class="nav-content-link" href="#"><i class="fas fa-shopping-cart"></i></a></li>
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
          <li class="all-category-list-item"><a href="#" class="all-category-list-link">Fruits<i class="fas fa-angle-right"></i></a>

          </li>
          <li class="all-category-list-item"><a href="#" class="all-category-list-link">Vegetables <i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="#" class="all-category-list-link">Food Grains, Oil & Spices<i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="#" class="all-category-list-link">Beverages<i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="#" class="all-category-list-link">Snacks & Branded Foods<i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="" class="all-category-list-link">Egg & Dairy Products<i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="" class="all-category-list-link">Personal Care<i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="" class="all-category-list-link">Cleaning & Household<i class="fas fa-angle-right"></i></a></li>
          <li class="all-category-list-item"><a href="" class="all-category-list-link">Baby Health Store<i class="fas fa-angle-right"></i></a></li>


        </ul>
      </label>

    </nav>
    <nav class="featured-category">
      <ul class="nav-row">
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Fruits</a></li>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Vegetables</a></li>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Food Grains, Oil & Spices</a></li>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Beverages</a></li>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Snacks & Branded Foods</a></li>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Baby Health Store</a></li>
        <li class="nav-row-list"><a href="#" class="nav-row-list-link">Contact</a></li>
      </ul>
    </nav>
  </div>

  
<!----------------------------  Script Started ------------------------ -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/bootstrap.bundle.js" ></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script>

$(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  owl.owlCarousel({
      items : 10, //10 items above 1000px browser width
      itemsDesktop : [1000,5], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
  });
 

</script>

</body>
</html>