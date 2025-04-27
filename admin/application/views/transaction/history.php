<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="Javascript::void(0)">Transaction</a></li>
                        <li class="breadcrumb-item active">History</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("home/add_wallet")?>"><i class="zmdi zmdi-plus"></i> Add Wallet</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Txn No.</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Note</th>
                                    <th>Transaction Mode</th>
                                    <th>Paid At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                // $CI = &get_instance();
                                foreach ($transactions as $t){ 
                                   $user = $this->db->get_where('users',array('ID'=>$t->userID))->row();
                                ?>
                                    <tr>
                                        <td><?=$t->transactionID?></td>
                                        <td><?=$user->name?> - <?=$user->mobile?></td>
                                        <td><?=$t->txn_no?></td>
                                        <td><?=$t->amount?></td>
                                        <td><?=$t->type?></td>
                                        <td><?=$t->note?></td>
                                        <td><?=$t->paid_by?></td>
                                        <td><?=date('d M Y H:i A',strtotime($t->transaction_at))?></td>
                                        
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