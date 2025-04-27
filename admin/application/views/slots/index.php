<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Slots</li>
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
                            <!-- <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Opening Hour <span class="text-danger">*</span> :</label><br>
                                        <input type="text" name="opening_time" id="timepicker" class="form-control timepicker" value="<?php echo (!empty($schedule) &&  $schedule->opening_time != "" ) ?  date("h:i A",strtotime( $schedule->opening_time )) :  ""; ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Closing Hour<span class="text-danger">*</span> :</label>
                                        <br>
                                        <input type="text" name="closing_time" class="form-control timepicker" value="<?php echo (!empty($schedule) && $schedule->closing_time != "") ?  date("h:i A",strtotime( $schedule->closing_time )) :  ""; ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Interval(Min) <span class="text-danger">*</span> :</label>
                                        <select name="interval" class="form-control ">
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 05) { echo "selected"; } ?> >05</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 10) { echo "selected"; } ?> >10</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 15) { echo "selected"; } ?> >15</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 20) { echo "selected"; } ?> >20</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 25) { echo "selected"; } ?> >25</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 30) { echo "selected"; } ?> >30</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 60) { echo "selected"; } ?> >60</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 120) { echo "selected"; } ?> >120</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 180) { echo "selected"; } ?> >180</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 240) { echo "selected"; } ?> >240</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3"></label>
                                    <div class="col-md-9">
                                        <div class="form-group form-button">
                                            <input type="submit" name="savecat" value="Save" class="btn btn-fill btn-warning" />
                                        </div>
                                    </div>
                                </div>
                            </div> myTable-->
                            <table class="table table-sm dataTable " id="">
                                <thead>
                                    <tr>
                                        <th>City Name <span class="text-danger">*</span> </th>
                                        <th>Max Order Count<span class="text-danger">*</span> </th>
                                        <th>Opening Hour <span class="text-danger">*</span>  </th>
                                        <th>Closing Hour <span class="text-danger">*</span> </th>
                                        <th>Interval(Min) <span class="text-danger">*</span>  </th>
                                </thead>
                                <tbody>
                                    <?php $cnt =0;?>
                                    <?php  foreach($city as $key => $c){$cnt = $key;
                                    $schedule =$this->home_m->get_single_row_where('time_slots',array('city_id'=>$c->id));
                                    ?>
                                    <tr>
                                        <td><?=$c->title?></td>
                                        <td><input type="text" class="form-control " value="<?php echo (!empty($schedule) &&  $schedule->max_order != "" ) ? $schedule->max_order :  0; ?>" name="max_order<?=$key?>"></td>
                                        <input type="hidden" name="city_id<?=$key?>" value="<?=$c->id?>">
                                        <td><input type="text"id="timepicker" class="form-control timepicker" value="<?php echo (!empty($schedule) &&  $schedule->opening_time != "" ) ?  date("h:i A",strtotime( $schedule->opening_time )) :  date("h:i A",strtotime( '07:00' )); ?>" name="opening_time<?=$key?>"></td>
                                        <td><input type="text" class="form-control timepicker" value="<?php echo (!empty($schedule) &&  $schedule->closing_time != "" ) ?  date("h:i A",strtotime( $schedule->closing_time )) :  date("h:i A",strtotime( '21:00' )); ?>" name="closing_time<?=$key?>"></td>
                                        <td>
                                            <select name="interval<?=$key?>" class="form-control ">
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 05) { echo "selected"; } ?> >05</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 10) { echo "selected"; } ?> >10</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 15) { echo "selected"; } ?> >15</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 20) { echo "selected"; } ?> >20</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 25) { echo "selected"; } ?> >25</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 30) { echo "selected"; } ?> >30</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 60) { echo "selected"; } ?> >60</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 120) { echo "selected"; } ?> >120</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 180) { echo "selected"; } ?> >180</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 240) { echo "selected"; } ?> >240</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                    <tr>
                                        <td colspan="8">
                                                    <button type="submit" class="btn btn-default btn-round">
                                                        <i class="zmdi zmdi-check-circle"></i> Save
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-round">
                                                        <i class="zmdi zmdi-replay"></i> Cancel
                                                    </button>
                                            
                                        </td>
                                    </tr>
                                <tfoot>
                                    
                                </tfoot>
                            </table>
                            <input type="hidden" name="counter" value="<?=$cnt?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Input -->
    </div>
</section>