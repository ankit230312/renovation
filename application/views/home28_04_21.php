<script src="script.js"></script>
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
  .fruits_store img{
    border-radius: 100%;
  }
  .fruits_store .product-thumb{
    border:none;
  }
  .slider {
    width: 100%;
    height: 350px;
    position: relative;
    margin: auto;
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
    width: 219px;
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
    width: 50px;
    height: 50px;
    border-radius: 100%;
    background: teal;
    border: none;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
    outline: none;
    color: #ff9800;

    position: absolute;
    top: 50%;
    margin-top: -27.5px;
  }

  .ctrl-btn.pro-prev {
    left: -50px;
    z-index: 33;
  }

  .ctrl-btn.pro-next {
    right: -50px;
    z-index: 33;
  }
  @media (max-width: 768px){
    .ctrl-btn.pro-prev{
      left: 0;
    }
    .ctrl-btn.pro-next{
      right: 0;
    }
  }
  
</style>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

  <ol class="carousel-indicators">

    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>

    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>

    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>

  </ol>

  <div class="carousel-inner">

    <?php 

    if(!empty($web_banners)){

      $i=1;

      foreach($web_banners as $b){

        ?>

        <div class="carousel-item <?php if($i==1) echo 'active'?>">

          <img class="d-block w-100" src="<?=base_url('admin/uploads/banners/web_banners/').$b->banner?>" alt="First slide">

        </div>

        <?php $i++;} } ?>

      </div>

      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">

        <span class="carousel-control-prev-icon" aria-hidden="true"></span>

        <span class="sr-only">Previous</span>

      </a>

      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">

        <span class="carousel-control-next-icon" aria-hidden="true"></span>

        <span class="sr-only">Next</span>

      </a>

    </div>


    <section class="about">

      <div class="container">

        <div class="row">

          <div class="col-lg-4 ">

            <div class="about_1 mb-2">

              <img src="<?=base_url('assets/');?>images/bo-1.jpg">

            </div>

          </div>

          <div class="col-lg-4">

            <div class="about_2 mb-2">

              <img src="<?=base_url('assets/');?>images/bo-2.jpg">

            </div>

          </div>

          <div class="col-lg-4">

            <div class="about_3 mb-2">

              <img src="<?=base_url('assets/');?>images/bo-3.jpg">

            </div>

          </div>

        </div>

      </div>



    </section>







    <section class="our-publication pt-40 pb-40" style="background-color:cornsilk; display: none;">

      <div class="container">

        <h3 class="h3">Best Deals</h3>

        <hr>

        <div class="row" style="position: relative;">
          
          <div class="slider" id="slider">
            <div class="slide" id="slide">
              <div class="item"><div class="product-grid4">

                <div class="product-image4">

                  <a href="#">

                    <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



                  </a>



                  <span class="product-new-label">New</span>

                  <span class="product-discount-label">23%</span>

                </div>

                <div class="product-content">

                  <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

                  <div class="price">

                    ₹170.00 <del class="ml-1">₹  220.00</del>



                  </div>

                  <span>

                    <div class="quantity buttons_added">

                      <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

                      <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

                      <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

                    </div>



                  </span>

                  <div class="qty">



                   1-KG


                 </div>

                 <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

<!-- <div class="quantity buttons_added">

<input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

inputmode=""><input type="button" value="+" class="plus">

</div> -->

</span>

<div class="form-group required multiple" style="display: none;">

  <select id="input-option230" class="form-control">

    <option value=""> Please Select </option>

    <option value="45">1kg(+$0.07)</option>

    <option value="46">5kg(+$0.22)</option>

    <option value="47">10kg(+$0.44)</option>

  </select>

</div>

<a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

</div>

