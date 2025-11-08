<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("coupons") ?>">Coupons</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?= base_url("coupons/add") ?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Coupon Code</th>
                                        <th>Type</th>
                                        <th>Offer Value</th>
                                        <th>Applied On</th>
                                        <th>Products</th> <!-- NEW COLUMN -->
                                        <th>Min cart Value</th>
                                        <th>Max Discount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($offers as $p): ?>
                                        <tr>
                                            <td><?= $p->offerID ?></td>
                                            <td><?= strtoupper($p->offer_code) ?></td>
                                            <td><?= $p->offer_type ?></td>
                                            <td><?= $p->offer_value ?></td>
                                            <td><?= $p->apply_on ?></td>
                                            <td><?= !empty($p->product_names) ? $p->product_names : '-' ?></td> <!-- Show joined products -->
                                            <td><?= $p->min_cart_value ?></td>
                                            <td><?= $p->max_discount ?></td>
                                            <td><?= date("d M Y", strtotime($p->start_date)) ?></td>
                                            <td><?= date("d M Y", strtotime($p->end_date)) ?></td>
                                            <td><?= $p->is_active == 'Y' ? 'Active' : 'Inactive' ?></td>
                                            <td>
                                                <a href="<?= base_url("coupons/edit/$p->offerID") ?>" class="btn btn-warning btn-sm">Edit</a>
                                                 <a href="<?= base_url("coupons/delete/$p->offerID") ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>