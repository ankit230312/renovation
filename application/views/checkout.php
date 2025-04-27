  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script> -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <style type="text/css">
  .btn-link:hover{
    text-decoration: none;
  }
  .option-input{
    margin: 22px;
  }
  .btn:focus, .btn.focus{
    text-decoration: none;
    box-shadow: none;
  }
  .text-muted h5{
    font-size: 15px;
  }
  .right .item {
    padding: 1.3rem 17px;
  }
  .cart-d p{
    margin-bottom: 0px;
  }
  .modal-backdrop {
    position: absolute!important;
  }
</style>
<!-- Cart Checkout Section -->
<?php 
 $delivery = $this->db->query("SELECT * FROM `settings`")->row();
$delivery_charge_new = $delivery->delivery_charge;

$free_delivery_amount = $delivery->free_delivery_amount;
$min_order_amount = $delivery->min_order_amount;

if (isset($_SESSION['loginUserID']) &&  $_SESSION['loginUserID'] == TRUE && $_SESSION['loginUserID'] != ''){
  $userID = $_SESSION['loginUserID'];
  $user_detail = $this->db->query("SELECT * FROM `users` WHERE ID = $userID")->row();
  $name = $user_detail->name;
  $mobile = $user_detail->mobile;
  $email = $user_detail->email;
  $wallet_bal = $user_detail->wallet;
}

?>

<?php 
echo $this->session->flashdata('message');

?>
<div class="cart pt-40">
  <div class="cart_body">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="left_border">

           <div class="accordion" id="accordionExample275">
            <div class="card z-depth-0 bordered">
              <div class="card-header" id="headingOne2">
                <h6 class="mb-0">
                  <button class="btn btn-link checkout_cart" type="button" data-toggle="collapse" data-target="#collapseOne2"
                  aria-expanded="true" aria-controls="collapseOne2">
                  Choose Delivery Address <i class="fas fa-arrow-alt-circle-down"></i>
                </button>
                <button class="btn btn-link  btn-primary checkout_cart1" type="button" data-toggle="collapse" data-target="#collapseOne2"
                aria-expanded="true" aria-controls="collapseOne2" style="float: right;">
                Change
              </button>

            </h6>
          </div>

          <div id="collapseOne2" class="collapse show" aria-labelledby="headingOne2"
          data-parent="#accordionExample275" style="padding: 10px;">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#basicExampleModal">
            Add Delivery Address
          </button>
          <div class="row" id="address_list">

          </div>
          <!-- Modal -->
          <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content from_bg">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

              </div>


              <div class="modal-body">
                <form id="save_address" method="post">
                  <label for="name">Full Name*</label>
                  <input placeholder="Name" class="form-control" type="text" name="contact_person_name"  required="" value="">
                  <label for="name">Mobile Number*</label>
                  <input type="text" class="form-control" name="contact_person_mobile" placeholder="Mobile Number" required="" value="">

                  <label for="name">House No</label>
                  <input type="text" class="form-control" name="flat_no" placeholder="House No" id="cart_option1" value="">

                  <label for="name">Building Name</label>
                  <input type="text" class="form-control" name="building_name" placeholder="Building Name" id="building_name" value="">

                  <label for="name">Address*</label>
                  <input type="text" class="form-control" name="location" id="location" placeholder="Address" value="">
                  <span id="location_error" style="color: red"></span>
                  <br>
                  <label for="Name">LandMark*</label><input type="text" name="landmark"  class="form-control" value="" id="landmark" placeholder="landmark" required="">
                  <span id="landmark_error" style="color: red"></span>
                  <br>

                  <label for="Name">Pincode*</label><input type="text" placeholder="Pin code" id="pincode_add" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" name="pincode" required="">
                  <span id="pincode_error" style="color: red"></span>
                  <br>
                  <input type="hidden" name="latitude" class="form-control" id="latitude" value="">
                  <input type="hidden" name="longitude" class="form-control" id="longitude" value="">
                  <label>Address Type</label>
                  <select class="form-control" name="address_type">

                    <option value="home" selected>Home</option>
                    <option value="office">Office</option>
                    <option value="others">Shop</option>
                  </select>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="add_add">Add Address</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card z-depth-0 bordered">
      <div class="card-header" id="headingTwo2">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed checkout_cart" type="button" data-toggle="collapse"
          data-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
          Select Delivery date and Time <i class="fas fa-arrow-alt-circle-down"></i>
        </button>
        <button class="btn btn-link btn-primary collapsed checkout_cart1" type="button" data-toggle="collapse"
        data-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2" style="float: right;">
        Change
      </button>
    </h5>
  </div>

  <?php
  
  ?>
  <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2"
  data-parent="#accordionExample275" style="padding: 10px;">

  <div class="time_slot pb-3">
    <ul class="nav nav-pills options" id="myTab" role="tablist">
      <?php for($i=0;$i<6;$i++){
        $today = date('Y-m-d');
        $date = date('Y-m-d', strtotime($today . ' +'.$i.'day'));

        if($i==0){
          $day_name = 'Today';
        }else{
          $day_name = date('d F', strtotime($date));
        }

        ?>
        <li class="nav-item"><a class="nav-link <?php if($i==0) echo 'active'?>" id="slot_date<?php echo $i;?>" onclick="date_slot('<?=$date?>')" data-toggle="tab" href="#home2" data-date="<?=$date?>" role="tab" aria-controls="home" aria-selected="true"><?=$day_name?></a>
        </li>
      <?php }?>
      <!-- <li class="nav-item"><a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">2 Apr</a></li>

      <li class="nav-item"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">3 Apr</a></li>
      <li class="nav-item"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">4 Apr</a></li>
      <li class="nav-item"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">5 Apr</a></li>
      <li class="nav-item"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">6 Apr</a></li>
      <li class="nav-item"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">7 Apr</a></li> -->
    </ul>
  </div>
  <div class="tab-content mb-4">
    <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
     <div class="form-group">

      <div id="slot_list">

      </div>

    </div>
  </div>

