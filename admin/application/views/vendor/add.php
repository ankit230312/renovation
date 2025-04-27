<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("home/vendor")?>">Admin</a></li>

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

                        <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?=base_url("home/vendor/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                    </div>

                    <div class="body">

                        <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                        <?php }?>

                        <form method="post" action="" enctype="multipart/form-data">

                            <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>City <span class="text-danger">*</span> :</label>

                                        <!-- <select class="form-control city_id" name="city_id" required> -->

                                        <select class="form-control city_id" name="city_id" required onchange="get_pincode(event)" id="cities">

                                            

                                            <option value="" disabled selected hidden>Select City</option>

                                            <?php foreach ($city as $c) {?>

                                                <option value="<?=$c->id?>"><?=$c->title?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <!-- <?php

                                    $pin_code = $this->db->query("SELECT * FROM locality WHERE status = 'Y'")->result();

                                    ?>

                                    <div class="form-group">

                                        <label>Pincode<span class="text-danger">*</span> :</label>

                                        <select class="pincode_div js-example-basic-multiple form-control" name="pincode[]" required multiple data-placeholder="Select Pincode">

                                            <?php foreach ($pin_code as $key => $p) {?>

                                                <option value="<?=$p->ID?>" ><?=$p->pin?></option>

                                            <?php } ?>

                                        </select>

                                    </div> -->



                                    <div class="form-group">

                                        <label>Pincode<span class="text-danger">*</span> :</label>

                                        <select class="form-control" name="pincode[]" id="pin" required multiple>



                                        </select>

                                    </div>



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

                                                <!-- <input type="number" class="form-control" required name="mobile" placeholder="mobile" /> -->
                                                <input type="text" class="form-control" required name="mobile" placeholder="Mobile (10 digits)" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" />

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

                                                <select class="form-control" name="role" required>

                                                    <option id="yesShow" value="vendor">Vendor</option>

                                                </select>

                                            </div>

                                        </div>

                                         <div class="col-sm-6" id="showcat" >

                                                <div class="form-group">

                                                    <label>Select Category<span class="text-danger">*</span> :</label>



                                                    <select class="form-control" id="category" name="category_id[]"  multiple >

                                                        <?php foreach ($category as $c){?>

                                                        <option value="<?=$c->categoryID?>"><?=$c->title?></option>

                                                             <?php }?>

                                

                                                    </select>



                                                </div>

                                            </div>

                                        </div>

                                         <div class="row clearfix">

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

    // $('.js-example-basic-multiple').select2();

    function selectfun(){

        $('.js-example-basic-multiple').select2();

    }

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

                $(".js-example-basic-multiple").select2({

                  tags: true

                });

            }

        });

    });

});

document.getElementById("get_cat").onchange = function (e) {

       if (this.value == 'vendor') {

         document.getElementById("showcat").style.display="block";

     } else {

         document.getElementById("showcat").style.display="none";

     }

 };

</script>





<script>

    function get_pincode(e) {

        e.preventDefault();

        let city_id  = $('#cities').val();

        if (city_id != '')

        {

            $.ajax({

                url:'<?=base_url("home/get_pincode/")?>'+city_id,

                method:'GET',

                success:function (response) {

                    let pin_code = JSON.parse(response);

                    let i;

                    let option = '';

                    for (i in pin_code)

                    {

                        option += '<option value="'+pin_code[i]['ID']+'">'+pin_code[i]['pin']+'</option>';

                    }

                    //alert(option);

                    $('#pin').html(option);

                    $('#pin').selectpicker('refresh');

                }

            });

        }

    }

</script>

<script>
    $(document).ready(function () {
        //user
       $("#cities").select2();
        $("#category").select2();
    });
 </script>