</div></div>
<div class="item"><div class="product-grid4">

  <div class="product-image4">

    <a href="#">

      <img class="pic-1" src="http://web.gowisekart.com/admin/uploads/products/product1570770420.jpg">



    </a>



    <span class="product-new-label">New</span>

    <span class="product-discount-label">23%</span>

  </div>

  <div class="product-content">

    <h3 class="title"><a href="http://web.gowisekart.com/home/product_detail/61">Apple - Kinnaur Red Delicious Regular</a></h3>

    <div class="price">

      ₹170.00 <del class="ml-1">₹  220.00</del>



    </div>

    <span>

      <div class="quantity buttons_added">

        <input type="button" value="-" class="minus" onclick="add_to_cart_type(61,218,event,0)">

        <input type="number" step="1" min="1" max="5" id="get_qty61" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

        <input type="button" value="+" class="plus" onclick="add_to_cart_type(61,218,event,1)">

      </div>



    </span>

    <div class="qty">



     1-KG


   </div>

   <span>

              <!-- <div class="quantity buttons_added">

                <input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

                  name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

                  inputmode=""><input type="button" value="+" class="plus">

                </div> -->

              </span>

              <div class="form-group required multiple" style="display: none;">

                <select id="input-option230" class="form-control">

                  <option value=""> Please Select </option>

                  <option value="45">1kg(+$0.07)</option>

                  <option value="46">5kg(+$0.22)</option>

                  <option value="47">10kg(+$0.44)</option>

                </select>

              </div>

              <a class="add-to-cart change_argument_new" onclick="add_to_cart(61,218,event);">ADD TO CART</a>

            </div>

          </div></div>   
        </div>
        
      </div>
      <button class="ctrl-btn pro-prev"><</button>
      <button class="ctrl-btn pro-next">></button>

      <?php 

      if(!empty($deal_product)){

        foreach($deal_product as $p){



          $imgUrl = '';

          if (file_exists("./admin/uploads/products/".$p['product_image'])) {

            $imgUrl = base_url('admin/uploads/products/'). $p['product_image'];

          }else{

            $imgUrl = base_url('assets/images/no_images.png');

          }

          ?>

          <div class="col-md-3 col-sm-6 col-xs-6 col-6">

            <div class="product-grid4">

              <div class="product-image4">

                <a href="#">

                  <img class="pic-1" src="<?=$imgUrl?>">



                </a>



                <span class="product-new-label">New</span>

                <span class="product-discount-label"><?=ceil((($p['retail_price']-$p['price'])/$p['retail_price'])*100); ?>%</span>

              </div>

              <div class="product-content">

                <h3 class="title"><a href="<?=base_url('home/product_detail/').$p['productID'];?>"><?=$p['product_name'];?></a></h3>

                <div class="price">

                  ₹<?=$p['price'];?> <del class="ml-1">₹  <?=$p['retail_price'];?></del>



                </div>

                <span>

                  <div class="quantity buttons_added">

                    <input type="button" value="-"   class="minus"  onclick="add_to_cart_type(<?=$p['productID']?>,<?=$p['variantID']?>,event,0)">

                    <input type="number" step="1" min="1" max="<?=$p['max_quantity'];?>" id="get_qty<?=$p['productID'];?>" name="quantity" value="<?php if($p['cart_qty']>0){ echo $p['cart_qty'];}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

                    <input type="button" value="+" class="plus"  onclick="add_to_cart_type(<?=$p['productID']?>,<?=$p['variantID']?>,event,1)">

                  </div>



                </span>

                <div class="qty">



                 <?=$p['unit_value'].'-'.$p['unit'].'';?>



               </div>

               <span>

              <!-- <div class="quantity buttons_added">

                <input type="button" value="-" class="minus"><input type="number" step="1" min="1" max=""

                  name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern=""

                  inputmode=""><input type="button" value="+" class="plus">

                </div> -->

              </span>

              <div class="form-group required multiple" style="display: none;">

                <select  id="input-option230" class="form-control">

                  <option value=""> Please Select </option>

                  <option value="45">1kg(+$0.07)</option>

                  <option value="46">5kg(+$0.22)</option>

                  <option value="47">10kg(+$0.44)</option>

                </select>

              </div>

              <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p['productID']?>,<?=$p['variantID']?>,event);">ADD TO CART</a>

            </div>

          </div>
          

        </div>
        

      <?php }}?>


      <div class="col-sm-12 text-center">

        <div class="btn btn-primary viewall"><a href="">View All</a></div>

      </div>
    </section>



    <!-- New Section Banner Start ---------- -->

    <section class="feature_bg pb-40">

      <div class="container">

        <div class="row">

          <div class="col-lg-12 feature_bg_secc text-center">



            <?php 

            $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y' limit 6");



            if(!empty($few_category)){

             foreach($few_category as $c){

              ?>





              <a class="text-center category-product" href="<?=base_url('home/category_products/').$c->categoryID;?>">



                <img src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="Apple" class="img-fluid">



                <p><?=$c->title?></p>





              </a>











            <?php } } ?> 



          </div>

        </div>

      </div>

    </section>






    <!------ Include the above in your HEAD tag ---------->
    <section class="feature_products pb-40" style="background-color: aliceblue;">

      <div class="container">

        <div class="row">

          <div class="col-12">
            <br>
            <div class="section_title our-publication"> <h3 class="h3"> Best Deal Of The Day </h3></div>

          </div>





        </div>

        <div class="row">



          <?php 

          if(!empty($featured)){

                                 // print_r($featured);

            foreach($featured as $p){

             $imgUrl = '';

             if (file_exists("./admin/uploads/products/".$p->product_image)) {

              $imgUrl = base_url('admin/uploads/products/'). $p->product_image;

            }else{

              $imgUrl = base_url('assets/images/no_images.png');

            }

            ?>



            <div class="col-md-3 col-sm-6 col-xs-6 col-6">

              <div class="product-grid4">

                <div class="product-image4">

                  <a href="#">

                    <img class="pic-1" src="<?=$imgUrl?>">



                  </a>



                  <span class="product-new-label">New</span>

                  <span class="product-discount-label"><?=ceil((($p->retail_price - $p->price)/$p->retail_price)*100); ?>%</span>

                </div>

                <div class="product-content">

                  <h3 class="title"><a href="<?=base_url('home/product_detail/').$p->productID;?>"><?=$p->product_name;?></a></h3>

                  <div class="price">

                    ₹<?=$p->price;?> <del class="ml-1">₹  <?=$p->retail_price;?></del>



                  </div>

                  <span>

                    <div class="quantity buttons_added">

                      <input type="button" value="-"   class="minus"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,0)">

                      <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" id="get_qty<?=$p->productID;?>" name="quantity" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

                      <input type="button" value="+" class="plus"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,1)">

                    </div>

                  </span>

                  <div class="qty">



                   <?=$p->unit_value.'-'.$p->unit.'';?>



                 </div>

                 <span>



                 </span>

                 <div class="form-group required multiple" style="display: none;">

                  <select  id="input-option230" class="form-control">

                    <option value=""> Please Select </option>

                    <option value="45">1kg(+$0.07)</option>

                    <option value="46">5kg(+$0.22)</option>

                    <option value="47">10kg(+$0.44)</option>

                  </select>

                </div>

                <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$p->variantID?>,event);">ADD TO CART</a>

              </div>

            </div>

          </div>

        <?php }}?>





      </div>

    </div>



  </section>


  <!-- New Section Started -->





  <!-- ========================= product Categories Section ================================= -->



  <section class="top-categories pt-5 pb-40" style="background-color: beige">



    <div class="container">

      <div class="row">

       <div class="section_title our-publication ">  <h3 class="h3">Top category</h3></div>

       <?php 

       $category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y'");

       if(!empty($category)){

        foreach($category as $val){

          $val->subcategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '$val->categoryID' && status= 'Y'");

        }

      }



      if(!empty($category)){

        $i=0;

        foreach($category as $c){

          if($i == 6) break;

          ?>

          <div class="product-layout col-lg-2 col-md-3 col-sm-4 col-6">

            <div class="product-thumb transition text-center" style="padding: 0px;">

              <div class="caption categoryname">

                <h4 style="background:teal;"><a style="color: #fff;" href="<?=base_url('home/category_products/'.$c->categoryID)?>"><?=$c->title?></a></h4>

              </div>

              <div class="image"><a href="<?=base_url('home/category_products/'.$c->categoryID)?>"><img src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="green_pear-1"

                title="green_pear-1" class="img-fluid"></a></div>

              </div>

            </div>

            

            <?php 

            $i++;

          } } ?>





        </div>

      </div>



    </section>



    <!-- ========================= product Fruits Store  Section ================================= -->

    <section class="fruits_store pb-40 pt-5" style="background-color:bisque;">

      <div class="container">

        <div class="row">

          <div class="col-12 ">



            <div class="section_title our-publication"><h3 class="h3"> Fruits store </h3></div>

          </div>

        <!-- <div class="col-sm-3 text-center mb-15"> <img style="height: 400px;
        border: 1px solid teal;border-radius: 8px;" src="<?=base_url('assets/strawberry_1.jpg')?>"  alt="" title=""

        class="img-fluid"> </div> -->

        <div class="col-sm-12 right_block">

          <div class="row">

            <?php 

            if(!empty($subCategory_products)){

             foreach($subCategory_products as $subcategory){

              if($subcategory->products){

                foreach($subcategory->products as $p){

                 ?>

                 <div class="product-layout col-lg-2 col-md-2 col-sm-4 col-6">

                  <div class="product-thumb transition">
                    

                    <div class="image"><a href="<?=base_url('home/product_detail/').$p->productID?>"><img src="<?=base_url('admin/uploads/products/'). $p->product_image;?>" alt="Apple" title="Apple"

                      class="img-fluid"></a>

                    </div>
                    <div class="mt-3">

                      <h4 ><a class="mb-3" href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a></h4>
                    </div>

                  </div>

                </div>

              <?php }}}}?>





            </div>

          </div>

          <div class="col-sm-12 text-center">

            <div class="btn btn-primary viewall"><a href="<?=base_url('home/category_products/1')?>">View All</a></div>

          </div>

        </div>

      </div>

    </section>



    <!-- ================================  Feature Products ==================================== -->

    <section class="feature_products pb-40 pt-5 pb-5" style="background-color: #e6e6fae6;">

      <div class="container">

        <div class="row">

          <div class="col-12">

            <div class="section_title our-publication"> <h3 class="h3"> Featured Products </h3></div>

          </div>





        </div>

        <div class="row">



          <?php 

          if(!empty($featured)){// print_r($featured);

            foreach($featured as $p){

             $imgUrl = '';

             if (file_exists("./admin/uploads/products/".$p->product_image)) {

              $imgUrl = base_url('admin/uploads/products/'). $p->product_image;

            }else{

              $imgUrl = base_url('assets/images/no_images.png');

            }

            ?>



            <div class="col-md-3 col-sm-6 col-xs-6 col-6">

              <div class="product-grid4">

                <div class="product-image4">

                  <a href="#">

                    <img class="pic-1" src="<?=$imgUrl?>">



                  </a>



                  <span class="product-new-label">New</span>

                  <span class="product-discount-label"><?=ceil((($p->retail_price - $p->price)/$p->retail_price)*100); ?>%</span>

                </div>

                <div class="product-content">

                  <h3 class="title"><a href="<?=base_url('home/product_detail/').$p->productID;?>"><?=$p->product_name;?></a></h3>

                  <div class="price">

                    ₹<?=$p->price;?> <del class="ml-1">₹  <?=$p->retail_price;?></del>



                  </div>

                  <span>

                    <div class="quantity buttons_added">

                      <input type="button" value="-"   class="minus"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,0)">

                      <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" id="get_qty<?=$p->productID;?>" name="quantity" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">

                      <input type="button" value="+" class="plus"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,1)">

                    </div>



                  </span>

                  <div class="qty">



                   <?=$p->unit_value.'-'.$p->unit.'';?>



                 </div>

                 <span>



                 </span>

                 <div class="form-group required multiple" style="display: none;">

                  <select  id="input-option230" class="form-control">

                    <option value=""> Please Select </option>

                    <option value="45">1kg(+$0.07)</option>

                    <option value="46">5kg(+$0.22)</option>

                    <option value="47">10kg(+$0.44)</option>

                  </select>

                </div>

                <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$p->variantID?>,event);">ADD TO CART</a>

              </div>

            </div>

          </div>

        <?php }}?>





      </div>

    </div>



  </section>



  <!-- ========================= Vegetable & Grocery Section ================================= -->

  <section class="fruits_store pb-5 pt-5" style="background-color:#fdf9e6;">

    <div class="container">

      <div class="row">

        <div class="col-12">

          <div class="section_title our-publication"><h3 class="h3"> Vegetable store </h3></div>

        </div>