</div>
</div>
</div>
<!-- slot -->
<!-- --------------------------------------------------------------- -->
<!-- Final Checkout Form  -->




<!-- Final Checkout form End -->


<div class="card z-depth-0 bordered">
  <div class="card-header" id="headingThree2" data-toggle="collapse"
  data-target="#collapseThree2" aria-expanded="false" aria-controls="collapseThree2">
  <h5 class="mb-0">
    <button class="btn btn-link collapsed checkout_cart show">
      Payment <i class="fas fa-arrow-alt-circle-down"></i>
    </button>
  </h5>
</div>
<div id="collapseThree2" class="collapse show" aria-labelledby="headingThree2"
data-parent="#accordionExample275">
<div class="form-group p-3">
  <div class="radio mb-10">
    <label >
      <input  type="radio" checked="checked" value="cod" name="payment_mode" onchange="getPymentValue(this)" > Would You like to pay by Cash on Delivery</label>
    </div>
    <div class="radio mb-10">
      <label>
        <input  type="radio" onchange="getPymentValue(this)" value="online" name="payment_mode"> Would you like to pay by Online</label>
      </div>
     <!--  <div class="radio mb-10">
      <label>
        <input  type="radio" onchange="getPymentValue(this)" value="wallet" name="payment_mode"> Would you like to pay by wallet</label>
      </div> -->
  </div>
</div>
</div>
</div>

