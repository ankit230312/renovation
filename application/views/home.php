<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script>
<style>
   .swiper-button-next,
   .swiper-container-rtl .swiper-button-prev {
   right: 0px;
   }
   .swiper-button-prev,
   .swiper-container-rtl .swiper-button-next {
   left: 0px;
   }
   .swiper-slide img {
   width: 100%;
   }
   .slider__ .item {
   width: 100% !important;
   }

   .swiper-button-next, .swiper-button-prev{
   padding: 72px 25px;
   background-color: antiquewhite;
   }
   @media (max-width: 768px) {
   .swiper-button-next, .swiper-button-prev{
   padding: 48px 0px;
   background-color: antiquewhite;
   }
   }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="<?=base_url("assets/css/animation.css")?>">
<?php 
    // phpinfo();
?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
   <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
   </ol>
   <div class="carousel-inner banner">
      <?php 
         if(!empty($web_banners)){
         
          $i=1;
         
          foreach($web_banners as $b){
         
            ?>
      <div class="carousel-item <?php if($i==1) echo 'active'?>">
         <a  href="<?=base_url('home/category_products/').$b->categoryID?>">
         <img class="d-block w-100" src="<?=base_url('admin/uploads/banners/web_banners/').$b->banner?>" alt="First slide" style= "">
         </a>
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

<section id="" class="py-5" data-id="122" style="position:relative;">
   <div class="container mb-5">
      <div class="row">
         <div class="col-lg-10">
            <h3 class="title_section">Top Selling Products</h3>
         </div>
         <div class="col-lg-2">
            <a href="<?=base_url('home/top_selling_products')?>">
            <button class="btn btn-danger"> View All</button>
            </a>
         </div>
      </div>
      <!-- Swiper START -->
      <div class="row ">
         <div class="swiper-container swap2" style="margin-top: 20px!important; padding-top: 2px!important;">
            <div class="swiper-wrapper">
               <?php 
                  if (empty($this->session->userdata('cityID'))) {
                   $cityID = 1;
                  }else{
                   $cityID = $this->session->userdata('cityID');
                  }
                  if (empty($this->session->userdata('loginUserID'))) {
                   $userID = 0;
                  }else{
                   $userID = $this->session->userdata('loginUserID');
                  }

                  if(!empty($best_selling_pro)){
                  
                  foreach($best_selling_pro as $d){
                  
                  
                   $CI =& get_instance();



                   $product = $this->db->query("SELECT products_variant.*,products.product_name,products.product_image,products.max_quantity FROM products_variant inner join products on products_variant.product_id=products.productID where products_variant.product_id='$d->productID' AND products.in_stock = 'Y' ")->row();
                    if(!empty($product)){
                   $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$d->productID' AND in_stock = 'Y'")->row();
                                // echo "string";
                   if (!empty($variants)) {
                     $variantID =  $variants->id;


                      $cart_qty = 0;
                  if(!empty($variantID) && $userID !=0){
                      $cart_qty = $CI->get_product_qty_cart($userID,$product->product_id, $variantID);
                  }

                   $pro_variants = $CI->all_variants($product->product_id, $cityID,$userID);
                   $totalVariants = count($pro_variants);
                  
                  
                   ?>
               <div class="swiper-slide">
                  <div class="product-grid4">
                     <div class="product-image4">
                        <a href="<?=base_url('home/product_detail/').$product->product_id?>">
                        <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $product->product_image;?>">
                        </a>
                        <span class="product-new-label" style="padding-top: 2px!important;">Special</span>
                        <span
                           class="product-discount-label" style="padding-top: 2px!important;"><?=ceil((($product->retail_price-$product->price)/$product->retail_price)*100); ?>% OFF</span>
                     </div>
                     <div class="product-content">
                        <h3 class="title"><a
                           href="<?=base_url('home/product_detail/').$product->product_id?>"><?=isset($product->product_name) ? $product->product_name :''?></a></h3>
                        <div class="price">
                           <b id="set_Price<?=$product->product_id?>">Rs. <?=$product->price;?></b>
                           <span id="set_retailPrice<?=$product->product_id?>">MRP <strike>Rs.<?=$product->retail_price;?></strike></span>
                        </div>
                        <span>
                        </span>
                        <br>
                        <?php
                           if($totalVariants>1){?>
                        <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"
                           productID="<?=$p->productID; ?>" get_user="<?=$userID; ?>">
                           <?php if(!empty($product->variants) && count($product->variants) > 0){
                              foreach($product->variants as $variant){
                                ?>
                           ?>
                           <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?>
                           </option>
                           <?php }   } ?>
                        </select>
                        <?php }else{
                           ?>
                        <div class="form-group required ">
                           <div class="produst_items_only">
                              <h6><?=$product->unit_value.'-'.$product->unit.' '. 'Rs.'.$product->price;?></h6>
                           </div>
                        </div>
                        <?php
                           }
                           ?>
                        <div class="row">
                           <div class="col-md-7" >
                              <div class="quantity buttons_added">
                                 <input type="button" value="-"
                                    onclick="add_to_cart_type(<?=$product->product_id?>,<?=$product->id?>,event,0)"
                                    class="minus change_argument">
                                 <input type="number" step="1" min="1" max="<?=$product->max_quantity;?>" name="quantity"
                                    id="get_qty<?=$product->product_id;?>"
                                    value="<?php if($cart_qty>0){ echo $cart_qty;}else{ echo "1";   };?>" title="Qty"
                                    class="input-text qty text" size="4" pattern="" inputmode="">
                                 <input type="button" value="+"
                                    onclick="add_to_cart_type(<?=$product->product_id?>,<?=$product->id?>,event,1)"
                                    class="plus change_argument1">
                              </div>
                           </div>
                           <div class="col-md-5" >
                              <a class="add-to-cart change_argument_new"
                                 onclick="add_to_cart(<?=$product->product_id?>,<?=$variantID?>,event);"><span
                                 id="add_cart_html<?=$product->product_id?>">ADD&nbsp;<i class="fa fa-shopping-cart"></i> 
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } } }}?>
            </div>
            <!-- Swiper END -->
         </div>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
   </div>
</section>
<section id="vertical_banner" class="py-3" style="background: #f7f3ee;">
   <div class="container">
      <h1 class="title_section"> Shop from Top Categories </h1>
      <div class="row">
         <?php 
            // $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  categoryID IN (1,2,3,4,5,30) && status= 'Y' LIMIT 8");
            $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  categoryID IN (1,2,3,4,5,30) && status= 'Y' LIMIT 8");
            
            
            if(!empty($few_category)){
            
            foreach($few_category as $c){
            
            ?>
         <div class=" mb-3 col-md-2   col-6 col-sm-6 col-xs-6">
            <div class="cat__">
               <a href="<?=base_url('home/category_products/').$c->categoryID;?>" title="" rel="nofollow"> <img
                  class="banner_img" src="<?=base_url('admin/uploads/category/'). $c->icon;?>" title="" alt="" width: 147px;> </a>
               <h2>
               <?=$c->title?></h6>
            </div>
         </div>
         <?php } } ?>
      </div>
   </div>
   </div>
</section>
<section class="about py-3 spl_sec">
   <div class="container">
      <div class="row">
         <?php  foreach($other_banners as $b){ ?>
         <div class="col-lg-6 " style="padding: 0px;">
            <div class="about_1 mb-3">
             
               <a href="">
               <img class="banner_img" src="<?=base_url('admin/uploads/banners/other_banners/').$b->banner?>" title="Red Label" alt="Red Label">
               </a>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</section>
<?php /* 
   if($this->session->userdata('loginUserID')){
     if(!empty($recent_purchase)){
   
       ?>
<section id="" class="py-5" data-id="122" style="position:relative;">
   <div class="container">
      <div class="row">
         <div class="col-lg-10">
            <h3 class="title_section">Recent Purchase</h3>
         </div>
         <div class="col-lg-2">
         </div>
      </div>
      <!-- Swiper START -->
      <div class="row">
         <div class="swiper-container swap" style="margin-top: 20px!important; padding-top: 2px!important;">
            <div class="swiper-wrapper">
               <?php 
                  if (empty($this->session->userdata('cityID'))) {
                   $cityID = 1;
                  }else{
                   $cityID = $this->session->userdata('cityID');
                  }
                  if (empty($this->session->userdata('loginUserID'))) {
                   $userID = 0;
                  }else{
                   $userID = $this->session->userdata('loginUserID');
                  }
                           //print_r($deal_product);
                  
                  
                  if(!empty($recent_purchase)){
                  
                  foreach($recent_purchase as $d){
                  
                  
                   $CI =& get_instance();
                   $product = $this->db->query("SELECT products_variant.*,products.product_name,products.product_image,products.max_quantity FROM products_variant inner join products on products_variant.product_id=products.productID where products_variant.product_id='$d->productID' AND products.in_stock = 'Y' ")->row();
                  
                  
                  
                         //$CI->get_product($d->productID);
                  
                  
                  
                   $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$d->productID' AND in_stock = 'Y'")->row();
                            // echo "string";
                  
                   $variantID =  isset($variants->id) ? $variants->id :'';
                  
                     if(!empty($variantID)){
                   $cart_qty = $CI->get_product_qty_cart($userID,$product->product_id, $variantID);
                }else{
                  $cart_qty = 0;
                }
                  
                             //$brand = $CI->get_brand($product->brand_id);
                  
                               //$cart_qty= '';
                   $pro_variants = $CI->all_variants($product->product_id, $cityID,$userID);
                   $totalVariants = count($pro_variants);
                  
                  
                   ?>
               <div class="swiper-slide">
                  <div class="product-grid4" style=" width:auto;">
                     <div class="product-image4">
                        <a href="<?=base_url('home/product_detail/').$product->product_id?>">
                        <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $product->product_image;?>">
                        </a>
                        <span class="product-new-label" style="padding-top: 2px!important;">Special</span>
                        <span
                           class="product-discount-label" style="padding-top: 2px!important;"><?=ceil((($product->retail_price-$product->price)/$product->retail_price)*100); ?>% OFF</span>
                     </div>
                     <div class="product-content">
                        <h3 class="title"><a
                           href="<?=base_url('home/product_detail/').$product->product_id?>"><?=$product->product_name?></a></h3>
                        <div class="price">
                           <b id="set_Price<?=$product->product_id?>">Rs. <?=$product->price;?></b>
                           <span id="set_retailPrice<?=$product->product_id?>">MRP <strike>Rs.<?=$product->retail_price;?></strike></span>
                        </div>
                        <span>
                        </span>
                        <br>
                        <?php
                           if($totalVariants>1){?>
                        <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"
                           productID="<?=$p->productID; ?>" get_user="<?=$userID; ?>">
                           <?php if(!empty($product->variants)){
                              foreach($product->variants as $variant){
                                ?>
                           ?>
                           <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?>
                           </option>
                           <?php }   } ?>
                        </select>
                        <?php }else{
                           ?>
                        <div class="form-group required ">
                           <div class="produst_items_only">
                              <h6><?=$product->unit_value.'-'.$product->unit.' '. 'Rs.'.$product->price;?></h6>
                           </div>
                        </div>
                        <?php
                           }
                           ?>
                        <div class="row">
                           <div class="col-md-7" >
                              <div class="quantity buttons_added">
                                 <input type="button" value="-"
                                    onclick="add_to_cart_type(<?=$product->product_id?>,<?=$product->id?>,event,0)"
                                    class="minus change_argument">
                                 <input type="number" step="1" min="1" max="<?=$product->max_quantity;?>" name="quantity"
                                    id="get_qty<?=$product->product_id;?>"
                                    value="<?php if($cart_qty>0){ echo $cart_qty;}else{ echo "1";   };?>" title="Qty"
                                    class="input-text qty text" size="4" pattern="" inputmode="">
                                 <input type="button" value="+"
                                    onclick="add_to_cart_type(<?=$product->product_id?>,<?=$product->id?>,event,1)"
                                    class="plus change_argument1">
                              </div>
                           </div>
                           <div class="col-md-5" >
                              <a class="add-to-cart change_argument_new"
                                 onclick="add_to_cart(<?=$product->product_id?>,<?=$variantID?>,event);"><span
                                 id="add_cart_html<?=$product->product_id?>">ADD <i class="fa fa-shopping-cart"></i> 
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } } ?>
            </div>
            <!-- Swiper END -->
         </div>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
   </div>
</section>
<?php } } */?>
<section id="" class="py-5" data-id="122">
   <div class="container">
      <div class="row">
         <div class="col-lg-10">
            <h3 class="title_section" style="font-size: 28px;font-weight: 600;">  <img src="<?=base_url('assets/images/deal.gif')?>" style="    width: 100px;
               position: absolute;
               bottom: 0;
               left: 117px;"> Deals </h3>
         </div>
         <div class="col-lg-2">
            <a href="<?=base_url('home/deal_products')?>">
            <button class="btn btn-danger"> View All</button>
            </a>
         </div>
      </div>
      <br>
      <div class="row">
         <?php 
            if (empty($this->session->userdata('cityID'))) {
             $cityID = 1;
            }else{
             $cityID = $this->session->userdata('cityID');
            }
            if (empty($this->session->userdata('loginUserID'))) {
             $userID = 0;
            }else{
             $userID = $this->session->userdata('loginUserID');
            }
                           //print_r($deal_product);
            
             foreach($deals as $d){

               $product = $this->db->query("SELECT products_variant.*,products.product_name,products.product_image,products.max_quantity from products_variant inner join products on products_variant.product_id=products.productID WHERE products_variant.id='$d->variantID' AND products_variant.product_id= '$d->productID' AND products_variant.in_stock='Y'")->result();

               foreach ($product as $p) {

                $CI =& get_instance();
                
              $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id = $p->product_id")->row();
              $variantID =  $variants->id;
              $cart_qty = $CI->get_product_qty_cart($userID,$p->product_id, $variantID);
              $pro_variants = $CI->all_variants($p->product_id, $cityID,$userID);
              $totalVariants = count($pro_variants);

              ?>
         <div class=" col-md-3 col-6 col-sm-6 col-xs-6">
            <div class="product-grid4">
               <div class="product-image4">
                  <a href="<?=base_url('home/product_detail/').$p->product_id?>">
                  <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>">
                  </a>
                  <span class="product-new-label">Special</span>
                  <span
                     class="product-discount-label"><?=ceil((($p->retail_price-$p->price)/$p->retail_price)*100); ?>% OFF</span>
               </div>
               <div class="product-content">
                  <h3 class="title"><a
                     href="<?=base_url('home/product_detail/').$p->product_id?>"><?=$p->product_name?></a></h3>
                  <div class="price">
                     <b id="set_Price<?=$p->product_id?>">Rs. <?=$p->price;?></b>
                     <span id="set_retailPrice<?=$p->product_id?>">MRP <strike style="color: red;"> Rs.<?=$p->retail_price;?></strike></span>
                  </div>
                  <br>
                  <?php
                     if($totalVariants>1){?>
                  <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"
                     productID="<?=$p->productID; ?>" get_user="<?=$userID; ?>">
                     <?php if(!empty($p->variants)){
                        foreach($p->variants as $variant){
                          ?>
                     ?>
                     <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?>
                     </option>
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
                     //print_r($product);
                     
                     
                     
                     
                     }
                     ?>
                  <div class="row">
                     <div class="col-md-7">
                        <span>
                           <div class="quantity buttons_added">
                              <!-- <input type="button" value="-"
                                 onclick="add_to_cart_type(<?=$product->product_id?>,<?=$product->id?>,event,0)"
                                 class="minus change_argument"> -->
                              <!--   <input type="number" step="1" min="1" max="<?=$product->max_quantity;?>" name="quantity"
                                 id="get_qty<?=$product->product_id;?>"
                                 value="<?php if($cart_qty>0){ echo $cart_qty;}else{ echo "1";   };?>" title="Qty"
                                 class="input-text qty text" size="4" pattern="" inputmode="">
                                 <input type="button" value="+"
                                 onclick="add_to_cart_type(<?=$product->product_id?>,<?=$product->id?>,event,1)"
                                 class="plus change_argument1">
                                 -->
                              <input type="button" value="-" class="minus" onclick="add_to_cart_type(<?=$p->product_id?>,<?=$p->id?>,event,0)"><input type="number" step="1" min="1" max='<?=$p->max_quantity;?>' name="quantity"  id="get_qty<?=$p->product_id;?>" readonly value='<?php if($cart_qty>0){ echo $cart_qty;}else{ echo "1";   };?>' title="Qty" class="input-text qty text" size="4" pattern="" inputmode=""><input type="button" value="+" class="plus" onclick="add_to_cart_type(<?=$p->product_id?>,<?=$p->id?>,event,1)">
                           </div>
                        </span>
                     </div>
                     <div class="col-md-5">
                        <a class="add-to-cart change_argument_new"
                           onclick="add_to_cart(<?=$p->product_id?>,<?=$variantID?>,event);"><span
                           id="add_cart_html<?=$p->product_id?>">ADD &nbsp;&nbsp;<i class="fa fa-shopping-cart"></i> 
                        </a>
                        </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php } } ?>
      </div>
   </div>
</section>
<section class="py-5" style="position: relative;overflow: hidden;">
   <div class="container">
      <h3 class="title_section"> Top Selling  </h3>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
         <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
         </ol>
         <div class="carousel-inner banner">
            <?php 
               if(!empty($featured_banner)){
               
                $i=1;
                
                foreach($featured_banner as $d){
               
                  ?>
            <div class="carousel-item <?php if($i==1) echo 'active'?>">
               <a  href="<?=base_url('/home/product_detail/').$d->productID?>">
               <img class="d-block w-100" src="<?=base_url('/admin/uploads/banners/'.$d->banner)?>" alt="First slide">
               </a>
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
   </div>
</section>
<!-- 
   style="background-color: #d4ecda"  -->
<section class="about py-3" id="">
   <div class="container">
   <h1 class="title_section">Fruits & Vegetables</h1>
   <div class="row">
      <?php 
         $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '1' && status= 'Y' LIMIT 3");
         
         
         
         if(!empty($few_category)){
         
           foreach($few_category as $c){
         
            ?>
      <div class="col-md-2 col-6">
         <div class="split_col" style="background-color: transparent; border:1px solid #f3dee0;">
            <!-- <span class="offer_badge"> Up To <b><?=$c->off_upto?>%</b> OFF </span> -->
            <div class="cat_details"> <a href="<?=base_url('home/sub_category_products/').$c->categoryID;?>"
               title="<?=$c->title?>">
               <span style="    background: teal;
                  color: white;
                  padding: 7px;
                  border-radius: 5px;"> Up To <b><?=$c->off_upto?>%</b> OFF </span>
               <span class="cat_img"> 
               <img
                  src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="Dals &amp; Pulses" style="width:111px; height: auto;"> </span> <span
                  class="cat_name"><?=$c->title?></span> </a> 
            </div>
         </div>
      </div>
      <?php }}?>
      <?php 
         $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '2' && status= 'Y' LIMIT 3");
         
         
         
         if(!empty($few_category)){
         
          foreach($few_category as $c){
         
           ?>
      <div class="col-md-2 col-6">
         <div class="split_col" style="background-color: transparent; border: 1px solid #f3dee0;">
            <!-- <span class="offer_badge"> Up To <b><?=$c->off_upto?>%</b> OFF </span> -->
            <div class="cat_details"> 
               <a href="<?=base_url('home/sub_category_products/').$c->categoryID;?>"
                  title="<?=$c->title?>">
               <span style="    background: teal;
                  color: white;
                  padding: 7px;
                  border-radius: 5px;"> Up To <b><?=$c->off_upto?>%</b> OFF </span>
               <span class="cat_img"> 
               <img  src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="Dals &amp; Pulses" style="width:111px; height:auto;"> 
               </span>
               <span class="cat_name"><?=$c->title?></span> 
               </a> 
            </div>
         </div>
      </div>
      <?php }}?>
   </div>
</section>
<section class="about py-3 spl_sec">
   <div class="container">
      <div class="row">
         <?php  foreach($other_section_banners as $b){ ?>
         <div class="col-lg-6 " style="padding: 0px;">
            <div class="about_1 mb-3">
               <img class="banner_img" src="<?=base_url('admin/uploads/banners/other_banners/').$b->banner?>"
                  title="health point" alt="health point">
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</section>
<section class="about py-3" id="">
   <div class="container">
   <h1 class="title_section">Food Gains , Oil & Spices</h1>
   <div class="row">
      <?php 
         $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '3' && status= 'Y' LIMIT 6");
         
         
         
         if(!empty($few_category)){
         
           foreach($few_category as $c){
         
            ?>
      <div class="col-lg-2 col-6">
         <div class="split_col" style="background:transparent; border: 1px solid #f3dee0;">
            <div class="cat_details"> <a href="<?=base_url('home/sub_category_products/').$c->categoryID;?>"
               title="<?=$c->title?>">
               <span style="background: teal;
                  color: white;
                  padding: 7px;
                  border-radius: 5px;"> Up To <b><?=$c->off_upto?>%</b> OFF </span>
               <span class="cat_img"> <img
                  src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="Dals &amp; Pulses" style="width:111px; height: auto;"> </span> <span
                  class="cat_name"><?=$c->title?></span> </a> 
            </div>
         </div>
      </div>
      <?php }}?>
   </div>
</section>
<section class="about py-3 spl_sec">
   <div class="container">
      <div class="row">
         <?php  foreach($last_section_banners as $b){ ?>
         <div class="col-lg-6 " style="padding: 0px;">
            <div class="about_1 mb-3">
               <a href="">
               <img class="banner_img" src="<?=base_url('admin/uploads/banners/other_banners/').$b->banner?>"
                  title="Wheat Bharti" alt="Wheat Bharti">
               </a>
            </div>
         </div>
       <?php } ?>
         
      </div>
   </div>
</section>
<section class="about py-3" id="">
   <div class="container">
   <h1 class="title_section">Beverages & Snacks</h1>
   <div class="row">
      <?php 
         $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '4' && status= 'Y' LIMIT 3");
         
         
         
         if(!empty($few_category)){
         
           foreach($few_category as $c){
         
            ?>
      <div class="col-lg-2 col-6">
         <div class="split_col" style="background:transparent; border: 1px solid #f3dee0;">
            <div class="cat_details"> <a href="<?=base_url('home/sub_category_products/').$c->categoryID;?>"
               title="<?=$c->title?>">
               <span style="background: teal;
                  color: white;
                  padding: 7px;
                  border-radius: 5px;"> Up To <b><?=$c->off_upto?>%</b> OFF </span>
               <span class="cat_img"> <img
                  src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="Dals &amp; Pulses" style="width:111px; height: auto;"> </span> <span
                  class="cat_name"><?=$c->title?></span> </a> 
            </div>
         </div>
      </div>
      <?php }}?>
      <?php 
         $few_category =  $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '5' && status= 'Y' LIMIT 3");
         
         
         
         if(!empty($few_category)){
         
           foreach($few_category as $c){
         
            ?>
      <div class="col-lg-2 col-6">
         <div class="split_col" style="background: transparent; border: 1px solid #f3dee0;">
            <div class="cat_details"> <a href="<?=base_url('home/sub_category_products/').$c->categoryID;?>"
               title="<?=$c->title?>">
               <span style="background: teal;
                  color: white;
                  padding: 7px;
                  border-radius: 5px;"> Up To <b><?=$c->off_upto?>%</b> OFF </span>
               <span class="cat_img"> <img
                  src="<?=base_url('admin/uploads/category/'). $c->icon;?>" alt="Dals &amp; Pulses" style="width:111px; height: auto;"> </span> <span
                  class="cat_name"><?=$c->title?></span> </a> 
            </div>
         </div>
      </div>
      <?php }}?>
   </div>
</section>
<section class="about py-3 spl_sec">
   <div class="container">
      <div class="row">
         <?php  foreach($final_section_banners as $b){ ?>
         <div class="col-lg-6 " style="padding: 0px;">
            <div class="about_1 mb-3">
               <a href="">
               <img class="banner_img" src="<?=base_url('admin/uploads/banners/other_banners/').$b->banner?>"
                  title="Red Label" alt="Red Label">
               </a>
            </div>
         </div>
        <?php } ?>
      </div>
   </div>
</section>
<script>
   $( function() {
     var availableTags = [
     "ActionScript",
     "AppleScript",
     "Asp",
     "BASIC",
     "C",
     "C++",
     "Clojure",
     "COBOL",
     "ColdFusion",
     "Erlang",
     "Fortran",
     "Groovy",
     "Haskell",
     "Java",
     "JavaScript",
     "Lisp",
     "Perl",
     "PHP",
     "Python",
     "Ruby",
     "Scala",
     "Scheme"
     ];
     $( "#tags" ).autocomplete({
       source: availableTags
     });
   } );
</script>
<script>
   var mySwiper1 = new Swiper('.swiper-1', {
     loop: true,
     spaceBetween: 25,
     slidesPerView: 5,
     initialSlide: 1,
     scrollbar: '.swiper-scrollbar',
     allowSwipeToPrev: true,
     allowSwipeToNext: true,
     spaceBetween: 0,
     parallax: true,
     autoplay:{
      delay: 3000,
    },
    speed: 500,
    autoplayDisableOnInteraction: false,
    navigation: {
     nextEl: '.swiper-button-next',
     prevEl: '.swiper-button-prev',
     
   },
   pagination: {
     el: '.swiper-pagination',
     type: 'bullets',
     clickable: true
   },
   breakpoints: {
    320: {
     slidesPerView: 2,
     spaceBetween: 5
   },
   
   480: {
     slidesPerView: 2,
     spaceBetween: 5
   }
   }
   
   
   });
   var mySwiper = new Swiper('.swiper-container', {
     loop: true,
     spaceBetween: 25,
     slidesPerView: 5,
     initialSlide: 1,
     scrollbar: '.swiper-scrollbar',
     allowSwipeToPrev: true,
     allowSwipeToNext: true,
     parallax: true,
     autoplay:{
      delay: 3000,
    },
    speed: 800,
    autoplayDisableOnInteraction: false,
    navigation: {
     nextEl: '.swiper-button-next',
     prevEl: '.swiper-button-prev',
     
   },
   pagination: {
     el: '.swiper-pagination',
     type: 'bullets',
     clickable: true
   },
   breakpoints: {
    320: {
     slidesPerView:2,
     spaceBetween: 5
   },
   
   480: {
     slidesPerView: 2,
     spaceBetween: 5
   }
   }
   
   
   });
   var mySwiper = new Swiper('.swiper-container', {
     loop: true,
     spaceBetween: 25,
     slidesPerView: 5,
     initialSlide: 1,
     scrollbar: '.swiper-scrollbar',
     allowSwipeToPrev: true,
     allowSwipeToNext: true,
     parallax: true,
     autoplay:{
      delay: 3000,
    },
    speed: 800,
    autoplayDisableOnInteraction: false,
    navigation: {
     nextEl: '.swiper-button-next',
     prevEl: '.swiper-button-prev',
     
   },
   pagination: {
     el: '.swiper-pagination',
     type: 'bullets',
     clickable: true
   },
   breakpoints: {
    320: {
     slidesPerView:2,
     spaceBetween: 5
   },
   
   480: {
     slidesPerView: 2,
     spaceBetween: 5
   }
   }
   
   
   });
   
</script>