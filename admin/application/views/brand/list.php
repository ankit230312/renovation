<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <!-- <h2><?=$title?></h2> -->

                    <h2>Category</h2>

                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("brand")?>">Category</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("category/brand_management")?>">Category Type Management</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("brand/brand_management/add")?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>Proprty Type Id</th>
                                   
                                    <th>Title</th>
                                 
                                    <!-- <th>Image</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($category as $s){ $secret = md5($s->brandID);
                                    // echo "<pre>";
                                    // print_r($category);
                                    // die;
                                    ?>
                                    <tr>
                                        <td><?=$s->brandID?></td>
                                      
                                        <td><?=$s->title?></td>
                                      
                                        <!-- <td><img style="height: 50px;width: 50px;" src="<?=base_url("uploads/brand/$s->image")?>"></td> -->
                                        <td><?php if ($s->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>
                                        <td>
                                            <ul class="header-dropdown" style="list-style: none">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle btn btn-round btn-sm" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Action </a>
                                                    <ul class="dropdown-menu slideUp">
                                                        <li><a href="<?=base_url("brand/brand_management/edit/$s->brandID")?>">Edit</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>