</div>
</div>
<div class="col-md-4">
  <div class="right border">
    <div class="header text-center"> <h5>Order Summary</h5> </div>
    <b><?=count($carts)?> items</b>
    
    <?php
    $total_saving = 0;
    $all_cart = [];
    if(!empty($carts)){
      $all_cart = json_encode($carts);
      $price =0;
      $total_price = 0;
      $sub_total= 0;
      $total_mrp = 0;
      $saving = 0;
      $sub_total1 = 0;

      foreach($carts as $cart){
        $variantID = isset($cart->variantID) ? $cart->variantID :'';
        $qty = 0;
        $pro_name = '';
        $varient_name='';
        $product_img = '';
        $path = base_url('/admin/uploads/products/');
        if(!empty($variantID)){
          $varients = $this->db->query("SELECT * FROM `products_variant` WHERE `id`='$variantID'")->row();
          if(!empty($varients)){
            $varient_name = $varients->unit_value.' '.$varients->unit;
            $varient_price = $varients->price;
            $varient_retailprice = $varients->retail_price;
          }
        }
        if($cart->qty != 0){
          $qty =$cart->qty;
        }
        
        $product = $this->db->query("SELECT * FROM `products` WHERE `productID`='$cart->productID'")->row();
        if(!empty($product)){
          $price = $product->price;
          //$total_price = $price * $qty;
          $total_price = $varient_price * $qty;
          $product_name = $product->product_name;
          $sub_total += $total_price;
          $total_mrp = $varient_retailprice * $qty;



          $saving = $varient_retailprice - $varient_price;


          $sub_total1 += $total_mrp;
          //$total_saving = $sub_total1 - $sub_total;
          $total_saving += $saving;
          $product_img = $path.$product->product_image;


          $delivery = $this->db->query("SELECT * FROM `settings`")->row();
          $delivery_charge_new = $delivery->delivery_charge;
          $free_delivery_amount = $delivery->free_delivery_amount;
          $min_order_amount = $delivery->min_order_amount;


          if($sub_total > $free_delivery_amount) {
           $delivery_charge = 0;
         }else{
          $delivery_charge = $delivery_charge_new;
        }

        $final =  $sub_total +  $delivery_charge ;



      }

      ?>  
      <div class="row item">
        <div class="col-md-4 align-self-center">
          <img class="img-fluid" src="<?=$product_img?>">
        </div>
        <div class="col-md-8 cart-d">

          <div class="row text-muted">
            <h5>
              <?=$product_name?>
            </h5>
          </div>
          <div class="row"><b>₹<?=$varient_price?></b>&nbsp;&nbsp;Rs. <strike><b><?=$varient_retailprice?></b></strike></div>
          <div class="row"><p style="color: red!important;">You Save Rs. <?=$saving?></p></div>
          <div class="row"></div>
          <div class="row">
            <p>
              <?=$varient_name?>
            </p>
          </div>
          <div class="row">
            <p>
              Qty:<?=$qty?>
            </p>
          </div>
        </div>
      </div>
      <hr>
    <?php }}?>

    <div class="row lower">
      <div class="col text-left">Subtotal</div>
      <div class="col text-right">₹<?=$sub_total?></div>
    </div>
     <div class="row lower">
      <div class="col text-left">Minimum Order Amount</div>
      <div class="col text-right">₹<?=$min_order_amount?></div>
    </div>
    <div class="row lower">
      <div class="col text-left">Total Savings</div>
      <div class="col text-right"><b style="color: red;">₹<?=$total_saving?></b></div>
    </div>
    <div class="row lower">
      <div class="col text-left">Delivery 
        <span data-toggle="popover" data-container="body" data-placement="right" data-content="T & C Apply" tabindex="0" role="button">
          <i class="fa fa-info-circle" aria-hidden="true"></i>
        </span>
      </div>
      <div class="col text-right">₹<?php  if ($sub_total > $free_delivery_amount) {
       echo $delivery_charge = 0;
     }else{
       echo $delivery_charge = $delivery_charge_new;
     }?></div>
   </div>

   <?php if(!empty($coupons)){?>
     <div class="row lower" id="apply_promo">
      <div class="col text-left">Add promo code <span id="info_icon" data-toggle="modal" data-target="#getinfo"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span id="promo_code" style="color: green;"></span></div>
      <div class="col text-right" id="coupon_html"><strong data-toggle="modal"  data-target="#applycoupon" tabindex="0" role="button">Apply</strong></div>
    </div>
  <?php }?>
  <?php if($user->cashback_wallet > 0 ){?>
    <div class="row lower" id="use_cashback">
      <div class="col text-left">Use Cashback</div>
      <div class="col text-right"><input type="checkbox" name="cashback" id="cashback" value="<?=$user->cashback_wallet?>"><strong style="color: green;">- ₹<?=$user->cashback_wallet?></strong></div>
    </div>
     

  <?php }?>
  <?php if($user->wallet > 0 ){?>
    <div class="row lower" id="use_wallet">
      <div class="col text-left">Use wallet</div>
      <div class="col text-right"><input type="checkbox" name="wallet" id="wallet" value="<?=$user->wallet?>"><strong style="color: green;">- ₹<?=$user->wallet?></strong></div>
    </div>
     

  <?php }?>
  <div class="row lower " >
    <div class="col text-left"><b>Total to pay</b></div>
    <input type="hidden" name="" id="sub_total_amount1" value="<?php echo $final;?>">
    <div class="col text-right"><b>₹ <span id="sub_total_amount"><?=$final?> </span></b></div>
  </div>

  <style>
  label{
    font-size: 16px !important;
  }
  .accordion .active{
    background-color: transparent;
  }
  .shape {
    border-style: solid;
    border-width: 0 70px 40px 0;
    float: right;
    height: 0px;
    width: 0px;
    -ms-transform: rotate(360deg); /* IE 9 */
    -o-transform: rotate(360deg); /* Opera 10.5 */
    -webkit-transform: rotate(360deg); /* Safari and Chrome */
    transform: rotate(360deg);
  }
  .listing {
    background: #fff;
       /* border: 1px solid #ddd;
       box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);*/
       margin: 15px 0;
       overflow: hidden;
     }
  /*    .listing:hover {
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -ms-transform: scale(1.1);
        -o-transform: scale(1.1);
        transform: rotate scale(1.1);
        -webkit-transition: all 0.4s ease-in-out;
        -moz-transition: all 0.4s ease-in-out;
        -o-transition: all 0.4s ease-in-out;
        transition: all 0.4s ease-in-out;
        }*/
        .shape {
          border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
        }
        .listing-radius {
          border-radius: 7px;
        }
        .listing-danger {
          border-color: #d9534f;
        }
        .listing-danger .shape {
          border-color: transparent #d9533f transparent transparent;
        }
        .listing-success {
          border-color: #5cb85c;
        }
        .listing-success .shape {
          border-color: transparent #5cb75c transparent transparent;
        }
        .listing-default {
          border-color: #999999;
        }
        .listing-default .shape {
          border-color: transparent #999999 transparent transparent;
        }
        .listing-primary {
          border-color: #428bca;
        }
        .listing-primary .shape {
          border-color: transparent #318bca transparent transparent;
        }
        .listing-info {
          border-color: #5bc0de;
        }
        .listing-info .shape {
          border-color: transparent #5bc0de transparent transparent;
        }
        .listing-warning {
          border-color: #f0ad4e;
        }
        .listing-warning .shape {
          border-color: transparent #f0ad4e transparent transparent;
        }
        .shape-text {
          color: #fff;
          font-size: 12px;
          font-weight: bold;
          position: relative;
          right: -40px;
          top: 2px;
          white-space: nowrap;
          -ms-transform: rotate(30deg); /* IE 9 */
          -o-transform: rotate(360deg); /* Opera 10.5 */
          -webkit-transform: rotate(30deg); /* Safari and Chrome */
          transform: rotate(30deg);
        }
        .listing-content {
          padding: 16px 31px 35px
        }
        .listing-content p{
          color: #797070;
          font-size: 13px;
        }
      </style>

      <div class="modal fade" id="getinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Coupon Info</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <span id="info_details"></span>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>




    <div class="modal fade" id="applycoupon" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #ffb1b1!important;">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Apply Coupons</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <span id="apply_coup_error" style="color: red;"></span>
          <div class="modal-body">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class=" d-flex">
                <input type="text" id="coupon_c" name="coupon_c" placeholder="Enter Coupon code" style="height: 46px; border-radius:  9px 0px 0px 9px;"class="form-control">
                <a style="color: #fff;border-radius: 0px 9px 9px 0px;
                padding: 8px 37px; background-color:teal;" onclick="apply_coupon(this)">Apply</a>
              </div>
            </div>



            <?php if(!empty($coupons)){
              foreach($coupons as $coup){
                if($coup->offer_type == 'FIXED'){
                  $dis = 'Discount';
                  $html = $coup->offer_value. ' OFF';
                } if($coup->offer_type == 'PERCENTAGE'){
                  $dis = 'Discount';
                  $html = $coup->offer_value. '%';
                }
                if($coup->offer_type == 'CASHBACK_PERCENTAGE'){
                  $dis = 'Cashback';
                  $html = $coup->offer_value. '%';
                }
                if($coup->offer_type == 'CASHBACK'){
                  $dis = 'Cashback';
                  $html = $coup->offer_value;
                }


                ?>
                <!-- <li><?=$coup->offer_code?></li> <a href="" style="float: right; color: red">Apply</a> -->

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 <!-- <p><?=$dis?></p> -->
                 <div class="listing listing-radius listing-success">
                  <div class="shape">

                    <div class="shape-text"><?=$html?></div>
                  </div>
                  <div class="listing-content" onclick="apply_coupon('<?=$coup->offer_code?>')">
                    <h3 class="lead" style="text-transform: uppercase;"><?=$coup->offer_code?></h3>
                    <p><?=$coup->description?></p>
                    <small style="float: left">T & C Apply</small>
                  </div>
                </div>
              </div>
            <?php }}?>
          </div>
       <!--    <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Apply</button>
          </div> -->
        </div>
      </div>
    </div>





    <?php
    $userID = $this->session->userdata('loginUserID');
    $carts_details = base64_encode(json_encode($carts));

    ?>
    <form id="order_place" method="post" action="<?=base_url('home/place_order')?>">
      <input type="hidden" name="user_id" value="<?=$userID?>">
      <input type="hidden" name="address_id" id="address_id" value="">
      <input type="hidden" name="delivery_date" id="delivery_date" value="">
      <input type="hidden" name="delivery_time" id="delivery_time" value="">
      <input type="hidden" name="payment_method" id="payment_method" value="cod">
      <input type="hidden" name="cashback_amount" id="cashback_amount" value="<?=$user->cashback_wallet?>">
       <input type="hidden" name="get_wallet" id="get_wallet" value="">
      <input type="hidden" name="get_cashback" id="get_cashback" value="">
      <input type="hidden" name="coupon_code" id="coupon_code" value="">
      <input type="hidden" name="coupon_discount" id="coupon_discount" value="">
      <input type="hidden" name="transaction_id" id="transaction_id" value="">
      <input type="hidden" name="cart_total" id="cart_total" value="<?=$final?>">
      <input type="hidden" name="wallet_apply" id="wallet_apply" value="">
      <input type="hidden" name="cashback_apply" id="cashback_apply" value="">
      <input type="hidden" name="discount_amount" id="discount_amount" value="">
      <input type="hidden" name="carts" id="carts" value="<?=$carts_details?>">
      <input type="hidden" name="subtotal" id="subtotal" value="<?=$sub_total?>">
      <input type="hidden" name="total" id="total" value="<?=$final?>">
      <input type="hidden" name="delivery_charges" id="delivery_charges" value="<?=$delivery_charge?>">
      <?php if ($sub_total > $min_order_amount) { ?>
      <button class="btn bg-color" type="submit" id="place_order">Place Order</button>
    <?php }else{ ?>
     <center><strong style="color: red;">Your Cart is below minimum cart value Please add some more items.</strong></center>
    <?php } ?>
    </form>
    
  </div>
