
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

              ?>


              <?php     
              
            } }
            ?>
          </div>

          <div><p>Price Range</p></div>
          <!-- <form action="" >
          <div class="range-slider">
            <span class="rangeValues"></span>
            <input value="1000" min="1000" max="25000" step="500" type="range">
            <input value="50000" min="25000" max="50000" step="500" type="range">
          </div>

          </form> -->
        <div class="rangeslider">
           <input class="min" name="range_1" type="range" min="0" max="999999" value="0"  />
           <input class="max" name="range_1" type="range" min="0" max="999999" value="999999" />
           <span class="range_min light left" data-name="0">0</span>
           <span class="range_max light right" data-name="999999">999999</span>
      </div>
        </div>


      </div>


      <div class="col-md-9" style="text-align: center;">
       <h3><?php if(isset($category_name)){ echo $category_name; }else{ echo "Products"; }?></h3>
       <div class="row">

        <?php 

        if($products){
          foreach($products as $p){
            $exist = 0;

            $html = 'ADD TO CART';
            $url = base_url('home/shopping_cart');
            // if(!empty($carts)){
            //   foreach($carts as $cart){
            //     if($cart->productID == $p->productID){
            //         $html = "GO TO CART";
            //         $exist = 1;
            //         $link = $url;
            //     }
            //   }
            // }
            $varient_id = isset($p->variantID) ? $p->variantID :'';
            ?>
            <div class="col-6 col-md-6 col-lg-3 mb-4">

              <div class="product-grid4">
                <div class="product-image4">
                  <a href="<?=base_url('home/product_detail/'.$p->productID)?>">
                    <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>">

                  </a>

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
                      <input type="button" value="-"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$varient_id?>,event,0)" class="minus change_argument">
                      <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" name="quantity"  id="get_qty<?=$p->productID;?>" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                      <input type="button" value="+" onclick="add_to_cart_type(<?=$p->productID?>,<?=$varient_id?>,event,1)" class="plus change_argument1">
                    </div>
                  </span>
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
                  <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$varient_id?>,event);"><span id="add_cart_html<?=$p->productID?>"><?=$html?>
                </a>
              </div>
            </div>

          </div>
        <?php } } ?>

      </div>
    </div>

    <?php 

    $start_loop = $pageno;
    $difference = $total_pages - $pageno;
    if($difference <= 5)
    {
     $start_loop = $total_pages - 5;
   }
   $end_loop = $start_loop + 4;

   if($pageno > 1)
   {
    echo '<ul class="pagination mt-3 mb-3 d-none">';
    echo '  <li><a  href="?pageno=1" class="page-link">First</a></li>';

    echo "<li class='page-item'><a class='page-link' href='?pageno=".($pageno - 1)."'><<</a></li>";
  }
  for($i=$start_loop; $i<=$end_loop; $i++)
  {  
    $class ='';
    if($pageno ==$i){
      $class = 'active';
    }   
    echo "<li class='page-item ".$class."'><a class='page-link' href='?pageno=".$i."'>".$i."</a></li>";
  }
  if($pageno <= $end_loop)
  {

   echo "<li class='page-item '><a class='page-link' href='?pageno=".($pageno + 1)."'>>></a></li>";
   echo "<li class='page-item'><a class='page-link' href='?pageno=".$total_pages."'>Last</a></li><ul>";
 }
 ?>
</div>
</div>
<!-- Footer -->

<style>
  ul li::marker {
   display: none;
 }
 ul li{
  list-style: none;
}

.page-link{
  color: #0c757a;
}
@media (max-width: 768px){
  .categories .accordion > .card {
    overflow: hidden;
    display: flex;
    flex-direction: row;
    white-space: nowrap;
    overflow: scroll;
  }

}

</style>
<style type="text/css">
   input[type='range'] {
  width: 210px;
  height: 30px;
  overflow: hidden;
  cursor: pointer;
    outline: none;
}
input[type='range'],
input[type='range']::-webkit-slider-runnable-track,
input[type='range']::-webkit-slider-thumb {
  -webkit-appearance: none;
    background: none;
}
input[type='range']::-webkit-slider-runnable-track {
  width: 200px;
  height: 1px;
  background: #003D7C;
}

