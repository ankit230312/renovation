<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("products")?>">Products</a></li>
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
                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?=base_url("products")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>
                </div>
                <div class="body">
                    <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                    <?php }?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span> :</label>
                                    <input class="form-control" value="<?=$products->product_name?>" required type="text"  name="product_name" placeholder="Enter Product Title">
                                </div>
                            </div>
                        </div>
                                     <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Use :</label>
                                        <textarea class="form-control"  type="text"  name="use" placeholder="Enter Use of Products"><?=$products->use?></textarea>
                                    </div>
                                </div>
                            </div>
                              <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Benefits  :</label>
                                        <textarea class="form-control"  type="text" name="benefits" placeholder="Enter benefits of Products"><?=$products->benefit?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Storage :</label>
                                        <input class="form-control" type="text" value="<?=$products->storage?>"  name="storage" placeholder="Enter Products Storage">
                                    </div>
                                </div>
                            </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span> :</label>
                                    <textarea class="form-control" required name="product_description" placeholder="Enter Product Description"><?=$products->product_description?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Change Image :</label>
                                    <input class="form-control" type="file" name="product_image">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span> :</label>
                                    <select class="form-control" onchange="get_subcategories(event)" id="categories">
                                        <?php foreach ($category as $c){?>
                                            <option value="<?=$c->categoryID?>" <?= ($selected_category->parent == $c->categoryID) ? 'selected' : '' ?>><?=$c->title?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>SubCategories <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="category_id[]" id="subcategories" required multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="in_stock" required>
                                        <option value="Y" <?php if ($products->in_stock == 'Y'){echo "selected";}?>>In Stock</option>
                                        <option value="N" <?php if ($products->in_stock == 'N'){echo "selected";}?>>Out of Stock</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>MRP <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" value="<?=$products->retail_price?>" step="0.01"  name="retail_price" placeholder="Enter Product MRP">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Selling Price <span class="text-danger">*</span> :</label>
                                    <input class="form-control" value="<?=$products->price?>" required type="number" step="0.01"  name="price" placeholder="Enter Product Selling Price">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Unit Value <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" value="<?=$products->unit_value?>" name="unit_value" placeholder="Enter Unit Value">
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Unit <span class="text-danger">*</span> :</label>
                                    <input style="text-transform: uppercase" class="form-control" value="<?=$products->unit?>" required type="text" name="unit" placeholder="Enter Unit like KG">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Featured <span class="text-danger">*</span> :</label>
                                    <select class="form-control" name="featured" required>
                                        <option value="Y" <?php if ($products->featured == 'Y'){echo "selected";}?>>Yes</option>
                                        <option value="N" <?php if ($products->featured == 'N'){echo "selected";}?>>No</option>
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
<?php
$selected_subcategories = $products->category_id;
?>
<script>
    let selected_subcategory = '<?=$selected_subcategories?>';
    selected_subcategory = selected_subcategory.split(',');
    function get_subcategories(e) {
        e.preventDefault();
        let categoryID  = $('#categories').val();
        if (categoryID != '')
        {
            $.ajax({
                url:'<?=base_url("category/get_subcategory/")?>'+categoryID,
                method:'GET',
                success:function (response) {
                    let subcategory = JSON.parse(response);
                    let i;
                    let option = '';
                    for (i in subcategory)
                    {
                        if (selected_subcategory.includes(subcategory[i]['categoryID'])){
                            option += '<option value="'+subcategory[i]['categoryID']+'" selected>'+subcategory[i]['title']+'</option>';
                        } else {
                            option += '<option value="'+subcategory[i]['categoryID']+'">'+subcategory[i]['title']+'</option>';
                        }
                    }
                    //alert(option);
                    $('#subcategories').html(option);
                    $('#subcategories').selectpicker('refresh');
                }
            });
        }
    }
    $(document).ready(function () {
        let categoryID  = $('#categories').val();
        if (categoryID != '')
        {
            $.ajax({
                url:'<?=base_url("category/get_subcategory/")?>'+categoryID,
                method:'GET',
                success:function (response) {
                    let subcategory = JSON.parse(response);
                    let i;
                    let option = '';
                    for (i in subcategory)
                    {
                        if (selected_subcategory.includes(subcategory[i]['categoryID'])){
                            option += '<option value="'+subcategory[i]['categoryID']+'" selected>'+subcategory[i]['title']+'</option>';
                        } else {
                            option += '<option value="'+subcategory[i]['categoryID']+'">'+subcategory[i]['title']+'</option>';
                        }
                    }
                    //alert(option);
                    $('#subcategories').html(option);
                    $('#subcategories').selectpicker('refresh');
                }
            });
        }
    });
</script>