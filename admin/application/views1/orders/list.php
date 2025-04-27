<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("orders")?>">Orders</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <form method="GET" action="<?=base_url("orders/")?>">
                <div class="row body">
                    <div class="col-sm-3">
                        <label>Delivery Date :</label>
                        <input value="<?php if (isset($_GET['delivery_date']) && !empty($_GET['delivery_date'])){echo $_GET['delivery_date'];}?>" class="form-control" type="date" name="delivery_date">
                    </div>
                    <div class="col-sm-3">
                        <label>Apartment :</label>
                        <select class="form-control" name="apartment">
                            <option value="">ALL</option>
                            <?php foreach ($apartments as $a){?>
                                <option <?php if (isset($_GET['apartment']) && ($_GET['apartment'] == $a->apartment)){echo 'selected';}?> value="<?=$a->apartment?>"><?=$a->apartment?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Status :</label>
                        <select class="form-control" name="status">
                            <option value="">ALL</option>
                            <option <?php if (isset($_GET['status']) && ($_GET['status'] == 'OUT_FOR_DELIVERY')){echo 'selected';}?> value="OUT_FOR_DELIVERY">IN PROGRESS</option>
                            <option <?php if (isset($_GET['status']) && ($_GET['status'] == 'DELIVERED')){echo 'selected';}?> value="DELIVERED">DELIVERED</option>
                            <option <?php if (isset($_GET['status']) && ($_GET['status'] == 'CANCEL')){echo 'selected';}?> value="CANCEL">CANCELLED</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Slot :</label>
                        <select class="form-control" name="delivery_slot">
                            <option value="">ALL</option>
                            <option <?php if (isset($_GET['delivery_slot']) && ($_GET['delivery_slot'] == '04:00 AM - 07:30 AM')){echo 'selected';}?> value="04:00 AM - 07:30 AM">04:00 AM - 07:30 AM</option>
                            <option <?php if (isset($_GET['delivery_slot']) && ($_GET['delivery_slot'] == '11:00 AM  - 05:00 PM')){echo 'selected';}?> value="11:00 AM  - 05:00 PM">11:00 AM  - 05:00 PM</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Click to Filter</label>
                        <button class="form-control btn btn-primary" type="submit">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="status_modal" class="modal" style="z-index: 1000 !important;">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Manage Order #<span id="status_orderID"></span></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pd-25">
                        <h4>Order Status :</h4>
                        <select class="form-control" id="status_status">
                            <option value="DELIVERED">DELIVERED</option>
                            <option value="CANCEL">CANCEL</option>
                        </select>
                        <input type="hidden" id="status_orderID_input">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="save btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" onclick="update_status(event)">Save changes</button>
                        <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" >
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>USER</th>
                                    <th>AMOUNT</th>
                                    <th>AGENT</th>
                                    <th>DATE/SLOT</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($orders as $o){  ?>
                                    <tr>
                                        <td><a href="<?=base_url("orders/order_detail/").$o->orderID?>">#<?=$o->orderID?></a></td>
                                        <td>
                                            <?=$o->user_name?><br>
                                            <?=$o->contact_no?><br>
                                            <?=$o->tower.' - '.$o->flat?><br>
                                            <?=$o->appartment?><br>
                                            <?=$o->city?>
                                        </td>
                                        <td><?=$o->total_amount?></td>
                                        <td>
                                            <?=$o->agent_name?><br>
                                            <?=$o->agent_phone?><br>
                                            <?=$o->agent_alt_phone?>
                                        </td>
                                        <td>
                                            <?=date("d M Y",strtotime($o->delivery_date))?><br>
                                            <?=$o->delivery_slot?>
                                        </td>
                                        <td id="order_status<?=$o->orderID?>"><?=($o->status == 'OUT_FOR_DELIVERY' ?'<a href="javascript:void(0)" onclick="update_status_open('.$o->orderID.')">IN PROGRESS</a>' : $o->status)?></td>
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
    function update_status_open(orderID) {
        $('#status_orderID').html(orderID);
        $('#status_orderID_input').val(orderID);
        $('#status_modal').modal('show');
    }
    function update_status(e) {
        e.preventDefault();
        let orderID = $('#status_orderID_input').val();
        let status = $('#status_status').val();
        if (orderID != '' && status != '')
        {
            $('.page-loader-wrapper').css('display','block');
            $.ajax({
                url: '<?=base_url('orders/update_status_new')?>',
                type: 'post',
                data: {status: status, id:orderID},
                success: function (response) {
                    $('#order_status'+orderID).html(response);
                    $("#status_modal").modal("toggle");
                    $('.page-loader-wrapper').css('display','none');
                }
            });
        }
    }
</script>