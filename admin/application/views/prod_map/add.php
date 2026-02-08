<style>
    .society-box {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 12px;
    }

    .society-item {
        display: flex;
        align-items: center;
        padding: 12px 14px;
        border: 1px solid #e2e2e2;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .society-item:hover {
        border-color: #007bff;
        background: #f8faff;
    }

    .society-item input {
        margin-right: 10px;
    }

    .society-name {
        font-weight: 500;
    }

    .floor-box {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }

    .floor-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        background: #fff;
        transition: 0.2s;
    }

    .floor-item:hover {
        border-color: #007bff;
        background: #f8faff;
    }

    .floor-item input {
        margin-right: 10px;
    }

    .floor-name {
        font-weight: 500;
    }

    .dimension-box {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 12px;
    }

    .dimension-item {
        display: flex;
        gap: 10px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        background: #fff;
        transition: 0.2s;
    }

    .dimension-item:hover {
        border-color: #28a745;
        background: #f8fff8;
    }

    .dimension-name {
        font-size: 14px;
        line-height: 1.4;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("items/product_society_map_add") ?>">Products Map</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Input -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?= base_url("items/product_society_map") ?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)) { ?>
                        <h2 class="title text-danger"><?= $error ?></h2>
                    <?php } ?>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url('items/save_product_mapping'); ?>">

                        <!-- Property Item -->
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Property Item <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="itemID" id="itemID">
                                        <option value="">Select Property Item</option>
                                        <?php if (!empty($product_item)) : ?>
                                            <?php foreach ($product_item as $item) : ?>
                                                <option value="<?= $item['item_product_id']; ?>">
                                                    <?= $item['product_name']; ?> <span> (<?= $item['society_name']; ?>) </span>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Society -->
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Select Society <span class="text-danger">*</span></label>
                                    <div class="society-box" id="societyBox">
                                        <p class="text-muted">Please select product first</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floor Type -->
                        <div class="row clearfix mt-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Select Floor Type <span class="text-danger">*</span></label>
                                    <div class="floor-box" id="floorBox">
                                        <p class="text-muted">Please select society first</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floor Dimensions -->
                        <div class="row clearfix mt-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Floor Dimensions <span class="text-danger">*</span></label>
                                    <div class="dimension-box" id="dimensionBox">
                                        <p class="text-muted">Please select floor type first</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button class="btn btn-default btn-round" type="submit"><i class="zmdi zmdi-check-circle"></i> Submit</button>
                                    <button class="btn btn-primary btn-round" type="reset"><i class="zmdi zmdi-replay"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- #END# Input -->
    </div>
</section>

