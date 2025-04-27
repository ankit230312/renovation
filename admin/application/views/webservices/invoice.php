<style>
   th,
   td {
      padding: 15px;
   }
</style>
<div style="padding-bottom:20px; padding-top:20px; text-align:right;">
   <img src="<?= base_url() ?>/uploads/settings/logo1561624485.png">
</div>
<table border="1" style="border-collapse: collapse; width:100%; text-align:left;">

   <thead>
      <?php
      // echo "<pre>";
      // print_r($orders);
      // print_r($items);
      // print_r($user);

      ?>
      <tr>
         <th colspan="4">Bill No.:PP/ONL/0000</th>

      </tr>

      <tr>
         <th colspan="3">Order # : <?= $orders->orderID  ?></th>
         <th></th>
      </tr>
      <tr>
         <th colspan="3">Mobile number : <?= $orders->contact_no ?? "0" ?></th>
         <th>Order Date : <?= $orders->added_on  ?></th>
      </tr>
      <tr>
         <th colspan="3">Email : <?php echo $user->email  ?></th>
      </tr>

      <tr>
         <td colspan="4"><strong>Name : <?= $user->name ?? "0" ?></strong></td>
      </tr>
      <tr>
         <td colspan="4"><strong>Users Address : <?= $orders->house_no . " " . $orders->apartment . " " . $orders->landmark  ?></strong></td>
      </tr>
      <tr>
         <td colspan="4"><strong>Delivery Address : <?= $orders->house_no . " " . $orders->apartment . " " . $orders->landmark  ?></strong></td>
      </tr>

   </thead>
   <tbody>

      <tr>
         <th>S.no</th>
         <th>Particulars</th>

         <th></th>
         <th>Amount</th>
      </tr>
      <?php
      $tax = 0;
      ?>

      <?php foreach ($items as $item) { ?>


         <tr>
            <td>1</td>
            <td><?= $item->product_name ?> * <?= $item->qty ?></td>
            <?php
            $a1 = 18;
            $a2 = 100 + 18;
            $b = round((($orders->total_amount * $a1) / $a2), 2);
            $tax = $tax + $b;
            ?>
            <td><?= $orders->price ?></td>
            <td><?= $orders->total_amount - round((($orders->price * $a1) / $a2), 2) ?></td>

         </tr>


      <?php  } ?>

      <?php ?>

   <tfoot>
      <tr>
         <th colspan="2">CGST@<?= round(($a1 / 2), 2) ?>%</th>
         <td></td>
         <td><?= round(($tax / 2), 2) ?></td>

      </tr>
      <tr>
         <th colspan="2">SGST@<?= round(($a1 / 2), 2) ?>%</th>
         <td></td>
         <td><?= round(($tax / 2), 2) ?></td>

      </tr>

      <tr>
         <th colspan="3">Total Amount (INR)</th>
         <td><?= $orders->total_amount ?? "0" ?></td>
      </tr>
   </tfoot>

</table>
<p>Please refer to<span style="color: red;"> <a href="https://grocistore.com/home/terms">Terms & Condition</a> </span>for full terms and conditions which are incorporated in this invoice by reference. By paying for association plans, you agree to and intend to be bound by Rapto current terms and conditions with respect to online ordering.</p>
<div style="float:left;">
   <p>Rapto , a unit of Rapto| Website: https://Rapto.com | Registered Office: Flat No: 476, POCKET - E, MAYUR VIHAR PHASE-2,
      DELHI, EAST DELHI, 110091 | Rapto@gmail.com</p>
</div>