
<!-- ============================= Slider Start =================================== -->


  <!-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
        <?php 
      if(!empty($web_banners)){
        foreach($web_banners as $b){
      ?>
          <div class="carousel-item active">
            <img class="d-block w-100" src="<?=base_url('admin/uploads/banners/web_banners/').$b->banner;?>" alt="First slide">
          </div>
          <?php } } ?>
         
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div> -->
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
        <?php 
      if(!empty($web_banners)){
        foreach($web_banners as $b){
      ?>
          <div class="carousel-item active">
            <img class="d-block w-100" src="<?=base_url('admin/uploads/banners/web_banners/').$b->banner?>" alt="First slide">
          </div>
          <?php } } ?>

        </div>

        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
<!-- ---------------------------- Header-bottom section -------------------- -->
<section class="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 ">
        <div class="about_1">
          <img src="<?=base_url('assets/');?>images/bo-1.jpg">
        </div>
      </div>
      <div class="col-lg-4">
        <div class="about_2">
          <img src="<?=base_url('assets/');?>images/bo-2.jpg">
        </div>
      </div>
      <div class="col-lg-4">
        <div class="about_3">
          <img src="<?=base_url('assets/');?>images/bo-3.jpg">
        </div>
      </div>
    </div>
  </div>

</section>

<!----------- Best Value Products -------------->
<section class="our-publication pt-100 pb-40">
  <div class="container">
    <h3 class="h3">Best Deals</h3>
    <hr>
    <div class="row">
    <?php 
      if(!empty($deal_product)){
        foreach($deal_product as $p){
      ?>
      <div class="col-md-3 col-sm-6">
        <div class="product-grid4">
          <div class="product-image4">
            <a href="#">
              <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p['product_image'];?>">
              <img class="pic-2" src="<?=base_url('admin/uploads/products/').$p['product_image'];?>">
            </a>
            <ul class="social">
              <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
              <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
              <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
            <span class="product-new-label">New</span>
            <span class="product-discount-label"><?=ceil((($p['retail_price']-$p['price'])/$p['retail_price'])*100); ?>%</span>
          </div>
          <div class="product-content">
            <h3 class="title"><a href="<?=base_url('home/product_detail/').$p['productID'];?>"><?=$p['product_name'];?></a></h3>
            <div class="price">
            <?=$p['price'];?>
              <span><?=$p['retail_price'];?></span>
            </div>
            <span>
              <div class="quantity buttons_added">
                  <input type="button" value="-"   class="minus"  onclick="add_to_cart_type(<?=$p['productID']?>,<?=$p['variantID']?>,event,0)">
                  <input type="number" step="1" min="1" max="<?=$p['max_quantity'];?>" id="get_qty<?=$p['productID'];?>" name="quantity" value="<?php if($p['cart_qty']>0){ echo $p['cart_qty'];}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                  <input type="button" value="+" class="plus"  onclick="add_to_cart_type(<?=$p['productID']?>,<?=$p['variantID']?>,event,1)">
                </div>

            </span>

            <div class="form-group required ">
            <div class="form-group required ">
                    <div class="produst_items_only">
                      <h6><?=$p['unit_value'].'-'.$p['unit'].' '. 'Rs.'.$p['price'];?></h6>
                  </div>
              </div>
            </div>

            <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p['productID']?>,<?=$p['variantID']?>,event);">ADD TO CART</a>
          </div>
        </div>
      </div>
      <?php } } ?>


     


    
  </div>


</section>

<!-- New Section Banner Start ---------- -->

<section class="feature_bg pb-40">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="owl_slider">
                <div id="owl-demo" class="owl-carousel owl-theme">
                <?php 
             if(!empty($few_category)){
               foreach($few_category as $c){
            ?>
                  <div class="item">
                    <a href="<?=base_url('home/category_products/').$c->categoryID;?>">
                    <img src="<?=base_url('admin/uploads/category/'). $c->icon;?>" style="width: 130px;height: 130px;border-radius: 50%;background-color: #e9ecef61;margin-top: 60px;" alt="Apple" class="img-fluid">
                    <p><?=$c->title?></p>
                  </a>
                  </div>

                    <?php } } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
 </section>

