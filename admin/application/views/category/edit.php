<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("category")?>">Category</a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("category/category_management")?>">Category Management</a></li>

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

                    <h2 class="text-left"><a class="btn btn-sm btn-primary" href="<?=base_url("category/category_management/list")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

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

                                    <input type="text" class="form-control" value="<?=$category->title?>" required name="title" placeholder="Enter Tile for Category" />

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Change Icon :</label>
                                    <img src="<?=base_url("uploads/category/$category->icon")?>" style="height: 50px;max-width: 50%">
                                    <input type="file" accept="image/*" class="form-control" name="icon"/>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Change Image :</label>
                                    <img src="<?=base_url("uploads/category/$category->image")?>" style="height: 80px;max-width: 80%">
                                    <input type="file" accept="image/*" class="form-control" name="image"/>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Description <span class="text-danger">*</span> :</label>

                                    <textarea class="form-control" name="description" required><?=$category->description?></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Parent Category :</label>

                                    <select class="form-control" name="parent" id="parent" required>

                                        <option value="0">No Parent</option>

                                        <?php foreach($par_category as $c){?>

                                            <option value="<?=$c->categoryID?>" <?= ($category->parent == $c->categoryID) ? 'selected' : '' ?>><?=$c->title?></option>

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

                                        <option value="Y" <?= ($category->status == 'Y') ? 'selected' : '' ?>>Active</option>

                                        <option value="N" <?= ($category->status == 'N') ? 'selected' : '' ?>>InActive</option>

                                    </select>

                                </div>

                            </div>

                        </div>
                        <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Off Upto</label>

                                        <input type="text" class="form-control" name="off_upto" value="<?=$category->off_upto?>" placeholder="Enter Off Upto" />

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
    $(document).ready(function () {
        //user
       $("#parent").select2();
    });
 </script>