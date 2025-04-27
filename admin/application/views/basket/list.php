<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("basket")?>">Basket</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="products_bulk_modal" tabindex="-1" role="dialog">
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
        </div>

        <!--Single Stock Update-->
        <div class="modal fade" id="stock_add_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <form action="<?=base_url("products/update_stock")?>" method="post">
                        <div class="modal-header">
                            <h4 class="title"><span id="product_name_stock_display"></span></h4>
                        </div>
                        <input type="hidden" name="redirect_url" value="<?=base_url("products")?>">
                        <div class="modal-body">
                            <input type="hidden" required id="productID_stock" name="productID">
                            <input type="hidden" required id="parameter_stock" name="parameter">
                            <div class="form-group">
                                <label>Qty <span class="text-danger">*</span> : </label>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="number" step="any" name="value" id="product_unit_value_stock" >
                                    </div>
                                    <div class="col-sm-3">
                                        <p id="product_unit_stock"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Cost Price <span class="text-danger">*</span> : </label>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="number" step="any" name="unit_price" id="product_unit_cost_price_stock" >
                                    </div>
                                    <div class="col-sm-3">
                                        <p id="product_unit_price_stock"></p>
                                    </div>
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
        </div>


        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("products/add")?>"><i class="zmdi zmdi-plus"></i> Add</a><a class="btn btn-primary btn-sm" href="#products_bulk_modal" data-toggle="modal" data-target="#products_bulk_modal" style="background:#f96332; border: none;"><i class="fas fa-plus" ></i> Import</a></h2>
                    </div>
                    <div>
                        <p>Filter By Category</p>
                        <h2 class="text-left">
                            <?php
                            foreach ($categories as $category){?>
                                <a class="btn btn-primary btn-sm" href="<?=base_url("basket/?cat=$category->categoryID")?>"><?=$category->title?></a>
                            <?php }?>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>SUB CATEGORY</th>
                                    <th>MRP</th>
                                    <th>SP</th>
                                    <th>CP</th>
                                    <th>ORDERED</th>
                                    <th>STOCK</th>
                                    <th>STOCK LEFT</th>
                                    <th>VENDOR</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach ($products as $p){?>
                                    <tr>
                                        <td>
                                            <a href="<?=base_url("products/edit/$p->productID/")?>"><span><?=$p->product_name?></span></a><br>
                                            <span>ID : <?=$p->productID?></span><br>
                                            <span>Weight : <?=$p->weight?></span><br>
                                            <span>QTY : <?=$p->unit_value.' '.$p->unit?></span><br>
                                            <span>Category : <?=$p->main_category_name?></span><br>
                                            Status : <a href="javascript:void(0)" onclick="active_inactive_product('<?=$p->productID?>')"><span><?php if ($p->in_stock == 'Y'){echo "Active";}else{echo 'InActive';}?></span></a>
                                        </td>
                                        <td><?=$p->category_name?></td>
                                        <td><?=$p->retail_price?></td>
                                        <td><?=$p->price?></td>
                                        <td><?=$p->cost_price?></td>
                                        <td><?=$p->ordered_count?></td>
                                        <td><?=$p->stock_count + $p->ordered_count?></td>
                                        <td><button class="btn btn-danger" style="padding: 2px 3px;font-size: 10px" <?php if ($p->stock_count < 1 ){echo 'disabled';}?> onclick="add_product_to_stock('<?=$p->productID?>','<?=$p->product_name?>','<?=$p->unit_value.' '.$p->unit?>','<?=$p->cost_price?>','<?=$p->stock_count?>','Remove')"><i class="zmdi zmdi-minus"></i></button>&nbsp;<span><?=$p->stock_count?></span>&nbsp;<button class="btn btn-danger" style="padding: 2px 3px;font-size: 10px" onclick="add_product_to_stock('<?=$p->productID?>','<?=$p->product_name?>','<?=$p->unit_value.' '.$p->unit?>','<?=$p->cost_price?>','<?=$p->stock_count?>','Add')"><i class="zmdi zmdi-plus"></i></button></td>
                                        <td><?=$p->brand?></td>
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
    
    function active_inactive_product(productID) {
        $('#productID_active').val(productID);
        $('#active_inactive_modal').modal('show');
    }


</script>