</div>
</div>
</div>
</div>
<div>
</div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#info_icon').hide();
//user clicks button
if ("geolocation" in navigator){ //check geolocation available 
//try to get user current location using getCurrentPosition() method
navigator.geolocation.getCurrentPosition(function(position){ 
    // $("#result").html("Found your location <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude);

    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);


  });
}else{
  console.log("Browser doesn't support geolocation!");
}
});
</script>
<script type="text/javascript">
  function date_slot(slot_date){
    get_slot(slot_date);
  }
</script>
<script type="text/javascript">
  function apply_coupon(coup_code=''){
    if(coup_code == ''){
      coup_code = $('#coupon_c').val();
    }
    $('#promo_code').show();
    $('#get_cashback').val('');
    $.ajax({
      url:'<?=base_url("home/apply_coupon")?>',
      data : "coup_code="+coup_code,
      dataType:"JSON",
      method : 'POST',

      success : function (res) {
        if(res.status){

          $('#info_icon').show();
          $('#use_cashback').hide();
          $('#use_wallet').hide();
          var type = res.type;

          if(type == 'discount'){

            var amount = res.discount;
            var total = '<?php echo $sub_total?>';
            var delivery_charge = '<?php echo $delivery_charge?>';
            var free_delivery_amount = '<?php echo $free_delivery_amount?>';
            amount = parseInt(amount);
            total = parseInt(total);
            delivery_charge = parseInt(delivery_charge);
            free_delivery_amount = parseInt(free_delivery_amount);

            if (total >free_delivery_amount) {
              var delivery_charges = 0;
              delivery_charges = parseInt(delivery_charges);
              var sub_total = parseInt(total) + parseInt(delivery_charges)- parseInt(amount);

            }else{
              delivery_charges = parseInt(delivery_charge);
              var sub_total = parseInt(total) + parseInt(delivery_charges)- parseInt(amount);
              
            }
            $('#cashback_apply').val('no');
            $('#sub_total_amount').html(sub_total);
            $('#total').val(sub_total);
            $('#discount_amount').val(amount);
            $('#delivery_charges').val(delivery_charges);
            $('#coupon_code').val(res.coup_code);
            $('#coupon_html').html('<span style="color:green;"> - '+amount + '<span>');
            $('#promo_code').html('  ('+res.coup_code+')<a onclick="remove_coupon()" style="color:red;">remove</a>');
            $('#applycoupon').modal('toggle');

          }else{
            var amount = res.discount;
            var total = '<?php echo $sub_total?>';
            var delivery_charge = '<?php echo $delivery_charge?>';
            var free_delivery_amount = '<?php echo $free_delivery_amount?>';
            amount = parseInt(amount);
            total = parseInt(total);
            delivery_charge = parseInt(delivery_charge);
            free_delivery_amount = parseInt(free_delivery_amount);

            if (total > free_delivery_amount ) {
             var delivery_charges = 0;
             delivery_charges = parseInt(delivery_charges);
             var sub_total = parseInt(total) + parseInt(delivery_charges);

           }else{
             
             delivery_charges = parseInt(delivery_charge);
             var sub_total = parseInt(total) + parseInt(delivery_charges);

           }
           $('#cashback_apply').val('yes');
           $('#sub_total_amount').html(sub_total);
           $('#total').val(total);
           $('#total').val(sub_total);
           $('#coupon_html').html('<span style="color:green;"> - '+amount + '<span>');
           $('#promo_code').html('  ('+res.coup_code+')<a onclick="remove_coupon()" style="color:red;">remove</a>');
           $('#get_cashback').val(amount);
           $('#applycoupon').modal('toggle');
           $('#coupon_code').val(res.coup_code);

         }
         $('#info_details').html(res.description);


       }else{
        // alert(res.message);

        $('#apply_coup_error').html(res.message);

      }
    }

  });
    
  }
