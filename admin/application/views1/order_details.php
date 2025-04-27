<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("orders/new_orders")?>">New Orders</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
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
                                    <th>Delivery Charge</th>
                                    <th>Coupon Code</th>
                                    <th>Coupon Discount</th>
                                    <th>Payment Mode</th>
                                    <th>Order status</th>
                                    <th>Order At</th>
                                    
                                   

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
                                        <td><?=$a->delivery_charges?></td>
                                        <td><?=$a->coupon_code?></td>
                                        <td><?=$a->coupon_discount?></td>
                                        <td><?=$a->payment_method?></td>
                                        <td><?=$a->status?></td>
                                        <td><?=$a->added_on?></td>
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
    </div>
</section>
