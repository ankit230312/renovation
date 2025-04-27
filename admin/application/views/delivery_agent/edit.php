<?php
$CI = &get_instance();
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("home/delivery_agent")?>">Delivery Agent</a></li>
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
                    <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?=base_url("home/delivery_agent/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                    <?php }?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span> :</label>
                                        <select class="form-control" name="city_id" required>
                                            <?php foreach ($city as $c) {?>
                                                <option value="<?=$c->id?>" <?php if($c->id == $delivery_agent->city_id){echo 'selected';}?>><?=$c->title?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control" required name="name" value="<?=$delivery_agent->name?>" placeholder="Name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span> :</label>
                                        <input type="email" class="form-control" required name="email" value="<?=$delivery_agent->email?>"placeholder="email"/>
                                    </div>
                                    
                                    <div class="row clearfix">
                                        
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span> :</label>
                                            <input type="number" class="form-control" value="<?=$delivery_agent->phone?>" required name="phone" placeholder="Phone" />
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Alternate Phone <span class="text-danger">*</span> :</label>
                                                <input type="number" class="form-control" required name="alternate_phone" value="<?=$delivery_agent->alternate_phone?>" placeholder="alternate_phone" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                           <div class="form-group">
                                                <label>Change Password</label>
                                                <input type="password" class="form-control" name="password"  value="" placeholder="Change Password" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Status <span class="text-danger">*</span> :</label>
                                                <select class="form-control" name="is_active" required>
                                                    <option value="Y" <?php if ($delivery_agent->is_active == 'Y'){echo "selected";}?>>Active</option>
                                                    <option value="N" <?php if ($delivery_agent->is_active == 'N'){echo "selected";}?>>InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <button class="btn btn-default btn-round" type="submit"><i class="zmdi zmdi-check-circle"></i> Submit</button>
                                                
                                            </div>
                                        </div>
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