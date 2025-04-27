<section class="mt-5">
<div class="container">
<div class="row">
<div class="col-md-12">

     <?php
               $this->load->view('user_left_bar');
               ?>
               <?php 
               echo $this->session->flashdata('message');
               ?>
    <div id="order" class="tabcontent">


        <div class="col-lg-12 p-3 bg-white rounded shadow-sm mb-5">
            <div class="table-responsive">

              <?php if(!empty($orders)){?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="border-0 bg-light">
                                <div class="p-2  text-uppercase">OrderId</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">Products</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">Price</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">Quantity</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">Status</div>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                      <?php

                       foreach($orders as $order){
                        $product_name = '';
                        $product_img = '';
                        $qty = 0;

                        $this->db->where('orderID',$order->orderID);
                        $items = $this->db->get('order_items')->result();
                        if(!empty($items)){
                            foreach($items as $item){
                              $qty+=$item->qty;
                              $productID = $item->productID;
                               $this->db->where('productID',$productID);
                                $products = $this->db->get('products')->result();
                                $product_name = $products[0]->product_name;
                                if(!empty($products[0]->product_image)){
                                  $product_img = base_url('/admin/uploads/products/').$products[0]->product_image;
                                }
                            }
                        }
                        ?>
                        <tr>
                          <td class="border-0 align-middle"><a href="<?=base_url('home/order_details/'.$order->orderID)?>"><strong><?=$order->orderID?></strong></a></td>


                            <th scope="row" class="border-0">
                              
                                <div class="p-2">
                                    <a href="<?=base_url('home/order_details/'.$order->orderID)?>" class="text-dark d-inline-block align-middle"><img src="<?=$product_img?>" alt="" width="70"
                                        class="img-fluid rounded shadow-sm"></a>
                                    <div class="ml-3 d-inline-block align-middle">
                                        <h6 class="mb-0"> <a href="<?=base_url('home/order_details/'.$order->orderID)?>"
                                                class="text-dark d-inline-block align-middle"><?=$product_name?></a></h6><?php if(count($items)>1){?>
                                                  <small><?=(count($items)-1).'More'?></small>
                                                <?php }?>
                                        
                                    </div>
                                </div>
                            </th>
                             

                            <td class="border-0 align-middle"><strong>₹<?=$order->total_amount?></strong></td>

                            <td class="border-0 align-middle"><strong><?=$qty?></strong></td>

                            <td class="border-0 align-middle"><strong><?=$order->status?></strong></td>
                        </tr>
                        
                        <?php }?>
                       
                    </tbody>
                </table>
              <?php }else{?>
                <p>No Orders Found</p>
              <?php }?>

            </div>

        </div>

     
    </div>


</div>
</div>
</section>

