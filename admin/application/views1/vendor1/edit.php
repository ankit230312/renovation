<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("home/vendor")?>">Admin</a></li>
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
                    <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?=base_url("home/vendor/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                    <?php }?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row clearfix">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>City <span class="text-danger">*</span> :</label>
                                    <select class="form-control city_id" name="city_id" required>
                                        <?php foreach ($city as $c) {?>
                                            <option value="<?=$c->id?>" <?php if($c->id == $admin_info->city_id){echo 'selected';}?>><?=$c->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php $locality = explode(',', $admin_info->pincode);
                                $pincode = $this->db->query("SELECT * FROM locality WHERE status = 'Y' AND locality = '$admin_info->city_id'")->result();
                                 ?>
                                <div class="form-group">
                                    <label>Pincode<span class="text-danger">*</span> :</label>
                                    <select class="form-control pincode_div" name="pincode[]" required multiple="multiple">
                                        <?php foreach ($pincode as $key => $p) {?>
                                            <option value="<?=$p->ID?>" <?php if(in_array($p->ID, $locality)){echo 'selected';}?>><?=$p->pin?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" required name="name" value="<?=$admin_info->name?>" placeholder="Name" />
                                </div>
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" required name="username" value="<?=$admin_info->username?>" placeholder="Username" />
                                </div>
                                <div class="form-group">
                                    <label> Change Password :</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" />
                                </div>
                            </div>
                            <div  class="col-sm-4">
                                <div class="form-group">
                                    <img class="img img-thumbnail m-1" src="<?=base_url("uploads/$admin_info->photo")?>" style="max-height: 150px;max-width: 100%">
                                    <label>Choose Photo to Change:</label>
                                    <input type="file" class="form-control" name="photo" placeholder="Photo"  accept="image/*"/>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mobile <span class="text-danger">*</span> :</label>
                                    <input type="number" class="form-control" value="<?=$admin_info->mobile?>" required name="mobile" placeholder="mobile" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email :</label>
                                    <input type="email" class="form-control" value="<?=$admin_info->email?>" name="email" placeholder="Email" />
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="role" required>
                                        <option value="vendor" <?php if ($admin_info->role == 'vendor'){echo 'selected';}?>>Vendor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="status" required>
                                        <option value="Y" <?php if ($admin_info->status == 'Y'){echo 'selected';}?>>Active</option>
                                        <option value="N" <?php if ($admin_info->role == 'N'){echo 'selected';}?>>InActive</option>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Input -->
    </div>
</section>
<script type="text/javascript">

$(document).ready( function () {
    // $('.myselect').select2();
    $(".city_id").change(function() {
        var city_id = $(this).children("option:selected").val();
       $.ajax({
            url: "<?php echo base_url('home/get_pincode');?>",
            type: "post",
            data:{city_id : city_id},
            success: function(response){
                var data = JSON.parse(response);
                var html ='';
                for(var i=0;i<data.length;i++){

                    html += '<option value="'+data[i].ID+'">'+data[i].pin+'</option>';
                }
                $('.pincode_div').html(html);
            }
        });
    });
});
</script>