</script>
<script type="text/javascript">
  function remove_coupon(){
   // alert('sdf');
   var amount = 0;
   var total = '<?php echo $sub_total?>';
   var delivery_charge = '<?php echo $delivery_charge?>';
    var free_delivery_amount = '<?php echo $free_delivery_amount?>';
   amount = parseInt(amount);
   total = parseInt(total);
   delivery_charge = parseInt(delivery_charge);
    free_delivery_amount = parseInt(free_delivery_amount);
   if(!confirm('Are you want to remove Coupon Code')){
    return false;
  }else{
    $('#info_icon').hide();
  //$('#coup_code').val(res.coup_code);
  if (total >free_delivery_amount ) {
   var delivery_charges = 0;
   delivery_charges = parseInt(delivery_charges);
   var sub_total = parseInt(total) + parseInt(delivery_charges);
 }else{
  
   delivery_charges = parseInt(delivery_charge);
   var sub_total = parseInt(total) + parseInt(delivery_charges);
 }

 $('#sub_total_amount').html(sub_total);
 $('#total').val(sub_total);
 $('#discount_amount').val(amount);
 $('#get_cashback').val(0);
 $('#coupon_code').val('');
 $('#get_cashback').val(0);
 $('#delivery_charges').val(0);
 $('#delivery_charges').val('');
 $('#apply_promo').show();
 $('#use_cashback').show();
  $('#use_wallet').show();
 $('#coupon_html').html('<strong data-toggle="modal" data-target="#applycoupon">Apply</strong>');
 $('#coupon_html').show();
 $('#promo_code').hide();
}
}
</script>