<!-- 
        <div class="col-sm-3 text-center mb-15"><img src="<?=base_url('assets/images/unnamed.png')?>" style="height: 400px;
        border: 1px solid teal;border-radius: 8px;" alt="" title=""

        class="img-fluid"> </div> -->

        <div class="col-md-12 right_block">

          <div class="row">

            <?php 

            if(!empty($vegitable_products)){

             $i=0;

             foreach($vegitable_products[0]->products as $p){

              ++$i;



              if($i > 6) break; 

              ?>

              <div class="product-layout col-lg-2 col-md-2 col-sm-4 col-6">

                <div class="product-thumb transition">



                  

                 


                  <div class="image mt-3">

                    <a href="<?=base_url('home/product_detail/').$p->productID?>"><img src="<?=base_url('admin/uploads/products/'). $p->product_image;?>" alt="Apple" title="Apple"

                      class="img-fluid"></a>

                    </div>
                    <div class="mt-3">
                      
                      <h4>
                       <a href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a>
                     </h4>
                   </div>

                 </div>

               </div>

               <?php 

             }



           }?>





         </div>

       </div>

       <div class="col-sm-12 text-center">

        <div class="btn btn-primary viewall"><a href="<?=base_url('home/category_products/2')?>">View All</a></div>

      </div>

    </div>

  </div>

