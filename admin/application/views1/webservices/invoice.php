<style>
th, td {
  padding: 15px;
}
</style>
<div style="padding-bottom:20px; padding-top:20px; text-align:right;">
  <img src="<?=base_url()?>/uploads/settings/logo1561624485.png">
</div>
<table border="1" style="border-collapse: collapse; width:100%; text-align:left;">
   
   <thead>
      <tr>
         <th colspan="4">Bill No.:PP/ONL/0000<?=$orderID?></th>
         
      </tr>
     
     <tr>
         <th colspan="3">Order # : <?=$order_no?></th>
         <th></th>
      </tr>
    <tr>
         <th colspan="3">Mobile number : <?=$user->contact_no?></th>
         <th>Order Date : <?=$added_on?></th>
      </tr>
    <tr>
         <th colspan="3">Email : <?=$user->email?></th>
      </tr>
    
     <tr>
         <td colspan="4"><strong>Name : <?=$user->name?></strong></td>
      </tr>
      <tr>
         <td colspan="4"><strong>Users Address : <?=?></strong></td>
      </tr>
      <tr>
         <td colspan="4"><strong>Delivery Address : <?=?></strong></td>
      </tr>
      
   </thead>
   <tbody>
    
      <tr>
       <th>S.no</th>
         <th>Particulars</th>
         
         <th></th>
         <th>Amount</th>
      </tr>
     <!--  <?php 
      $tax = 0;
     ?>
        <tr>
          <td>1</td>
          <td><?=$products?> X <?=$qty?></td>
          <?php
          $a1 = 18;
          $a2 = 100 + 18;
          $b = round((($payTotalPrice * $a1)/$a2),2);
          $tax = $tax + $b;
          ?>
          <td></td>
          <td><?=$payTotalPrice - round((($payTotalPrice * $a1)/$a2),2)?></td>
          
        </tr>
      <?php ?> -->
      
    
   <tfoot>
      <tr>
    <!--      <th colspan="2">CGST@<?=round(($a1/2),2)?>%</th>
         <td></td>
         <td><?= round(($tax/2),2)?></td>
     
      </tr> -->
     <!--  <tr>
         <th colspan="2">SGST@<?=round(($a1/2),2)?>%</th>
         <td></td>
         <td><?= round(($tax/2),2)?></td>
         
      </tr>
 -->      <tr>
         <th colspan="3">Total Amount (INR)</th>
         <td><?= $net_price?></td>
      </tr>
   </tfoot>
   
</table>
<p>Please refer to<span style="color: red;"> <a href="https://grocistore.com/home/terms">Terms & Condition</a> </span>for full terms and conditions which are incorporated in this invoice by reference. By paying for association plans, you agree to and intend to be bound by WAGONMART current terms and conditions with respect to online ordering.</p>
<div style="float:left;"><p>Gowisekart , a unit of WAGONMART| Website: https://gowisekart.com | Registered Office: Flat No: 476, POCKET - E, MAYUR VIHAR PHASE-2, 
DELHI, EAST DELHI, 110091 | gowisekart@gmail.com</p></div>