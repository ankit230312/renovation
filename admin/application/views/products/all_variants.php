<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("products")?>">Products</a></li>
                        <li class="breadcrumb-item active">All Variants</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <!-- <div class="header">
                        <?php if($_SESSION['role']=='admin'){?><h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("products/add_variants")?>"><i class="zmdi zmdi-plus"></i> Add Variant</a></h2><?php } ?>
                    </div> -->
                    <div>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>City</th>
                                    <th>Image</th>
                                    <th>RETAIL PRICE</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>UNIT</th>
                                   
                                    <th>COST PRICE</th>
                                    <th>STOCK</th>
                                    <th>Status</th>
        
                                    <!-- <th>STATUS</th> -->
                                     <?php if($_SESSION['role']=='admin'){?>
                                        <th>ACTION</th>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($all_variants as $p){?>
                                    <tr>
                                        <td><?=$p->id?></td>
                                        <td><?=$p->cityName?></td>
                                        <td><img src="<?php echo base_url('uploads/variants/').$p->variant_image; ?>" height="30px"></td>
                                        <td><?=$p->retail_price?></td>
                                        <td><?=$p->price?></td>
                                        <td><?=$p->unit_value?></td>
                                        <td>
                                            
                                            <div class="form-group">
                                                <select class="form-control" required name="unit" value="<?=$p->unit?>">
                                                <option <?php if (strtoupper($p->unit) == 'PC' ){echo "selected";}?>>PC</option>

                                                <option <?php if (strtoupper($p->unit) == 'KG' ){echo "selected";}?>>KG</option>

                                                <option <?php if (strtoupper($p->unit) == 'GM' ){echo "selected";}?>>GM</option>
                                                <option <?php if (strtoupper($p->unit) == 'Half' ){echo "selected";}?>>Half</option>
                                                <option <?php if (strtoupper($p->unit) == 'Full' ){echo "selected";}?>>Full</option>

                                                <option <?php if (strtoupper($p->unit) == 'ML' ){echo "selected";}?>>ML</option>

                                                <option <?php if (strtoupper($p->unit) == 'Litre' ){echo "selected";}?>>Litre</option>
                                                </select>
                                            </div>        
                                        </td>
                                        <td><?=$p->cost_price?></td>
                                        <td><?=$p->stock_count?><a href="javascript:void(0)" style="text-align: right" onclick="add_stock('<?=$p->id?>','<?=$p->stock_count?>')" title="Add Stock"><i class="zmdi zmdi-plus-circle"></i></a></td>
                                        <!-- <td><?=$p->st_ct?> <a href="javascript:void(0)" onclick="add_stock('<?=$p->pd_id?>')" title="Add Stock"><i class="zmdi zmdi-plus-circle"></i></a></td> -->
                                        <td><a href="javascript:void(0)" onclick="active_inactive_product('<?=$p->id?>')"><span><?php if ($p->in_stock == 'Y'){echo "Active";}else{echo 'InActive';}?></span></a></td>
                                        <?php if($_SESSION['role']=='admin'){?>
                                            <td><a class="btn btn-default btn-sm" href="<?=base_url("products/update_variant/").$p->id?>" title="Edit variant">Edit Variant</a>
                                            </td>
                                        <?php }?>
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
<div class="modal fade" id="add_stock_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <form action="<?=base_url("products/var_stockupdate")?>" method="post">
                        <div class="modal-header">
                            <h4 class="title">Update Status</h4>
                        </div>
                        <input type="hidden" name="redirect_url" value="<?=base_url("products")?>">
                        <div class="modal-body">
                            <input type="text" required id="variantID" name="variantID">
                            <div class="form-group">
                                <label>Stock Count <span class="text-danger">*</span> : </label>
                                <div class="row">
                                    <input type="text" name="stockCount" id="stockCount" class="form-control">
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
        </div>
        <div class="modal fade" id="active_inactive_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <form action="<?=base_url("products/var_active_inactive")?>" method="post">
                        <div class="modal-header">
                            <h4 class="title">Update Status</h4>
                        </div>
                        <input type="hidden" name="redirect_url" value="<?=base_url("products")?>">
                        <div class="modal-body">
                            <input type="hidden" required id="variantID_active" name="variantID">
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
        </div>
<script>
    function add_product_to_stock(productID,product,unit,price,stock_count,parameter) {
        if (productID != '' && product != '' && unit != '' && price != '')
        {
            $('#productID_stock').val(productID);
            $('#product_unit_value_stock').val(stock_count);
            $('#product_name_stock_display').html(parameter+' '+product);
            $('#product_unit_cost_price_stock').val(price);
            $('#product_unit_stock').text('* '+unit);
            $('#product_unit_price_stock').text('/ '+unit);
            $('#parameter_stock').val(parameter);
            $('#stock_add_modal').modal('show');
        }
    }
    
    function active_inactive_product(variantID) {
        $('#variantID_active').val(variantID);
        $('#active_inactive_modal').modal('show');
    }
    function add_stock(variantID,stockCount) {
        $('#variantID').val(variantID);
        $('#stockCount').val(stockCount);
        $('#add_stock_modal').modal('show');
    }


</script>