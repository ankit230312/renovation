<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("orders/new_orders")?>">New Orders</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                	<div class="body">
                        <?php if (isset($error)){?>
                        <h2 class="title text-danger"><?=$error?></h2>
                        <?php }?>
                        <form method="post" action="<?=base_url('orders/generate_report')?>">
                            
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="date" placeholder="Enter Start Date" name="start_date">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span> :</label>
                                        <input class="form-control" required type="date" placeholder="Enter End Date" name="end_date">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <br>
                                        <button class="btn btn-success btn-round" type="submit" title="Export In CSV"><i class="zmdi zmdi-check-circle"></i> Export</button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable1" >
                                <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>City Name</th>
                                    <th>Vendor name</th>
                                    <th>Total Amount</th>
                                    <th>Delivery Charge</th>
                                    <th>Payment Mode</th>
                                    <th>Delivery On</th>
                                    <th>Order status</th>
                                    <th>Order At</th>
                                    <th>Action</th>
                                    <th>Address</th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($new_orders as $a){ $secret = md5($a->orderID);
                                $city = $this->db->get_where('city',array('ID'=>$a->cityID))->row();  
                                $vendor = $this->db->get_where('admin',array('ID'=>$a->vendorID))->row();  
                                    ?>
                                    <tr>
                                        <td><?=$a->orderID?></td>
                                        <td><?=$city->title?></td>
                                        <td><?php if(!empty($vendor)){ echo $vendor->name;}else{ echo 'Admin';}?></td>
                                        <td><?=$a->total_amount?></td>
                                        <td><?=$a->delivery_charges?></td>
                                        <td><?=$a->payment_method?></td>
                                        <td><?=date('d M Y',strtotime($a->delivery_date))?> <br><?=$a->delivery_slot?></td>
                                        <td><?=$a->status?></td>
                                        <td><?=$a->delivery_date?></td>
                                        <td>
                                            <ul class="header-dropdown" style="list-style: none">
                                                <li><a role="menuitem" class="btn btn-success"  style="padding:2px" tabindex="-1" href="<?=base_url("../webservice/test_pdf/").$a->orderID.'/'.$a->userID?>" target="_blank">Download Invoice</a></li>
                                            </ul>
                                        </td>
                                        <td><?=$a->location?></td>
                                        
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
    </div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('.js-exportable1').DataTable({
	        dom: 'Bfrtip',
	        scrollX: false,
	        responsive: true,
	        lengthMenu: [
	            [ 10, 25, 50,100],
	            [ '10', '25', '50', '100' ]
	        ],
	        buttons: [
	        {
	            extend: 'csv',
	            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,10]
            	}
            }],
            buttons: [
	        {
	            extend: 'pageLength',
        		exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            	}
            },
            'colvis'],
	        order: [[ 0, "desc" ]],
	    });
	});
</script>