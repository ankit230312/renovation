<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("brand")?>">Category Type</a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("brand/brand_management")?>">Category Type Management</a></li>

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

                        <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?=base_url("brand")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                    </div>

                    <div class="body">

                        <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                        <?php }?>

                        <form method="post" enctype="multipart/form-data">

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Title <span class="text-danger">*</span> :</label>

                                        <input type="text" class="form-control" required name="title" placeholder="Enter Tile for Category" />

                                    </div>

                                </div>

                            </div>

                        

                            <!-- <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Image <span class="text-danger">*</span> :</label>

                                        <input type="file" accept="image/*" class="form-control" required name="image"/>

                                    </div>

                                </div>

                            </div> -->


                      

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

                            <!-- <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Off Upto</label>

                                        <input type="text" class="form-control" name="off_upto" placeholder="Enter Off Upto" />

                                    </div>

                                </div>

                            </div> -->

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
    $(document).ready(function () {
        //user
       $("#parent").select2();
    });
 </script>