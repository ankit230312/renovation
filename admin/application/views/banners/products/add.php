<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("banners")?>">Banners</a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("banners/featured_prod_banners")?>">Featured products</a></li>

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

                        <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?=base_url("banners/featured_prod_banners/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                    </div>

                    <div class="body">

                        <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                        <?php }?>

                        <form method="post" enctype="multipart/form-data">

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Banner <span class="text-danger">*</span> :</label>

                                        <input class="form-control" required type="file" name="banner">
                                        <p>Size : (1538*452)</p>

                                    </div>

                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Priority <span class="text-danger">*</span> :</label>

                                        <input class="form-control" required type="number" name="priority" placeholder="Enter priority">

                                    </div>

                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Product <span class="text-danger">*</span> :</label>

                                        <select class="form-control" name="productID" required>

                                            <?php foreach ($products as $p){?>

                                                <option value="<?=$p->productID?>"><?=$p->product_name?></option>

                                            <?php }?>

                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Status <span class="text-danger">*</span> :</label>

                                        <select class="form-control" name="status" required>

                                            <option value="Y">Active</option>

                                            <option value="N">InActive</option>

                                        </select>

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