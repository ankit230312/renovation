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

                        <li class="breadcrumb-item"><a href="<?=base_url("products")?>">Products</a></li>

                        <li class="breadcrumb-item active">List</li>

                    </ul>

                </div>

            </div>

        </div>



        <!-- <div class="modal fade" id="products_bulk_modal" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content ">

                    <form action="<?=base_url("products/products_bulk_import")?>" method="post" enctype="multipart/form-data">

                        <div class="modal-header">

                            <h4 class="title" id="defaultModalLabel">Products Bulk Import &nbsp;&nbsp;&nbsp;<a href="<?=base_url("products/sample_product_export")?>" class="btn btn-sm btn-light">Sample</a></h4>

                        </div>

                        <div class="modal-body">

                            <h5 class="text-danger" id="import_error"></h5>

                            <div class="form-group">

                                <label>File (only csv as per sample) <span class="text-danger">*</span> : </label>

                                <input class="form-control" name="file" id="file" type="file">

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary btn-round waves-effect">UPLOAD</button>

                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>

                        </div>

                    </form>

                </div>

            </div>

        </div> -->



        <!-- <div class="modal fade" id="active_inactive_modal" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content ">

                    <form action="<?=base_url("products/active_inactive")?>" method="post">

                        <div class="modal-header">

                            <h4 class="title">Update Status</h4>

                        </div>

                        <input type="hidden" name="redirect_url" value="<?=base_url("products")?>">

                        <div class="modal-body">

                            <input type="hidden" required id="productID_active" name="productID">

                            <div class="form-group">

                                <label>Status <span class="text-danger">*</span> : </label>

                                <div class="row">

                                    <select class="form-control" name="in_stock">

                                        <option value="Y">Active</option>

                                        <option value="N">InActive</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>

                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>

                        </div>

                    </form>

                </div>

            </div>

        </div> -->



        <div class="row clearfix">

            <div class="col-lg-12">

                <div class="card">

                    <!-- <div class="header">

                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("products/add")?>"><i class="zmdi zmdi-plus"></i> Add</a><a class="btn btn-primary btn-sm" href="#products_bulk_modal" data-toggle="modal" data-target="#products_bulk_modal" style="background:#f96332; border: none;"><i class="fas fa-plus" ></i> Import</a></h2>

                    </div> -->

                    <!-- <div>

                        <p>Filter By Category</p>

                        <h2 class="text-left">

                            <?php

                            foreach ($categories as $category){?>

                                <a class="btn btn-primary btn-sm" href="<?=base_url("products/?cat=$category->categoryID")?>"><?=$category->title?></a>

                            <?php }?>

                        </h2>

                    </div> -->

	                    <!-- <form class="form"  method="post" enctype="multipart/form-data"> -->

	                    	<div class="body">

			                    <div class="col-md-12" style="text-align: center;">

			                        <?php $products =$this->home_m->get_single_row_where('products',array('productID'=>$this->uri->segment(3)));?>

			                        <input type="hidden" name="products_id" value="<?=$this->uri->segment(3)?>">

			                        <span><strong>Product Name:- </strong><?=$products->product_name?></span>

			                	</div>

		                        <div class="table-responsive">

		                            <table class="table table-sm dataTable " id="myTable">

			                            <thead>

			                                <tr>
                                               <th>ID</th>
			                                    <th>City Name</th>

			                                    <th>Mrp Price</th>

			                                    <th>Selling Price</th>

			                                    <th>Stock Qty</th>

			                                   <!--  <th>Cost Prize</th> -->
                                                <th>Quantity</th>
                                                <th>Unit</th>

                                                <th>Status</th>
                                                <th>Save</th>

			                                </tr>

			                            </thead>

			                            <tbody>

			                                <?php $cnt =0;?>

			                            	<?php  foreach($city as $key => $c){$cnt = $key;

			                                $product =$this->home_m->get_all_row_where('products_variant',array('city_id'=>$c->id,'product_id'=>$this->uri->segment(3)));
                                               foreach($product as $p) {
			                                ?>

			                                <tr>
                                            <td><?php if(!empty($product)){echo $p->id;}?></td>
			                                    <td><?=$c->title?></td>

			                                    <input type="hidden" name="city_id<?=$key?>" value="<?=$c->id?>">

			                                    <td><input type="text" id="userinput1" class="form-control border-primary retail_price<?=$p->id?>" value="<?php if(!empty($product)){echo $p->retail_price;}?>" name="retail_price<?=$key?>" placeholder="00.00"></td>

			                                    <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->price;}?>" class="form-control border-primary price<?=$p->id?>"name="price<?=$key?>"placeholder="00.00"></td>

			                                    <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->stock_count;}?>" class="form-control border-primary stock_count<?=$p->id?>" name="stock_count<?=$key?>"placeholder="0"></td>
			                                   <!--  <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->cost_price;}?>" class="form-control border-primary"name="cost_price<?=$key?>"placeholder="00.00"></td> -->
                                                <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->unit_value;}?>" class="form-control border-primary unit_value<?=$p->id?>" name="unit_value<?=$key?>"></td>
                                                <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->unit;}?>" class="form-control border-primary unit<?=$p->id?>"name="unit<?=$key?>"></td>
	                                            <td>
                                                        
	                                                <select class="form-control in_stock<?=$p->id?>" name="in_stock<?=$p->id?>" required>

	                                                    <option value="" selected disabled>Select Status</option>

	                                                    <option value="Y" <?php if(!empty($product)){if ($p->in_stock == 'Y'){echo "selected";}}?>>Active</option>

	                                                    <option value="N" <?php if(!empty($product)){if ($p->in_stock == 'N'){echo "selected";}}?>>InActive</option>

	                                                </select>

                                                </td>
                                                <td><button class=" btn btn-primary save_variant" id="<?php if(!empty($product)){echo $p->id;}?>">Save</button></td>

			                                </tr>
                                           

			                            <?php } }?>

			                            </tbody>

			                                <tr>

			                                	<!-- <td colspan="8">

					                                <button type="submit" class="btn btn-default btn-round">

					                                    <i class="zmdi zmdi-check-circle"></i> Save

					                                </button>

			                                		<button type="button" class="btn btn-primary btn-round">

					                                    <i class="zmdi zmdi-replay"></i> Cancel

					                                </button>

					                            </td> -->

			                                </tr>

			                            <tfoot>

			                            	

			                            </tfoot>

		                        	</table>

			                            <!-- <div style="text-align: center">

				                            <button type="button" class="btn btn-primary btn-round">

			                                    <i class="zmdi zmdi-replay"></i> Cancel

			                                </button>

			                                <button type="submit" class="btn btn-default btn-round">

			                                    <i class="zmdi zmdi-check-circle"></i> Save

			                                </button>

			                            </div> -->

		                        	<input type="hidden" name="counter" value="<?=$cnt?>">

		                        </div>

	                        </div>

	                    </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<script>
 $(document).ready(function(){
     $('.save_variant').click(function(){
        var variantID =  $(this).attr('id');
        var retail_price = $('.retail_price'+variantID).val();
        var price = $('.price'+variantID).val();
        var stock_count = $('.stock_count'+variantID).val();
        var unit_value = $('.unit_value'+variantID).val();
        var unit = $('.unit'+variantID).val();
        var in_stock =$( ".in_stock"+variantID+" option:selected" ).val();
        $.ajax({
            url: '<?php echo base_url(); ?>/products/update_singleVarinat',
            type: 'POST',
            data: {variantID:variantID,retail_price:retail_price,price:price,stock_count:stock_count,unit_value:unit_value,unit:unit,in_stock:in_stock},
            success: function (data) {
               if(data='success'){
                location.reload();
               }
               
            }
        });
     });
 });   
</script>