</section>

<!-- Grocery Store ------------------------>

<section class="fruits_store pb-5 pt-5" style="background: bisque;">

  <div class="container our-publication">

    <h3 class="h3"> Grocery store </h3>

    <div class="row">

      <div class="col-12">

        <div class="section_title"> </div>

      </div>

<!--       <div class="col-sm-3 text-center mb-15"> <img src="<?=base_url('assets/Grocery_banner.jpg')?>" style="height: 400px;
      border: 1px solid teal;border-radius: 8px;" alt="" title=""

      class="img-fluid"> </div> -->

      <div class="col-sm-12  right_block">

        <div class="row">

          <?php 

          if(!empty($grocery_products)){

            $i =0;

            foreach($grocery_products[0]->products as $p){

             ++$i;



             if($i > 6) break; 

             ?>

             <div class="product-layout col-lg-2 col-md-2 col-sm-4 col-6">

              <div class="product-thumb transition">
               
                <div class="image"><a href="<?=base_url('home/product_detail/').$p->productID?>"><img style="border-radius: 0;" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>" alt="Apple" title="Apple"

                  class="img-fluid">

                </a>

              </div>
              <div class="mt-3">

                <h4><a class="mb-3" href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a></h4>
              </div>


            </div>

          </div>

        <?php }}?>





      </div>

    </div>

    <div class="col-sm-12 text-center">

      <div class="btn btn-primary viewall"><a href="<?=base_url('home/category_products/3')?>">View All</a></div>

    </div>

  </div>

