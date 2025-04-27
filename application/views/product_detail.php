
  <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/xzoom.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://raw.githubusercontent.com/bbbootstrap/libraries/main/xzoom.css" media="all" />
  <!-- ============================== Product Details Page ============================== -->
<?php
$currentURL = current_url(); //http://myhost/main

$uri1 = $this->uri->segment(3);
$category_id = isset($product->category_id) ? $product->category_id :'';


$category_id = explode(",",$category_id);
$category_id = $category_id[0];


$categories = $this->home_m->get_single_row_where('category',array('categoryID'=>$category_id));
if($categories->parent != 0){
  $parent = $this->home_m->get_single_row_where('category',array('categoryID'=>$categories->parent));
}

?>



  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>


   <?php if(!empty($parent)){?>
     <li class="breadcrumb-item"><a href="<?=base_url('home/category_products/'.$parent->categoryID)?>"><?=isset($parent->title) ? $parent->title :''?></a></li>
   <?php }?>


 <?php if(!empty($categories)){?>
     <li class="breadcrumb-item"><a href="<?=base_url('home/sub_category_products/'.$parent->categoryID)?>"><?=isset($categories->title) ? $categories->title :''?></a></li>
   <?php }?>


    <li class="breadcrumb-item active" aria-current="page"><?=isset($product->product_name) ? $product->product_name :''?></li>
  </ol>
</nav>

<?php 
$discount = $product->retail_price - $product->price ;
$dis_per = ($discount/$product->retail_price) * 100;
?>

  <section class="product_detail pt-5 mt-5">
    <div class="container">
      <div class="row">
          <div class="col-md-3" style="border: 1px solid #e9d3d3!important; text-align: center;background-color: #fbfbfb!important;">
          <div class="large-5 column">
                <div class="xzoom-container"> <img style="width: 100%" class="xzoom" id="xzoom-default" src="<?=base_url('admin/uploads/products/').$product->product_image;?>" xoriginal="<?=base_url('admin/uploads/products/').$product->product_image;?>" />

                    <div class="xzoom-thumbs mt-3"> 
                      <a href="<?=base_url('admin/uploads/products/').$product->product_image;?>"> <img class="xzoom-gallery" width="80" src="<?=base_url('admin/uploads/products/').$product->product_image;?>" xpreview="<?=base_url('admin/uploads/products/').$product->product_image;?>" style="border: 1px solid rgb(132, 194, 37);"></a>
                   </div>
                </div>
            </div>
          </div>
        <div class="col-md-9"  style="background-color: #fbfbfb!important;">
          <article class="card-body">
           <h2 class="title mb-3" style="font-size: 24px!important;"><strong><?=$product->product_name?></strong></h2>
             <span style="font-size: 22px!important;color: red!important;"> MRP.<strike>₹<?=$product->retail_price?></strike> </span></span>
            <p class="price-detail-wrap" style="font-size: 22px!important;"> 
              <span class="price h3 "> 
               <strong style="font-size: 22px!important;">Price : </strong>  
               <span class="currency" style="font-size: 22px!important;">₹</span><span class="num" id="set_Price<?=$product->productID?>" style="font-size: 22px!important;"><?=$product->price?> 

              </span> 
              <span>/per <?=$product->unit?></span> 
              (<?=round($dis_per)?>% Discount)
            </p> <!-- price-detail-wrap .// -->
            <dl class="param param-feature">
              <dt class="mb-2"  style="font-size: 20px!important;">Available in:</dt>
              <dd style="color: red;">In Stock</dd>
            </dl> 
            <dl class="param param-feature">
              <dt class="mb-2" style="font-size: 20px!important;">Expected Delivery:</dt>
              <dd>48 Hours</dd>
            </dl>
            <div class="row">
              <div class="col-sm-12 pb-40">
                <dt style="font-size: 20px!important;">Available in </dt>
                <br>
                <dd>
               
                <?php
             if($product->totalVariants>1){?>
                  <select class="form-control form-control-sm variant_change" style="width:150px;" productID="<?=$product->productID; ?>" get_user="<?=$userID; ?>">
                  <?php 
                  if(!empty($product->variants)){
                      foreach($product->variants as $variant){
                  
                  ?>
                   <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?></option>
            
                    <?php } } ?>
                  </select>
                  <?php }else{
              ?>
               <div class="form-group required ">
                <div class="produst_items_only" style="width: 140px;">
                <h6><?=$product->unit_value.'-'.$product->unit.' '. 'Rs.'.$product->price;?></h6>
                </div>
              </div> 
            <?php
             }
            ?>
                </dd>
              </dl> 
            </div> 

            <!-- Tabs Product description -->

          </div>
           <span class="price h3 "> 
             <div class="quantity buttons_added">
                  <input type="button" value="-"  onclick="add_to_cart_type(<?=$product->productID?>,<?=$product->variantID?>,event,0)" class="minus change_argument">
                  <input type="number" step="1" min="1" max="<?=$product->max_quantity;?>" name="quantity"  id="get_qty<?=$product->productID;?>" value="<?php if($product->cart_qty>0){ echo $product->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                  <input type="button" value="+" onclick="add_to_cart_type(<?=$product->productID?>,<?=$product->variantID?>,event,1)" class="plus change_argument1">
                </div>
           
          <button type="button"  class="btn btn-primary change_argument_new" onclick="add_to_cart(<?=$product->productID?>,<?=$product->variantID?>,event);">Add to Cart</button>
 </span> 
          <!-- <nav class="pt-40">
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>

              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Product Information</a>

            </div>
          </nav> -->
          <!-- <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <?=$product->product_description?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <?=$product->product_description?>
            </div>
          </div> -->
        </div> <!-- row.// -->

      </div>
      <br>
      <div class="row">
      <div class="col-lg-10">
        <h4><strong>Description</strong></h4>
        <div class="col-lg-3">
           <hr>
        </div>
       
        <p>
        <ul>
          <li style="list-style: disc!important;"> <?=$product->product_description?></li>
        </ul> </p>
      </div>
      
    </div><br>
       <div class="row">
      <div class="col-lg-12">
        <h4><strong>Use & Benefits</strong></h4>
        <div class="col-lg-3">
           <hr>
        </div>
        <ul>
          <?php if (!empty($product->use)) {?>
          <li style="list-style: disc!important;"> <?=$product->use?></li>
        <?php } ?>
          <?php if (!empty($product->benefit)) {?>
          <li style="list-style: disc!important;"> <?=$product->benefit?></li>
        <?php } ?>
        </ul> </p>
      </div>
      
    </div>
    </article> <!-- card-body.// -->
  </div> <!-- col.// -->

