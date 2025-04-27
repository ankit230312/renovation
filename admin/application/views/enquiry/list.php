<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("enquiry")?>">Enquiry</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="status_modal" class="modal" style="z-index: 1000 !important;">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Manage Enquiry #<span id="status_orderID"></span></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pd-25">
                        <h4>Enquiry Status :</h4>
                        <select class="form-control" id="status_status">
                            <option value="COMPLETE">COMPLETE</option>
                        </select>
                        <h4>Message</h4>
                        <input type="text" name="reply" value="" id="reply" class="form-control">
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
                                    <th style="width: 20%">ID</th>
                                    <th >USER</th>
                                    <th style="width: 250px;">Text</th>
                                    <th style="width: 250px;">Reply</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($enquiry)){
                                 foreach ($enquiry as $o){  ?>
                                    <tr <?php 

                                    if($o->status == 'NEW') {
                                        echo "style='background-color:red'";
                                    }elseif($o->status == 'COMPLETED'){
                                     echo "style='background-color:green!important'";}
                                 ?>>
                                        <td style="width: 20%"><?=$o->enquiryID?></td>
                                        <td><?=$o->name?><br><?=$o->mobile?></td>
                                        <td><?=$o->message?></td>
                                        <td><?=$o->reply?></td>
                                        <td><?=date("d M Y H:i",strtotime($o->added_on))?></td>
                                        <td id="enquiry_status<?=$o->enquiryID?>"><?=($o->status == 'NEW' ? '<a href="javascript:void(0)" onclick="update_status_open('.$o->enquiryID.')">'.$o->status.'</a>':$o->status)?></td>
                                    </tr>
                                <?php }}?>
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
        let reply = $('#reply').val();
        if (orderID != '' && status != '')
        {
            $('.page-loader-wrapper').css('display','block');
            $.ajax({
                url: '<?=base_url('enquiry/update_status_new')?>',
                type: 'post',
                data: {status: status, id:orderID,reply:reply},
                success: function (response) {
                    $('#enquiry_status'+orderID).html(response);
                    $("#status_modal").modal("toggle");
                    $('.page-loader-wrapper').css('display','none');
                    location.reload();
                }
            });
        }
    }
</script>