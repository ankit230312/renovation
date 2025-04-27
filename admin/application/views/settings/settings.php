<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("settings")?>">Settings</a></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- Input -->

    <div class="row clearfix">

        <div class="col-lg-12">

            <div class="card">

                <div class="body">

                    <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                    <?php }?>

                    <form method="post" enctype="multipart/form-data" action="<?=base_url('settings')?>">

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Site Name <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->site_name?>" required type="text"  name="site_name" placeholder="Enter Site Settings">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Change Logo :</label>

                                    <input class="form-control" type="file" accept="image/png"  name="logo" >

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Change Favicon :</label>

                                    <input class="form-control" type="file" accept="image/png"  name="favicon" >

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Mobile Number<span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->mobile?>" required type="text" name="mobile" placeholder="Enter Mobile No">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Alternet Mobile Number :</label>

                                    <input class="form-control" value="<?=$settings->mobile2?>"  type="text" name="mobile2" placeholder="Enter Alternet Mobile No">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Min Order Amount <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->min_order_amount?>" required type="number" step="0.01"  name="min_order_amount" placeholder="Enter Min Order Amount">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Max Order Amount <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->max_order_amount?>" required type="number" step="0.01"  name="max_order_amount" placeholder="Enter Max Order Amount">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Free Delivery Amount <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->free_delivery_amount?>" required type="number" step="0.01"  name="free_delivery_amount" placeholder="Enter Amount Above which Delivery will be free">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Delivery Charges <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->delivery_charge?>" required type="number" step="0.01"  name="delivery_charge" placeholder="Enter Delivery Charges ">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Cashback Discount<span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->cashback_discount?>" required type="number"   name="cashback_discount" placeholder="Enter Cashback Discount">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Min cart amount for cashback<span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->min_amount_cashback?>" required type="number"   name="min_amount_cashback" placeholder="Enter Cashback Discount">

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


<!--  Refer and earn section -->
<div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2>Refer And Earn</h2>

                </div>

            </div>

        </div>

    </div>
<div class="row clearfix">

        <div class="col-lg-12">

            <div class="card">

                <div class="body">

                    <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                    <?php }?>

                    <form method="post" enctype="multipart/form-data" action="<?=base_url('settings/refer')?>">
                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Refer & Earn <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$settings->refer_earn?>" required type="number" step="0.01"  name="refer_earn" placeholder="Enter refer & earn ">

                                </div>

                            </div>

                        </div>



                         <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Refer Description <span class="text-danger">*</span> :</label>

                                    <textarea name="refer_description" id="description" class="form-control"><?=$settings->refer_description?></textarea>

                                </div>

                            </div>

                        </div>



                         <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Refer Image <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="" type="file" name="refer_image">


                                    <?php 
                                     $imgUrl ='';
                                    if(!empty($settings->refer_image)){
                                        $imgUrl = base_url('/uploads/'.$settings->refer_image);
                                    }
                                    ?>
                                    <a href="<?=$imgUrl?>" target="_blank"><img src="<?=$imgUrl?>" height="50px" width="50px"></a>

                                </div>

                            </div>

                        </div>


                           <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Refer Banner Image <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="" type="file" name="refer_banner">


                                    <?php 
                                     $imgUrl1 ='';

                                    if(!empty($settings->refer_banner)){
                                        $imgUrl1 = base_url('/uploads/'.$settings->refer_banner);
                                    }
                                    
                                    ?>
                                    <a href="<?=$imgUrl1?>" target="_blank"><img src="<?=$imgUrl1?>" height="50px" width="50px"></a>

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

    </div>

</section>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
 <script>
                        CKEDITOR.replace( 'description' );
                </script>