    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
    .placeorder:hover {

      color: white;

    }

    .address h5 {
      font-size: 15px;

    }
    .address-right{
      float: right;
    }
    @media (max-width:767px){
      .address-right{
        float:left;
      }
    }
  
  </style>

<section>
   <div class="container">
      <div class="row">
         <div class="col-md-12">

           <?php
            $this->load->view('user_left_bar');
            ?>
            <?php 
            echo $this->session->flashdata('message');
            ?>



  <div class="cart pt-40">
    <div class="cart_body">
      <div class="container">
        <div class="row">
          <button style="width: 100%;    margin: 10px;" class="btn btn-success">Order Details</button>

            <?php if($orders->status =='CONFIRM' || $orders->status =='PLACED'){?>
            <button style="width: 100%; color: #fff; margin: 10px;" class="btn btn-danger" onclick="cancel_all_order('<?=$orders->orderID?>')">Cancel Order</button>
          <?php }?>

          <div class="col-md-6 mb-5">

            <div class="address">
              <br>
              <h5><b>Shipping Address:</b></h5>
              <h5>
                <?=$orders->customer_name;?>

              </h5>
              <h5><?=$orders->house_no.' '.$orders->apartment;?>
              </h5>
              <h5><?=$orders->location;?>
              </h5>
              
              <h5>
                Phone: +91 <?=$orders->contact_no?>
              </h5>
            </div>



          </div>
          <div class="col-md-6 mb-5">
            
            <div class="address address-right">
              <br>
              <h5><b> Billing Address:</b></h5>
              <h5>
                <?=$orders->customer_name;?>

              </h5>
              <h5><?=$orders->house_no.' '.$orders->apartment;?>
              </h5>
              <h5><?=$orders->location;?>
              </h5>
             
              <h5>
                Phone: +91 <?=$orders->contact_no?>
              </h5>
            </div>
          </div>

          
           <div class="col-md-12 mb-5">
            
            <div class="address">
              <br>
              <h5><b>Delivery Date:<?=$orders->delivery_date;?></b></h5>
              <h5>
                Delivery Time: <?=$orders->delivery_slot?>
              </h5>
              <h5>
               Status: <?=$orders->status?>
              </h5>
            </div>

     
        </div>
        <br>
          <div class="col-md-12">
            <div class="">

              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col" class="border-0 bg-light">
                        <div class="p-2  text-uppercase">Sl No</div>
                      </th>
                      <th scope="col" class="border-0 bg-light">
                        <div class="p-2  text-uppercase">Product Name</div>
                      </th>
                      <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Price</div>
                      </th>
                      <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Quantity</div>
                      </th>
                      <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Total</div>
                      </th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($items)){
                      $i=1;
                          $qty = 0;
                            $price = 0;
                            $product_name='';
                            $imgUrl='';
                            $total_price=0;
                            $all_total = 0;
                      foreach($items as $item){
                          $products = $this->home_m->get_single_row_where('products',array('productID'=>$item->productID));

                          if($item->productID == $products->productID ){
                            $product_name = $products->product_name;
                            $imgUrl = base_url('/admin/uploads/products/').$products->product_image;
                            $qty = $item->qty;
                            $price = $item->price;
                            $total_price = $qty * $price;
                        }

                        $all_total += $total_price;
                        if(!empty($orders->delivery_charges)){
                          $all_total = $orders->total_amount;
                        //$all_total = $orders->order_amount - $orders->coupon_discount + $orders->delivery_charges;
                      }else{
                        $all_total = $orders->total_amount;
                        //$all_total = $orders->order_amount - $orders->coupon_discount ;
                      }
                      // if(!empty($orders->delivery_charges)){
                      // $orders->order_amount = $orders->order_amount - $orders->delivery_charges;

                      // }else{
                      //   $orders->order_amount = $orders->order_amount;
                      // }






                      ?>
                    <tr>
                      <td class="border-0 align-middle"><strong><?=$i++?></strong></td>

                      <th scope="row" class="border-0">
                        <div class="p-2">
                          <img src="<?=$imgUrl ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                          <div class="ml-3 d-inline-block align-middle">
                            <h5 class="mb-0 text-dark d-inline-block align-middle"> <?=$product_name?></h5>
                          </div>
                        </div>
                      </th>
                      <td class="border-0 align-middle"><strong>₹<?=$price?></strong></td>
                      <td class="border-0 align-middle"><strong><?=$qty?></strong></td>
                      <td class="border-0 align-middle"><strong><?=$total_price?></strong></td>

                    </tr>
                    <?php }}?>
                  </tbody>
                </table>
              </div>

            </div>
            <hr>
            <div class="mb-5">
              <?php /*
              <?php if(!empty($orders->coupon_code)){?>
              <div class="row lower">
                <div class="col text-left"><b>Discount</b> 
                 </div>
                <div class="col text-right"><b style="color: green;">-<?=$orders->coupon_discount?></b></div>
              </div>
            <?php }?>
  

  */
            //print_r($orders);

            ?>
          
            
               <div class="row lower">
                <div class="col text-left"><b> Total
                  </b></div>
                <div class="col text-right"><b><?=$orders->order_amount?></b></div>
              </div>
                <div class="row lower">
                <div class="col text-left"><b> Delivery Charge 
                  </b></div>
                <div class="col text-right"><b><?=$orders->delivery_charges?></b></div>
              </div>
               <div class="row lower">
                <div class="col text-left"><b>Discount <?php if(!empty($orders->coupon_code)){?>
                    (<?=$orders->coupon_code?>)
                  <?php }?>
                  </b></div>
                <div class="col text-right"><b>- <span style="color: green;"><?=$orders->coupon_discount?></span></b></div>
              </div> 

              <?php if ($orders->coupon_discount > 0 && $orders->coupon_discount > $orders->total_amount ) {?>
                <div class="row lower">
                <div class="col text-left"><b>Remaining Cashback 
                  </b></div>
                <div class="col text-right"><b style="color: green;"> <?=$orders->coupon_discount - $orders->total_amount?></b></div>
              </div>
              <?php }else{ ?>
                  <div class="row lower">
                <div class="col text-left"><b>Remaining Cashback 
                  </b></div>
                <div class="col text-right"><b style="color: green;"> 0  </b></div>
              </div>
              <?php }  ?>


              <?php if($orders->type == 'CASHBACK'){?>
                <div class="row lower">
                <div class="col text-left"><b>Cashback 
                  </b></div>
                <div class="col text-right"><b style="color: green;"> <?=$orders->cashback_amount?></b></div>
              </div>

              <?php }?>

             
              <div class="row lower">
                <div class="col text-left" style="color: #d52b10;"><b>Subtotal</b>  
                  </div>
                <div class="col text-right" style="color: #d52b10;"><b><?=$all_total?></b></div>
              </div>
            
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
    </div>
  </div>
</div>
</div>
</div>
</section>





<script type="text/javascript">
function cancel_all_order(order_id){

var order_id = order_id;

  if(confirm('Are You Want to Cancel This Order')){
      $.ajax({

        url:'<?=base_url("home/cancel_order")?>',

        data : "orderID="+order_id,

        dataType:"JSON",
        method : 'POST',
        success : function (res) {
         var res1 = JSON.parse(res);
         if(res1.status){
          
        }
      }

    });
      
    }
}
</script>