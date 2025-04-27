<style type="text/css">
  .center{
width: 150px;
  margin: 40px auto;
  
}

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
  margin-top: 10px;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}
.table th, .table td{
  padding: 0;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }
}


.p-name-font{
  font-size: 12px;
  padding: 11px 3px;
}
.p-name-font:hover{
  text-decoration: none;
}
</style>








<?php

$CI = &get_instance();

$settings = $CI->db->query("SELECT * FROM `settings`")->row();

$free_min_order_amount = $settings->min_order_amount;

$delivery_charges = $settings->delivery_charge;//get delivery charges


$free_delivery_amount_m = 499.00;

$free_delivery_amount_n =$settings->free_delivery_amount;



//get userinfo

$userID = $_SESSION['loginUserID'];

$userDetail = $this->db->query("select * from users where ID='$userID'")->row();
$total = 0;
?>
<!-- ================================ Shopping Cart ============================  -->

<section class="Product_banner text-center">
<div class="container">
  <div class="row">
  </div>
</div>
</section>
<div class="pb-5">
<div class="container">
  <div id="cart_details">





  </div>
  
   <div class="row" id="checkout_button">
    <div class="col-md-4 mb-3 mt-3 col-sm-12">
      <a href="<?=base_url('home/')?>">
      <button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i>Continue Shopping</span><span class="float-right"><span class="mdi mdi-chevron-right"></span></span></button></a>
    </div>
    <div class="col-md-4 mb-3 mt-3 col-sm-12" style="float: right;">
      <a href="<?=base_url('home/checkout')?>">
      <button class="btn btn-success btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong>₹ <span id="total"></span> </strong> <span class="mdi mdi-chevron-right"><i class="fa fa-arrow-right"></i> </span></span></button></a>
    </div>

    
  </div>







</div>

</div>
</div>





<script type="text/javascript">
  $( document ).ready(function() {
    var user_id = '<?php echo $this->session->userdata('loginUserID')?>';
    if(user_id !=''){
      get_cart(user_id);
    }else{
      return false;
    }
  });
  function get_cart(user_id){

    $.ajax({

      url:'<?=base_url("home/get_cart")?>',

      data : "user_id="+user_id,

      dataType:"HTML",

      success : function (res) {
        var res1 = JSON.parse(res);
        //alert(res1.total);
        $('#cart_details').html(res1.html);
        $('#total').html(res1.total);
        if(res1.total == 0){
          $('#checkout_button').hide();
        }
        var carts = res1.carts;
        var total = res1.total;
        <?php $carts='carts';
            $total = 'total';
        ?> 

      }

    });
  }
</script>
<script type="text/javascript">
  function delete_item(cartId){

    if(confirm('Are You Want to remove From Cart')){

      var user_id = '<?php echo $this->session->userdata('loginUserID')?>';
      $.ajax({

        url:'<?=base_url("home/delete_cart")?>',

        data : "cartID="+cartId,

        dataType:"HTML",
        method : 'POST',
        success : function (res) {
         var res1 = JSON.parse(res);
         if(res1.status){
          get_cart(user_id);
        }
      }

    });
      
    }else{
      return false;
    }

  }
</script>