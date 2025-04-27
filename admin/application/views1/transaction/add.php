<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Add Wallet</li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        <!-- Input -->
        <div class="row clearfix">
            <div class="col-lg-6">
                <div class="card">
                    
                    <div class="body">
                        <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                        <?php }?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">User <span class="text-danger">*</span></h2>
                                    <select class="form-control selectpicker z-index show-tick" data-show-subtext="true" data-live-search="true" name="userID" required>
                                        <option value="">-- Please select --</option>
                                        <?php foreach($users as $u){?> 
                                           <option value="<?=$u->userID?>"><?=$u->name.'-'.$u->mobile?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Note <span class="text-danger"></span> :</label>
                                        <input class="form-control" type="text" name="note" placeholder="Why you are crediting amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Price <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="number" step="1" name="amount" placeholder="Enter product price">
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