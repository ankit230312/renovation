<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("locality")?>">Locality</a></li>

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

                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?=base_url("locality")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                </div>

                <div class="body">

                    <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                    <?php }?>

                    <form method="post">

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Locality <span class="text-danger">*</span> :</label>

                                    <!-- <input class="form-control" required type="text" value="<?=$locality->locality?>"  name="locality" placeholder="Enter Locality Name"> -->

                                    <select class="form-control" required type="text" id="locality"  name="locality">

                                        <option value="" selected="" hidden="" disabled="">Select City</option>

                                    <?php foreach($cities as $city){?>

                                        <option value="<?=$city->id?>" <?php if($city->id == $locality->locality){echo 'selected hidden';}?>><?=$city->title?></option>

                                    <?php }?>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Pin Code <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="number" value="<?=$locality->pin?>"  name="pin" placeholder="Enter Pin Code of Locality">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Status <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="status" required>

                                        <option value="Y" <?php if ($locality->status == 'Y'){echo "selected";}?>>Active</option>

                                        <option value="N" <?php if ($locality->status == 'N'){echo "selected";}?>>InActive</option>

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

<script>
    $(document).ready(function () {
       $("#locality").select2();
    });
 </script>