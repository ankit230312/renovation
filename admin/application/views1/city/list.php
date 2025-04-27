<div class="modal fade" id="city_bulk_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?=base_url("city/bulk_import")?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">city Bulk Import &nbsp;&nbsp;&nbsp;<a href="<?=base_url("sample/city.csv")?>" class="btn btn-sm btn-light">Sample</a></h4>
                </div>
                <div class="modal-body">
                    <h5 class="text-danger" id="import_error"></h5>
                    <div class="form-group">
                        <label>File (only csv as per sample) <span class="text-danger">*</span> : </label>
                        <input class="form-control" name="file" id="file" type="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">UPLOAD</button>
                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("city")?>">City</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("city/add")?>"><i class="zmdi zmdi-plus"></i> Add</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-success" href="#city_bulk_modal" data-toggle="modal" data-target="#city_bulk_modal">Bulk Import</a></h2></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>city</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($city as $p){ $secret = md5($p->id);?>
                                    <tr>
                                        <td><?=$p->id?></td>
                                        <td><?=wordwrap($p->title,25,"<br>\n")?></td>
                                        <td><?php if ($p->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>
                                        <td>
                                            <ul class="header-dropdown" style="list-style: none">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle btn btn-round btn-sm" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Action </a>
                                                    <ul class="dropdown-menu slideUp">
                                                        <li><a href="<?=base_url("city/edit/$p->id/")?>">Edit</a></li>
                                                        <li><a onclick="return confirm('Are you sure you want to delete this ?');" href="<?=base_url("city/delete/$p->id/$secret")?>">Delete</a></li>
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