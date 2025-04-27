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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" >
                                <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>User</th>
                                    <th>City Name</th>
                                    <th>Vendor Name</th>
                                    <th>Address</th>
                                    <th>Total Amount</th>
                                    <th>Delivery Charge</th>
                                    <th>Payment Mode</th>
                                    <th>Delivery On</th>
                                    <th>Order status</th>
                                    <th>Order At</th>
                                    <th>Action</th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($new_orders as $a){ $secret = md5($a->orderID);
                                $user = $this->db->get_where('users',array('ID'=>$a->userID))->row();
                                $city = $this->db->get_where('city',array('ID'=>$a->cityID))->row();  
                                $vendor = $this->db->get_where('admin',array('ID'=>$a->vendorID))->row();
                                    ?>
                                    <tr>
                                        <td><?=$a->orderID?></td>
                                        <td><?php if(!empty($user)){echo $user->name."<br>".$user->mobile;}?></td>
                                        <td><?=$city->title?></td>
                                        <td><?php if(!empty($vendor)){ echo $vendor->name;}else{ echo 'N/A';}?></td>
                                        <td><?=$a->location?></td>
                                        <td><?=$a->total_amount?></td>
                                        <td><?=$a->delivery_charges?></td>
                                        <td><?=$a->payment_method?></td>
                                        <td><?=date('d M Y',strtotime($a->delivery_date))?> <br><?=$a->delivery_slot?></td>
                                        <td><?=$a->status?></td>
                                        <td><?=$a->added_on?></td>
                                        <td>
                                            <ul class="header-dropdown" style="list-style: none">
                                                <li><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#modaldemo<?=$a->orderID?>">Update Status</a></li>
                                                <li><a role="menuitem" tabindex="-1" href="<?=base_url("orders/order_detail/").$a->orderID?>">Details</a></li>
                                            </ul>
                                        </td>
                                        <div id="modaldemo<?=$a->orderID?>" class="modal" style="z-index: 1000 !important;">
                                            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                                                <div class="modal-content bd-0 tx-14">
                                                    <div class="modal-header pd-y-20 pd-x-25">
                                                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Manage Order# <?=$a->orderID?></h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body pd-25">
                                                        <?php if($a->status == 'PLACED'){ ?>
                                                            <h4>Order Status :</h4>
                                                            <select class="form-control" name="status" id="status<?=$a->orderID?>">
                                                                <option value="CONFIRM">CONFIRM</option>
                                                                <option value="CANCEL">CANCEL</option>
                                                            </select>
                                                        <?php } elseif($a->status == 'CONFIRM' && $_SESSION['role']=='admin'){ ?>
                                                            <h4>Delivery Agent:</h4>
                                                            <select class="form-control" name="delivery_agent" id="delivery_agent<?=$a->orderID?>">
                                                                <?php foreach($delivery_agent as $da){?>
                                                                    <option value="<?=$da->delivery_agentID?>"><?=$da->name?></option>

                                                                <?php } ?>

                                                            </select>
                                                            <input type="hidden" name="status" value="ALLOCATED" id="status<?=$a->orderID?>">
                                                        <?php } elseif($a->status == 'OUT_FOR_DELIVERY' || $a->status == 'ALLOCATED'){?>
                                                            <h4>Order Status :</h4>
                                                            <select class="form-control" name="status" id="status<?=$a->orderID?>">
                                                                <option value="DELIVERED">DELIVERED</option>
                                                                <option value="CANCEL">CANCEL</option>
                                                            </select>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="save btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" attr="<?=$a->orderID?>">Save changes</button>
                                                        <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div><!-- modal-dialog -->
                                        </div><!-- modal -->
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
<script>
    function update_order_status(orderID,status) {
        let options = '';
        $('#order_status_form').attr('action','<?=base_url("orders/status_update")?>/'+orderID);
        $('#order_status_options').html(options);
        $('#modaldemo').modal('show');
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".save").click(function(){
            var id = $(this).attr("attr");
            var status = $("#status"+id).val();
            var delivery_agent = '0';
            if(status == 'ALLOCATED')
            {
                var delivery_agent = $("#delivery_agent"+id).val()
            }

            if(status !='')
            {

                $.ajax({
                    url: '<?=base_url('orders/update_status')?>',
                    type: 'post',
                    data: {status: status, delivery_agent:delivery_agent, id:id},
                    success: function (response) {
                        //alert(response);
                        $("#modaldemo"+id).modal("toggle");
                        if(response == '0')
                        {
                            alert("Successfully Status Updated");
                            location.reload();

                        } else {
                            alert("Error while updatation");
                            location.reload();
                        }



                    }
                });
            } else {
                alert("Please Select Order Status");
            }
        });

        $('#datatable1').dataTable({
            bLengthChange: false,
            order: [[ 0, "desc" ]],
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });

    });
</script>