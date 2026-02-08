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
                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?= base_url("Items") ?>"><i
                                class="zmdi zmdi-arrow-back"></i> List</a></h2>
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
                                    <input class="form-control" required type="text" name="product_name"
                                        placeholder="Enter Society Title">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Description </label>
                                    <textarea class="form-control" type="text" name="use"
                                        placeholder="Enter Description"></textarea>
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
                                        <select class="form-control" style="width: 100%;" name="property_type[]"
                                            id="property_type" multiple>

                                        </select>
                                    </div>
                                </div>
                            </div>



                            <!-- <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type Feature <span class="text-danger">*</span> :</label>
                                        <select class="form-control" style="width: 100%;" name="property_feature[]"
                                            id="property_feature" multiple>
                                            <
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <div id="property_feature_wrapper"></div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Product Accessory <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="product_acc" id="product_acc">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
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
                                            <p class="text-muted">Please select an accessory category</p>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>



                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Images <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="file" name="product_image[]" multiple>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Price </label>
                                    <input class="form-control" required type="text" id='product_price'
                                        name="product_price" placeholder="Enter Society Title">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Product Information</label>
                                    <textarea id="product_info" name="product_info" class="form-control" name="use"
                                        placeholder="Enter Description">

                                     </textarea>
                                </div>
                            </div>
                        </div>

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
                                    <button class="btn btn-default btn-round" type="submit"><i
                                            class="zmdi zmdi-check-circle"></i> Submit</button>
                                    <button class="btn btn-primary btn-round" type="reset"><i
                                            class="zmdi zmdi-replay"></i> Reset</button>
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








                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Input -->
    </div>
</section>
<!-- Load CKEditor Super Build -->
<!-- Load CKEditor Super Build FIRST -->


<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
                success: function (response) {
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
    $(document).ready(function () {
        let categoryID = $('#categories').val();
        if (categoryID != '') {
            $.ajax({
                url: '<?= base_url("category/get_subcategory/") ?>' + categoryID,
                method: 'GET',
                success: function (response) {
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
    $(document).ready(function () {
        let brandID = $('#brand').val();
        if (brandID != '') {

        }
        $.ajax({
            url: '<?= base_url("brand/get_brand/") ?>' + brandID,
            method: 'GET',
            success: function (response) {
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
    $(document).ready(function () {
        $("#categories").select2();
        $("#subcategories").select2();
        $("#property_type").select2();
        // $("#property_feature").select2();

        $(".property_feature_select").select2();
    });
</script>

<script>
    $(document).ready(function () {
        $('#product_dep').change(function () {
            if ($(this).val() === 'Y') {
                $('#setVisible').slideDown(); // or use .show()
            } else {
                $('#setVisible').slideUp(); // or use .hide()
            }
        });

        // Trigger change on page load to handle default value
        $('#product_dep').trigger('change');
    });

    $(document).ready(function () {
        $('#product_acc').change(function () {
            if ($(this).val() === '1') {
                $('#setAccessory').slideDown(); // or use .show()
            } else {
                $('#setAccessory').slideUp(); // or use .hide()
            }
        });

        // Trigger change on page load to handle default value
        $('#product_acc').trigger('change');
    });
</script>


<!-- <script>
    $(document).ready(function () {

        $('#property_type').on('change', function () {

            let societyId = $('#society_id').val();
            let propertyTypes = $(this).val(); // ARRAY
            let $wrapper = $('#property_feature_wrapper');

            $wrapper.empty();

            if (!propertyTypes || propertyTypes.length === 0) {
                return;
            }

            propertyTypes.forEach(function (typeId) {

                $.ajax({
                    url: '<?= site_url("Items/get_floor_type_feature") ?>',
                    type: 'POST',
                    data: {
                        society_id: societyId,
                        property_type_id: typeId
                    },
                    dataType: 'json',
                    success: function (response) {

                        let html = `
                        <div class="form-group">
                            <label>Features for Property Type ${typeId}</label>
                            <select class="form-control"
                                    name="property_feature[${typeId}][]"
                                    multiple>
                    `;

                        if (response.length > 0) {
                            response.forEach(function (item) {
                                html += `<option value="${item.id}">${item.room_type}</option>`;
                            });
                        }

                        html += `
                            </select>
                        </div>
                    `;

                        $wrapper.append(html);
                    }
                });
            });
        });

    });
</script> -->

<script>
    $(document).ready(function () {
        $('#society_id').on('change', function () {
            var societyId = $(this).val();

            if (societyId !== '') {
                $.ajax({
                    url: '<?= site_url("Items/get_floor_type/") ?>', // Adjust controller name
                    type: 'POST',
                    data: {
                        society_id: societyId
                    },
                    dataType: 'json',
                    success: function (response) {
                        var $propertyType = $('#property_type');
                        $propertyType.empty(); // Clear existing options

                        if (response.length > 0) {
                            // Add default option
                            $propertyType.append('<option value="">Please select type</option>');

                            // Add fetched options
                            response.forEach(function (item) {
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
                    error: function (xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }
                });
            } else {
                $('#property_type').empty().append('<option value="">Select Society First</option>');
            }
        });
    });



    $(document).ready(function () {

        $('#property_type').on('change', function () {

            let societyId = $('#society_id').val();
            let propertyTypes = $(this).val(); // ARRAY
            let $wrapper = $('#property_feature_wrapper');

            $wrapper.empty();

            if (!propertyTypes || propertyTypes.length === 0) {
                return;
            }

            propertyTypes.forEach(function (typeId) {

                $.ajax({
                    url: '<?= site_url("Items/get_floor_type_feature") ?>',
                    type: 'POST',
                    data: {
                        society_id: societyId,
                        property_type_id: typeId
                    },
                    dataType: 'json',
                    success: function (response) {

                        let html = `
                <div class="form-group">
                    <label>Features for Property Type ${typeId}</label>
                    <select class="form-control property_feature_select"
                            name="property_feature[${typeId}][]"
                            multiple>
                `;

                        if (response.length > 0) {
                            response.forEach(function (item) {
                                html += `<option value="${item.id}">${item.room_type}</option>`;
                            });
                        }

                        html += `
                    </select>
                </div>
                `;

                        $wrapper.append(html);

                        // 🔥 THIS IS THE ONLY UI CHANGE
                        $wrapper.find('.property_feature_select').last().select2({
                            placeholder: 'Select features',
                            width: '100%'
                        });
                    }
                });
            });
        });


    });
</script>

<script>
    $(document).ready(function () {

        $('#accessory_category_id').on('change', function () {

            let category_id = $(this).val();

            if (category_id === '') {
                $('#accessory_list').html(
                    '<p class="text-muted">Please select an accessory category</p>'
                );
                return;
            }

            $.ajax({
                url: '<?= base_url("Items/get_accessories"); ?>',
                type: 'POST',
                data: { category_id: category_id },
                success: function (response) {
                    $('#accessory_list').html(response);
                }
            });

        });

    });
</script>