<script type="text/javascript">
  function get_address_id(id){
    $('#address_id').val(id);
  }
  // function get_slot_time(slot_time){
  //   alert(slot_time);
  //   $('#delivery_time').val(slot_time);

  // }
  function getValue(radio) {
    $('#delivery_time').val(radio.value);
  }
  function getPymentValue(pay){
    $('#payment_method').val(pay.value);

    var payment_method = $('#payment_method').val();
      if (payment_method == 'cod') {
         $('#use_cashback').hide();
        $('#use_wallet').hide();
      }else{
         $('#use_cashback').show();
        $('#use_wallet').show();
      }

  }

</script>
<script type="text/javascript">
  $("#place_order").click(function(){
    var payment_method = $('#payment_method').val();
    //alert(payment_method);
    // return false;
    var coup_code = $('#coupon_code').val();
    var total = $('#total').val();
    var delivery_charge = '<?php echo $delivery_charge?>';
    var free_delivery_amount = '<?php echo $free_delivery_amount?>';
    var name = '<?php echo $name?>';
    var mobile = '<?php echo $mobile?>';
    var email = '<?php echo $email?>';

    delivery_charge = parseInt(delivery_charge);
    free_delivery_amount = parseInt(free_delivery_amount);
    name = name;
    mobile = mobile;
    email = email;
    if(payment_method == 'cod' || total == 0){
      $('#order_place').submit();
    }else if(payment_method == 'online'){
     var logoUrl = "https://gowisekart.com/admin/uploads/logo1575713051.png";
     var currSel = $(this);
     var options = {
        //rzp_test_a47BCOLPPkaYO2
        key: "rzp_live_kNpmPYYnMbMwQE",
        



        amount: total * 100,
        id: "<?php echo rand(0000,9999)?>",
        name: 'GOWISEKART',
        image: logoUrl,
        "prefill": {
          "name": name,
          "contact": mobile,
          "email": email
        },
        handler: demoSuccessHandler
      }
      window.r = new Razorpay(options);
      var succ = r.open();
      if(succ){
        return false;
      }
    }
    $('#sub_total_amount').html(sub_total);
    $('#total').val(sub_total);
    $('#delivery_charges').val(delivery_charges);
  });

  function padStart(str) {
    return ('0' + str).slice(-2)
  }

  function demoSuccessHandler(transaction) {
        // You can write success code here. If you want to store some data in database.
        $("#paymentDetail").removeAttr('style');
        $('#paymentID').text(transaction.razorpay_payment_id);
        var paymentDate = new Date();
        $('#paymentDate').text(
          padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
          );

        var transaction_id = transaction.razorpay_payment_id;
        $('#transaction_id').val(transaction_id);
       $('#order_place').submit();
        //submitPaymentForm(transaction_id);
      }

    </script>



    <script type="text/javascript">
      $( document ).ready(function() {


       var date = '<?php echo date('Y-m-d')?>';
       get_slot(date);
     });




      function get_slot(date){
        $("#place_order").attr('disabled', false);
        $.ajax({

          url:'<?=base_url("home/slot")?>',

          data : "booking_date="+date,

          dataType:"HTML",
          method : 'POST',

          success : function (res) {
            var res1 = JSON.parse(res);
      //alert(res1[0].status);
      if(res1[0].status){
        if(res1[0].slot_time !=''){
          $("#place_order").attr('disabled', false);

          $('#slot_list').html(res1[0].html);
          $('#delivery_date').val(date);
          $('#delivery_time').val(res1[0].slot_time);
        }else{
         $("#place_order").attr('disabled', 'disabled');
         $('#slot_list').html(res1[0].html);
         $('#delivery_date').val(date);
         $('#delivery_time').val(res1[0].slot_time);
       }
     }
   }

 });

      }
    </script>

    <script type="text/javascript">
      $( document ).ready(function() {
       var user_id = '<?php echo $this->session->userdata('loginUserID')?>';
       get_address(user_id);
     });

      function get_address(user_id){
        $("#place_order").attr('disabled', false);
        $.ajax({

          url:'<?=base_url("home/get_user_address")?>',

          data : "user_id="+user_id,

          dataType:"HTML",
          method : 'POST',
          success : function (res) {
            var res = JSON.parse(res);
            if(res.status){
             $("#place_order").attr('disabled', false);
             $('#address_list').html(res.html);
             $('#address_id').val(res.address_id);
           }
         }

       });


      }

    </script>

    
    <script type="text/javascript">
      $("#add_add").click(function(){

        $('#landmark_error').html('');
        $('#city_error').html('');
        $('#pin_code_error').html('');
        $('#location_error').html('');
        var user_id = '<?php echo $this->session->userdata('loginUserID')?>';
        var landmark = $('#landmark').val();
        var city = $('#city').val();
        var pin_code = $('#pincode_add').val();
        var location = $('#location').val();

        if(user_id ==''){
          return false;
        }
    // if(landmark == ''){
    //   $('#landmark_error').html('Landmark is Required');
    //   console.log("landmark");
    //   return false;
    // }
    if(city == ''){
      console.log("city");
      $('#city_error').html('City is Required');
      return false;
    }if(pin_code == ''){
      console.log("pin_code");
      $('#pin_code_error').html('Pincode is Required');
      return false;
    }if(location == ''){
      console.log("location");
      $('#location_error').html('Location is Required');
      return false;
    }else{

      var formData = $('#save_address').serialize();
      //console.log("jjjj");
      $.ajax({

        url:'<?=base_url("home/add_address_order")?>',

        data : formData,

        dataType:"JSON",
        method : 'POST',
        success : function (res) {
           //var res = JSON.parse(res);
         //console.log(res);
         if(res.status){
           $('#basicExampleModal').modal('toggle');
           get_address(user_id);
           window.location.reload();
         }else{
          alert(res.message);
        }
      }

    });
    }

  });