<!-- New Section Started -->
<section class="our-publication pt-100 pb-40">
  <div class="container">
    <h3 class="h3">Recommended Products</h3>
    <hr>
    <div class="row">
    <?php 
      if(!empty($featured)){
        foreach($featured as $p){
      ?>

<div class="col-md-3 col-sm-6">
        <div class="product-grid4">
          <div class="product-image4">
            <a href="#">
              <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>">
              <img class="pic-2" src="<?=base_url('admin/uploads/products/').$p->product_image;?>">
            </a>
            <ul class="social">
              <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
              <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
              <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
            <span class="product-new-label">New</span>
            <span class="product-discount-label"><?=ceil((($p->retail_price-$p->price)/$p->retail_price)*100); ?>%</span>
          </div>
          <div class="product-content">
            <h3 class="title"><a href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a></h3>
            <div class="price">
            <b id="set_Price<?=$p->productID?>"><?=$p->price;?></b>
              <span id="set_retailPrice<?=$p->productID?>"><?=$p->retail_price;?></span>
            </div>
            <span>
              <div class="quantity buttons_added">
                  <input type="button" value="-"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,0)" class="minus change_argument">
                  <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" name="quantity"  id="get_qty<?=$p->productID;?>" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                  <input type="button" value="+" onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,1)" class="plus change_argument1">
                </div>
            </span>
            <?php
             if($p->totalVariants>1){?>
              <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"  productID="<?=$p->productID; ?>"
               get_user="<?=$userID; ?>">
                <?php if(!empty($p->variants)){
                  foreach($p->variants as $variant){
                    ?>
                    <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?></option>
                 <?php }   } ?>
              
                
              </select>
            <?php }else{
              ?>
                 <div class="form-group required ">
                <div class="produst_items_only">
                <h6><?=$p->unit_value.'-'.$p->unit.' '. 'Rs.'.$p->price;?></h6>
                </div>
              </div> 
            <?php
             }
            ?>
            <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$p->variantID?>,event);">ADD TO CART</a>
          </div>
        </div>
      </div>


      <?php } } ?>
    
    </div>
    <br>
  </div>
</section>

<!-- ========================= product Categories Section ================================= -->

<!-- ========================= product Fruits Store  Section ================================= -->
<section class="fruits_store pb-40">
  <div class="container">

    <div class="row">
    <?php 
      if(!empty($parentCategory)){
        foreach($parentCategory as $c){
         //echo  $p->product_name; exit;
      ?>
      <div class="col-12">
        <div class="section_title"><?=$c->title;?></div>
      </div>
      <div class="col-sm-3 text-center mb-15"> <img src="<?=base_url('assets/')?>images/strawberry_1.jpg" alt="" title="" class="img-fluid"> </div>
      <div class="col-sm-9 right_block">
        <div class="row">
           <?php if(!empty($c->subCategory)){
             foreach($c->subCategory as $sub){
             ?>
          <div class="product-layout col-lg-4 col-md-4 col-sm-4 col-6">
            <div class="product-thumb transition">
              <h4><a href="#"><?=$sub->title;?></a></h4><br/>
              <div class="image"><a href="<?=base_url('home/get_products/').$sub->categoryID;?>"><img src="<?=base_url('admin/uploads/category/').$sub->icon;?>" alt="Apple" title="Apple" class="img-fluid"></a>
              </div>
            </div>
          </div>
          <?php }  } ?>
        </div>
      </div>
      <!-- <div class="col-sm-12 text-center">
        <div class="btn btn-primary viewall"><a href="#">View All</a></div>
      </div> -->
      <?php }  } ?>
               

    </div>

    
  </div>
</section>


<!-- ================================= Why Choose us ==================================== -->
<section class="fruits_store pb-40">
  <div class="shipping-outer section">
      <div class="container">
        <div class="shipping-inner row">
          <div class="heading col-lg-3 col-12 text-center text-lg-left">
            <h2>Why choose us?</h2>
          </div>
          <div class="subtitle-part subtitle-part1 col-lg-3 col-4 text-center text-lg-left">
            <div class="subtitle-part-inner">
              <div class="subtitile">
                <div class="subtitle-part-image"><i class="far fa-clock"></i></div>
                <div class="subtitile1">On time delivery</div>
                <div class="subtitile2">15% back if not able</div>
              </div>
            </div>
          </div>
          <div class="subtitle-part subtitle-part2 col-lg-3 col-4 text-center text-lg-left">
            <div class="subtitle-part-inner">
              <div class="subtitile">
                <div class="subtitle-part-image"><i class="fas fa-truck"></i></div>
                <div class="subtitile1">Free delivery</div>
                <div class="subtitile2">Order over $ 200</div>
              </div>
            </div>
          </div>
          <div class="subtitle-part subtitle-part3 col-lg-3 col-4 text-center text-lg-left">
            <div class="subtitle-part-inner">
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script>
      $(document).ready(function() {

        $("#owl-demo").owlCarousel({

          autoPlay: 3000, //Set AutoPlay to 3 seconds

          items : 6,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3]

        });

      });
    </script>


    