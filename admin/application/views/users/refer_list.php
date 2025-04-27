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

                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" id="user_data">
                            <!-- <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" id="user_data"> -->

                                <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Name</th>

                                    <th>Mobile</th>

                                    <th>Email</th>

                                    <th>Total Orders</th>

                                    <th>Wallet</th>
                                    <th>Cashback</th>

                                    <th>Referral Code</th>

                                    <th>Referred By</th>


                                    <th>Status</th>

                                    <th>Registered At</th>

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
                                        <td><?=$p->cashback_wallet?></td>

                                		    <td><?=$p->referral_code?></td>

                                        <td><?php if(!empty($referral_name)){echo '<strong style ="color:red;">' .$referral_name->name. '</strong>'; } else { echo "N/A";} ?> </td>

                                        
                                        <td><?php if ($p->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>

                                        <td><?=$p->added_on?></td>

                                       
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





