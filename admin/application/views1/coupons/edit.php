<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("coupons")?>">Coupons</a></li>

                        <li class="breadcrumb-item active">Edit</li>

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

                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?=base_url("coupons/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                </div>

                <div class="body">

                    <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                    <?php }?>

                    <form method="post">

                        <!-- <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Coupon Code </span> :  <?=$offers->offer_code?></label>

                                </div>

                            </div>

                        </div> -->
                        <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Coupon Code <span class="text-danger">*</span> :</label>

                                        <input style="text-transform: uppercase" class="form-control" required type="text" placeholder="Enter Coupon Code" name="offer_code" value="<?=$offers->offer_code?>">

                                    </div>

                                </div>

                            </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Offer Type <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="offer_type" required>

                                        <option value="PERCENTAGE" <?php if ($offers->offer_type == 'PERCENTAGE'){echo "selected";}?>>PERCENTAGE</option>

                                        <option value="FIXED" <?php if ($offers->offer_type == 'FIXED'){echo "selected";}?>>FIXED</option>

                                        <option value="CASHBACK" <?php if ($offers->offer_type == 'CASHBACK'){echo "selected";}?>>CASHBACK FIXED</option>
                                        <option value="CASHBACK_PERCENTAGE" <?php if ($offers->offer_type == 'CASHBACK_PERCENTAGE'){echo "selected";}?>>CASHBACK PERCENTAGE</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Offer Value <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$offers->offer_value?>" required type="number" placeholder="Enter Offer Value" name="offer_value">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Offer Description <span class="text-danger">*</span> :</label>

                                    <textarea class="form-control" required name="description" placeholder="Enter Description about this offer"><?=$offers->description?></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Offer Terms <span class="text-danger">*</span> :</label>

                                    <textarea class="form-control" required name="terms" placeholder="Enter Offer Terms"><?=$offers->terms?></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Min cart Value <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="number" placeholder="Enter Min Cart Value" value="<?=$offers->min_cart_value?>" name="min_cart_value">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Max Discount <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="number" placeholder="Enter Max Discount" value="<?=$offers->max_discount?>" name="max_discount">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Allowed Per User (Times) <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="number" placeholder="Enter No of time allowed per user" value="<?=$offers->allowed_user_times?>" name="allowed_user_times">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Start Date <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="date" placeholder="Enter Start Date" name="start_date" value="<?=$offers->start_date?>">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>End Date <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="date" placeholder="Enter End Date" name="end_date" value="<?=$offers->end_date?>">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Status <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="is_active" required>

                                        <option value="Y" <?php if ($offers->is_active == 'Y'){echo "selected";}?>>Active</option>

                                        <option value="N" <?php if ($offers->is_active == 'N'){echo "selected";}?>>InActive</option>

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