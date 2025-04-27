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
                        <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                        <?php }?>
                        <form method="post" action="<?=base_url('orders/generate_vendor_report')?>">
                            
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="date" placeholder="Enter Start Date" name="start_date">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="date" placeholder="Enter End Date" name="end_date">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <br>
                                        <button class="btn btn-success btn-round" type="submit" title="Export In CSV"><i class="zmdi zmdi-check-circle"></i> Export</button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
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
                                    <th>Registered At</th>
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
                                        <td><a href="#" class="referrals" data-toggle="modal" data-id="<?=$p->ID?>"><?=$p->total_referral?></a></td>
                                        <td><?php if ($p->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>
                                        <td><?=$p->added_on?></td>
                                        <td>
                                          <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="add_money('<?=$p->ID?>','<?=$p->name?>','<?=$p->mobile?>')" title="ADD MONEY TO WALLET"><i class="zmdi zmdi-plus"></i></a>
                                            <a class="btn btn-round btn-sm" href="<?=base_url("users/order_details/$p->ID/")?>"><i class="zmdi zmdi-eye"></i> view</a>

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

<div class="modal fade" id="user_type_modal" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: -webkit-linear-gradient(-45deg, #ff253a 0%,#ff8453 100%);">
                <h6 class="modal-title" style="margin-left: 150px;margin-bottom: 10px;">
                    <center id="user_name"></center><center id="user_mobile"></center>
                </h6>

                <button type="button" class="btn btn-sm" style=" width: 5%;    margin-top: -15px; background:transparent;" data-dismiss="modal"><strong>X</strong></button>
            </div>
            <div class="modal-body">
                <div class="card-body" style="margin-top: -30px">
                    <div class="col-lg-12 col-md-12 mx-auto Promocodes">
                        <form method="post" action="<?=base_url("users/add_wallet")?>">
                            <input type="hidden" name="ID" id="user_id">
                            <div class="form-group">
                                <label class="control-label">Txn No <span class="text-danger">*</span> : </label>
                                <input class="form-control" name="txn_no" required placeholder="eg; pay_Eas2MO12345" type="text">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Amount <span class="text-danger">*</span> : </label>
                                <input class="form-control" name="amount" required type="number" step="0.01" placeholder="eg; 100.00">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: -webkit-linear-gradient(-45deg, #ff253a 0%,#ff8453 100%); height: 40px;">
            </div>
        </div>
    </div>
</div>

        <div class="modal fade" id="referrals" role="dialog" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background: -webkit-linear-gradient(-45deg, #ff253a 0%,#ff8453 100%);">
              <h6 class="modal-title" style="margin-left: 150px;margin-bottom: 10px;">
              <center> List Of Referral Users</center>
              </h6>
              
              <button type="button" class="btn btn-sm" style=" width: 5%;    margin-top: -15px; background:transparent;" data-dismiss="modal"><strong>X</strong></button>
            </div>
              <div class="modal-body">
                <div class="card-body" style="margin-top: -30px">
                  <div class="col-lg-12 col-md-12 mx-auto Promocodes">
                      <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                        <thead>
                          <tr style="text-align: center;">
                              <th>#</th>
                              <th>Name</th>
                          </tr>
                        </thead>
                        <tbody id="table_referral">
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer" style="background: -webkit-linear-gradient(-45deg, #ff253a 0%,#ff8453 100%); height: 40px;">
              </div>
            </div>
          </div>
      </div> 

      <script type="text/javascript">
          $(document).ready(function(){
            $(".referrals").on("click", function(){
              var id1 = $(this).data('id');
              $.ajax({
                    type : 'POST',
                    url:"<?php echo base_url('users/get_referral_name')?>",
                    data : {'id':id1},
                    dataType: "json",
                    success : function (data) {                     
                      var html = '';
                      var i;
                        for(i=0; i<data.length; i++){
                            html +='<tr>'+'<td>'+i+'</td>'+'<td>'+data[i]['name']+'</td>'+'</tr>';
                            } 
                      $("#table_referral").html(html);
                      $('#referrals').modal('show');
                    }
                });

            });
          });
      </script> 

      <script>
        function add_money(id,name,mobile) {
            if (id != '')
            {
                $('#user_name').text(name);
                $('#user_mobile').text(mobile);
                $('#user_id').val(id);
                $('#user_type_modal').modal('show');
            }
        }
    </script>