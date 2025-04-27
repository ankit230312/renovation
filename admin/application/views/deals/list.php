<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("deals")?>">Deals</a></li>

                        <li class="breadcrumb-item active">List</li>

                    </ul>

                </div>

            </div>

        </div>

        <div class="row clearfix">

            <div class="col-lg-12">

                <div class="card">

                    <div class="header">

                        <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("deals/add")?>"><i class="zmdi zmdi-plus"></i> Add</a></h2>

                    </div>

                    <div class="body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">

                                <thead>

                                    <tr>

                                        <th>Image</th>
                                        <th>Status</th>

                                        <th>Product</th>

                                        <th>City</th>

                                        <th>MRP</th>

                                        <th>Price (old)</th>

                                        <th>Price (new)</th>

                                        <th>Start Date</th>

                                        <th>End Date</th>

                                        <th>Status</th>

                                        <th>Max Quantity</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($offers as $p){

                                        ?>

                                        <tr>

                                            <td><img src="<?=base_url("uploads/products/$p->product_image")?>" style="height: 50px"></td> 
                                            <td><select class="form-control" onchange="change_status(this.value,<?php echo $p->dealID?>)" name="status" required>

                                                <option <?=(($p->status == 'Y')?'selected':'')?> value="Y">Active</option>

                                                <option <?=(($p->status == 'N')?'selected':'')?> value="N">InActive</option>

                                            </select></td>

                                            <td><?=$p->product_name?></td>

                                            <td><ul>

                                                <?php $city = explode(',', $p->cityID); 

                                                foreach ($city as $key => $c) {

                                                    $cities = $this->home_m->get_single_row_where('city',array('id'=>$c),'title');

                                                    ?>

                                                    <li><?=$cities->title?></li>

                                                <?php }?>

                                            </ul></td>

                                            <td><?=$p->retail_price.' / '.$p->unit_value.' '.$p->unit?></td>

                                            <td><?=$p->mrp.' / '.$p->unit_value.' '.$p->unit?></td>

                                            <td><?=$p->deal_price.' / '.$p->unit_value.' '.$p->unit?></td>

                                            <td><?=date("d M Y",strtotime($p->start_date))?></td>

                                            <td><?=date("d M Y",strtotime($p->end_date))?></td>

                                            <td><?php if(strtotime('+1 day',strtotime($p->end_date)) < time() ){echo "Expired";}elseif ($p->status == 'Y'){echo "Active";}else{echo "InActive";}?></td>

                                            <td><?=$p->max_quantity?></td>

                                            <td>

                                                <ul class="header-dropdown" style="list-style: none">

                                                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle btn btn-round btn-sm" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Action </a>

                                                        <ul class="dropdown-menu slideUp">

                                                            <li><a href="<?=base_url("deals/edit/$p->dealID/")?>">Edit</a></li>
                                                            <li><a href="<?=base_url("deals/delete/$p->dealID/")?>">Delete</a></li>

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

<script type="text/javascript">
    $("#status").change(function() {
    //get the selected value
    var selectedValue = this.value;
      alert(selectedValue);
    //make the ajax call
    // $.ajax({
    //     url: 'function.php',
    //     type: 'POST',
    //     data: {option : selectedValue},
    //     success: function() {
    //         console.log("Data sent!");
    //     }
    // });
});
    function change_status(selectedValue,dealID){
       // alert(selectedValue);  
       // alert(dealID); 
       var base_url = '<?php echo base_url()?>';
       $.ajax({
        url: base_url+'Deals/change_status',
        type: 'POST',
        data: {selectedValue : selectedValue,dealID : dealID},
        success: function(res) {
            //console.log("Data sent!");
            if (res) {
                  alert('Updat success !'); 
            }
        }
    }); 
    }
</script>