</div>

</section>

<!-- ================================= Why Choose us ==================================== -->

<section class="fruits_store">

  <div class="shipping-outer section">

    <div class="container">

      <div class="shipping-inner row">

        <div class="heading col-12 col-sm-3 text-center text-lg-left">

          <h2>Why choose us?</h2>

        </div>

        <div class="subtitle-part subtitle-part1 col-12 mb-3 col-sm-3  text-lg-left">

          <div class="subtitle-part-inner text-left">

            <div class="subtitile">

              <div class="subtitle-part-image"><i class="far fa-clock"></i></div>

              <div class="subtitile1">On time delivery</div>

              <div class="subtitile2"></div>

            </div>

          </div>

        </div>

        <div class="subtitle-part subtitle-part2 mb-3 col-12 col-sm-3 text-center text-lg-left">

          <div class="subtitle-part-inner text-left">

            <div class="subtitile">

              <div class="subtitle-part-image"><i class="fas fa-truck"></i></div>

              <div class="subtitile1">Free delivery</div>

              <div class="subtitile2">Order over ₹200</div>

            </div>

          </div>

        </div>

        <div class="subtitle-part subtitle-part3 col-12 col-sm-3 mb-3 text-center text-lg-left">

          <div class="subtitle-part-inner text-left">

            <div class="subtitile">

              <div class="subtitle-part-image"><i class="fas fa-check-circle"></i></div>

              <div class="subtitile1">Quality assurance</div>

              <div class="subtitile2">You can trust us</div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>
<?php

// $user_ip = $_SERVER['REMOTE_ADDR'];
// $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
// print_r($geo);
// echo $user_ip;
// $country = $geo["geoplugin_countryName"];
// $city = $geo["geoplugin_city"];
// $latitude = $geo['geoplugin_latitude'];
// $longitude = $geo['geoplugin_longitude'];
// $geocode = file_get_contents("http://maps.google.com/maps/api/geocode/json?latlng=$latitude,$longitude");
// $json = json_decode($geocode);


?>

<script>
  "use strict";

  productScroll();

  function productScroll() {
    let slider = document.getElementById("slider");
    let next = document.getElementsByClassName("pro-next");
    let prev = document.getElementsByClassName("pro-prev");
    let slide = document.getElementById("slide");
    let item = document.getElementById("slide");

    for (let i = 0; i < next.length; i++) {
    //refer elements by class name

    let position = 0; //slider postion

    prev[i].addEventListener("click", function() {
      //click previos button
      if (position > 0) {
        //avoid slide left beyond the first item
        position -= 1;
        translateX(position); //translate items
      }
    });

    next[i].addEventListener("click", function() {
      if (position >= 0 && position < hiddenItems()) {
        //avoid slide right beyond the last item
        position += 1;
        translateX(position); //translate items
      }
    });
  }

  function hiddenItems() {
    //get hidden items
    let items = getCount(item, false);
    let visibleItems = slider.offsetWidth / 210;
    return items - Math.ceil(visibleItems);
  }
}

function translateX(position) {
  //translate items
  slide.style.left = position * -210 + "px";
}

function getCount(parent, getChildrensChildren) {
  //count no of items
  let relevantChildren = 0;
  let children = parent.childNodes.length;
  for (let i = 0; i < children; i++) {
    if (parent.childNodes[i].nodeType != 3) {
      if (getChildrensChildren)
        relevantChildren += getCount(parent.childNodes[i], true);
      relevantChildren++;
    }
  }
  return relevantChildren;
}

</script>