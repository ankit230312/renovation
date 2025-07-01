<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("society") ?>">Product</a></li>
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
                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?= base_url("Items") ?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)) { ?>
                        <h2 class="title text-danger"><?= $error ?></h2>
                    <?php } ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Category Title <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="text" name="product_name" placeholder="Enter Society Title">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Category Description </label>
                                    <textarea class="form-control" type="text" name="use" placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Category <span class="text-danger">*</span> :</label>
                                    <select class="form-control" id="cateogry_id" name="cateogry_id">
                                        <option value=""> Select Product Category </option>
                                        <?php foreach ($item_category as $it) { ?>
                                            <option value="<?= $it->categoryID ?>"><?= $it->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Product Dependent <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="product_dep" id="product_dep">
                                        <option value="N">No</option>
                                        <option value="Y">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>





                        <!-- <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Sub Category <span class="text-danger">*</span> :</label>
                                    <select class="form-control" id="society_id" name="society_id">
                                        <option value=""> Select sub Product Category </option>
                                        <?php foreach ($item_category as $it) { ?>
                                            <option value="<?= $it->categoryID ?>"><?= $it->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div> -->


                        <div id="setVisible" style="display: none;">
                            <!-- <div id="setVisible"> -->
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Society <span class="text-danger">*</span> :</label>
                                        <select class="form-control" id="society_id" name="society_id">
                                            <option value=""> Select Society </option>
                                            <?php foreach ($society as $s) { ?>
                                                <option value="<?= $s->productID ?>"><?= $s->product_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type <span class="text-danger">*</span> :</label>
                                        <select class="form-control" style="width: 100%;" name="property_type" id="property_type">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type Feature <span class="text-danger">*</span> :</label>
                                        <select class="form-control" style="width: 100%;" name="property_feature[]" id="property_feature" multiple>
                                            <!-- options go here -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Image <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="file" name="product_image">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Price </label>
                                    <input class="form-control" required type="text" id='product_price' name="product_price" placeholder="Enter Society Title">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Society Region <span class="text-danger">*</span> :</label>
                                    <select class="form-control" onchange="get_subcategories(event)" id="categories">
                                        <?php foreach ($category as $c) { ?>
                                            <option value="<?= $c->categoryID ?>"><?= $c->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Society Sub Region <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="category_id[]" id="subcategories" required multiple>

                                    </select>
                                </div>
                            </div>
                        </div> -->



                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Status <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>



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
    $(document).ready(function() {
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
    });
    $(document).ready(function() {
        let brandID = $('#brand').val();
        if (brandID != '') {

        }
        $.ajax({
            url: '<?= base_url("brand/get_brand/") ?>' + brandID,
            method: 'GET',
            success: function(response) {
                let brand = JSON.parse(response);
                let i;
                let option = '';
                for (i in brand) {
                    option += '<option value="' + brand[i]['brandID'] + '">' + brand[i]['title'] + '</option>';
                }
                //alert(option);
                $('#brand').html(option);
                $('#brand').selectpicker('refresh');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#categories").select2();
        $("#subcategories").select2();
        $("#property_type").select2();
        $("#property_feature").select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#product_dep').change(function() {
            if ($(this).val() === 'Y') {
                $('#setVisible').slideDown(); // or use .show()
            } else {
                $('#setVisible').slideUp(); // or use .hide()
            }
        });

        // Trigger change on page load to handle default value
        $('#product_dep').trigger('change');
    });
</script>



<script>
    $(document).ready(function() {
        $('#society_id').on('change', function() {
            var societyId = $(this).val();

            if (societyId !== '') {
                $.ajax({
                    url: '<?= site_url("Items/get_floor_type/") ?>', // Adjust controller name
                    type: 'POST',
                    data: {
                        society_id: societyId
                    },
                    dataType: 'json',
                    success: function(response) {
                        var $propertyType = $('#property_type');
                        $propertyType.empty(); // Clear existing options

                        if (response.length > 0) {
                            // Add default option
                            $propertyType.append('<option value="">Please select type</option>');

                            // Add fetched options
                            response.forEach(function(item) {
                                $propertyType.append(
                                    $('<option>', {
                                        value: item.floor_id,
                                        text: item.floor_type
                                    })
                                );
                            });
                        } else {
                            // If no results
                            $propertyType.append('<option value="">No Property Types Found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }
                });
            } else {
                $('#property_type').empty().append('<option value="">Select Society First</option>');
            }
        });
    });



    $(document).ready(function() {
        $('#property_type').on('change', function() {
            var societyId = $('#society_id').val();
            var propertyTypes = $(this).val(); // this returns an array if multiple

            if (societyId !== '' && propertyTypes.length > 0) {
                $.ajax({
                    url: '<?= site_url("Items/get_floor_type_feature") ?>',
                    type: 'POST',
                    data: {
                        society_id: societyId,
                        property_type_id: propertyTypes // pass array directly
                    },
                    dataType: 'json',
                    success: function(response) {
                        var $propertyFeature = $('#property_feature');
                        $propertyFeature.empty();

                        if (response.length > 0) {
                            $propertyFeature.append('<option value="">Please select feature</option>');
                            response.forEach(function(item) {
                                $propertyFeature.append(
                                    $('<option>', {
                                        value: item.id,
                                        text: item.room_type
                                    })
                                );
                            });
                        } else {
                            $propertyFeature.append('<option value="">No Features Found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }
                });
            } else {
                $('#property_feature').empty().append('<option value="">Select Property Type</option>');
            }
        });
    });
</script>