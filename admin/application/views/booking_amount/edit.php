<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("Discount/booking_amount") ?>">Booking Amount</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2 class="text-left">
                        <a class="btn-sm btn btn-primary" href="<?= base_url("Discount/booking_amount") ?>">
                            <i class="zmdi zmdi-arrow-back"></i> List
                        </a>
                    </h2>
                </div>

                <div class="body">
                    <?php if (isset($error)) { ?>
                        <h2 class="title text-danger"><?= $error ?></h2>
                    <?php } ?>

                    <form method="post">

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Amount Type <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="offer_type" required>
                                        <option value="FIXED" <?= ($booking['offer_type'] == 'FIXED') ? 'selected' : '' ?>>FIXED</option>
                                        <option value="PERCENTAGE" <?= ($booking['offer_type'] == 'PERCENTAGE') ? 'selected' : '' ?>>PERCENTAGE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Amount Value <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" placeholder="Enter Offer Value" 
                                           name="offer_value" value="<?= htmlspecialchars($booking['offer_value']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="is_active" required>
                                        <option value="Y" <?= ($booking['is_active'] == 'Y') ? 'selected' : '' ?>>Active</option>
                                        <option value="N" <?= ($booking['is_active'] == 'N') ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button class="btn btn-default btn-round" type="submit">
                                        <i class="zmdi zmdi-check-circle"></i> Update
                                    </button>
                                    <a href="<?= base_url('Discount/booking_amount') ?>" class="btn btn-primary btn-round">
                                        <i class="zmdi zmdi-replay"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
