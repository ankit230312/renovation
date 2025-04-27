<section id="" class="py-3" data-id="122">
   <div class="container">
      <div class="row">
         <div class="col-lg-10">
            <h3 class="title_section"> Top Deals </h3>
         </div>
         <div class="col-lg-2">
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
            
            /*var_dump($_SESSION);*/

             foreach($deals as $d){

               $product = $this->db->query("SELECT products_variant.*,products.product_name,products.product_image,products.max_quantity from products_variant inner join products on products_variant.product_id=products.productID WHERE products_variant.id='$d->variantID' AND products_variant.product_id= '$d->productID' AND products_variant.in_stock='Y' AND products_variant.city_id='$cityID' ")->result();
               //echo $this->db->last_query();
               foreach ($product as $p) {

                $CI =& get_instance();
                
              $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id = $p->product_id")->row();
              $variantID =  $variants->id;
              $cart_qty = $CI->get_product_qty_cart($userID,$p->product_id, $variantID);
              $pro_variants = $CI->all_variants($p->product_id, $cityID,$userID);
              $totalVariants = count($pro_variants);
              


              ?>
         <div class=" col-md-3 col-6 col-sm-6 col-xs-6" style="margin-bottom: 20px!important;">
            <div class="product-grid4">
               <div class="product-image4">
                  <a href="<?=base_url('home/product_detail/').$p->product_id?>">
                  <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>">
                  </a>
                  <span class="product-new-label">Special</span>
                  <span
                     class="product-discount-label"><?=ceil((($p->retail_price-$p->price)/$p->retail_price)*100); ?>%</span>
               </div>
               <div class="product-content">
                  <h3 class="title"><a
                     href="<?=base_url('home/product_detail/').$p->product_id?>"><?=$p->product_name?></a></h3>
                  <div class="price">
                     <b id="set_Price<?=$p->product_id?>">Rs. <?=$p->price;?></b>
                     <span id="set_retailPrice<?=$p->product_id?>">MRP <strike>Rs.<?=$p->retail_price;?></strike></span>
                  </div>
                  <span>
                     
                  </span>
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
                     }
                     ?>
              <div class="row">
                 
                <div class="col-md-7" >
                     <div class="quantity buttons_added">
                        <input type="button" value="-"
                           onclick="add_to_cart_type(<?=$p->product_id?>,<?=$p->id?>,event,0)"
                           class="minus change_argument">
                        <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" name="quantity"
                           id="get_qty<?=$p->product_id;?>"
                           value="<?php if($cart_qty>0){ echo $cart_qty;}else{ echo "1";   };?>" title="Qty"
                           class="input-text qty text" size="4" pattern="" inputmode="">
                        <input type="button" value="+"
                           onclick="add_to_cart_type(<?=$p->product_id?>,<?=$p->id?>,event,1)"
                           class="plus change_argument1">
                     </div>
                   </div>
                   <div class="col-md-5" >
                  <a class="add-to-cart change_argument_new"
                     onclick="add_to_cart(<?=$p->product_id?>,<?=$variantID?>,event);"><span
                     id="add_cart_html<?=$p->product_id?>">ADD&nbsp;&nbsp;<i class="fa fa-shopping-cart"></i> </span>
                  </a>
                </div>
              </div>
               </div>
            </div>
         </div>
         <br>
         <?php } } ?>
      </div>
   </div>
</section>