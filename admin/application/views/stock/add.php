<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("stock") ?>">Stock</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Input -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?= base_url("stock") ?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)) { ?>
                        <h2 class="title text-danger"><?= $error ?></h2>
                    <?php } ?>
                    <!-- <form method="post" action="<?php // base_url("stock/store") 
                                                        ?>">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Select Product <span class="text-danger">*</span> :</label>
                                    <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true" name="product" required onchange="change_product()" id="product">
                                        <option value=""> -- SELECT PRODUCT -- </option>
                                        <?php // foreach ($products as $p) { 
                                        ?>
                                            <option value="<?= $p->product_name ?>" unit="<?= $p->unit ?>"><?= $p->product_name . ' (' . $p->unit . ')' ?></option>
                                        <?php // } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div> -->



                    <!-- </form> -->


                    <form method="post" action="<?= base_url("stock/add") ?>">

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Product <span class="text-danger">*</span> :</label>

                                    <input type="text" class="form-control" required name="product" placeholder="Enter Tile for Category" />

                                </div>

                            </div>

                        </div>




                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Qty <span class="text-danger">*</span> :</label>
                                    <div class="row">
                                        <div class="col-sm-12"><input class="form-control" name="unit" type="number"> </div>
                                        <div class="col"><span id="unit_text"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Value <span class="text-danger">*</span> :</label>
                                    <div class="row">
                                        <div class="col-sm-12"><input class="form-control" name="value" type="number"> </div>
                                        <div class="col"><span id="unit_text"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Cost Price <span class="text-danger">*</span> :</label>
                                    <div class="row">
                                        <div class="col-sm-12"><input class="form-control" name="cost_price" type="number"> </div>
                                        <div class="col"><span id="unit_text"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Last Price <span class="text-danger">*</span> :</label>
                                    <div class="row">
                                        <div class="col-sm-12"><input class="form-control" name="last_price" type="number"> </div>
                                        <div class="col"><span id="unit_text"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>




                </div>

                <div class="row clearfix">

                    <div class="col-sm-6">

                        <div class="form-group">

                            <button class="btn btn-default btn-round" type="submit"><i class="zmdi zmdi-check-circle"></i> Submit</button>

                            <button class="btn btn-primary btn-round" type="reset"><i class="zmdi zmdi-replay"></i> Reset</button>

                        </div>

                    </div>

                </div>

                </form>

            </div>
        </div>
    </div>
    </div>
    <!-- #END# Input -->
    </div>
</section>

<script>
   
</script>