<!-- Main Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<style type="text/css">

   <style>

   #blink {

      animation: blinker 0.6s linear infinite;

      font-weight: bold;

      font-family: sans-serif;

   }

   #blinkp {

      animation: blinker 0.6s linear infinite;

      font-weight: bold;

      font-family: sans-serif;

   }

   #blinkr {

      animation: blinker 0.6s linear infinite;

      color: #1c87c9;

      font-family: sans-serif;

   }

}

</style>

</style>

<?php if($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'subadmin' ){?>

   <section class="content home">

      <div class="container-fluid">

         <div class="block-header">

            <div class="row clearfix">

               <div class="col-lg-5 col-md-5 col-sm-12">

                  <h2><?=$title?></h2>

                  <ul class="breadcrumb padding-0">

                     <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                     <li class="breadcrumb-item active">Dashboard</li>

                  </ul>

               </div>

               <div class="col-lg-5 col-md-5 col-sm-5">

                  <h2><span class="tx-11 tx-roboto tx-white-6">Today Date: <?=date('d M Y')?></span></h2>

               </div>

            </div>

         </div>

         <div class="row clearfix">

            <div class="col-lg-3 col-md-6">

               <div class="card text-center">

                  <div class="body" >

                     <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>
                     <a href="<?=base_url('orders/new_orders');?>">
                        <span>New Order</span>

                        <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=$place_orders->order_count?></h5>
                     </a>

                     <hr>

                     <span><strong>Today's Order: </strong></span>
                     <a href="<?=base_url('orders/today_orders');?>">
                        <span class="tx-11 tx-roboto tx-white-6"><strong style="color: blue;"><?=$today_orders->order_count?></strong></span><br>
                     </a>
                     <span><strong>Monthly Order: </strong></span>
                     <a href="<?=base_url('orders/monthly_orders');?>">
                        <span class="tx-11 tx-roboto tx-white-6"><strong><?=$monthly_orders->order_count?></strong></span> </a><br>
                        <span><strong>Total Order: </strong></span>
                        <a href="<?=base_url('orders/total_orders');?>">
                           <span class="tx-11 tx-roboto tx-white-6"><strong style="color: blue;"><?=$total_orders->order_count?></strong></span><br>
                        </a>


                     </div>

                  </div>

               </div>

               <div class="col-lg-3 col-md-6">

                  <div class="card text-center">

                     <div class="body" >

                        <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>
                        <a href="<?=base_url('orders/ongoing_orders');?>">
                           <span>Ongoing Orders</span>

                           <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=$ongoing_orders->order_count?></h5>
                        </a>
                        <hr>
                        <span><strong>Today's Date: </strong></span>
                        <span class="tx-11 tx-roboto tx-white-6"><strong style="color: blue;"><?=date('d M Y')?></strong></span><br>
                        <br><br>
                     </div>

                  </div>

               </div>

               <div class="col-lg-3 col-md-6">

                  <div class="card text-center">

                     <div class="body">

                        <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>
                        <a href="<?=base_url('orders/cancelled_orders');?>">
                           <span>Cancel Order:</span>

                           <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=$cancel_orders->order_count?></h5>
                        </a>
                        <hr>
                        <span><strong>Today's Date: </strong></span>
                        <span class="tx-11 tx-roboto tx-white-6"><strong style="color: blue;"><?=date('d M Y')?></strong></span><br>
                        <br><br>

                     </div>

                  </div>

               </div>

               <div class="col-lg-3 col-md-6">

                  <div class="card text-center">

                     <div class="body">

                        <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>
                        <a href="<?=base_url('orders/completed_orders');?>">
                           <span>Complete Order</span>

                           <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=$complete_orders->order_count?></h5>

                        </a>

                        <hr>
                        <span><strong>Today's Date: </strong></span>
                        <span class="tx-11 tx-roboto tx-white-6"><strong style="color: blue;"><?=date('d M Y')?></strong></span><br>
                        <br><br>
                     </div>

                  </div>

               </div>

            </div>

            <div class="row clearfix">
               <div class="col-lg-3 col-md-6">

                  <div class="card text-center">

                     <div class="body" >

                        <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>
                        <a href="<?=base_url('orders/pending_orders');?>">
                           <span>Pending  Order</span>

                           <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" <?php if($pending_orders->order_count>0){echo 'id="blink"'; } ?>><strong style="color: red;"><?=$pending_orders->order_count?></strong></h5>
                        </a>
                        <hr>

                        <span><strong>Monthly Order: </strong></span>
                        <a href="<?=base_url('orders/monthly_orders');?>">
                           <span class="tx-11 tx-roboto tx-white-6"><strong><?=$monthly_orders->order_count?></strong></span> </a><br>



                           <span><strong>Total Order: </strong></span>

                           <span class="tx-11 tx-roboto tx-white-6"><strong><?=$total_orders->order_count?></strong></span><br>

                        </div>

                     </div>

                  </div>
         <!-- <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body" >

                  <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>

                  <span>Today New Order</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" <?php if($today_orders->order_count>0){echo 'id="blink"'; } ?>><?=$today_orders->order_count?></h5>

                  <hr>

                  <span><strong>Cancel Order: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$cancel_orders->order_count?></strong></span><br>

                  <span><strong>Completed Order: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$complete_orders->order_count?></strong></span><br>


                  <span><strong>Total Order: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$total_orders->order_count?></strong></span><br>

               </div>

            </div>

         </div> -->

        <!--  <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body" >

                  <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>

                  <span>Pending Orders</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" <?php if($pending_orders->order_count>5){echo 'id="blinkp"'; } ?>><?=$pending_orders->order_count?></h5>

                  <hr>

                  <span><strong>Cancel Order: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$cancel_orders->order_count?></strong></span><br>

                  <span><strong>Completed Order: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$complete_orders->order_count?></strong></span><br>


                  <span><strong>Total Order: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$total_orders->order_count?></strong></span><br>

               </div>

            </div>

         </div> -->

         <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body">

                  <p class="m-b-20"><i class="zmdi zmdi-assignment zmdi-hc-3x col-blue"></i></p>

                  <span>New Users:</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=$today_users->today_users?></h5>

                  <hr>

                  <span><strong>Monthly Users</strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$monthly_users->user_count?></strong></span><br>

                  <span><strong>Total Users:</strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=$total_users->order_count?></strong></span><br>

                  <p class="tx-11 tx-roboto tx-white-6"></p>

               </div>

            </div>

         </div>

         <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body">

                  <p class="m-b-20"><i class="zmdi zmdi-shopping-basket zmdi-hc-3x"></i></p>

                  <span>Today revenue</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><span>&#8377 </span><?=$today_revenue->today_revenue?></h5>

                  <hr>

                  <span><strong>Monthly revenue:</strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><span>&#8377 </span><?=$monthly_revenue->monthly_revenue?></strong></span><br>

                  <span><strong>Total revenue:</strong></span>

                  <span class="tx-11 tx-roboto tx-white-6" <?php if($total_revenue->total_revenue>5){echo 'id="blinkr"'; } ?>><strong><span>&#8377 </span><?=$total_revenue->total_revenue?></strong></span><br>


               </div>

            </div>

         </div>



         <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body">

                  <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p> 
                  <a href="<?=base_url("products/?cat=0")?>">

                     <span>Out of Stock Products</span>

                     <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=count($product_stock)?></h5>
                  </a>

                  <hr>

                  
               </div>

            </div>

         </div>

      </div>

      <div class="row clearfix">

         <div class="col-lg-5 col-md-5 col-sm-12">

            <h4>New Orders</h4>

            <ul class="breadcrumb padding-0">

               <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

               <li class="breadcrumb-item"><a href="<?=base_url("orders/new_orders")?>">New Orders</a></li>

               <li class="breadcrumb-item active">List</li>

            </ul>

         </div>

      </div>

      <div class="row clearfix">

         <div class="col-lg-12">

            <div class="card">

               <div class="body">

                  <div class="table-responsive">

                     <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable display" id="example" >

                        <thead>

                           <tr>

                              <th>Order Id</th>

                              <th>User</th>

                              <th>Address</th>

                              <th>Total Amount</th>

                              <th>Payment Mode</th>

                              <th>Delivery On</th>

                              <th>Order status</th>

                              <th>Order At</th>

                              <th>Action</th>

                           </tr>

                        </thead>

                        <tbody>

                           <?php foreach ($orders as $a){ $secret = md5($a->orderID);

                              $user = $this->db->get_where('users',array('ID'=>$a->userID))->row();

                              ?>

                              <tr>

                                 <td><?=$a->orderID?></td>

                                 <td><?php if(!empty($user)){echo $user->name."<br>".$user->mobile;}?></td>

                                 <td><?=$a->location?></td>

                                 <td><?=$a->total_amount?></td>

                                 <td><?=$a->payment_method?></td>

                                 <td><?=date('d M Y',strtotime($a->delivery_date))?> <br><?=$a->delivery_slot?></td>

                                 <td><?=$a->status?></td>

                                 <td><?=$a->added_on?></td>

                                 <td>

                                    <ul class="header-dropdown" style="list-style: none">

                                       <li><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#modaldemo<?=$a->orderID?>">Update Status</a></li>

                                       <li><a role="menuitem" tabindex="-1" href="<?=base_url("orders/order_detail/").$a->orderID?>">Details</a></li>

                                    </ul>

                                 </td>

                                 <div id="modaldemo<?=$a->orderID?>" class="modal" style="z-index: 1 !important;">

                                    <div class="modal-dialog modal-dialog-vertical-center" role="document">

                                       <div class="modal-content bd-0 tx-14">

                                          <div class="modal-header pd-y-20 pd-x-25">

                                             <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Manage Order# <?=$a->orderID?></h6>

                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                <span aria-hidden="true">&times;</span>

                                             </button>

                                          </div>

                                          <div class="modal-body pd-25">

                                             <?php if($a->status == 'PLACED' && $_SESSION['role']=='admin'){ ?>

                                                <h4>Vendor :</h4>

                                                <select class="form-control" name="delivery_agent" id="vendor_<?=$a->orderID?>">

                                                   <?php $vendor = $this->db->get_where('admin',array('role'=>'vendor','city_id'=>$a->cityID))->result(); 

                                                   if(!empty($vendor)){

                                                      foreach($vendor as $va){?>

                                                         <option value="<?=$va->id?>"><?=$va->name?></option>

                                                      <?php } } ?>

                                                   </select>

                                                   <input type="hidden" name="status" value="ALLOCATED_VENDOR" id="status<?=$a->orderID?>">

                                                <?php } elseif($a->status == 'ALLOCATED'){ ?>

                                                   <h4>Order Status :</h4>

                                                   <select class="form-control" name="status" id="status<?=$a->orderID?>">

                                                      <option value="CONFIRM">CONFIRM</option>

                                                      <option value="CANCEL">CANCEL</option>

                                                   </select>

                                                <?php } elseif($a->status == 'CONFIRM' && $_SESSION['role']=='vendor'){ ?>

                                                   <h4>Order Status :</h4>

                                                   <select class="form-control" name="status" id="status<?=$a->orderID?>">

                                                    <option value="PACKED">PACKED</option>

                                                 </select>

                                              <?php } elseif($a->status == 'CONFIRM'  ||$a->status == 'PACKED'  && $_SESSION['role']=='admin'){ ?>

                                                <h4>Delivery Agent:</h4>

                                                <select class="form-control" name="delivery_agent" id="delivery_agent<?=$a->orderID?>">

                                                   <?php foreach($delivery_agent as $da){?>

                                                      <option value="<?=$da->delivery_agentID?>"><?=$da->name?></option>

                                                   <?php } ?>

                                                </select>

                                                <input type="hidden" name="status" value="ALLOCATED" id="status<?=$a->orderID?>">

                                             <?php } elseif($a->status == 'OUT_FOR_DELIVERY' || $a->status == 'ALLOCATED'){?>

                                                <h4>Order Status :</h4>

                                                <select class="form-control" name="status" id="status<?=$a->orderID?>">

                                                   <option value="DELIVERED">DELIVERED</option>

                                                   <option value="CANCEL">CANCEL</option>

                                                </select>

                                             <?php } ?>

                                          </div>

                                          <div class="modal-footer">

                                             <button type="button" class="save btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" attr="<?=$a->orderID?>">Save changes</button>

                                             <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>

                                          </div>

                                       </div>

                                    </div>

                                    <!-- modal-dialog -->

                                 </div>

                                 <!-- modal -->

                              </tr>

                           <?php }?>

                        </tbody>

                     </table>

                  </div>

               </div>

            </div>

         </div>

      </div>


      <div class="row clearfix">

         <div class="col-lg-5 col-md-5 col-sm-12">

            <h4>Order Charts</h4>

            <ul class="breadcrumb padding-0">



            </ul>

         </div>

      </div>

      <div class="row clearfix">

         <div class="col-lg-6">

            <div class="card">

               <div class="body">

                  <canvas id="orderChart" style="width:100%;max-width:700px"></canvas>


               </div>

            </div>

         </div>


         <div class="col-lg-6">

            <div class="card">

               <div class="body">

                  <canvas id="userChart" style="width:100%;max-width:700px"></canvas>


               </div>

            </div>

         </div>

      </div>




   </div>

</section>

<script>

   function update_order_status(orderID,status) {

    let options = '';

    $('#order_status_form').attr('action','<?=base_url("orders/status_update")?>/'+orderID);

    $('#order_status_options').html(options);

    $('#modaldemo').modal('show');

 }

</script>

<script type="text/javascript">

   $(document).ready(function(){

    $(".save").click(function(){

     var id = $(this).attr("attr");

     var status = $("#status"+id).val();

     var delivery_agent = '0';

     if(status == 'ALLOCATED')

     {

      var delivery_agent = $("#delivery_agent"+id).val()

   }



   if(status !='')

   {



      $.ajax({

       url: '<?=base_url('orders/update_status')?>',

       type: 'post',

       data: {status: status, delivery_agent:delivery_agent, id:id},

       success: function (response) {

                       //alert(response);

                       $("#modaldemo"+id).modal("toggle");

                       if(response == '0')

                       {

                        alert("Successfully Status Updated");

                        location.reload();



                     } else {

                        alert("Error while updatation");

                        location.reload();

                     }







                  }

               });

   } else {

      alert("Please Select Order Status");

   }

});



    $('#datatable1').dataTable({

     bLengthChange: false,

     order: [[ 0, "desc" ]],

     responsive: true,

     language: {

      searchPlaceholder: 'Search...',

      sSearch: '',

   }

});



 });

</script>

<?php }elseif ($this->session->userdata('role') == 'vendor') {  ?>

   <section class="content home">

      <div class="container-fluid">

         <div class="block-header">

            <div class="row clearfix">

               <div class="col-lg-5 col-md-5 col-sm-12">

                  <h2><?=$title?></h2>

                  <ul class="breadcrumb padding-0">

                     <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                     <li class="breadcrumb-item active">Dashboard</li>

                  </ul>

               </div>

               <div class="col-lg-5 col-md-5 col-sm-5">

                  <h2><span class="tx-11 tx-roboto tx-white-6">Today Date: <?=date('d M Y')?></span></h2>

               </div>

            </div>

         </div>

         <div class="row clearfix">

           <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body" >

                  <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>

                  <span>Pending Orders</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" <?php if($vendor_pending_orders->order_count>5){echo 'id="blinkp"'; } ?>><?=$vendor_pending_orders->order_count?></h5>

                  <hr>

                  <span><strong>Today Date: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=date('d M Y')?></strong></span><br>

               </div>

            </div>

         </div>

         <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body" >

                  <p class="m-b-20"><i class="zmdi zmdi-view-dashboard zmdi-hc-3x col-amber"></i></p>

                  <span>Allocated Orders</span>

                  <strong style="color: red;"><h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"  <?php if($vendor_allocated_orders->order_count>0){echo 'id="blink"'; } ?>><?=$vendor_allocated_orders->order_count?></h5></strong>

                  <hr>

                  <span><strong>Today Date: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=date('d M Y')?></strong></span><br>

               </div>

            </div>

         </div>

         <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body">

                  <p class="m-b-20"><i class="zmdi zmdi-assignment zmdi-hc-3x col-blue"></i></p>

                  <span>Completed orders:</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><?=$vendor_complete_orders->order_count?></h5>

                  <hr>

                  <span><strong>Today Date: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=date('d M Y')?></strong></span><br>

               </div>

            </div>

         </div>

         <div class="col-lg-3 col-md-6">

            <div class="card text-center">

               <div class="body">

                  <p class="m-b-20"><i class="zmdi zmdi-shopping-basket zmdi-hc-3x"></i></p>

                  <span>Cancelled Orders</span>

                  <h5 class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1"><span>&#8377 </span><?=$vendor_cancel_orders->order_count?></h5>

                  <hr>

                  <span><strong>Today Date: </strong></span>

                  <span class="tx-11 tx-roboto tx-white-6"><strong><?=date('d M Y')?></strong></span><br>

               </div>

            </div>

         </div>

      </div>

      <div class="row clearfix">

         <div class="col-lg-5 col-md-5 col-sm-12">

            <h4>Allocated Orders</h4>

            <ul class="breadcrumb padding-0">

               <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

               <li class="breadcrumb-item"><a>Allocated Orders</a></li>

               <li class="breadcrumb-item active">List</li>

            </ul>

         </div>

      </div>

      <div class="row clearfix">

         <div class="col-lg-12">

            <div class="card">

               <div class="body">

                  <div class="table-responsive">

                     <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" >

                        <thead>

                           <tr>

                              <th>Order Id</th>

                              <th>User</th>

                              <th>Address</th>

                              <th>Total Amount</th>

                              <th>Payment Mode</th>

                              <th>Delivery On</th>

                              <th>Order status</th>

                              <th>Order At</th>

                              <th>Action</th>

                           </tr>

                        </thead>

                        <tbody>

                           <?php foreach ($vendor_allocated as $a){ $secret = md5($a->orderID);

                              $user = $this->db->get_where('users',array('ID'=>$a->userID))->row();

                              ?>

                              <tr>

                                 <td><?=$a->orderID?></td>

                                 <td><?php if(!empty($user)){echo $user->name."<br>".$user->mobile;}?></td>

                                 <td><?=$a->location?></td>

                                 <td><?=$a->total_amount?></td>

                                 <td><?=$a->payment_method?></td>

                                 <td><?=date('d M Y',strtotime($a->delivery_date))?> <br><?=$a->delivery_slot?></td>

                                 <td><?=$a->status?></td>

                                 <td><?=$a->added_on?></td>

                                 <td>

                                    <ul class="header-dropdown" style="list-style: none">

                                       <li><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#modaldemo<?=$a->orderID?>">Update Status</a></li>

                                       <li><a role="menuitem" tabindex="-1" href="<?=base_url("orders/order_detail/").$a->orderID?>">Details</a></li>

                                    </ul>

                                 </td>

                                 <div id="modaldemo<?=$a->orderID?>" class="modal" style="z-index: 1 !important;">

                                    <div class="modal-dialog modal-dialog-vertical-center" role="document">

                                       <div class="modal-content bd-0 tx-14">

                                          <div class="modal-header pd-y-20 pd-x-25">

                                             <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Manage Order# <?=$a->orderID?></h6>

                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                <span aria-hidden="true">&times;</span>

                                             </button>

                                          </div>

                                          <div class="modal-body pd-25">

                                             <?php if($a->status == 'PLACED' && $_SESSION['role']=='admin'){ ?>

                                                <h4>Vendor :</h4>

                                                <select class="form-control" name="delivery_agent" id="vendor_<?=$a->orderID?>">

                                                   <?php $vendor = $this->db->get_where('admin',array('role'=>'vendor','city_id'=>$a->cityID))->result(); 

                                                   if(!empty($vendor)){

                                                      foreach($vendor as $va){?>

                                                         <option value="<?=$va->id?>"><?=$va->name?></option>

                                                      <?php } } ?>

                                                   </select>

                                                   <input type="hidden" name="status" value="ALLOCATED_VENDOR" id="status<?=$a->orderID?>">

                                                <?php } elseif($a->status == 'ALLOCATED'){ ?>

                                                   <h4>Order Status :</h4>

                                                   <select class="form-control" name="status" id="status<?=$a->orderID?>">

                                                      <option value="CONFIRM">CONFIRM</option>

                                                      <option value="CANCEL">CANCEL</option>

                                                   </select>

                                                <?php } elseif($a->status == 'CONFIRM' && $_SESSION['role']=='vendor'){ ?>

                                                   <h4>Order Status :</h4>

                                                   <select class="form-control" name="status" id="status<?=$a->orderID?>">

                                                    <option value="PACKED">PACKED</option>

                                                 </select>

                                              <?php } elseif($a->status == 'CONFIRM' ||$a->status == 'PACKED'  && $_SESSION['role']=='admin'){ ?>

                                                <h4>Delivery Agent:</h4>

                                                <select class="form-control" name="delivery_agent" id="delivery_agent<?=$a->orderID?>">

                                                   <?php foreach($delivery_agent as $da){?>

                                                      <option value="<?=$da->delivery_agentID?>"><?=$da->name?></option>

                                                   <?php } ?>

                                                </select>

                                                <input type="hidden" name="status" value="ALLOCATED" id="status<?=$a->orderID?>">

                                             <?php } elseif($a->status == 'OUT_FOR_DELIVERY' || $a->status == 'ALLOCATED'){?>

                                                <h4>Order Status :</h4>

                                                <select class="form-control" name="status" id="status<?=$a->orderID?>">

                                                   <option value="DELIVERED">DELIVERED</option>

                                                   <option value="CANCEL">CANCEL</option>

                                                </select>

                                             <?php } ?>

                                          </div>

                                          <div class="modal-footer">

                                             <button type="button" class="save btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" attr="<?=$a->orderID?>">Save changes</button>

                                             <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>

                                          </div>

                                       </div>

                                    </div>

                                    <!-- modal-dialog -->

                                 </div>

                                 <!-- modal -->

                              </tr>

                           <?php }?>

                        </tbody>

                     </table>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </div>

</section>

<?php } else{?>

   <section class="content home">

      <div class="container-fluid">

         <div class="block-header">

            <div class="row clearfix">

               <div class="col-lg-5 col-md-5 col-sm-12">

                  <h2><?=$title?></h2>

                  <ul class="breadcrumb padding-0">

                     <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                     <li class="breadcrumb-item active">Dashboard</li>

                  </ul>

               </div>

            </div>

         </div>

         <div class="row clearfix">

            <div class="col-lg-12 col-md-12" style="text-align: center">

               <span style="font-weight: bold;font-size: 30px">Comming Soon</span>

            </div>

         </div>

      </div>

   </section>

<?php } ?>

