<?php
isset($brand_ids) ? "" : $brand_ids = array();


$CI = &get_instance();
?>
<style type="text/css">

  .new {
    padding: 10px;
  }
  .accordion__toggle{
    background-color: black !important;
    height: 2px !important;
  }
  .accordion__toggle::before{
   width: 2px !important;
 }

</style>

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
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active"><a href="#">Category</a></li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-3 categories">
      <div class="card-header md-none bg-color text-white text-uppercase"><i class="fa fa-list"></i> Categories</div>
      <div class="accordion">
       <?php
       if(!empty($category)){
        foreach($category as $c){
          $cat_id =  $this->uri->segment(3);  
          ?>
          <div class="accordion__header <?php if($c->categoryID == $cat_id) echo 'active'?>" >
            <h2> <a href="<?=base_url('home/category_products/').$c->categoryID?>" ><?=$c->title?></a></h2>
            <span class="accordion__toggle"></span>
          </div>

          <div class="accordion__body">
            <?php if(!empty($c->subcategory)){
              foreach($c->subcategory as $sub){ ?>
               <a href="<?=base_url('home/sub_category_products/').$sub->categoryID?>" ><?=$sub->title?> <br></a>


             <?php  }  } ?></div><?php  } } ?>

           </div>

           <br><br>
           <div class="card-header bg-color text-white text-uppercase"><i class="fa fa-list"></i> &nbsp;Price Range</div>

           <div class="card-body card-shop-filters">
            <?php
            $min = $product_data->min_price;
            $max = $product_data->max_price;

            ?>
            <div class="rangeslider">
             <input class="min" name="range_1" type="range" min="0" max="999" value="<?=$min?>"  />
             <input class="max" name="range_1" type="range" min="0" max="999" value="<?=$max?>" />
             <span class="range_min light left" data-name="<?=$min_price?>"><?=$min_price?></span>
             <span class="range_max light right" data-name="<?=$max_price?>"><?=$max_price?></span>
           </div>
         </div>
         <br><br><br>
         <div class="card-header bg-color text-white text-uppercase"><i class="fa fa-list"></i> &nbsp;Shop By Brand</div>

         <div class="card-body  new" style="overflow-y: scroll;height: 250px;">
          <br>
          <div class="form-group" id="myUL">
            <?php foreach($brands as $b){ ?>
              <input type="checkbox" name="brand[]" id="brand_id" class="brands"  id="cb<?=$b['brandID']?>" value="<?=$b['brandID']?>" onclick="filter(this)" <?php if(in_array($b['brandID'], $brand_ids)) echo 'checked'; ?>>
              <label  for="cb<?=$b['brandID']?>" ><?=$b['brand']?></label><br>
            <?php } ?>

          </div>

        </div>
        <br>
        <div class="card-header bg-color text-white text-uppercase"><i class="fa fa-list"></i> &nbsp;Discount</div>

        <div class="card-body new"  style="overflow-y: scroll;height: 250px;">
          <?php foreach($products as $p) 
          $discount = ceil((($p->retail_price-$p->price)/$p->retail_price)*100);
          ?>
          <div class="form-group">
           <input type="radio" name="discount"  data-type="less"  id="disc"  data-min= "0" data-max= "15"   value="1"  onclick="filter_discount(this,15,'less')" <?php if ($disc_min == 0 && $disc_max == 15) echo 'checked' ?>>
           <label >0 to 15% </label><br>
         </div>
         <div class="form-group">
           <input type="radio"  name="discount" data-type="less"   id="disc" data-min= "15" data-max= "25"  value="2" onclick="filter_discount(this,25,'less')" <?php if ($disc_min == 15 && $disc_max == 25) echo 'checked' ?>>
           <label >15 to 25% </label><br>
         </div>
         <div class="form-group">
           <input type="radio"  name="discount" data-type="less"   id="disc" data-min= "25" data-max= "35"  value="3" onclick="filter_discount(this,35,'less')" <?php if ($disc_min == 25 && $disc_max == 35) echo 'checked' ?>>
           <label >25 to 35% </label><br>
         </div>
         <div class="form-group">
           <input type="radio" name="discount"  data-type="less"  id="disc" data-min= "35" data-max= "50"  value="4" onclick="filter_discount(this,50,'less')" <?php if ($disc_min == 35 && $disc_max == 50) echo 'checked' ?>>
           <label >35 to 50% </label><br>
         </div>
         <div class="form-group">
           <input type="radio" name="discount"  data-type="greater"   id="disc" data-min= "50" data-max= "100" value="5" onclick="filter_discount(this,50,'greater')" <?php if ($disc_min == 50 && $disc_max == 100) echo 'checked' ?> >
           <label >More than 50%</label><br>
         </div>
       </div>
       <br><br>
     </div>
     <div class="col-md-9 our-publication">
      <?php 
      if(!empty($subCategory_products)){
       foreach($subCategory_products as $subcategory){
         ?>
         <h3 class="mb-3"><?=$subcategory->title?></h3>
         <div class="row">
          <?php if(!empty($subcategory->products)){
            foreach($subcategory->products as $p){
              $p_variantID = isset($p->variantID) ? $p->variantID :0;
              ?>
              <div class="col-6 col-md-6 col-lg-4 mb-4">
                <div class="product-grid4">
                  <div class="product-image4">
                    <a href="<?=base_url('home/product_detail/').$p->productID;?>">
                      <img class="pic-1" src="<?=base_url('admin/uploads/products/'). $p->product_image;?>">
                    </a>
                    <span class="product-new-label">Offer</span>
                    <span class="product-discount-label"><?=ceil((($p->retail_price-$p->price)/$p->retail_price)*100); ?>% OFF</span>
                  </div>
                  <div class="product-content">
                    <h3 class="title"><a href="<?=base_url('home/product_detail/').$p->productID?>"><?=$p->product_name;?></a></h3>
                    <div class="price">
                      <b id="set_Price<?=$p->productID?>">Rs. <?=$p->price;?></b>
                      <span id="set_retailPrice<?=$p->productID?>">MRP <strike>Rs.<?=$p->retail_price;?></strike>
                      </span>
                    </div>
                    <br>
                    <?php
                    if($p->totalVariants>1){?>
                      <select name="option[239]" id="input-option230" class="form-control get_variant variant_change"  productID="<?=$p->productID; ?>"
                       get_user="<?=$userID; ?>">
                       <?php if(!empty($p->variants)){
                        $variantID = '';
                        foreach($p->variants as $variant){
                          $variantID =$variant->id;
                          ?>
                          <option value="<?=$variant->id?>"><?=$variant->unit_value.$variant->unit.'('.$variant->price.')'?></option>
                        </select>
                      <?php }
                    } ?>
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
                      <input type="button" value="-"  onclick="add_to_cart_type(<?=$p->productID?>,<?=$p_variantID?>,event,0)" class="minus change_argument">
                      <input type="number" step="1" min="1" max="<?=$p->max_quantity;?>" name="quantity"  id="get_qty<?=$p->productID;?>" value="<?php if($p->cart_qty>0){ echo $p->cart_qty;}else{ echo "1";   };?>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                      <input type="button" value="+" onclick="add_to_cart_type(<?=$p->productID?>,<?=$p_variantID?>,event,1)" class="plus change_argument1">
                    </div>
                  </div>
                  <div class="col-md-5" >
                    <a class="add-to-cart change_argument_new" onclick="add_to_cart(<?=$p->productID?>,<?=$p_variantID?>,event);">ADD &nbsp;&nbsp;<i class="fa fa-shopping-cart"></i></a>
                  </div>
                </div>
                <br>
              </div>

            </div>
          </div>

        <?php } }else{?>
          <p style="text-align: center;">No Products Found</p>
        <?php }?>
        <?php 

        $start_loop = $pageno;
        $difference = $total_pages - $pageno;
        if($difference <= 5)
        {
         $start_loop = $total_pages - 5;
       }
       $end_loop = $start_loop + 4;
       if($pageno >= 1)
       {
        /*echo '<ul class="pagination mt-3 mb-3 d-none">';*/
        echo '  <li style="list-style: none;"><a  href="?pageno=1" class="page-link">First</a></li>';

        echo "<li style='list-style: none;' class='page-item'><a class='page-link' href='?pageno=".($pageno - 1)."'><<</a></li>";
      }
      for($i=$start_loop; $i<=$end_loop; $i++)
      {  
        $class ='';
        if($pageno ==$i){
          $class = 'active';
        }   
        echo "<li style='list-style: none;' class='page-item ".$class."'><a class='page-link' href='?pageno=".$i."'>".$i."</a></li>";
      }
      if($pageno <= $end_loop)
      {

       echo "<li style='list-style: none;' class='page-item '><a class='page-link' href='?pageno=".($pageno + 1)."'>>></a></li>";
       echo "<li style='list-style: none;' class='page-item'><a class='page-link' href='?pageno=".$total_pages."'>Last</a></li>";
     }
     ?>
     <br><br>
   </div>
 <?php } } ?>

</div>


</div>
</div>
<!-- Footer -->

<style>
  .categories{
    position: sticky;
    top: 12px !important;
    height: calc(280vh - 100%);
  }
  .accordion__header h2 a{
    color: black;
  }
  .accordion__header h2 a:hover{
    text-decoration: none;
  }
  .accordion__header.is-active{
    background-color: #ccc;
    transition: height 1s ease !important;
  }
  .accordion__header.is-active a{
    margin-bottom: 10px;
  }
  .accordion__toggle{
    background-color: black !important;
  }
  @media (max-width: 768px)
  {
   .categories{
    position: relative;
     /* top: 12px !important;
     height: calc(280vh - 100%);*/
   }
 }
</style>
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
  margin-left: 0px;
}
.rangeslider input{
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
#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myUL {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a {
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block
}

#myUL li a:hover:not(.header) {
  background-color: #eee;
}
</style>

<script>
  function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
</script>