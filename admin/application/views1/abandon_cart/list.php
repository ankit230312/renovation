<?php
$CI = &get_instance();
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("users")?>">Abandon Cart</a></li>
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
                                    <th>Cart Products </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($distinct_user as $p){
                                    $users = $CI->home_m->get_single_row_where('users',array('ID'=>$p->userID),'*'); 
                                    ?>
                                    <tr>
                                        <td><?=$p->userID?></td>
                                        <td><?=wordwrap($users->name,25,"<br>\n");  ?></td>
                                        <td><?=$users->mobile?></td>
                                        <td><?=$users->email?></td>
                                        <td><a href="<?=base_url("abandon_cart/get_products/$p->userID")?>"><strong style="color: red;"><?=$p->get_cart_products?></strong> </a></td>
                                        
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