<script type="text/javascript">

   var blink = document.getElementById('blink');

   setInterval(function() {

     blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);

  }, 100);

   var blinkp = document.getElementById('blinkp');

   setInterval(function() {

     blinkp.style.opacity = (blinkp.style.opacity == 0 ? 1 : 0);

  }, 300);

   // var blinkr = document.getElementById('blinkr');

   // setInterval(function() {

   //   blinkr.style.opacity = (blinkr.style.opacity == 0 ? 1 : 0);

   // }, 900);

</script>

<script type="text/javascript">

   $(document).ready(function(){

    $(".save").click(function(){

     var id = $(this).attr("attr");

     var status = $("#status"+id).val();

     var delivery_agent = '0';

     if(status == 'ALLOCATED')

     {

      var delivery_agent = $("#delivery_agent"+id).val();

   }

   if(status == 'ALLOCATED_VENDOR')

   {

      var delivery_agent = $("#vendor_"+id).val();

   } 

   if(status !='')

   {



      $.ajax({

       url: '<?=base_url('orders/update_status')?>',

       type: 'post',

       data: {status: status, delivery_agent:delivery_agent, id:id},

       success: function (response) {

                       //alert(response);

                       $("#modaldemo"+id).modal("toggle");

                       if(response == '0')

                       {

                        alert("Successfully Status Updated");

                        location.reload();



                     } else {

                        alert("Error while updatation");

                        location.reload();

                     }







                  }

               });

   } else {

      alert("Please Select Order Status");

   }

});



      /* $('#datatable1').dataTable({

           bLengthChange: false,

           order: [[ 0, "desc" ]],

           responsive: true,

           language: {

               searchPlaceholder: 'Search...',

               sSearch: '',

           }

       });

   

    });*/
 </script>


 <script>
   var xValues = ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec"];
   var yValues = [<?php 
     $year = date('Y');
     for ($i = 1; $i <= 12; $i++) {
       $this->db->select('*');
       $this->db->from('orders');
       $this->db->where('MONTH(added_on)',$i);
       $this->db->where('YEAR(added_on)',$year);
       $query = $this->db->get();
       $sub_count = $query->num_rows();
      ?>
      "<?php echo $sub_count?>",

      <?php } ?>];

      new Chart("orderChart", {
        type: "line",
        data: {
          labels: xValues,

          datasets: [{
            label: '# No of Orders- <?php echo date('Y');?>',
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
         }]
      },
      options: {
       scales: {
         y: {
           beginAtZero: true
        }
     }
  }
});
</script>



<script>
   var xValues = ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec"];
   var yValues = [<?php 
     $year = date('Y');
     for ($i = 1; $i <= 12; $i++) {
       $this->db->select('*');
       $this->db->from('users');
       $this->db->where('MONTH(added_on)',$i);
       $this->db->where('YEAR(added_on)',$year);
       $query = $this->db->get();
       $sub_count = $query->num_rows();
      ?>
      "<?php echo $sub_count?>",

      <?php } ?>];

      new Chart("userChart", {
        type: "line",
        data: {
          labels: xValues,

          datasets: [{
            label: '# No of Users- <?php echo date('Y');?>',
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
         }]
      },
      options: {
       scales: {
         y: {
           beginAtZero: true
        }
     }
  }
});
</script>
