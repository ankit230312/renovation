<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("coupons")?>">Coupons</a></li>
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
                    
                    <div class="body">
                        <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                        <?php }?>
                        <form method="post" action="<?=base_url('home/generate_stock_report')?>">
                            
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="date" placeholder="Enter Start Date" name="start_date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <br>
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