<script>
    function get_subcategories(e) {
        e.preventDefault();
        let categoryID = $('#categories').val();
        if (categoryID != '') {
            $.ajax({
                url: '<?= base_url("category/get_subcategory/") ?>' + categoryID,
                method: 'GET',
                success: function(response) {
                    let subcategory = JSON.parse(response);
                    let i;
                    let option = '';
                    for (i in subcategory) {
                        option += '<option value="' + subcategory[i]['categoryID'] + '">' + subcategory[i]['title'] + '</option>';
                    }
                    //alert(option);
                    $('#subcategories').html(option);
                    $('#subcategories').selectpicker('refresh');
                }
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        $("#categories").select2();
        $("#subcategories").select2();
    });
</script>

<script>
    $("#itemID").change(function() {

        let productID = $(this).val();

        // 🔥 FULL RESET
        $("#societyBox").html('');
        $("#floorBox").html('<p class="text-muted">Please select society first</p>');
        $("#dimensionBox").html('<p class="text-muted">Please select floor type first</p>');

        // Remove any hidden values / old selections
        $('input[name="society_id[]"]').prop('checked', false);
        $('input[name="floor_id[]"]').prop('checked', false);
        $('input[name="dimension_id[]"]').prop('checked', false);

        if (!productID) {
            $("#societyBox").html('<p class="text-muted">Please select product first</p>');
            return;
        }

        $.ajax({
            url: "<?= base_url('items/get_available_societies'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                productID
            },

            success: function(res) {

                if (res.length === 0) {
                    $("#societyBox").html(
                        '<p class="text-danger">Already mapped with all societies</p>'
                    );
                    return;
                }

                let html = '';
                $.each(res, function(i, item) {
                    html += `
                    <label class="society-item">
                        <input type="checkbox" name="society_id[]" value="${item.productID}">
                        <span class="society-name">${item.product_name}</span>
                    </label>
                `;
                });

                $("#societyBox").html(html);
            }
        });
    });

    $(document).on('change', 'input[name="society_id[]"]', function() {

        // 🔥 RESET LOWER LEVELS
        $("#floorBox").html('');
        $("#dimensionBox").html('<p class="text-muted">Please select floor type first</p>');
        $('input[name="floor_id[]"]').prop('checked', false);
        $('input[name="dimension_id[]"]').prop('checked', false);

        let checkedSocieties = $('input[name="society_id[]"]:checked')  ;
        // 🔒 Disable other societies if one is selected
        if (checkedSocieties.length > 0) {
            $('input[name="society_id[]"]').not(':checked').prop('disabled', true);
        } else {
            // 🔓 Re-enable all if none selected
            $('input[name="society_id[]"]').prop('disabled', false);
        }

        let societyIds = [];
        $('input[name="society_id[]"]:checked').each(function() {
            societyIds.push($(this).val());
        });

        if (societyIds.length === 0) {
            $("#floorBox").html('<p class="text-muted">Please select society first</p>');
            return;
        }

        $.ajax({
            url: "<?= base_url('items/get_floor_types'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                society_ids: societyIds
            },

            success: function(res) {

                if (res.length === 0) {
                    $("#floorBox").html('<p class="text-danger">No floor types available</p>');
                    return;
                }

                let html = '';
                $.each(res, function(i, floor) {
                    html += `
                    <label class="floor-item">
                        <input type="checkbox" name="floor_id[]" value="${floor.floor_id}">
                        <span class="floor-name">${floor.floor_type}</span>
                    </label>
                `;
                });

                $("#floorBox").html(html);
            }
        });
    });


    $(document).on('change', 'input[name="floor_id[]"]', function() {

        $("#dimensionBox").html('');
        $('input[name="dimension_id[]"]').prop('checked', false);

        let floorTypeId = $('input[name="floor_id[]"]:checked')
        if (floorTypeId.length > 0) {
            // Disable other floor types if one is selected
            $('input[name="floor_id[]"]').not(':checked').prop('disabled', true);
        } else {
            // Re-enable all if none selected
            $('input[name="floor_id[]"]').prop('disabled', false);
        }

        let floorTypeIds = [];
        $('input[name="floor_id[]"]:checked').each(function() {
            floorTypeIds.push($(this).val());
        });

        if (floorTypeIds.length === 0) {
            $("#dimensionBox").html('<p class="text-muted">Please select floor type first</p>');
            return;
        }

        $.ajax({
            url: "<?= base_url('items/get_available_features'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                floor_type_ids: floorTypeIds,
                itemID: $('#itemID').val()
            },

            success: function(res) {

                if (res.length === 0) {
                    $("#dimensionBox").html('<p class="text-danger">No dimensions found</p>');
                    return;
                }

                let html = '';
                $.each(res, function(i, d) {
                    html += `
                    <label class="dimension-item">
                        <input type="checkbox" name="dimension_id[]" value="${d.id}">
                        <span class="dimension-name">
                            <strong>${d.room_type ?? 'Room'}</strong><br>
                            (${d.area_sqft} sqft)
                        </span>
                    </label>
                `;
                });

                $("#dimensionBox").html(html);
            }
        });
    });
</script>