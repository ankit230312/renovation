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
                                    <input  class="form-control" value="<?=$products->product_name?>" required type="text"  name="product_name" placeholder="Enter Product Title">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Use  :</label>
                                        <textarea class="form-control"  name="use" placeholder="Enter Use Of Product"><?=$products->use?></textarea>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Benefits :</label>
                                        <textarea class="form-control"  name="benefit" placeholder="Enter Product Benefits"><?=$products->benefit?></textarea>
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
                                <img src="<?=base_url("uploads/products/$products->product_image")?>" style="height: 100px;max-width: 100%">
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
                                        <option value="Y" <?php if ($products->in_stock == 'Y'){echo "selected";}?>>Active</option>
                                        <option value="N" <?php if ($products->in_stock == 'N'){echo "selected";}?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Brand <span class="text-danger">*</span> :</label>
                                  
                                    <select class="form-control" name="brand_id" >
                                    <option value="">Select Brand</option>
                                        <?php foreach ($brand as $b) {   ?>
                                            <option value="<?= $b->brandID ?>"><?= $b->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>MRP <span class="text-danger">*</span> :</label>
                                    <input class="form-control" value="<?=$products->retail_price?>" required type="number" step="0.01"  name="retail_price" placeholder="Enter MRP">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Selling Price <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" value="<?=$products->price?>" step="0.01"  name="price" placeholder="Enter Selling Price">
                                </div>
                            </div>
                        </div> 
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Weight / Qty <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="text" value="<?=$products->unit_value?>" name="unit_value" placeholder="Enter Unit Value">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Unit <span class="text-danger">*</span> :</label>
                                    <select class="form-control" required name="unit">
                                        <option <?php if (strtoupper($products->unit) == 'PC' ){echo "selected";}?>>PC</option>
                                        <option <?php if (strtoupper($products->unit) == 'KG' ){echo "selected";}?>>KG</option>
                                        <option <?php if (strtoupper($products->unit) == 'GM' ){echo "selected";}?>>GM</option>
                                        <option <?php if (strtoupper($products->unit) == 'ML' ){echo "selected";}?>>ML</option>
                                        <option <?php if (strtoupper($products->unit) == 'Litre' ){echo "selected";}?>>Litre</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                         <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Weight :</label>
                                    <input class="form-control" type="text" name="weight" value="<?=$products->weight?>" placeholder="eg; 500 - 600 GRAMS">
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
                         <div class="col-sm-12">
                         <div class="form-group">
                         <label>Max Quantity<span class="text-danger">*</span> :</label>
                         <input class="form-control" required type="number" name="max_quantity" value="<?=$products->max_quantity?>" >
                            </div>
                           </div>
                         </div>

                         <div class="row clearfix">
                            <div class="col-sm-12">

                         <div class="form-group">
                         <label>Priority<span class="text-danger">*</span> :</label>
                         <input class="form-control" required type="number" name="priority" value="<?=$products->priority?>" >
                            </div>
                           </div>
                         </div>

                          <div class="row clearfix">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Add Tags <span class="text-danger">*</span> :</label><br/>
                                <input type="text" value="<?=$products->tags?>" name="tags" data-role="tagsinput" class="form-control" />

                              </div>
                            </div>
                          </div>


                        <!-- <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Stock Qty <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" step="1"  name="stock_count" value="<?=$products->stock_count?>" placeholder="Enter Product Selling Price">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cost Price <span class="text-danger">*</span> :</label>
                                    <input class="form-control" required type="number" step="0.01"  name="cost_price" value="<?=$products->cost_price?>" placeholder="Enter Product Cost Price">
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

<script>
    $(document).ready(function () {
       $("#categories").select2();
      $("#subcategories").select2();
    });
 </script>