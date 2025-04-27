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
                        <?php if($_SESSION['role']=='admin'){?><h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("products/add")?>"><i class="zmdi zmdi-plus"></i> Add</a><a class="btn btn-primary btn-sm" href="#products_bulk_modal" data-toggle="modal" data-target="#products_bulk_modal" style="background:#f96332; border: none;"><i class="fas fa-plus" ></i> Import</a></h2><?php } ?>
                    </div>
                    <div>
                        <p>Filter By Category</p>
                        <h2 class="text-left">
                            <?php
                            foreach ($categories as $category){?>
                                <a class="btn btn-primary btn-sm" href="<?=base_url("products/get_product_detail/?cat=$category->categoryID")?>"><?=$category->title?></a>
                            <?php }?>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                                <table class="table display table-striped nowrap table-bordered responsive" style="width: 100%" id="myTable">
                                    <thead>
                                       <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category Name</th>
                                        <th>City Name</th>
                                        <th>Unit</th>
                                        <th>Unit Value</th>
                                        <th>Weight</th>
                                        <th>Retail Price</th>
                                        <th>Selling Price</th>
                                        <th>Cost Price</th>
                                        <th>Stock Count</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($products_detail as $pd){
                                        $product = $this->home_m->get_product_detail($pd->product_id);
                                        $city = $this->home_m->get_city($pd->city_id);

                                        ?>
                                        <tr>
                                            <td><?=$pd->id?></td>
                                            <td><?=$product->product_name?></td>
                                            <td><?=$pd->main_category_name?></td>
                                            <td><?=$city->title?></td>
                                            <td><?=$product->unit?></td>
                                            <td><?=$product->unit_value?></td>
                                            <td><?=$product->weight?></td>
                                            <td><?=$pd->retail_price?></td>
                                            <td><?=$pd->price?></td>
                                            <td><?=$pd->cost_price?></td>
                                            <td><?=$pd->stock_count?></td>
                                            <td><?php if($pd->status=='Y'){echo 'Active';}else{echo 'Inactive';}?></td>
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
                    <form action="<?=base_url("products/stockupdate")?>" method="post">
                        <div class="modal-header">
                            <h4 class="title">Update Status</h4>
                        </div>
                        <input type="hidden" name="redirect_url" value="<?=base_url("products")?>">
                        <div class="modal-body">
                            <input type="hidden" required id="product_stock" name="productID">
                            <div class="form-group">
                                <label>Stock Count <span class="text-danger">*</span> : </label>
                                <div class="row">
                                    <input type="text" name="stock_count" class="form-control">
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
    
    function active_inactive_product(productID) {
        $('#productID_active').val(productID);
        $('#active_inactive_modal').modal('show');
    }
    function add_stock(productID) {
        $('#product_stock').val(productID);
        $('#add_stock_modal').modal('show');
    }


</script>