</div> <!-- row.// -->

</div>
</section>

<!-- Related Products -->
<section class="related_product mt-5 pb-5">
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mb-4">
          <div class="heading_title">
              <h3>Related Products </h3>
          </div>
        </div>
  </div>
  <div class="row">
      <?php if(!empty($related_products)){
         foreach($related_products as $p){
             $imgUrl = base_url('assets/images/no_images.png');
              if (file_exists("./admin/uploads/products/".$p->product_image)) {
               
                $imgUrl = base_url('admin/uploads/products/'). $p->product_image;
              }

          ?>

    <div class="col-6 col-md-6 col-lg-3">
    <div class="product-grid4">
          <div class="product-image4">
            <a href="#">
              <img class="pic-1" src="<?=$imgUrl;?>">
            
            </a>
           
            <span class="product-new-label">Discount</span>
            <span class="product-discount-label"><?=ceil( (($p->retail_price-$p->price)/$p->retail_price)*100); ?>% OFF</span>
          </div>
          <br>
          <div class="product-content">
            <h3 class="title"><a href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a></h3>
            <div class="price">
              <span id="set_retailPrice<?=$p->productID?>">MRP <strike>Rs.<?=$p->retail_price;?></strike></span>
              
            </div>
            <div class="price">
            <b id="set_Price<?=$p->productID?>">Rs. <?=$p->price;?></b>
            </div>
            
            <span>
             
            </span>
            <br>
            <?php
             if($p->totalVariants>1){?>
            <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"  productID="<?=$p->productID; ?>"
               get_user="<?=$userID; ?>">
                <!-- <option value=""> --- Please Select --- </option> -->
                <?php if(!empty($p->variants)){
                  foreach($p->variants as $variant){
                    ?>
                    <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?></option>
                 <?php }
                } ?>
                
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
             <?php 
                  if(!empty($product->variants)){
                      foreach($product->variants as $variant){
                  
                  ?>
             <div class="row">
                <!--  <div class="col-md-2">
                  <h6 style="color: #000!important;margin-top: 1rem;">Qty </h6>
                </div> -->
                <div class="col-md-7" >
                 
             <div class="quantity buttons_added">
                  <input type="button" value="-"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$variant->id?>,event,0)" class="minus change_argument">
                  <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" name="quantity"  id="get_qty<?=$p->productID;?>" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                  <input type="button" value="+" onclick="add_to_cart_type(<?=$p->productID?>,<?=$variant->id?>,event,1)" class="plus change_argument1">
                </div>
             
              </div>
                <div class="col-md-5" >
            <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$variant->id?>,event);"> ADD &nbsp;&nbsp;<i class="fa fa-shopping-cart"></i></a>
          </div>
        </div>
         <?php } } ?>
          </div>
        </div>
    </div>
    <?php 
         }
      } 
      ?>
  </div>
  </div>
