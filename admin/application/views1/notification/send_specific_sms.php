<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("notification")?>">SMS</a></li>
                        <li class="breadcrumb-item active">Send</li>
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
                        <h2 class="text-left">Send Multiple User SMS</h2>
                    </div>
                    <div class="body">
                        <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                        <?php }?>
                        <form class="form" action="<?=base_url('notification/specific_user_sms')?>" method="post" enctype="multipart/form-data">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Users <span class="text-danger">*</span> :</label>
                                        <select class="form-control" name="userID[]" id="user" required multiple>
                                          <option value="">Select User</option>
                                          <?php 
                                            foreach($user as $values)
                                            { 
                                            ?>
                                            <option value="<?=$values->ID?>"> <?php echo $values->name." (".$values->mobile.")";?> </option>
                                          <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="text"  name="title" placeholder="Enter Title" value="Gowisekart">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Message <span class="text-danger">*</span> :</label>
                                        <textarea class="form-control"  name="message" placeholder="Enter Message"></textarea>
                                    </div>
                                </div>
                            </div>
                          
                            
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <button class="btn btn-default btn-round" type="submit"><i class="zmdi zmdi-check-circle"></i> Send</button>
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