</script>


<script type="text/javascript">
  $( document ).ready(function() {
    var cashback = $('#get_cashback').val();
    if(cashback != ''){
      return false;
    }

    $("#cashback").click(function(){
     var cashback = $('#get_cashback').val();

     if(cashback != ''){
      //alert('You Already Applied Coupon');
    }

    if($("#cashback").is(':checked')){

      $('#apply_promo').hide();
       $('#use_wallet').hide();

      var amount = '<?php echo $user->cashback_wallet?>';
      var total = '<?php echo $sub_total?>';///57
      var delivery_charge = '<?php echo $delivery_charge?>';
      var free_delivery_amount = '<?php echo $free_delivery_amount?>';
     
      delivery_charge = parseInt(delivery_charge);
      free_delivery_amount = parseInt(free_delivery_amount);
      amount = parseInt(amount);/////100
      total  = parseInt(total);////57
       if (total > free_delivery_amount) {
         var delivery_charges = 0;
         total = total+delivery_charges;
       }
       else{
         var delivery_charges =  parseInt(delivery_charge);
         total = total+delivery_charges;
       }

      if(amount > total){

        var remaining_cashback = parseInt(amount) -  parseInt(sub_total);
         

        $('#sub_total_amount').html('0');
        $('#total').val('0');
        $('#remaining_cashback').html(remaining_cashback);
        $('#get_cashback').val(amount);
        $('#cashback_apply').val('yes');
      }
      else{
         var sub_total = parseInt(total) - parseInt(amount);
          //alert(sub_total);
         var remaining_cashback1 = 0;
       $('#remaining_cashback1').html(remaining_cashback1);
       $('#sub_total_amount').html(sub_total);
       $('#total').val(sub_total);
       $('#cashback_apply').val('yes');
       $('#discount_amount').val('amount');


     }



   }
   else{
    $('#apply_promo').show();
     $('#use_wallet').show();
    var cashback = $('#get_cashback').val();
    if(cashback != ''){
     //alert('You Already Applied Coupon');
   }
   var amount = '<?php echo $user->cashback_wallet?>';
   var total = '<?php echo $sub_total?>';
  var delivery_charge = '<?php echo $delivery_charge?>';
  var free_delivery_amount = '<?php echo $free_delivery_amount?>';


   amount = parseInt(amount);
   total = parseInt(total);
    delivery_charge = parseInt(delivery_charge);
   free_delivery_amount = parseInt(free_delivery_amount);

   if (total > free_delivery_amount) {
     var delivery_charges = 0;
     delivery_charges = parseInt(delivery_charges);
     var sub_total = parseInt(total) + parseInt(delivery_charges);


   }else
   {
    delivery_charges = parseInt(delivery_charge);
    var sub_total = parseInt(total) + parseInt(delivery_charges);

  }
   //alert(sub_total);
  $('#remaining_cashback').html(amount);
  $('#remaining_cashback1').html(amount);
  $('#sub_total_amount').html(sub_total);
  $('#total').val(sub_total);
  $('#cashback_apply').val('no');
}




});
  });






  $(document).ready(function() {
   $('[data-toggle="popover"]').popover({
    trigger: 'hover',
    container: 'body'

  });
   // $("div").removeAttr("title");
 });



  $(function () {
    $('.example-popover').popover({
      container: 'body'
    })
  })
