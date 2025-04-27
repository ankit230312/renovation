<?php
$CI = &get_instance();
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("users")?>">Abandon Cart</a></li>
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
                             <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>PRODUCT</th>
                                    <th>Sale Price</th>
                                    <th>Retail Price</th>
                                    <th>Cost Price</th>
                                    <th>Stock</th>
                                    <th>WEIGHT</th>
                                    <th>Unit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($get_products as $key => $p){ $c = $key+1;

                                    $get_product_variant = $CI->home_m->get_single_row_where('products_variant',array('id'=>$p->variantID,'product_id'=>$p->productID),'*');   

                                     $products = $CI->home_m->get_single_row_where('products',array('productID'=>$get_product_variant->product_id),'*'); 
                                  
                                    ?>
                                    <tr>
                                        <td><?php echo $c;?></td>
                                         <td><img src="<?php echo base_url('uploads/variants/').$get_product_variant->variant_image; ?>" height="30px"></td>
                                        <td><?=wordwrap($products->product_name,35,"<br>\n") ?></td>
                                       
                                        <td>Rs. <?=$get_product_variant->price?></td>
                                        <td>Rs. <?=$get_product_variant->retail_price?></td>
                                        <td>Rs. <?=$get_product_variant->cost_price?></td>
                                         <td><?=$get_product_variant->stock_count?></td>
                                        <td><?=$get_product_variant->weight?></td>
                                        <td><?=$get_product_variant->unit_value .'/'. $get_product_variant->unit?></td>
                                       
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
