<div class="modal fade" id="city_bulk_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("contact") ?>">Contact</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <!-- <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?= base_url("city/add") ?>"><i class="zmdi zmdi-plus"></i> Add</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-success" href="#city_bulk_modal" data-toggle="modal" data-target="#city_bulk_modal">Bulk Import</a></h2></h2> -->
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contact as $p) {
                                        $secret = md5($p->id); ?>
                                        <tr>
                                            <td><?= $p->id ?></td>
                                            <td><?= wordwrap($p->name, 25, "<br>\n") ?></td>
                                            <td><?= htmlspecialchars($p->email) ?></td>
                                            <td><?= htmlspecialchars($p->phone) ?></td>
                                            <td><?= htmlspecialchars($p->message) ?></td>
                                            <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
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