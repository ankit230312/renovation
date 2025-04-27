<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ul>
                </div>
            </div>
        </div>
         <h4 class="title" id="defaultModalLabel">Generate Order Detail &nbsp;&nbsp;&nbsp;<a href="<?=base_url("orders/sample_product_export/").$order->orderID?>" class="btn btn-sm btn-light">Excel</a></h4>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">

                            <div class="col-sm-6">

                                <p><strong>OrderID : </strong> #<?=$order->orderID?></p>
                                <p><strong>User Name : </strong> <?=$user->name?></p>
                                <p><strong>User Mobile : </strong> <?=$user->mobile?></p>
                                <p><strong>Agent Details :- </strong> </p>
                                <p><strong>Name : </strong> <?=$order->agent_name?></p>
                                <p><strong>Email : </strong> <?=$order->agent_email?></p>
                                <p><strong>Phone : </strong> <?=$order->agent_phone?></p>
                                <p><strong>Alternate Phone : </strong> <?=$order->agent_alternate_number?></p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>Delivery Details :- </strong></p>
                                <p><strong>Contact Person : </strong> <?=$order->customer_name?></p>
                                <p><strong>Contact Person Mobile : </strong> <?=$order->contact_no?></p>
                                <p><strong>House No : </strong> <?=$order->house_no?></p>
                                <p><strong>Apartment : </strong> <?=$order->apartment?></p>
                                <p><strong>Landmark : </strong> <?=$order->landmark?></p>
                                <p><strong>Location : </strong> <?=$order->location?></p>
                                <p><strong>Address Type : </strong> <?=$order->address_type?></p>
                                <p><strong>Delivery Date : </strong> <?=$order->delivery_date?></p>
                                <p><strong>Delivery Slot : </strong> <?=$order->delivery_slot?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                         <th>#</th>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                         <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Net Price</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i= 1; foreach ($order_items as $item){  ?>
                                        <tr>
                                            <td><?=$i++?></td>
                                            <td><img src="<?=base_url("uploads/variants/").$item->product_image?>" style="height: 100px"></td>
                                            <td><?php echo wordwrap($item->product_name,15,"<br>\n");?></td>
                                            <td><?=$item->category_name?></td>
                                            <td><?=$item->qty?></td>
                                            <td><?=$item->unit_value.' / '.$item->unit?></td>
                                            <td><?=$item->brand_name?></td>
                                            <td><?=$item->price?></td>
                                            <td><?=$item->net_price?></td>
                                            <td>

                                               <?=$item->status?>
                                                </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                
                            </div>
                            <div class="col-sm-4">
                                  <?php 
                                  $amt =   $order->total_amount;
                                  $cash_amt = $order->cashback_amount;
                                  $dis_amt = $order->coupon_discount;
                                  
                                  ?>

                               
                                <p><strong>Payment Method : </strong> <?=$order->payment_method?></p>
                            	
                                 <p><strong>Order From : </strong> <?=$order->order_from?></p>
                                <p><strong>Total Amount : </strong>₹ <?=$order->order_amount?></p>
                                <p><strong>Delivery Charges : </strong>₹ <?=$order->delivery_charges?></p>
                                <?php if($order->type=='CASHBACK'){ ?>
                                     <p><strong>CASHBACK  : </strong>₹ <?=$order->cashback_amount?></p>
                               <?php }else{?>
                                       <p><strong>Discount  : </strong>₹ <?=$order->coupon_discount?></p>
                              <?php } ?>
                               <?php if($order->type=='CASHBACK'){ ?>
                                    <h6><strong>Payable Amount : </strong>₹ <?=$order->total_amount?></h6>
                               <?php }else{?>
                                       <h6><strong>Payable Amount : </strong>₹  <?=$order->total_amount?></h6>
                              <?php } ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>