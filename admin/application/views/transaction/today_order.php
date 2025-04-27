<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<div class="row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-12">
					<h2><?=$title?></h2>
					<ul class="breadcrumb padding-0">
						<li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
						<li class="breadcrumb-item"><a href="Javascript::void(0)">Today order count</a></li>
						<li class="breadcrumb-item active">Today order count</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<!--  <h2 class="text-left"><a class="btn btn-primary btn-sm" href="<?=base_url("home/add_wallet")?>"><i class="zmdi zmdi-plus"></i> Add Wallet</a></h2> -->
					</div>
					<div class="body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable">
								<thead>
									<tr>
										<th>Order ID</th>
										<th>Product name</th>
										<th>Products variant</th>
										<!-- s -->
										<th>qty</th>
                                  <!--   <th>Net price</th>
                                  	<th>Status</th> -->
                                  	<th>Paid At</th>
                                  </tr>
                              </thead>
                              <tbody>
                              	<?php 
                                // $CI = &get_instance();
                              	foreach ($today_order as $t){ 
                              		$p_data = $this->db->get_where('products',array('productID'=>$t->productID))->row();
                              		$p_v_data = $this->db->get_where('products_variant',array('id'=>$t->variantID))->row();

                              		$after = date('Y-m-d', strtotime(date("Y-m-d"). ' + 1 days'));
                              		$befor = date('Y-m-d', strtotime(date("Y-m-d"). ' - 1 days'));
                              		$condition['status !='] = 'CANCEL';
                              		$condition['added_on <'] = $after;
                              		$condition['added_on >'] = date("Y-m-d");
                              		$condition['variantID'] = $t->variantID;
                              		$order_q = $this->db->get_where('order_items',$condition)->result();
                              		$qty =0;
                              		foreach ($order_q as $key) {
                              			$qty += $key->qty;
                              		}

                              		?>
                              		<tr>
                              			<td><?=$t->orderID?></td>
                              			<td><?=$p_data->product_name?></td>
                              			<td><?=$p_v_data->unit_value?> - <?=$p_v_data->unit?></td>
                              			<!--  <td><?=$t->price?></td> -->
                              			<td><?=$qty?></td>
                              			<!--   <td><?=$t->net_price?></td> -->
                              			<!--  <td><?=$t->status?></td> -->
                              			<td><?=date('d M Y H:i A',strtotime($t->added_on))?></td>

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