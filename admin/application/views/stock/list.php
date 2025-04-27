<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("stock")?>">Stock</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("stock/add")?>"><i class="zmdi zmdi-plus"></i> Add</a><a class="btn btn-success btn-sm" href="<?=base_url("stock/remove")?>"><i class="zmdi zmdi-minus"></i> Remove</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Stock</th>
                                    <th>Added On</th>
                                    <th>Updated on</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $l){?>
                                    <tr>
                                        <td><?=$l->id?></td>
                                        <td><?=$l->product?></td>
                                        <td><?=(+$l->value).' '.$l->unit?></td>
                                        <td><?=date("d M Y H:i",strtotime($l->created_at))?></td>
                                        <td><?=date("d M Y H:i",strtotime($l->updated_at))?></td>
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