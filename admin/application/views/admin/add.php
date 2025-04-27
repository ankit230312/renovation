<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("home/admin")?>">Admin</a></li>

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

                        <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?=base_url("home/admin/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                    </div>

                    <div class="body">

                        <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                        <?php }?>

                        <form method="post" enctype="multipart/form-data">

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <!-- <div class="form-group">

                                        <label>City <span class="text-danger">*</span> :</label>

                                        <select class="form-control city_id" name="city_id" required>

                                            <option value="" disabled selected hidden>Select City</option>

                                            <?php foreach ($city as $c) {?>

                                                <option value="<?=$c->id?>"><?=$c->title?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label>Pincode<span class="text-danger">*</span> :</label>

                                        <select class="form-control pincode_div" name="pincode[]" required multiple="">

                                            

                                        </select>

                                    </div> -->

                                    <div class="form-group">

                                        <label>Name <span class="text-danger">*</span> :</label>

                                        <input type="text" class="form-control" required name="name" placeholder="Name" />

                                    </div>

                                    <div class="form-group">

                                        <label>Username <span class="text-danger">*</span> :</label>

                                        <input type="text" class="form-control" required name="username" placeholder="Username" />

                                    </div>

                                    <div class="form-group">

                                        <label>Password <span class="text-danger">*</span> :</label>

                                        <input type="password" class="form-control" required name="password" placeholder="Password" />

                                    </div>

                                    <div class="row clearfix">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>Mobile <span class="text-danger">*</span> :</label>

                                                <input type="number" class="form-control" required name="mobile" placeholder="mobile" />

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>Email :</label>

                                                <input type="email" class="form-control" name="email" placeholder="Email" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row clearfix">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>Role <span class="text-danger">*</span> :</label>

                                                <select class="form-control" name="role" id="get_cat" required>

                                                <option selected disabled>Select Option</option>

                                                <option value="admin">Admin</option>
                                                <option value="subadmin">Sub Admin</option>
                                                <option value="order_manager">Order Manager</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>Image :</label>

                                                <input type="file" class="form-control" name="photo" accept="image/*" placeholder="Chose Image" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row clearfix">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>latitude<span class="text-danger">*</span> :</label>

                                               <input type="text" class="form-control" name="lat" placeholder="Enter vendor Latitude" />

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>Longitude<span class="text-danger">*</span> :</label>

                                                <input type="text" class="form-control" name="lng" placeholder="Enter vendor Longitude" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row clearfix">

                                        <div class="col-sm-12">

                                            <div class="form-group">

                                                <label>Address<span class="text-danger">*</span> :</label>

                                               <textarea class="form-control" name="address" placeholder="Enter Vendor Address" /></textarea>

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

    $(".city_id").change(function() {

        var city_id = $(this).children("option:selected").val();

        $.ajax({

            url: "<?php echo base_url('home/get_pincode');?>",

            type: "post",

            data:{city_id : city_id},

            success: function(response){

                var data = JSON.parse(response);

                var html ='';

                html +='<option value="" disabled selected hidden>Select Pincode</option>';

                for(var i=0;i<data.length;i++){



                    html += '<option value="'+data[i].ID+'">'+data[i].pin+'</option>';

                }

                $('.pincode_div').html(html);

            }

        });

    });

});



/*document.getElementById("get_cat").onchange = function (e) {

       if (this.value == 'vendor') {

         document.getElementById("showcat").style.display="block";

     } else {

         document.getElementById("showcat").style.display="none";

     }

 };*/



</script>