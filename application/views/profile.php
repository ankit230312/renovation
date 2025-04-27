

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







            <?php 



            $imgUrl = 'https://cdn1.iconfinder.com/data/icons/avatar-97/32/avatar-02-512.png';

            if(!empty($myprofile['image']) && file_exists('./uploads/users/'.$myprofile['image'])){

               $imgUrl = base_url('/').'/uploads/users/'.$myprofile['image'];

            }

            ?>

           

            <div id="profile" class="tabcontent">





               <div class="col-lg-12 p-3 bg-white rounded shadow-sm mb-5">



                  <div class="card card-body account-right">

                     <div class="widget">

                        <div class="section-header">

                           <div>

                              

                              <form method="post" id="upload_image" action="<?=base_url('home/upload')?>" enctype="multipart/form-data">

                                 <img src="<?=$imgUrl?>" alt="" width="99" class="" style="border-radius: 50%;height: 100px;width: 100px;">

                                 <label for="upload">

                                 <span class="glyphicon glyphicon-folder-open" aria-hidden="true" style="position: relative;

                                 top: 37px;

                                 right: 43px;

                                 padding: 3px 0px;

                                 color: black;">

                                 <i class="fa fa-edit" aria-hidden="true" title="Click Here to Upload Profile Image"></i>

                              </span>

                              <input type="file" id="upload" name="photo" style="display:none">

                           </label>

                           </form>









                           <h5 class="mb-2">

                              HI <span style="color: teal;"><?=$myprofile['name']?></span>

                           </h5>

                           <h5 class="mb-2"><?=$myprofile['mobile']?></h5>

                        </div>

                     </div>

                     <div style="display: flex;">

                        <div class="row profile-sec">

                           <div class="col-sm-12">

                              <h5>Name : <?=$myprofile['name']?></h5>

                              <h5>Mobile : <?=$myprofile['mobile']?></h5>

                              <h5>Email : <?=$myprofile['email']?></h5>

                              <h5>Referral Code : <span style="color: Red;"><?=$myprofile['referral_code']?></span></h5>

                              <h5>Wallet : <span style="color: Red;"><?='₹ '.$myprofile['wallet']?></span></h5>

                              <h5>Cashback : <span style="color: Red;"><?='₹ '.$myprofile['cashback_wallet']?></span></h5>

                           </div>

                        </div>

                        <div>

                           <button class="btn btn-success" id="edit">Edit Profile</button>

                        </div>



                     </div>







                  </div>

               </div>

            </div>



            <div id="edit_profile" style="display: none;">

               <h5>Edit Profile</h5>

               <div class="col-lg-12 p-3 bg-white rounded shadow-sm mb-5">





                  <form name="" id="update_profile" action="<?=base_url('home/update_profile')?>" method="post">

                     <label for="name">Name</label>

                     <input type="hidden" name="user_id" id="user_id" value="<?=$myprofile['ID']?>">

                     <input type="text" name="name" class="form-control" id="name" value="<?=$myprofile['name']?>">

                     <span id="name_error" style="color: red;"></span>

                     <br>

                     <label>Email Address</label>

                     <input type="text" name="email" id="email"class="form-control" value="<?=$myprofile['email']?>">

                     <span id="email_error" style="color: red;"></span>



                     <br>

                     <button type="button" class="btn btn-success" id="update">Update</button>

                  </form>





               </div>

            </div>







         </div>





      </div>

   </div>

</section>





<script type="text/javascript">

   $("#edit").click(function(){

      $('#edit_profile').toggle(1500);

   });

   $("#update").click(function(){

      var name = $('#name').val();

      var email = $('#email').val();

      $('#name_error').html('');

      $('#email_error').html('');

      if(name == ''){

         $('#name_error').html('Name is Required');

         return false;

      }if(email == ''){

         $('#email_error').html('Email is Required');

         return false;

      }



      $('#update_profile').submit();



   });

</script>

<script type="text/javascript">

   $("#upload").change(function(){

      $('#upload_image').submit();

   });

</script>