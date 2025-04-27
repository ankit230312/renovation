
  <!-- =============================== Banner Images ========================== -->
  <section class="Product_banner text-center">
    <div class="container">
      <div class="row">
      </div>
    </div>
  </section>
  <div class="container">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active"><a href="#">Category</a></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-3 ">
        <div class="card-header bg-color text-white text-uppercase pb-40"><i class="fa fa-list"></i> Categories</div>
        <div id="accordion" class="accordion">
        <div class="card mb-0">
          <?php
        if(!empty($category)){
              foreach($category as $c){
            ?>
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                <a href="<?=base_url('home/category_products/').$c->categoryID?>" class="card-title mb-0">
                <?=$c->title?>
                </a>
            </div>
             <?php 
              // if(!empty($c->subcategory)){
              //   foreach($c->subcategory as $sub){
              
             ?>

            <!-- <div id="collapseOne" class="card-body collapse" data-parent="#accordion" >
                <p><a href="<?=$sub->categoryID?>"><?=$sub->title?></a></p>
            </div> -->
            <?php     
                //}  }
               } }
                 ?>


        </div>
    </div>
      </div>

      <div class="col-md-9">
         <h3><?=$category_name?></h3>
        <div class="row">

            <?php if($products){
              foreach($products as $p){
               ?>
          <div class="col-12 col-md-6 col-lg-3">

          <div class="product-grid4">
          <div class="product-image4">
            <a href="#">
              <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>">
             
            </a>
            <ul class="social">
              <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
              <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
              <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
           <!--  <span class="product-new-label">Offer</span> -->
            <span class="product-discount-label"><?=ceil((($p->retail_price-$p->price)/$p->retail_price)*100); ?>% OFF</span>
          </div>
          <div class="product-content">
            <h3 class="title"><a href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a></h3>
            <div class="price">
            <b id="set_Price<?=$p->productID?>"><?=$p->price;?></b>
              <span id="set_retailPrice<?=$p->productID?>">MRP <strike>Rs.<?=$p->retail_price;?></strike></span>
            </div>
            <span>
             
            </span>
            <br>
            <?php
             if($p->totalVariants>1){?>
            <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"  productID="<?=$p->productID; ?>"
               get_user="<?=$userID; ?>">
               <?php if(!empty($p->variants)){
                  foreach($p->variants as $variant){
                    ?>
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
             <div class="row">
                     <div class="col-md-2">
                      <h6 style="color: #000!important;margin-top: 1rem;">Qty</h6>
                     </div>
          <div class="col-md-5" >
             <div class="quantity buttons_added">
                  <input type="button" value="-"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,0)" class="minus change_argument">
                  <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" name="quantity"  id="get_qty<?=$p->productID;?>" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                  <input type="button" value="+" onclick="add_to_cart_type(<?=$p->productID?>,<?=$p->variantID?>,event,1)" class="plus change_argument1">
                </div>
              </div>
               <div class="col-md-5" >
            <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$p->variantID?>,event);">ADD</a>
          </div>
          </div>
        </div>

          </div>
          <?php } } ?>
          
        </div>
        
    

 <!-- Pagenations -->
          <!--<div class="col-12 text-center">
            <nav aria-label="...">
              <ul class="pagination">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item ">
                  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
          </div>-->
      </div>
    </div>
  </div>
  <!-- Footer -->
  