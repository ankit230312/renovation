<?php

$CI = &get_instance();

?>

<style>

.modal-content .modal-header{

    padding-bottom: none!important;

}



</style>

<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("users")?>">All Orders</a></li>

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

                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" id="order_data">
                                <thead>

                                    <tr>

                                        <th>ID</th>
                                        <th>USER</th>
                                        <th>MOBILE NO</th>
                                        <th>AMOUNT</th>
                                        <th>DATE/SLOT</th>
                                        <th>Payment Mode</th>
                                        <th>STATUS</th>

                                    </tr>

                                </thead>

                                <tbody>


                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script type="text/javascript" language="javascript" >  
    //$.noConflict();
    $(document).ready(function(){  
      var dataTable = $('#order_data').DataTable({  
        "processing":true,  
        "serverSide":true,  
        "order":[],  
    dom: 'Bfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    "ajax":{  
      url:"<?php echo base_url() . 'Orders/fetch_order'; ?>",  
      type:"POST",
      //data : {"indestry_id":indestry_id,"status":status},  
  },  
  "columnDefs":[  
  {  
   "targets":[0, 3, 4],  
   "orderable":false,  
},  
],  
}); 

  });  
</script> 


<script type="text/javascript">
   function change_order_status(order_id){
    var status = $('#change_order_status'+order_id).val();
    $.ajax({
        url: '<?php echo base_url() . 'Orders/change_order_status'; ?>',
        data: ({ order_id: order_id ,status:status}),
        dataType: 'json', 
        type: 'post',
        success: function(data) {
          
            if(data.status){
                alert('Status Updated');
            }
        }             
    });


}
</script>