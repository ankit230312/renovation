<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("home")?>">HOME</a></li>
                    </ul>
                </div>
            </div>
        </div>
         <div class="row" style="background-color: white;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 style="margin-bottom: .75rem;"><strong>Select Dates</strong></h4>
                                <form class="form-inline" role="form" method="post">
                                     <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Select From Date</label>
                    <input type="date" class="form-control" name="from_date" id="from_date" required/>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Select To Date</label>
                    <input type="date" class="form-control" name="to_date" id="to_date" required/>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Select Delivery Agent</label>
                   <select class="form-control" name="delivery_agentID" id="delivery_agentID" required/>
                        <option value="">-- SELECT Delivery Agent --</option>
                        <?php foreach ($delivery_agent as $c) {?>
                        <option value="<?=$c->delivery_agentID?>"><?=$c->name?></option>
                        <?php } ?>
                        </select>
                </div>
            </div>
                    <button type="submit" class="btn btn-primary" style="background: background: #1150af;" value="Generate Reports" >Generate Reports</button>
                                   
                                </form>
                            </div>    
                        </div>
                    </div>
                    
                </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                       <h4 class="card-title">Sales Report</h4> 
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
                                <thead>
                                <tr>
                                     <th>Agent</th>
                                    <th>Delivery Date</th>
                                     <th>Delivery Slot</th>
                                    
                                    <th>OrderID</th>
                                    <th>Item</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $order_id=0; $delivery_charge=(float)0; $coupon_discounts=(float)0; foreach ($report as $r) {
                                        $delivery_charge= $r->delivery_charges;
                                        $coupon_discounts= $r->coupon_discount;
                                        $delivery_agent = $this->db->query("SELECT * FROM delivery_agent where delivery_agentID = '$delivery_agentID'")->row();
                                     if($r->orderID == $order_id) {
                                        $delivery_charge = 0;
                                        $coupon_discounts = 0;
                                    }
                                     $order_id=$r->orderID;  
                                    ?>
                                    <tr>
                                        
                                         <td><?=$delivery_agent->name;?></td>
                                       <td><?= date("Y-m-d",strtotime($r->updated_on))?></td>
                                       <td><?=$r->delivery_slot?></td>
                                       <td><?=$r->orderID?></td>
                                        <td><?php echo wordwrap($r->product_name,15,"<br>\n");?></td>
                                        <td>Rs. <?=$r->price.' / '.$r->unit_value.' '.$r->unit?></td>
                                        <td><?=$r->qty?></td>
                                        <td><?=$r->net_price?></td>
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