</script>
<script>
    $("#wallet").click(function(){
     var wallet = $('#get_wallet').val();
    if($("#wallet").is(':checked')){

      $('#apply_promo').hide();
      $('#use_cashback').hide();

      var amount = '<?php echo $user->wallet?>';
      var total = '<?php echo $sub_total?>';///57
      var delivery_charge = '<?php echo $delivery_charge?>';
      var free_delivery_amount = '<?php echo $free_delivery_amount?>';
     
      delivery_charge = parseInt(delivery_charge);
      free_delivery_amount = parseInt(free_delivery_amount);
      amount = parseInt(amount);/////203
      total  = parseInt(total);////500
      if (total > free_delivery_amount) {
         var delivery_charges = 0;
         total = total+delivery_charges;
      }
      else{
         var delivery_charges =  parseInt(delivery_charge);
         total = total+delivery_charges;
      }
      if(amount > total){
        var remaining_wallet = parseInt(amount) -  parseInt(sub_total);
        $('#sub_total_amount').html('0');
        $('#total').val('0');
        $('#remaining_wallet').html(remaining_wallet);
        $('#get_wallet').val(amount);
        $('#wallet_apply').val('yes');
      }
      else{
         var sub_total = parseInt(total) - parseInt(amount);
         var remaining_wallet1 = 0;
       $('#remaining_wallet1').html(remaining_wallet1);
       $('#sub_total_amount').html(sub_total);
       $('#total').val(sub_total);
       $('#wallet_apply').val('yes');
       $('#discount_amount').val('amount');
     }
   }
   else{
    $('#apply_promo').show();
    $('#use_cashback').show();
    var wallet = $('#get_wallet').val();
    var amount = '<?php echo $user->wallet?>';
    var total = '<?php echo $sub_total?>';
    var delivery_charge = '<?php echo $delivery_charge?>';
    var free_delivery_amount = '<?php echo $free_delivery_amount?>';
    amount = parseInt(amount);
    total = parseInt(total);
    delivery_charge = parseInt(delivery_charge);
    free_delivery_amount = parseInt(free_delivery_amount);

   if (total > free_delivery_amount) {
     var delivery_charges = 0;
     delivery_charges = parseInt(delivery_charges);
     var sub_total = parseInt(total) + parseInt(delivery_charges);
   }else
   {
    delivery_charges = parseInt(delivery_charge);
    var sub_total = parseInt(total) + parseInt(delivery_charges);

  }
   //alert(sub_total);
  $('#remaining_wallet').html(amount);
  $('#remaining_wallet1').html(amount);
  $('#sub_total_amount').html(sub_total);
  $('#total').val(sub_total);
  $('#wallet_apply').val('no');
}
});

</script>

<script type="text/javascript">
      $( document ).ready(function() {
       var payment_method = $('#payment_method').val();
      if (payment_method == 'cod') {
         $('#use_cashback').hide();
        $('#use_wallet').hide();
      }
     });
   </script>
