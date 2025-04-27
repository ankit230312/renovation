<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Schedule Hour</li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        <!-- Input -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    
                    <div class="body">
                        <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                        <?php }?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                        </div>
                                        <input type="text" name="date" class="form-control datetimepicker" placeholder="Please choose start date & time...">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                        </div>
                                        <input type="text" name="start_date" class="form-control datetimepicker" placeholder="Please choose end date & time...">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Hour <span class="text-danger">*</span> :</label><br>
                                        <input type="text" name="opening_time" class="form-control timepicker"  />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Hour<span class="text-danger">*</span> :</label>
                                        <br>
                                        <input type="text" name="closing_time" class="form-control timepicker"  />
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="submit" name="addcatg" value="Add"  class="btn btn-default btn-round"  />
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

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                   <div class="body">
                    <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th class="text-center">Start Date</th>
                                        <th class="text-center">Closing Date</th>
                                        <th class="text-center">From - To</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Closing Date</th>
                                        <th class="text-center">From - To</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach($schedule as $time){ ?>
                                    <tr>
                                        <td class="text-center"><?php echo $time->start_date; ?></td>
                                        <td class="text-center"><?php echo $time->date; ?></td>
                                        <td class="text-center"><?php echo date("h:i A",strtotime($time->from_time))." to ".date("h:i A",strtotime($time->to_time)); ?></td>
                                        <td class="td-actions text-center"><div class="btn-group">
                                        <?php echo anchor('schedule_hour/delete_closing_date/'.$time->id,  '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                            <i class="material-icons">close</i>
                                                            </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                                
                                                </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    
                   </div>
                </div>
            </div>
        </div>

    </div>
</section>