</section>
<!-- ============================== Product Details Page End ========================== -->
<script type="text/javascript">
  (function ($) {
$(document).ready(function() {
$('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 400, title: true, tint: '#333', Xoffset: 15});
$('.xzoom2, .xzoom-gallery2').xzoom({position: '#xzoom2-id', tint: '#ffa200'});
$('.xzoom3, .xzoom-gallery3').xzoom({position: 'lens', lensShape: 'circle', sourceClass: 'xzoom-hidden'});
$('.xzoom4, .xzoom-gallery4').xzoom({tint: '#006699', Xoffset: 15});
$('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});

//Integration with hammer.js
var isTouchSupported = 'ontouchstart' in window;

if (isTouchSupported) {
//If touch device
$('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function(){
var xzoom = $(this).data('xzoom');
xzoom.eventunbind();
});

$('.xzoom, .xzoom2, .xzoom3').each(function() {
var xzoom = $(this).data('xzoom');
$(this).hammer().on("tap", function(event) {
event.pageX = event.gesture.center.pageX;
event.pageY = event.gesture.center.pageY;
var s = 1, ls;

xzoom.eventmove = function(element) {
element.hammer().on('drag', function(event) {
event.pageX = event.gesture.center.pageX;
event.pageY = event.gesture.center.pageY;
xzoom.movezoom(event);
event.gesture.preventDefault();
});
}

xzoom.eventleave = function(element) {
element.hammer().on('tap', function(event) {
xzoom.closezoom();
});
}
xzoom.openzoom(event);
});
});

$('.xzoom4').each(function() {
var xzoom = $(this).data('xzoom');
$(this).hammer().on("tap", function(event) {
event.pageX = event.gesture.center.pageX;
event.pageY = event.gesture.center.pageY;
var s = 1, ls;

xzoom.eventmove = function(element) {
element.hammer().on('drag', function(event) {
event.pageX = event.gesture.center.pageX;
event.pageY = event.gesture.center.pageY;
xzoom.movezoom(event);
event.gesture.preventDefault();
});
}

var counter = 0;
xzoom.eventclick = function(element) {
element.hammer().on('tap', function() {
counter++;
if (counter == 1) setTimeout(openfancy,300);
event.gesture.preventDefault();
});
}

function openfancy() {
if (counter == 2) {
xzoom.closezoom();
$.fancybox.open(xzoom.gallery().cgallery);
} else {
xzoom.closezoom();
}
counter = 0;
}
xzoom.openzoom(event);
});
});

$('.xzoom5').each(function() {
var xzoom = $(this).data('xzoom');
$(this).hammer().on("tap", function(event) {
event.pageX = event.gesture.center.pageX;
event.pageY = event.gesture.center.pageY;
var s = 1, ls;

xzoom.eventmove = function(element) {
element.hammer().on('drag', function(event) {
event.pageX = event.gesture.center.pageX;
event.pageY = event.gesture.center.pageY;
xzoom.movezoom(event);
event.gesture.preventDefault();
});
}

var counter = 0;
xzoom.eventclick = function(element) {
element.hammer().on('tap', function() {
counter++;
if (counter == 1) setTimeout(openmagnific,300);
event.gesture.preventDefault();
});
}

function openmagnific() {
if (counter == 2) {
xzoom.closezoom();
var gallery = xzoom.gallery().cgallery;
var i, images = new Array();
for (i in gallery) {
images[i] = {src: gallery[i]};
}
$.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
} else {
xzoom.closezoom();
}
counter = 0;
}
xzoom.openzoom(event);
});
});

} else {
//If not touch device

//Integration with fancybox plugin
$('#xzoom-fancy').bind('click', function(event) {
var xzoom = $(this).data('xzoom');
xzoom.closezoom();
$.fancybox.open(xzoom.gallery().cgallery, {padding: 0, helpers: {overlay: {locked: false}}});
event.preventDefault();
});

//Integration with magnific popup plugin
$('#xzoom-magnific').bind('click', function(event) {
var xzoom = $(this).data('xzoom');
xzoom.closezoom();
var gallery = xzoom.gallery().cgallery;
var i, images = new Array();
for (i in gallery) {
images[i] = {src: gallery[i]};
}
$.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
event.preventDefault();
});
}
});
})(jQuery);
</script>

<style>
.nav-tabs a:hover{
  color: #ffff !important;
  background-color: teal !important;
}
.nav-tabs .nav-link.active{
  font-size: 13px;
}
.card-body{
  padding: 20px;
}
.card-body .title{
  font-size: 14px;
}
.price-detail-wrap .price{
  font-size: 14px;
}
dt{
  font-size: 13px !important;
}
</style>