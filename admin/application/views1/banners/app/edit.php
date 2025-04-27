<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("banners")?>">Banners</a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("banners/app_banners")?>">App Banners</a></li>

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

                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?=base_url("banners/app_banners/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                </div>

                <div class="body">

                    <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                    <?php }?>

                    <form method="post" enctype="multipart/form-data">

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Change Banner :</label>

                                    <input class="form-control" type="file" name="banner">
                                    Size :(1024*500)

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Priority <span class="text-danger">*</span> :</label>

                                    <input value="<?=$banners->priority?>" class="form-control" required type="number" name="priority" placeholder="Enter priority">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Type :</label>
                                        <select class="form-control" onchange="get_categoryProducts(event)" name="type" id="type"> 
                                        <option value="category" <?= ($banners->type == 'category') ? 'selected' : '' ?>>Category</option>
                                        <option value="subcategory" <?= ($banners->type == 'subcategory') ? 'selected' : '' ?>>SubCategory</option>
                                          <option value="deal" <?= ($banners->type == 'deal') ? 'selected' : '' ?>>Deal</option>
                                        <option value="product" <?= ($banners->type == 'product') ? 'selected' : '' ?>>Product</option>
                                        </select>
                                    </div>
                                </div>

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Category/Subcategory/Deal/Product <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="categoryID" id="categoryID" required>

                                        <?php foreach ($category as $c){?>

                                            <option value="<?=$c->categoryID?>" <?php if ($c->categoryID == $banners->categoryID){echo "selected";}?>><?=$c->title?></option>

                                        <?php }?>

                                        <?php
                                               if($banners->type == 'category'){
                                                 foreach ($category as $c){
                                                ?>
                                                <option value="<?=$c->categoryID?>" <?php if ($c->categoryID == $banners->categoryID){echo "selected";}?>><?=$c->title?></option>

                                              <?php } }
                                               elseif($banners->type == 'subcategory'){
                                              foreach($all_subcategory as $c){?>

                                                <option value="<?=$c->categoryID?>" <?php if($c->categoryID==$banners->categoryID){ echo "selected"; } ?>><?=$c->title?></option>

                                            <?php }}elseif($banners->type == 'product'){ 
                                                  foreach($all_products as $c){
                                                ?>
                                                 <option value="<?=$c->productID?>" <?php if($c->productID==$banners->categoryID){ echo "selected"; } ?>><?=$c->product_name?></option>

                                           <?php } }else{?>
                                                     <option value="0">select</option>
                                          <?php }?>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Status <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="status" required>

                                        <option value="Y" <?php if ($banners->status == 'Y'){echo "selected";}?>>Active</option>

                                        <option value="N" <?php if ($banners->status == 'N'){echo "selected";}?>>InActive</option>

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
    function get_categoryProducts(e) {
        e.preventDefault();
        let type  = $('#type').val();
        if (type != '')
        {
            $.ajax({
                url: '<?php echo base_url(); ?>/banners/get_categoryProducts',
                type: 'POST',
                data: {type:type},
                success: function (response) {
                    //alert(response);
                   let subparent = JSON.parse(response);
                    let i;
                    let option = '';
                    option += '<option value="0">select</option>';
                    for (i in subparent)
                    {
                        // option += '<option value="'+subparent[i]['productID']+'">'+subparent[i]['product_name']+'</option>';
                        // option += '<option value="'+subparent[i]['categoryID']+'">'+subparent[i]['title']+'</option>';
                        if(type=='category'){
                        option += '<option value="'+subparent[i]['categoryID']+'">'+subparent[i]['title']+'</option>';
                        }
                        if(type=='subcategory'){
                            option += '<option value="'+subparent[i]['categoryID']+'">'+subparent[i]['title']+'</option>';
                        }
                        // if(type=='deal'){
                        //     option += '<option value="'+subparent[i]['dealID']+'">'+subparent[i]['dealID']+'</option>';
                        // }
                        if(type=='product'){
                            option += '<option value="'+subparent[i]['productID']+'">'+subparent[i]['product_name']+'</option>';
                        }

                    }
                    $('#categoryID').html(option);
                    $('#categoryID').selectpicker('refresh');
                }
            });
        }
    }
</script> 

<script>
    $(document).ready(function () {
      $("#type").select2();
       $("#categoryID").select2();

    });
 </script>
