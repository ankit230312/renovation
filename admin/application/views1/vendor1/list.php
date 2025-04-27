<div class="modal fade" id="pass_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">Reset Password</h4>
            </div>
            <div class="modal-body">
                <input class="form-control" name="userid" id="userid" hidden type="text">
                <h5 class="text-danger" id="reset_error"></h5>
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span> : </label>
                    <input class="form-control" name="password" id="password" type="password">
                </div>
                <div class="form-group">
                    <label>Confirm <span class="text-danger">*</span> : </label>
                    <input class="form-control" name="cpassword" id="cpassword" type="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round waves-effect" onclick="reset_psw(event)">SAVE CHANGES</button>
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
                        <li class="breadcrumb-item"><a href="<?=base_url("home/vendor")?>">Vendor</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("home/vendor/add")?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>City Name</th>
                                    <th>Pincodes</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($admin as $a){ $secret = md5($a->id);
                                    $city = $this->db->query("SELECT title FROM city WHERE id = '$a->city_id'")->row();

                                 ?>

                                    <tr>
                                        <td><?=$a->id?></td>
                                        <td><?=$a->name?></td>
                                        <td><?=$a->username?></td>
                                        <td><?php if(!empty($city)){echo wordwrap($city->title,25,"<br>\n"); } ?></td>
                                        <td><?php $pin = explode(',', $a->pincode);?>
                                                <ul>
                                            <?php foreach ($pin as $key => $value) {
                                                $locality = $this->db->query("SELECT pin FROM locality WHERE id = $value")->row();?>
                                                    <li><?=$locality->pin?></li>
                                            <?php }?>
                                                </ul></td>
                                        <td><?=$a->email?></td>
                                        <td><?=$a->mobile?></td>
                                        <td><?=ucwords($a->role)?></td>
                                        <td><?php if ($a->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>
                                        <td>
                                            <ul class="header-dropdown" style="list-style: none">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle btn btn-round btn-sm" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Action </a>
                                                    <ul class="dropdown-menu slideUp">
                                                        <li><a href="<?=base_url("home/vendor/edit/$a->id/$secret")?>">Edit</a></li>
                                                        <li><a href="javascript:void(0);" onclick="ch_pass(<?=$a->id?>)">Change Password</a></li>
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
    function ch_pass(id) {
        let userID = id;
        $('#userid').val(userID);
        $('#password').val('');
        $('#cpassword').val('');
        $('#pass_modal').modal('toggle');
    }
    function reset_psw(e) {
        e.preventDefault();
        let id = $('#userid').val();
        let psw = $('#password').val();
        let cpass = $('#cpassword').val();
        if (psw.trim() != '' && cpass.trim() != '' && id.trim() != ''){
            let data = "userID="+id+"&pass="+psw+"&cpass="+cpass;
            $.ajax({
                url:"<?=base_url("home/reset_admin_psw")?>",
                method : "post",
                data : data,
                success : function (res) {
                    let response = JSON.parse(res);
                    if (response.result == 'success'){
                        $('#userid').val('');
                        $('#password').val('');
                        $('#cpassword').val('');
                        $('#pass_modal').modal('toggle');
                        $('#success_modal').modal('toggle');
                    } else {
                        $('#reset_error').text(response.msg);
                    }
                }
            });
        } else {
            $('#reset_error').text('! All the fields are required');
        }
    }
</script>