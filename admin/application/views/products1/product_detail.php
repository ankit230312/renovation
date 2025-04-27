<?php
$CI = &get_instance();
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("products")?>">Products</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <form class="form"  method="post" enctype="multipart/form-data">
                    	<div class="body">
		                    <div class="col-md-12" style="text-align: center;">
		                        <?php $products =$this->home_m->get_single_row_where('products',array('productID'=>$this->uri->segment(3)));?>
		                        <input type="hidden" name="products_id" value="<?=$this->uri->segment(3)?>">
		                        <span><strong>Product Name:- </strong><?=$products->product_name?></span>
		                	</div>
	                        <div class="table-responsive">
	                            <table class="table table-sm dataTable " id="myTable">
		                            <thead>
		                                <tr>
		                                    <th>City Name</th>
		                                    <th>Mrp Price</th>
		                                    <th>Selling Price</th>
		                                    <th>Stock Qty</th>
		                                    <th>Cost Prize</th>
		                                    <th>Status</th>
                                            <th>Is Variant</th>
                                            <th>Variant Add</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            	<?php $cnt =0; foreach($city as $key => $c){$cnt = $key;
		                                $product =$this->home_m->get_single_row_where('products_detail',array('city_id'=>$c->id,'product_id'=>$this->uri->segment(3)));
                                        $product_variant =$this->home_m->get_all_row_where('products_variant',array('city_id'=>$c->id,'product_id'=>$this->uri->segment(3)));
		                                ?>
		                                <tr>
		                                    <td><?=$c->title?></td>
		                                    <input type="hidden" name="city_id<?=$key?>" value="<?=$c->id?>">
		                                    <td><input type="text" id="userinput1" class="form-control border-primary" value="<?php if(!empty($product)){echo $product->retail_price;}?>" name="retail_price<?=$key?>" placeholder="00.00"></td>
		                                    <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $product->price;}?>" class="form-control border-primary"name="price<?=$key?>"placeholder="00.00"></td>
		                                    <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $product->stock_count;}?>" class="form-control border-primary"name="stock_count<?=$key?>"placeholder="0"></td>
		                                    <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $product->cost_price;}?>" class="form-control border-primary"name="cost_price<?=$key?>"placeholder="00.00"></td>
                                            <td>
                                                <select class="form-control" name="status<?=$key?>" required>
                                                    <option value="" selected disabled>Select Status</option>
                                                    <option value="Y" <?php if(!empty($product)){if ($product->status == 'Y'){echo "selected";}}?>>Active</option>
                                                    <option value="N" <?php if(!empty($product)){if ($product->status == 'N'){echo "selected";}}?>>InActive</option>
                                                </select>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php if($product->is_variant == 'Y'){ echo 'Available';?><?php }else{echo 'Not Available';} ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <label style="color: blue;padding: 10px">
                                                    <input type="checkbox" class="Variant_check" data-id="<?=$key?>" name="is_variant<?=$key?>">
                                                </label>
                                            </td>
                                            
		                                </tr>
                                        <?php $c =0;  if(!empty($product_variant)){ foreach ($product_variant as $k => $pv) { $c = $k; ?>
                                            <input type="hidden" class="form-control charge" placeholder="" name="old_variants<?=$key?><?=$k?>[id]" id="id" value="<?=$pv->id?>" autocomplete="off">
                                            <tr>
                                                <td colspan="11">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Unit Value</label>
                                                                <input type="text" class="form-control charge" placeholder="" name="old_variants<?=$key?><?=$k?>[unit_value]" id="unit_value" value="<?=$pv->unit_value?>" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Unit</label>
                                                                <input type="text" class="form-control charge" placeholder="" name="old_variants<?=$key?><?=$k?>[unit]" id="unit" value="<?=$pv->unit?>" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Weight</label>
                                                                <input type="text" class="form-control charge" placeholder="" name="old_variants<?=$key?><?=$k?>[weight]" id="weight" value="<?=$pv->weight?>" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Mrp Price</label>
                                                                <input type="text" class="form-control order0" placeholder="" name="old_variants<?=$key?><?=$k?>[retail_price]" id="retail_price" value="<?=$pv->retail_price?>" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Selling Price</label>
                                                                <input type="text" class="form-control charge" placeholder="" name="old_variants<?=$key?><?=$k?>[price]" id="price" value="<?=$pv->price?>" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Stock Qty</label>
                                                                <input type="text" class="form-control order0" placeholder="" name="old_variants<?=$key?><?=$k?>[stock_count]" id="stock_count" value="<?=$pv->stock_count?>" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <label style="<?php if($k>0){?>display: none<?php } ?>">Cost Prize</label>
                                                                <input type="text" class="form-control charge" placeholder="" name="old_variants<?=$key?><?=$k?>[cost_price]" id="cost_price" value="<?=$pv->cost_price?>" autocomplete="off">
                                                            </td>
                                                            <td><img src="<?=base_url("uploads/variants/$pv->variant_image")?>" style="height: 45px">
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <label style="color: blue;padding: 10px">
                                                                    <input type="checkbox" name="old_variants<?=$key?><?=$k?>[is_active]" <?php if($pv->is_active == 'Y'){ echo " checked";}?>><?php if($pv->is_active == 'Y'){ echo " Active";}else{ echo " Inactive" ;}?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <input type="hidden" name="old_counter<?=$key?>" value="<?=$c?>">
                                        <?php } }?>
                                        <tr class="variants_field<?=$key?>">
                                            <td colspan="11" class="variant_second_table<?=$key?>">
                                                 <table>
                                                    <tr>
                                                        <td>
                                                            <label><strong>Unit Value<span style="color: red">*</span></strong></label>
                                                            <input type="text" class="form-control charge" placeholder="" name="variants<?=$key?>[0][unit_value]" id="unit_value0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Unit<span style="color: red">*</span></strong></label>
                                                            <input type="text" class="form-control charge" placeholder="" name="variants<?=$key?>[0][unit]" id="unit0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Weight<span style="color: red">*</span></strong></label>
                                                            <input type="text" class="form-control charge" placeholder="" name="variants<?=$key?>[0][weight]" id="weight0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Mrp Price<span style="color: red">*</span> <span class="charges_error" style="color:red"></span></strong></label>
                                                            <input type="text" class="form-control order0" placeholder="" name="variants<?=$key?>[0][retail_price]" id="retail_price0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Selling Price<span style="color: red">*</span></strong></label>
                                                            <input type="text" class="form-control charge" placeholder="" name="variants<?=$key?>[0][price]" id="price0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Stock Qty<span style="color: red">*</span> <span class="charges_error" style="color:red"></span></strong></label>
                                                            <input type="text" class="form-control order0" placeholder="" name="variants<?=$key?>[0][stock_count]" id="stock_count0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Cost Prize<span style="color: red">*</span></strong></label>
                                                            <input type="text" class="form-control charge" placeholder="" name="variants<?=$key?>[0][cost_price]" id="cost_price0" autocomplete="off">
                                                        </td>
                                                        <td>
                                                            <label><strong>Image<span style="color: red">*</span> <span class="charges_error" style="color:red"></span></strong></label>
                                                            <input type="file" class="form-control order0" placeholder="" name="variants<?=$key?>[0][variant_image]" id="variant_image0" autocomplete="off">
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <label style="color: black;padding: 10px">
                                                                <input type="checkbox" name="variants<?=$key?>[0][is_active]"> Is Active
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <button type="button" data-id="<?=$key?>" class="btn btn-info add_more_button0" style="margin-top: 26px;padding: 4px;color: #fff!important;background-color: #8bc36f!important;" ><i class="zmdi zmdi-plus-circle" style="font-size: 30px;"></i></button>
                                                        </td>
                                                    </tr>
                                                </table>
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
	                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
        var dsval = <?=sizeof($city);?>;
        var max_fields_limit      = 50; //set limit for maximum input fields
        var i = 0;//initialize counter for text box
        var c = 0;
    $(document).ready(function () {
        for (var i = 0; i < dsval; i++) {
            $('.variants_field'+i).hide();
        }
        $('.Variant_check').change(function(){
            var key_val = $(this).data('id');
            if(this.checked) {
            $('.variants_field'+key_val).show();
        }else{
            $('.variants_field'+key_val).hide();
        }
        });

        $('.add_more_button0').click(function(e){ 
            var sel = $(this).data('id');
                ++i;
              e.preventDefault();
              if(c < max_fields_limit){ //check conditions
                c++;
                $('.variant_second_table'+sel).append('<table id="more_table'+c+'"><tr><td><label><strong>Unit Value<span style="color: red">*</span></strong></label><input type="text" class="form-control charge" placeholder="" name="variants'+sel+'['+i+'][unit_value]" id="unit_value0" autocomplete="off"></td><td><label><strong>Unit<span style="color: red">*</span></strong></label><input type="text" class="form-control charge" placeholder="" name="variants'+sel+'['+i+'][unit]" id="unit0" autocomplete="off"></td><td><label><strong>Weight<span style="color: red">*</span></strong></label><input type="text" class="form-control charge" placeholder="" name="variants'+sel+'['+i+'][weight]" id="weight0" autocomplete="off"></td><td><label><strong>Mrp Price<span style="color: red">*</span> <span class="charges_error" style="color:red"></span></strong></label><input type="text" class="form-control order0" placeholder="" name="variants'+sel+'['+i+'][retail_price]" id="retail_price0" autocomplete="off"></td><td><label><strong>Selling Price<span style="color: red">*</span></strong></label><input type="text" class="form-control charge" placeholder="" name="variants'+sel+'['+i+'][price]" id="price0" autocomplete="off"></td><td><label><strong>Stock Qty<span style="color: red">*</span> <span class="charges_error" style="color:red"></span></strong></label><input type="text" class="form-control order0" placeholder="" name="variants'+sel+'['+i+'][stock_count]" id="stock_count0" autocomplete="off"></td><td><label><strong>Cost Prize<span style="color: red">*</span></strong></label><input type="text" class="form-control charge" placeholder="" name="variants'+sel+'['+i+'][cost_price]" id="cost_price0" autocomplete="off"></td><td><label><strong>Image<span style="color: red">*</span> <span class="charges_error" style="color:red"></span></strong></label><input type="file" class="form-control order0" placeholder="" name="variants'+sel+'['+i+'][variant_image]" id="variant_image0" autocomplete="off"></td><td style="text-align: center;"><label style="color: black;padding: 10px"><input type="checkbox" name="variants'+sel+'['+i+'][is_active]"> Is Active</label></td><td><button type="button" class="btn btn-info remove_field'+c+'" onclick="remove_field(this)"  data-id="'+c+'" style="margin-top: 26px;padding: 4px;color: #fff!important;background-color: #8bc36f!important;" ><i class="zmdi zmdi-minus-circle" style="font-size: 30px;"></i></button></td></tr></table>'); //add input field
                }
        }); 
        // $('.variants_field').on("click",".remove_field", function(e){ //user click on remove text links
        //     e.preventDefault();
        //      $(this).parent('div').remove();
        //       x--;
        // });
        });
        function Variant_check(obj) {
            if(obj.checked) {
                $('.variants_field').show();
            }else{
                $('.variants_field').hide();
            }
        }function remove_field(obj) {
            // return false;
            var id = $(obj).data('id');
            $('#more_table'+id).remove();
            c--;
        }
</script>