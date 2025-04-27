<?php $site_settings = $this->db->get_where('settings')->row();?>
<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?=$title?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?=base_url("uploads/").$site_settings->favicon?>" type="image/x-icon">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/main.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/color_skins.css">
</head>
<body class="theme-black">
<div class="authentication">
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="row">
                <div class="col-lg-3 col-md-12">

                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card-plain">
                        <div class="header">
                            <h4 class="logo" style="margin-top: 0;"><img src="<?=base_url("uploads/".$site_settings->logo)?>" alt="<?=$site_settings->site_name?>" style="width: 100%"></h4>
                        </div>
                        <form class="form" method="post">
                            <?php
                            if (isset($error))
                            {
                                echo "<span class='text-danger'>! $error </span>";
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" required class="form-control" name="username" placeholder="User Name">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="password" required class="form-control" name="password" placeholder="Password">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                </div>
                            </div>
                            <div class="footer">
                                <button type="submit" class="btn btn-primary btn-round btn-block">SIGN IN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jquery Core Js -->
<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
</body>
</html>