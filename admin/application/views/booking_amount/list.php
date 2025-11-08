<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("Discount/booking_amount") ?>">Booking Amount</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?= base_url("Discount/booking_amount/add") ?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Booking Type</th>
                                        <th>Booking Value</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    foreach ($booking_amounts as $p) {

                                    ?>
                                        <tr>
                                            <td><?= $p['id'] ?></td>
                                            <td><?= $p['offer_type'] ?></td>
                                            <td><?= $p['offer_value'] ?></td>

                                            <td><?php if ($p['is_active'] == 'Y') {
                                                    echo "Active";
                                                } else {
                                                    echo "InActive";
                                                } ?></td>
                                            <td>
                                                <a class="btn btn-warning" href="<?= base_url("Discount/booking_amount/edit/" . $p['id'] . "") ?>">Edit</a>

                                                <a class="btn btn-danger"
                                                    href="<?= base_url("Discount/booking_amount/delete/" . $p['id']) ?>"
                                                    onclick="return confirm('Are you sure you want to delete this booking amount?');">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>