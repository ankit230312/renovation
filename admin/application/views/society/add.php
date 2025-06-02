<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?= $title ?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("society") ?>">Society</a></li>
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
                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?= base_url("society") ?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)) { ?>
                        <h2 class="title text-danger"><?= $error ?></h2>
                    <?php } ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity Title <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="text" name="product_name" placeholder="Enter Product Title">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity Description 1</label>
                                    <textarea class="form-control" type="text" name="use" placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Benefits :</label>
                                    <textarea class="form-control" type="text" name="benefit" placeholder="Enter benefits of Products"></textarea>
                                </div>
                            </div>
                        </div> -->
                     
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity Description <span class="text-danger">*</span> :</label>
                                    <textarea class="form-control" required name="product_description" placeholder="Enter Product Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity Image <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="file" name="product_image">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Socity Category <span class="text-danger">*</span> :</label>
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
                                    <label>Socity SubCategories <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="category_id[]" id="subcategories" required multiple>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php


                        ?>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity Status <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="in_stock" required>
                                        <option value="Y">Active</option>
                                        <option value="N">InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> Proprty Type <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="brand_id">
                                    <option value="">Select Proprty Type</option>
                                        <?php foreach ($brand as $b) {   ?>
                                            <option value="<?= $b->brandID ?>"><?= $b->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity MRP <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" step="0.01" name="retail_price" placeholder="Enter MRP">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Socity Selling Price <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" step="0.01" name="price" placeholder="Enter Selling Price">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Weight / Qty <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" name="unit_value" placeholder="Enter Weight / Qty">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Unit <span class="text-danger">*</span> :</label>
                                    <select class="form-control" required name="unit">
                                        <option>PC</option>
                                        <option>KG</option>
                                        <option>GM</option>
                                        <option>ML</option>
                                        <option>Litre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Weight :</label>
                                    <input class="form-control" type="text" name="weight" placeholder="eg; 500 - 600 GRAMS">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Featured <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="featured" required>
                                        <option value="Y">Yes</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Max Quantity <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" name="max_quantity" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Stock Qty <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" step="1" name="stock_count" value="0" placeholder="Enter Product Selling Price">
                                </div>
                                <div class="form-group">
                                    <label>Product Type <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="vegtype" required>
                                        <option value="V"> Veg </option>
                                        <option value="N"> Non Veg </option>
                                        <option value="E"> Eggtarian </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cost Price <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" step="0.01" name="cost_price" value="0" placeholder="Enter Product Cost Price">
                                </div>
                                <div class="form-group">
                                    <label>Priority<span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" name="priority" value="0">
                                </div>
                            </div>

                        </div> -->
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Add Tags <span class="text-danger">*</span> :</label><br />
                                    <input type="text" value="" name="tags" data-role="tagsinput" class="form-control" />
                                    <div id="tags">
                                        
                                          <input type="text" value=""  placeholder="Add a tags with enter"/>
                                        </div>
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
    });
</script>