input[type='range']:nth-child(2)::-webkit-slider-runnable-track{
  background: none;
}

input[type='range']::-webkit-slider-thumb {
  position: relative;
  height: 15px;
  width: 15px;
  margin-top: -7px;
  background: #fff;
  border: 1px solid #003D7C;
  border-radius: 25px;
  z-index: 1;
}


input[type='range']:nth-child(1)::-webkit-slider-thumb{
  z-index: 2;
}

.rangeslider{
    position: relative;
    height: 60px;
    width: 210px;
    display: inline-block;
    margin-top: -5px;
    margin-left: 20px;
}
.rangeslider input{
    position: absolute;
}
.rangeslider{
    position: absolute;
}

.rangeslider span{
    position: absolute;
    margin-top: 30px;
    left: 0;
}

.rangeslider .right{
   position: relative;
   float: right;
   margin-right: -5px;
}
</style>
<!-- <style type="text/css">

  .range-slider {
    width: 300px;
    text-align: center;
    position: relative;
    padding: 0px 23px;
  }



  input[type=range] {
    -webkit-appearance: none;
    border: 1px solid white;
    width: 200px;
    position: relative;
    left: 0;
  }

  input[type=range]::-webkit-slider-runnable-track {
    width: 300px;
    height: 5px;
    background: #ddd;
    border: none;
    border-radius: 3px;

  }

  input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
    border: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #21c1ff;
    margin-top: -4px;
    cursor: pointer;
    position: relative;
    z-index: 1;
  }

  input[type=range]:focus {
    outline: none;
  }

  input[type=range]:focus::-webkit-slider-runnable-track {
    background: #ccc;
  }

  input[type=range]::-moz-range-track {
    width: 300px;
    height: 5px;
    background: #ddd;
    border: none;
    border-radius: 3px;
  }

  input[type=range]::-moz-range-thumb {
    border: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #21c1ff;

  }


  /*hide the outline behind the border*/

  input[type=range]:-moz-focusring {
    outline: 1px solid white;
    outline-offset: -1px;
  }

  input[type=range]::-ms-track {
    width: 300px;
    height: 5px;
    /*remove bg colour from the track, we'll use ms-fill-lower and ms-fill-upper instead */
    background: transparent;
    /*leave room for the larger thumb to overflow with a transparent border */
    border-color: transparent;
    border-width: 6px 0;
    /*remove default tick marks*/
    color: transparent;
    z-index: -4;

  }

  input[type=range]::-ms-fill-lower {
    background: #777;
    border-radius: 10px;
  }

  input[type=range]::-ms-fill-upper {
    background: #ddd;
    border-radius: 10px;
  }

  input[type=range]::-ms-thumb {
    border: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #21c1ff;
  }

  input[type=range]:focus::-ms-fill-lower {
    background: #888;
  }

  input[type=range]:focus::-ms-fill-upper {
    background: #ccc;
  }

</style>
<script type="text/javascript">
	function getVals(){
  // Get slider values
  let parent = this.parentNode;
  let slides = parent.getElementsByTagName("input");
  let slide1 = parseFloat( slides[0].value );
  let slide2 = parseFloat( slides[1].value );
  // Neither slider will clip the other, so make sure we determine which is larger
  if( slide1 > slide2 ){ let tmp = slide2; slide2 = slide1; slide1 = tmp; }
  
  let displayElement = parent.getElementsByClassName("rangeValues")[0];
  displayElement.innerHTML = "$" + slide1 + " - $" + slide2;
}

window.onload = function(){
  // Initialize Sliders
  let sliderSections = document.getElementsByClassName("range-slider");
  for( let x = 0; x < sliderSections.length; x++ ){
    let sliders = sliderSections[x].getElementsByTagName("input");
    for( let y = 0; y < sliders.length; y++ ){
      if( sliders[y].type ==="range" ){
        sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
          }
        }
      }
    }
  </script> -->