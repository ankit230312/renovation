<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?= $title ?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?= base_url("propertyFeature") ?>">Property Feature</a></li>

                        <li class="breadcrumb-item"><a href="<?= base_url("propertyFeature") ?>">Property Feature Management</a></li>

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

                    <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?= base_url("propertyFeature") ?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                </div>

                <div class="body">

                    <?php if (isset($error)) { ?>

                        <h2 class="title text-danger"><?= $error ?></h2>

                    <?php } ?>

                    <form method="post" enctype="multipart/form-data">

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Select Property <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="property_id" id="property_id" required>
                                        <option value="">-- Select Property --</option>
                                        <?php if (!empty($products)) : ?>
                                            <?php foreach ($products as $product) : ?>
                                                <option selected value="<?= $product->productID; ?>">
                                                    <?= htmlspecialchars($product->product_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                       

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Select Propert Type <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="property_type_id" id="property_type" required>
                                        <option value="">-- Select Property Type --</option>
                                    </select>

                                </div>
                            </div>
                        </div>



                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Title <span class="text-danger">*</span> :</label>

                                    <input type="text" value="<?php echo $products[0]->room_type ?>" class="form-control" required name="room_type" placeholder="Enter Title for Feature" />

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Area Squre Feet <span class="text-danger">*</span> :</label>

                                    <input type="text" value="<?php echo $products[0]->area_sqft ?>" class="form-control" required name="area_sqft" placeholder="Enter Area Squre Feet" />

                                </div>

                            </div>

                        </div>





                        <!-- <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Image <span class="text-danger">*</span> :</label>

                                        <input type="file" accept="image/*" class="form-control" required name="image"/>

                                    </div>

                                </div>

                            </div> -->




                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Status <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="status" required>

                                        <option value="active">Active</option>

                                        <option value="inactive">InActive</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <!-- <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Off Upto</label>

                                        <input type="text" class="form-control" name="off_upto" placeholder="Enter Off Upto" />

                                    </div>

                                </div>

                            </div> -->

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
    // $(document).ready(function() {
    //     $('#property_id').on('load', function() {
    //         var propertyID = $(this).val();
    //         if (propertyID !== '') {
    //             $.ajax({
    //                 url: '<?= base_url("/propertyFeature/get_property_types") ?>',
    //                 type: 'POST',
    //                 data: {
    //                     property_id: propertyID
    //                 },
    //                 dataType: 'json',
    //                 success: function(response) {
    //                     console.log(response); // Debug
    //                     var options = '<option value="">-- Select Property Type --</option>';
    //                     $.each(response, function(index, item) {
    //                         options += '<option value="' + item.floor_id + '">' + item.floor_type + '</option>';
    //                     });

    //                     $('#property_type').html(options);
    //                     $('#property_type').selectpicker('refresh');
    //                     console.log(options)
    //                 },
    //                 error: function() {
    //                     alert("Failed to fetch property types.");
    //                 }
    //             });
    //         }
    //     });
    // });

    $(document).ready(function() {
        // Get preselected property ID on page load
        var propertyID = $('#property_id').val();

        // Trigger AJAX only if a property is preselected
        if (propertyID !== '') {
            $.ajax({
                url: '<?= base_url("/propertyFeature/get_property_types") ?>',
                type: 'POST',
                data: {
                    property_id: propertyID
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Debug
                    var options = '<option value="">-- Select Property Type --</option>';
                    $.each(response, function(index, item) {
                        options += '<option selected value="' + item.floor_id + '">' + item.floor_type + '</option>';
                    });

                    $('#property_type').html(options);
                    $('#property_type').selectpicker?.('refresh'); // Only if you're using bootstrap-select
                    console.log(options);

                    // OPTIONAL: Preselect the property_type_id if editing
                    <?php if (!empty($selected_property_type_id)) : ?>
                        $('#property_type').val('<?= $selected_property_type_id ?>');
                    <?php endif; ?>
                },
                error: function() {
                    alert("Failed to fetch property types.");
                }
            });
        }

        // ALSO handle change event in case user changes property manually
        $('#property_id').on('change', function() {
            var propertyID = $(this).val();
            if (propertyID !== '') {
                $.ajax({
                    url: '<?= base_url("/propertyFeature/get_property_types") ?>',
                    type: 'POST',
                    data: {
                        property_id: propertyID
                    },
                    dataType: 'json',
                    success: function(response) {
                        var options = '<option value="">-- Select Property Type --</option>';
                        $.each(response, function(index, item) {
                            options += '<option value="' + item.floor_id + '">' + item.floor_type + '</option>';
                        });

                        $('#property_type').html(options);
                        $('#property_type').selectpicker?.('refresh');
                    },
                    error: function() {
                        alert("Failed to fetch property types.");
                    }
                });
            }
        });
    });
</script>