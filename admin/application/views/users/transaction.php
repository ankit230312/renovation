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
                                    <th>Txn No</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Against For</th>
                                    <th>Paid By</th>
                                    <th>Transaction At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($transactions as $p){

                                    ?>
                                    <tr>
                                        <td><?=$p->transactionID?></td>
                                        <td><?=$p->txn_no?></td>
                                        <td><?=$p->amount?></td>
                                        <td><?=$p->type?></td>
                                        <td><?=$p->against_for?></td>
                                        <td><?=$p->paid_by?></td>
                                        <td><?=date('d-m-Y',strtotime($p->transaction_at))?></td>
                                		
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
