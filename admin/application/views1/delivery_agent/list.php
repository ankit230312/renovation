<?php
$CI = &get_instance();
?>
<div class="modal fade" id="del_pass_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">Reset Password</h4>
            </div>
            <div class="modal-body">
                <input class="form-control" name="del_userid" id="del_userid" hidden type="text">
                <h5 class="text-danger" id="del_reset_error"></h5>
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span> : </label>
                    <input class="form-control" name="del_password" id="del_password" type="password">
                </div>
                <div class="form-group">
                    <label>Confirm <span class="text-danger">*</span> : </label>
                    <input class="form-control" name="del_cpassword" id="del_cpassword" type="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round waves-effect" onclick="reset_del_psw(event)">SAVE CHANGES</button>
                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("home/delivery_agent")?>">Delivery Agent</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("home/delivery_agent/add")?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Alternate Phone</th>
                                    <th>Ongoing Orders</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                               
                                   <?php foreach ($delivery_agent as $a){
                                    $ongoing = $CI->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `agentID`='$a->delivery_agentID' AND `status`!='REQUESTED' AND `status`!='CANCELLED' AND `status`!='DELIVERED'");
                                    ?>
                                    <tr>
                                        <td><?=$a->name?></td>
                                        <td><?=$a->email?></td>
                                        <td><?=$a->phone?></td>
                                        <td><?=$a->alternate_phone?></td>
                                        <td><!-- <a href="<?=base_url('home/agent_pending_order/').$a->delivery_agentID?>"> --><?=$ongoing->order_count?></a></td>
                                        <td><?php if ($a->is_active == 'Y'){echo "Active";}else{echo "InActive";}?></td>
                                        <td>
                                            <ul class="header-dropdown" style="list-style: none">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle btn btn-round btn-sm" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Action </a>
                                                    <ul class="dropdown-menu slideUp">
                                                        <li><a href="<?=base_url("home/delivery_agent/edit/$a->delivery_agentID/")?>">Edit</a></li>
                                                        <li><a href="javascript:void(0);" onclick="ch_del_pass(<?=$a->delivery_agentID?>)">Change Password</a></li>
                                                        <li><a href="<?=base_url("home/delete_delivery_agent/$a->delivery_agentID/")?>">Delete</a></li>

                                                    </ul>
                                                </li>
                                            </ul>
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
<script>
    function ch_del_pass(id) {
        let userID = id;
        $('#del_userid').val(userID);
        $('#del_password').val('');
        $('#del_cpassword').val('');
        $('#del_pass_modal').modal('toggle');
    }
    function reset_del_psw(e) {
        e.preventDefault();
        let id = $('#del_userid').val();
        let psw = $('#del_password').val();
        let cpass = $('#del_cpassword').val();
        if (psw.trim() != '' && cpass.trim() != '' && id.trim() != ''){
            let data = "userID="+id+"&pass="+psw+"&cpass="+cpass;
            $.ajax({
                url:"<?=base_url("home/reset_delivery_psw")?>",
                method : "post",
                data : data,
                success : function (res) {
                    let response = JSON.parse(res);
                    if (response.result == 'success'){
                        $('#del_userid').val('');
                        $('#del_password').val('');
                        $('#del_cpassword').val('');
                        $('#del_pass_modal').modal('toggle');
                        $('#success_modal').modal('toggle');
                    } else {
                        $('#del_reset_error').text(response.msg);
                    }
                }
            });
        } else {
            $('#del_reset_error').text('! All the fields are required');
        }
    }
</script>