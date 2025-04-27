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
   
   <div class="body">
    <div class="col-md-12" style="text-align: center;">
     <?php $products =$this->home_m->get_single_row_where('products',array('productID'=>$this->uri->segment(3)));?>
     <input type="hidden" name="products_id" value="<?=$this->uri->segment(3)?>">
     <span><strong>Product Name:- </strong><?=$products->product_name?></span><br>
   </div>
 </div>
</div>
<form  method="post" action="<?php echo base_url('/products/update_singleVarinat1');?>">

  <div class="table-responsive">
    <table class="table table-sm dataTable " > 
    <thead>
     <tr>
      <th>ID</th>
      <th>City Name</th>
      <th>Mrp Price</th>
      <th>Selling Price</th>
      <th>Stock Qty</th>
      <!--  <th>Cost Prize</th> -->
      <th>Quantity</th>
      <th>Unit</th>
      <th>Weight</th>
      <th>Status</th>
      <!-- <th>Save</th> -->
      <th>Image</th>
    </tr>
  </thead>
  <tbody>

   <?php $cnt =0;?>
   <?php $i = 0;?>
   <?php  foreach($city as $key => $c){$cnt = $key;
    $product =$this->home_m->get_all_row_where('products_variant',array('city_id'=>$c->id,'product_id'=>$this->uri->segment(3)));
    foreach($product as $p) {
      ?>
      <tr>
        <td><?php if(!empty($product)){echo $p->id;}?></td>
        <td><?=$c->title?></td>
        <input type="hidden" name="city_id<?=$key?>" value="<?=$c->id?>">
        <input type="hidden" name="variantID[<?=$i?>]" value="<?=$p->id?>">
        <input type="hidden" name="v_id" value="<?=$v_id?>">
        <td><input type="text" id="userinput1" class="form-control border-primary retail_price<?=$p->id?>" value="<?php if(!empty($product)){echo $p->retail_price;}?>" name="retail_price[<?=$i?>]" placeholder="00.00"></td>
        <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->price;}?>" class="form-control border-primary price<?=$p->id?>"name="price[<?=$i?>]"placeholder="00.00"></td>
        <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->stock_count;}?>" class="form-control border-primary stock_count<?=$p->id?>" name="stock_count[<?=$i?>]"placeholder="0"></td>
        <!--  <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->cost_price;}?>" class="form-control border-primary"name="cost_price<?=$key?>"placeholder="00.00"></td> -->
        <td><input type="text" id="userinput1" value="<?php if(!empty($product)){echo $p->unit_value;}?>" class="form-control border-primary unit_value<?=$p->id?>" name="unit_value[<?=$i?>]"></td>
        <td>
          <!--    <input type="hidden" name="v_unit[<?=$i?>]" value="<?=$p->unit?>"> -->
          <select class="form-control unit<?=$p->id?>"  name="unit1[<?=$i?>]" style="width: 50px;">
            <option value="PC"<?php if ($p->unit == 'PC' ){echo "selected";}?>>PC</option>
            <option value="KG"<?php if ($p->unit == 'KG' ){echo "selected";}?>>KG</option>
            <option value="GM"<?php if ($p->unit == 'GM' ){echo "selected";}?>>GM</option>
            <option value="Half"<?php if ($p->unit == 'Half' ){echo "selected";}?>>Half</option>
            <option value="Full"<?php if ($p->unit == 'Full' ){echo "selected";}?>>Full</option>
            <option value="ML"<?php if ($p->unit == 'ML' ){echo "selected";}?>>ML</option>
            <option value="Litre"<?php if ($p->unit == 'Litre' ){echo "selected";}?>>Litre</option>
          </select>
        </td>
         <td><input type="text" size="200" id="userinput1" value="<?php if(!empty($product)){echo $p->weight;}?>" class="form-control border-primary weight<?=$p->id?>" name="weight[<?=$i?>]"></td>
        <td>
         <select class="form-control" name="in_stock[<?=$i?>]" >
          <option value="" selected disabled>Select Status</option>
          <option value="Y" <?php if(!empty($product)){if ($p->in_stock == 'Y'){echo "selected";}}?>>Active</option>
          <option value="N" <?php if(!empty($product)){if ($p->in_stock == 'N'){echo "selected";}}?>>InActive</option>
        </select>
      </td>
      <td><a href="<?=base_url("products/update_variant/").$p->id?>">Change</a></td>
    </tr>
    <?php $i++;?>
  <?php } }?>
  
</tbody>
<tr>
</tr>
<tfoot>
</tfoot>
</table>
<button class=" btn btn-primary" type="Submit">Bulk Update</button>
</form>
<input type="hidden" name="counter" value="<?=$cnt?>">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<script>
 $(document).ready(function(){
   $('.save_variant').click(function(){
    var variantID =  $(this).attr('id');
    var retail_price = $('.retail_price'+variantID).val();
    var price = $('.price'+variantID).val();
    var stock_count = $('.stock_count'+variantID).val();
    var unit_value = $('.unit_value'+variantID).val();
    var unit = $('.unit'+variantID).val();
    var in_stock =$( ".in_stock"+variantID+" option:selected" ).val();
    alert(variantID);
    $.ajax({
      url: '<?php echo base_url(); ?>/products/update_singleVarinat',
      type: 'POST',
      data: {variantID:variantID,retail_price:retail_price,price:price,stock_count:stock_count,unit_value:unit_value,unit:unit,in_stock:in_stock},
      success: function (data) {
       if(data='success'){
        location.reload();
      }
      
    }
  });
  });
   submitform = function(){
    alert("saa");
    document.getElementById("form6006").submit();
    document.getElementById("form6005").submit();
  }
});   
</script>