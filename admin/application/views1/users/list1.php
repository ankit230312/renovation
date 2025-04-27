<?php
$CI = &get_instance();
?>
<style>
    .modal-content .modal-header{
        padding-bottom: none!important;
    }
   
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("users")?>">Users</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Total Orders</th>
                                    <th>Wallet</th>
                                    <th>Referral Code</th>
                                    <th>Referred By</th>
                                    <th>List Of Referral User</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $p){

                                 $referral_name = $CI->home_m->get_single_row_where('users',array('ID'=>$p->referral_userID),'name'); 
                                 
                                    ?>
                                    <tr>
                                        <td><?=$p->ID?></td>
                                        <td><?=$p->name?></td>
                                        <td><?=$p->mobile?></td>
                                        <td><?=$p->email?></td>
                                        <td><?=$p->total_orders?></td>
                                        <td><?=$p->wallet?></td>
                                		<td><?=$p->referral_code?></td>
                                        <td><?php if(!empty($referral_name)){echo '<strong style ="color:red;">' .$referral_name->name. '</strong>'; } else { echo "N/A";} ?> </td>
                                        <td><a href="#" data-target="#referrals" data-toggle="modal"><?=$p->total_referral?></a></td>
                                
                                        <td><?php if ($p->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>
                                        <td>
                                            <a class="btn btn-round btn-sm" href="<?=base_url("users/profile/$p->ID/")?>"><i class="zmdi zmdi-eye"></i> view</a>

                                        </td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="referrals" role="dialog" >
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header" style="background: -webkit-linear-gradient(-45deg, #ff253a 0%,#ff8453 100%);">
                  <h6 class="modal-title" style="margin-left: 150px;margin-bottom: 10px;">
                     <center> List Of Referral Users</center>
                  </h6>
                  <button type="button" class="btn btn-sm" style=" width: 5%;    margin-top: -15px; background:transparent;" data-dismiss="modal"><strong>X</strong></button>
               </div>
               <div class="modal-body">
           <div class="card-body" style="margin-top: -30px">
               <div>
                  <div class="col-lg-12 col-md-12 mx-auto Promocodes">
                      <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $u){
                                  $referral_list = $CI->home_m->get_single_table_query(("SELECT * FROM `users` WHERE `referral_userID`='$u->ID'"),'name');
                                  ?>
                                    <tr> 
                                        <td></td>
                                        <td><?=$referral_list->name?></td>
                                
                                     </tr>
                                <?php  }?> 
                                </tbody>
                            </table>
                    
                  </div>
                  
               </div>
            </div>
         </div>
               <div class="modal-footer" style="background: -webkit-linear-gradient(-45deg, #ff253a 0%,#ff8453 100%); height: 40px;">
               </div>
            </div>
         </div>
      </div>