<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("products")?>">Products</a></li>
                        <li class="breadcrumb-item active">Add Variants</li>
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
                                        <label>Image <span class="text-danger">*</span> :</label>
                                        <input class="form-control" type="file" name="product_image">
                                    </div>
                                </div>
                                <span><img src="<?php echo base_url('uploads/variants/').$variant_image; ?>" height="50px" width="50px"></span>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span> :</label>
                                        <select class="form-control" name="in_stock" required>
                                        <option value="Y" <?php if ($in_stock == 'Y'){echo "selected";}?>>Active</option>
                                        <option value="N" <?php if ($in_stock == 'N'){echo "selected";}?>>Inactive</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>MRP <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="number" step="0.01"  name="retail_price" placeholder="Enter MRP" value="<?php echo $retail_price; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Selling Price <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="number" step="0.01"  name="price" placeholder="Enter Selling Price" value="<?php echo $price; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Weight / Qty <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="number" name="unit_value" placeholder="Enter Weight / Qty" value="<?php echo $unit_value; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Unit <span class="text-danger">*</span> :</label>
                                        <select class="form-control" required name="unit" value="<?php echo $unit; ?>">
                                        <option <?php if (strtoupper($unit) == 'PC' ){echo "selected";}?>>PC</option>

                                        <option <?php if (strtoupper($unit) == 'KG' ){echo "selected";}?>>KG</option>

                                        <option <?php if (strtoupper($unit) == 'GM' ){echo "selected";}?>>GM</option>
                                        <option <?php if (strtoupper($unit) == 'Half' ){echo "selected";}?>>Half</option>
                                        <option <?php if (strtoupper($unit) == 'Full' ){echo "selected";}?>>Full</option>

                                        <option <?php if (strtoupper($unit) == 'ML' ){echo "selected";}?>>ML</option>

                                        <option <?php if (strtoupper($unit) == 'Litre' ){echo "selected";}?>>Litre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Cost Price <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="number" step="0.01"  name="cost_price" placeholder="Enter Product Cost Price" value="<?php echo $cost_price; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="hidden_image" value="<?php echo $variant_image; ?>">
                                        <button class="btn btn-default btn-round" type="submit"><i class="zmdi zmdi-check-circle"></i>Update</button>
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
                        option += '<option value="'+subcategory[i]['categoryID']+'">'+subcategory[i]['title']+'</option>';
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
                       option += '<option value="'+subcategory[i]['categoryID']+'">'+subcategory[i]['title']+'</option>';
                   }
                   //alert(option);
                   $('#subcategories').html(option);
                   $('#subcategories').selectpicker('refresh');
               }
            });
        }
    });
</script>