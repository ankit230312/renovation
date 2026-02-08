<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <!-- <li class="breadcrumb-item"><a href="<?= base_url("society") ?>">Product</a></li> -->
                        <li class="breadcrumb-item active">Edit</li>
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

                                    <label>Product Title <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="text" name="product_name" value="<?php echo $products->product_name ?>" placeholder="Enter Society Title">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Description </label>
                                    <textarea class="form-control" type="text" name="use" placeholder="Enter Description"><?php echo $products->product_description ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Category <span class="text-danger">*</span> :</label>
                                    <select class="form-control" id="cateogry_id" name="cateogry_id">

                                        <option value="<?= $item_category->categoryID ?>"><?= $item_category->title ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Product Dependent <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="product_dep" id="product_dep">
                                        <option value="N" <?= (isset($products->isDependent) && $products->isDependent == 'N') ? 'selected' : '' ?>>No</option>
                                        <option value="Y" <?= (isset($products->isDependent) && $products->isDependent == 'Y') ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>








                        <div id="setVisible" style="display: none;">
                            <!-- <div id="setVisible"> -->
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Society <span class="text-danger">*</span> :</label>
                                        <select class="form-control" id="society_id" name="society_id" disabled>
                                            <?php 
                                            $society_data = $this->db->get_where('products', ['productID' => $products->society_id])->row();
                                            if ($society_data) {
                                                echo '<option value="' . $society_data->productID . '" selected>' . $society_data->product_name . '</option>';
                                            } else {
                                                echo '<option value="">Select Society</option>';
                                            }
                                            ?>
                                        </select>
                                        <!-- Hidden input to submit the value since disabled fields don't submit -->
                                        <input type="hidden" name="society_id" value="<?= $products->society_id ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type <span class="text-danger">*</span> :</label>
                                        <select class="form-control" style="width: 100%;" name="property_type" id="property_type" disabled>
                                            <?php 
                                            $floor_type = $this->db->get_where('floor_type', ['floor_id' => $products->property_type_id])->row();
                                            if ($floor_type) {
                                                echo '<option value="' . $floor_type->floor_id . '" selected>' . $floor_type->floor_type . '</option>';
                                            } else {
                                                echo '<option value="">Please select type</option>';
                                            }
                                            ?>
                                        </select>
                                        <!-- Hidden input to submit the value since disabled fields don't submit -->
                                        <input type="hidden" name="property_type" value="<?= $products->property_type_id ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type Feature <span class="text-danger">*</span> :</label>
                                        <select class="form-control" style="width: 100%;" name="property_feature[]" id="property_feature" multiple disabled>
                                            <?php 
                                            if (isset($products->property_feature_id) && !empty($products->property_feature_id)) {
                                                $feature_ids = explode(',', $products->property_feature_id);
                                                foreach ($feature_ids as $feature_id) {
                                                    $feature = $this->db->get_where('floor_dimensions', ['id' => trim($feature_id)])->row();
                                                    if ($feature) {
                                                        echo '<option value="' . $feature->id . '" selected>' . $feature->room_type . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <!-- Hidden inputs to submit the values since disabled fields don't submit -->
                                        <?php 
                                        if (isset($products->property_feature_id) && !empty($products->property_feature_id)) {
                                            $feature_ids = explode(',', $products->property_feature_id);
                                            foreach ($feature_ids as $feature_id) {
                                                echo '<input type="hidden" name="property_feature[]" value="' . trim($feature_id) . '">';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Product Accessory <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="product_acc" id="product_acc" required>
                                        <option value="0" <?= (isset($products->isAccessory) && $products->isAccessory == 0) ? 'selected' : '' ?>>No</option>
                                        <option value="1" <?= (isset($products->isAccessory) && $products->isAccessory == 1) ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="setAccessory"
                            style="display:none; border:1px solid #eee; padding:15px; border-radius:6px;">

                            <h5 class="mb-3">Accessory Details</h5>

                            <!-- Accessory Category -->
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Accessory Category <span class="text-danger">*</span></label>
                                        <select class="form-control" id="accessory_category_id"
                                            name="accessory_category_id">
                                            <option value="">Select Accessory Category</option>
                                            <?php foreach ($accessories_category as $at) { ?>
                                                <option value="<?= $at->category_id ?>">
                                                    <?= $at->title ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Accessories <span class="text-danger">*</span></label>

                                        <div id="accessory_list" class="pl-2">
                                            <?php 
                                            if (isset($selected_accessories) && !empty($selected_accessories)) {
                                                echo '<p class="text-success">Current accessories loaded</p>';
                                            } else {
                                                echo '<p class="text-muted">Please select an accessory category</p>';
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Images <span class="text-danger">*</span> :</label>
                                    <p class="text-muted small">Leave empty to keep existing images</p>
                                    <input class="form-control" type="file" name="product_image[]" multiple>
                                    
                                    <?php if (isset($products->product_image) && !empty($products->product_image)) { ?>
                                        <div class="mt-3">
                                            <label>Current Images:</label>
                                            <div class="row">
                                                <?php 
                                                $images = array_filter(explode(',', $products->product_image));
                                                foreach ($images as $img) { 
                                                ?>
                                                    <div class="col-md-3 col-sm-4 mb-3">
                                                        <div class="card" style="border: 1px solid #ddd;">
                                                            <img src="<?= base_url('uploads/items/' . trim($img)) ?>" 
                                                                 alt="Product Image" 
                                                                 class="card-img-top" 
                                                                 style="height: 150px; object-fit: cover;">
                                                         
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Price </label>
                                    <input class="form-control" required type="text" id='product_price' name="product_price" placeholder="Enter Society Title"

                                        value="<?php echo $products->price ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Information</label>
                                    <textarea id="product_info" name="product_info" class="form-control"
                                        placeholder="Enter Description"><?= isset($products->long_desc) ? htmlspecialchars($products->long_desc) : '' ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Status <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="status" required>
                                        <option value="active" <?= $products->status == 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= $products->status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector("#product_info"), {
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'blockQuote', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'insertTable', '|',
                    'removeFormat', 'sourceEditing'
                ],
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                }
            })
            .then(editor => {
                console.log('✅ CKEditor loaded successfully');
                window.editor = editor;
            })
            .catch(err => console.error('❌ CKEditor initialization error:', err));
    });
</script>

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
                $('#setVisible').slideDown();
            } else {
                $('#setVisible').slideUp();
            }
        });

        $('#product_dep').trigger('change');
    });

    $(document).ready(function() {
        $('#product_acc').change(function() {
            if ($(this).val() === '1') {
                $('#setAccessory').slideDown();
            } else {
                $('#setAccessory').slideUp();
            }
        });

        $('#product_acc').trigger('change');
    });
</script>



<script>
    // Disabled in edit mode - Society, Property Type and Features are pre-selected and cannot be changed
    /*
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
    */
</script>

<script>
    $(document).ready(function() {

        $('#accessory_category_id').on('change', function() {

            let category_id = $(this).val();
            let productId = '<?= isset($products->productID) ? $products->productID : '' ?>';

            if (category_id === '') {
                $('#accessory_list').html(
                    '<p class="text-muted">Please select an accessory category</p>'
                );
                return;
            }

            $.ajax({
                url: '<?= base_url("Items/get_accessories"); ?>',
                type: 'POST',
                data: { 
                    category_id: category_id,
                    product_id: productId 
                },
                success: function(response) {
                    $('#accessory_list').html(response);
                }
            });

        });

        // Load accessories on page load if product has accessories
        var isAccessory = $('select[name="product_acc"]').val();
        if (isAccessory === '1') {
            var savedCategory = $('#accessory_category_id').val();
            if (savedCategory) {
                $('#accessory_category_id').trigger('change');
            }
        }

    });
</script>