<?php $cities = $this->db->get_where('city', array('status' => 'Y'))->result(); ?>

<style>
    .low-stock {
        background-color: #ffcccc;
        /* Red background for low stock products */
    }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <!-- <h2><?= $title ?></h2> -->
                    <h2>Items</h2>

                    <ul class="breadcrumb padding-0">
                        <!-- <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li> -->
                        <li class="breadcrumb-item"><a href="<?= base_url("Items") ?>">Product List</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- <div class="modal fade" id="products_bulk_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <form action="<?= base_url("products/products_bulk_import") ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">Products Bulk Import &nbsp;&nbsp;&nbsp;<a href="<?= base_url("products/sample_product_export") ?>" class="btn btn-sm btn-light">Sample</a></h4>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-danger" id="import_error"></h5>
                            <div class="form-group">
                                <label>Locality <span class="text-danger">*</span> :</label>
                                <select class="form-control" required type="text"  name="cityID">
                                    <option value="" selected="" hidden="" disabled="">Select City</option>
                                <?php foreach ($cities as $city) { ?>
                                    <option value="<?= $city->id ?>"><?= $city->title ?></option>
                                <?php } ?>
                                </select>
                            </div>
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
        <div class="modal fade" id="products_bulk_modal_city" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <form action="<?= base_url("products/products_bulk_import_city") ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">Products Bulk Import &nbsp;&nbsp;&nbsp;<a href="<?= base_url("products/sample_product_export") ?>" class="btn btn-sm btn-light">Sample</a></h4>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-danger" id="import_error"></h5>
                            <div class="form-group">
                                <label>City<span class="text-danger">*</span> :</label>
                                <select class="form-control" type="text" name="cityID">
                                    <option value="" selected="" hidden="" disabled="">Select City</option>
                                    <?php foreach ($cities as $city) { ?>
                                        <option value="<?= $city->id ?>"><?= $city->title ?></option>
                                    <?php } ?>
                                </select>

                                <label>Category<span class="text-danger">*</span> :</label>
                                <select class="form-control" type="text" name="categoryID">
                                    <option value="" selected="" hidden="" disabled="">Select Category</option>
                                    <?php
                                    $Category = $this->db->query("select * from category where parent!='0'")->result();
                                    foreach ($Category as $cat) { ?>
                                        <option value="<?= $cat->categoryID ?>"><?= $cat->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label>File (only csv as per sample) <span class="text-danger">*</span> : </label>
                                <input class="form-control" name="file" id="file" type="file">
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-round waves-effect">submit</button>
                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="products_bulk_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <form action="<?= base_url("products/products_bulk_import") ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">Products Bulk Import &nbsp;&nbsp;&nbsp;<a href="<?= base_url("products/sample_product_export") ?>" class="btn btn-sm btn-light">Sample</a></h4>
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
                    <form action="<?= base_url("products/active_inactive") ?>" method="post">
                        <div class="modal-header">
                            <h4 class="title">Update Status</h4>
                        </div>
                        <input type="hidden" name="redirect_url" value="<?= base_url("products") ?>">
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
                        <?php if ($_SESSION['role'] == 'admin') { ?><h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?= base_url("Items/add") ?>"><i class="zmdi zmdi-plus"></i> Add</a>
                                <!-- <a class="btn btn-primary btn-sm" href="#products_bulk_modal" data-toggle="modal" data-target="#products_bulk_modal" style="background:#f96332; border: none;"><i class="fas fa-plus"></i> Import</a> -->
                            </h2>
                            <!-- <a class="btn btn-primary btn-sm" href="#products_bulk_modal_city" data-toggle="modal" data-target="#products_bulk_modal_city" style="background:#f96332; border: none;"><i class="fas fa-plus"></i>city/category sample</a></h2> -->
                        <?php } ?>
                    </div>
                    <!-- <div>
                        <p>Filter By Category</p>
                        <h2 class="text-left"> -->
                    <?php
                    // foreach ($categories as $category) {
                    //     $catID = $category->categoryID;
                    //     $subCategoryQuery = $this->db->query("SELECT `categoryID` FROM `category` WHERE `parent` = $catID AND `status`='Y'");

                    //     if ($subCategoryQuery) {
                    //         // The query was successful, fetch subcategories
                    //         $subCategories = $subCategoryQuery->result();

                    //         if (!empty($subCategories)) {
                    //             // Display the link to the category with subcategories
                    //             echo '<a class="btn btn-primary btn-sm" href="' . base_url("products/?cat=$catID") . '">' . $category->title . '</a>';
                    //         } else {
                    //             // Handle the case when there are no subcategories (JavaScript alert)
                    //             echo '<a class="btn btn-primary btn-sm" href="#" onclick="alert(\'Product not found in ' . $category->title . '\')">' . $category->title . '</a>';
                    //         }
                    //     } else {
                    //         // Handle database query error here
                    //         echo '<span>Error fetching subcategories for ' . $category->title . '</span>';
                    //     }
                    // }

                    ?>

                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th> <?php if ($_SESSION['role'] == 'admin') {
                                                echo 'ID';
                                            } else {
                                                echo 'Sr.No';
                                            } ?></th>
                                    <th>PRODUCT</th>
                                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>
                                        <th>CATEGORY</th>
                                        <th>Assign Item</th>
                                        <th>Price</th>
                                        <th>Image</th>

                                    <?php } ?>
                                    <?php if ($_SESSION['role'] == 'vendor') { ?>
                                        <th>Sale Price</th>
                                        <th>Retail Price</th>
                                        <th>Cost Price</th>
                                        <th>Stock</th>
                                    <?php } ?>
                                    <!-- <th>Stck Count</th> -->
                                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>

                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($message)) {

                                    // echo "<pre>"; print_r($products);die;
                                    foreach ($products as $key => $p) {
                                        $c = $key + 1;
                                        $low_stocl = 'low-stock';
                                        //$stockClass = //($p->stock_count < "50") ? 'low-stock' : ''; 
                                ?>
                                        <tr class="<?php echo $low_stocl ?>">
                                            <td><?php if ($_SESSION['role'] == 'admin') {
                                                    echo $p->productID;
                                                } else {
                                                    echo $c;
                                                } ?></td>
                                            <td><?php if ($_SESSION['role'] == 'admin') { ?>
                                                    <!-- <a href="<?= base_url("products/edit/$p->productID/") ?>"> -->
                                                    <span><?= wordwrap($p->product_name, 35, "<br>\n") ?></span>
                                                    <!-- </a>  -->
                                                    &nbsp;<span style="float: right">
                                                        <!-- <a href="<?= base_url("products/add_detail/") . $p->productID ?>" title="Add Product Detail"><i class="zmdi zmdi-plus-circle" style="font-size: 30px;"></i></a> -->
                                                    </span><?php } else {
                                                            echo wordwrap($p->product_name, 35, "<br>\n");
                                                        } ?>
                                            </td>
                                            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>
                                                <td><?= wordwrap($p->main_category_name, 25, "<br>\n") ?></td>
                                                <td><?= wordwrap($p->isDependent, 25, "<br>\n") ?></td>
                                                <td><?= wordwrap($p->price, 25, "<br>\n") ?></td>
                                                <td>  <img style="height: 50px;width: 50px;" src="<?= base_url("uploads/items/$p->product_image") ?>"></td>
                                                <td><?= ($p->status == 'active') ? "Active"  : "In Active" ?></td>

                                            <?php } ?>
                                            <?php if ($_SESSION['role'] == 'vendor') { ?>
                                                <td><?= $p->price ?></td>
                                                <td><?= $p->retail_price ?></td>
                                                <td><?= $p->cost_price ?></td>
                                                <td><a href="javascript:void(0)" onclick="add_stock('<?= $p->pd_id ?>','<?= $p->st_ct ?>')"><?= $p->st_ct ?></a></td>
                                            <?php } elseif ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>
                                                <!-- <td><?php // $p->unit 
                                                            ?></td> -->

                                                <td>
                                                    <?php if ($_SESSION['role'] == 'admin') { ?>
                                                        <a href="<?= base_url("products/delete_products/$p->productID") ?>" onclick="return confirm('Are you sure you want to delete this item?');" title="DELETE" class="btn btn-primary btn-sm"><i class="zmdi zmdi-delete"></i></a>&nbsp;
                                                    <?php } ?>
                                                    <a class="btn btn-default btn-sm" href="<?= base_url("products/edit/") . $p->productID ?>" title="Edit Product variants" style="background-color: #404040">Edit</a>&nbsp;
                                                    <!-- <a class="btn btn-default btn-sm" href="<?= base_url("products/add_variant_detail/") . $p->productID ?>" title="Add Product Detail">Add Detail</a>&nbsp;  -->


                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="7"><?php echo $message ?></td>
                                    </tr>
                                <?php    } ?>
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
            <form action="<?= base_url("products/stockupdate") ?>" method="post">
                <div class="modal-header">
                    <h4 class="title">Update Status</h4>
                </div>
                <input type="hidden" name="redirect_url" value="<?= base_url("products") ?>">
                <div class="modal-body">
                    <input type="hidden" required id="product_stock" name="productID">
                    <div class="form-group">
                        <label>Stock Count <span class="text-danger">*</span> : </label>
                        <div class="row">
                            <input type="text" name="stock_count" class="form-control" id="stock_count">
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
    function add_product_to_stock(productID, product, unit, price, stock_count, parameter) {
        if (productID != '' && product != '' && unit != '' && price != '') {
            $('#productID_stock').val(productID);
            $('#product_unit_value_stock').val(stock_count);
            $('#product_name_stock_display').html(parameter + ' ' + product);
            $('#product_unit_cost_price_stock').val(price);
            $('#product_unit_stock').text('* ' + unit);
            $('#product_unit_price_stock').text('/ ' + unit);
            $('#parameter_stock').val(parameter);
            $('#stock_add_modal').modal('show');
        }
    }

    function active_inactive_product(productID) {
        $('#productID_active').val(productID);
        $('#active_inactive_modal').modal('show');
    }

    function add_stock(productID, stct) {
        $('#product_stock').val(productID);
        $('#stock_count').val(stct);
        $('#add_stock_modal').modal('show');
    }
</script>