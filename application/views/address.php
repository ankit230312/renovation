

<section class="mt-100">
<div class="container">
<div class="row">
<div class="col-md-12">
   <?php
   $this->load->view('user_left_bar');
   ?>
   <?php 
   echo $this->session->flashdata('message');
   ?>

   <div id="address" class="tabcontent">


    <div class="col-lg-12 p-3 bg-white rounded shadow mb-5">

        <div class="card card-body account-right" style="border: none; width: 100%;">
            <div class="widget">

                <div class="col-sm-12 p-3 mb-2">
                    <div class="address-body">
                        <button type="button" id="add_address" class="btn btn-danger mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add Address</button>

                        <div id="add" style="display: none;">
                          <div class="col-lg-12 p-3 bg-white rounded shadow-sm mb-5" style="width: 100%">


                           <form name="" id="save_address" action="<?=base_url('home/add_address')?>" method="post">
                             
                            <input type="hidden" name="userID" id="userID" value="<?=$myprofile['ID']?>">
                            <input type="hidden" name="contact_person_name" id="contact_person_name" value="<?=$myprofile['name']?>">
                            <input type="hidden" name="contact_person_mobile" id="contact_person_mobile" value="<?=$myprofile['mobile']?>">
                            
                            <label for="name">House No</label>
                            <input type="text" name="flat_no" class="form-control" id="flat_no" value="" style="width: 100%">
                            <label for="name">Building Name</label>
                            <input type="text" name="building_name" class="form-control" id="building_name" value="">
                            <label for="name">Address</label>
                            <input type="text" name="location" class="form-control" id="location" value="">
                            <span id="location_error" style="color: red"></span>
                            <br>
                            <label for="name">LandMark</label>
                            <input type="text" name="landmark" class="form-control" id="landmark" value="">
                            <span id="landmark_error" style="color: red"></span>
                            <br>
                            <label for="name">Pincode</label>
                            <input type="text" name="pincode" class="form-control" id="pincode" value="">
                            <span id="pincode_error" style="color: red"></span>
                            <br>
                            <input type="hidden" name="latitude" class="form-control" id="latitude" value="">
                            <input type="hidden" name="longitude" class="form-control" id="longitude" value="">

                            <label style="padding: 0px 12px;">
                            <input type="radio" name="address_type" value="home" checked style="margin: 0 12px 0px 0;">Home</label>
                            <label style="padding: 0px 12px;">
                            <input type="radio" name="address_type" value="office" style="margin:  0 12px 0px 0;">Office</label>
                            <label style="padding: 0px 12px;"><input type="radio" name="address_type m-auto" value="others" style="margin: 0 12px 0px 0;">Others</label>
                            <br>
                            <button type="button" class="btn btn-success" id="add_add">Update</button>
                        </form>


                    </div>
                </div>

                <?php if(!empty($addresses)){
                    foreach($addresses as $add){
                        $type = '';
                        if($add->address_type == 'Home' ||$add->address_type == 'home'){
                            $type = 'Home'; 
                        }elseif($add->address_type == 'Office' ||$add->address_type == 'office'){
                           $type = 'Office'; 
                       }elseif($add->address_type == 'Others' ||$add->address_type == 'others'){
                           $type = 'Others';
                       }

                       ?>
                       <div class="address-item card mb-3">
                        <div class="address-icon1">
                            <i class="fa fa-home" aria-hidden="true"></i> 
                        </div>
                        <div class="address-dt-all" style="width: 100%;">
                            <h4><?=$type?></h4>
                            <p><strong>Name: </strong> <?=$add->contact_person_name?></p>
                            <p><strong>Mobile No: </strong> <?=$add->contact_person_mobile?></p>
                            <p><strong>Building No: </strong> <?=$add->building_name?></p>
                            <p><strong>Flat/House No: </strong> <?=$add->flat_no?></p>
                            <p><strong>Address: </strong> <?=$add->location?></p>
                            <p><strong>Pincode: </strong> <?=$add->pincode?></p>


                            </div>
                            <div>
                            <ul class="action-btns">
                                <!-- <li><a href="#" class="action-btn"><i class="fa fa-edit"></i></a></li> -->
                                <li><a id="delete<?=$add->addressID?>" data-id="<?=$add->addressID?>" onclick="delete_address(<?=$add->addressID?>)" class="action-btn"><i class="fa fa-trash"></i></a></li>
                                <form id="delete_add<?=$add->addressID?>" action="<?=base_url('home/delete_addr')?>" method="post">
                                    <input type="hidden" name="add_id" value="<?=$add->addressID?>">
                                </form>


                            </ul>
                            </div>
                        
                    </div>
                <?php }}?>
                



            </div>

        </div>
    </div>
</div>


</div>


</div>
</div>
</section>


<script type="text/javascript">
$("#add_address").click(function(){
$('#add').toggle(1500);
});

$("#add_add").click(function(){
var landmark = $('#landmark').val();
var city = $('#city').val();
var pin_code = $('#pincode').val();
var location = $('#location').val();
if(landmark == ''){
$('#landmark_error').html('Landmark is Required');
return false;
}if(city == ''){
$('#city_error').html('City is Required');
return false;
}if(pin_code == ''){
$('#pin_code_error').html('Pincode is Required');
return false;
}if(location == ''){
$('#location_error').html('Location is Required');
return false;
}

$('#save_address').submit();

});


</script>



<script type="text/javascript">
$( document ).ready(function() {
//user clicks button
if ("geolocation" in navigator){ //check geolocation available 
//try to get user current location using getCurrentPosition() method
navigator.geolocation.getCurrentPosition(function(position){ 
    // $("#result").html("Found your location <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude);

    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);


});
}else{
console.log("Browser doesn't support geolocation!");
}
});
</script>


<script type="text/javascript">
function delete_address(id){
if(confirm('Are You Want To Delete This Address??')){
$('#delete_add'+id).submit();
}else{
return false;
}
}
</script>