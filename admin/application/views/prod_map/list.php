<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <!-- <h2><?= $title ?></h2> -->

                    <h2>Product Mapping</h2>

                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("items/product_society_map") ?>">Prodcut Map</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("items/product_society_map") ?>">Prodcut Map Management</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?= base_url("items/product_society_map_add") ?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Society Name</th>
                                        <th>Floor Type</th>
                                        <th>Feature</th>
                                        <th></th>Price</th>
                                        <th>Visibility</th>
                                        <th>Dependency</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($products)) {
                                        $i = 1;
                                        foreach ($products as $p) {

                                    ?>
                                            <tr>
                                                <td><?= $i; ?></td>

                                                <td><?= htmlspecialchars($p['product_name']); ?></td>
                                                <td><?= htmlspecialchars($p['society_name']); ?></td>

                                                <td>
                                                    <?php 
                                                    $floor_type = $this->db->get_where('floor_type', ['floor_id' => $p['property_type_id']])->row();
                                                    echo $floor_type ? htmlspecialchars($floor_type->floor_type) : '-';
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php 
                                                    if (!empty($p['property_feature_id'])) {
                                                        $feature_ids = explode(',', $p['property_feature_id']);
                                                        $features = [];
                                                        foreach ($feature_ids as $feature_id) {
                                                            $feature = $this->db->get_where('floor_dimensions', ['id' => trim($feature_id)])->row();
                                                            if ($feature) {
                                                                $features[] = htmlspecialchars($feature->room_type);
                                                            }
                                                        }
                                                        echo !empty($features) ? implode(', ', $features) : '-';
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>

                                                <td><?= number_format($p['price'], 2); ?></td>

                                                <td>
                                                    <?php if ($p['isVisible'] == 'Y') { ?>
                                                        <span class="badge badge-success">Visible</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-danger">Hidden</span>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php if ($p['isDependent'] == 'Y') { ?>
                                                        <span class="badge badge-warning">Dependent</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-info">Standalone</span>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <a href="javascript:void(0);"
                                                        class="toggle-status badge <?= ($p['status'] === 'active') ? 'badge-success' : 'badge-danger'; ?>"
                                                        data-id="<?= $p['item_product_id']; ?>"
                                                        data-status="<?= $p['status']; ?>">
                                                        <?= ucfirst($p['status']); ?>
                                                    </a>
                                                </td>


                                                <td>
                                                    <a class="btn btn-danger" href="<?= base_url('items/mapping_de/' . $p['item_product_id']); ?>">
                                                        Delete Mapping
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        }
                                    } else { ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No products found</td>
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
<script>
$(document).on('click', '.toggle-status', function () {

    let el = $(this);
    let id = el.data('id');
    let currentStatus = el.data('status');

    let newStatus = (currentStatus === 'active') ? 'inactive' : 'active';

    $.ajax({
        url: "<?= base_url('items/change_product_status'); ?>",
        type: "POST",
        dataType: "json",
        data: {
            item_product_id: id,
            status: newStatus
        },
        success: function (res) {
            if (res.success) {
                el
                  .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1))
                  .data('status', newStatus)
                  .removeClass('badge-success badge-danger')
                  .addClass(newStatus === 'active' ? 'badge-success' : 'badge-danger');
                  window.location.reload();
            } else {
                alert('Failed to update status');
            }
        }
    });
});
</script>
