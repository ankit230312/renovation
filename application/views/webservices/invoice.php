<?php

$CI =&get_instance();
$site_settings = $this->db->get_where('settings')->row();
?>

<div class="row">
    <div class="col">
        <table border="1">
            <thead>
            <tr style="text-align: center; ">
                <td><img src="<?=base_url("admin/uploads/$site_settings->logo")?>" style="height: 40px; width: 100px;"></td>
                <td colspan="2"> Contact Us: 9871722048 / gowisekart@gmail.com</td>
                <td> GST No: 07BCXPK0675HIZ4 </td>
            </tr>
            </thead>
            <tbody >
            <tr>
                <th colspan="4">Order ID: # GS/ONL/<?=$orders->orderID?></th>

            </tr>

            <tr>
                <th colspan="2"><strong>Order Date :</strong> <?=date("d M Y",strtotime($orders->added_on))?></th>
                <th colspan="2"><strong>Shipping Address</strong></th>

            </tr>
            <tr>
                <th colspan="2"><strong>Invoice Date :</strong><?=date('d M Y')?></th>
                <th colspan="2"><?=$orders->customer_name.',<br>'.$orders->contact_no.',<br>'.$orders->location.'<br>'?></th>
            </tr>

            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total Amount</th>
            </tr>
            <?php
            $total = 0;
            foreach($items as $o) {
              $total += $o->net_price;
                ?>
                <tr>
                    <td><?=$o->product_name?></td>
                    <td><?=$o->price?></td>
                    <td><?=$o->qty?></td>
                    <td><?=$o->net_price?></td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="3">Order Amount (INR)</th>
                <th><?= $orders->order_amount?></th>
            </tr>
            <tr>
                <th colspan="3">Delivery Charges (INR)</th>
                <th><?= $orders->delivery_charges?></th>
            </tr>
            <tr>
                <th colspan="3">Coupon Discount (INR)</th>
                <th><?= $orders->coupon_discount?></th>
            </tr>
            <tr>
                <th colspan="3">Payable Amount (INR)</th>
                <th><?= $orders->total_amount?></th>
            </tr>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</div>
<p>Please refer to<span style="color: red;"> <a href="https://grocistore.com/home/terms">Terms & Condition</a> </span>for full terms and conditions which are incorporated in this invoice by reference. By paying for association plans, you agree to and intend to be bound by WAGONMART current terms and conditions with respect to online ordering.</p>
<div style="float:left;"><p>Gowisekart , a unit of WAGONMART| Website: https://gowisekart.com | Registered Office: Flat No: 476, POCKET - E, MAYUR VIHAR PHASE-2, 
DELHI, EAST DELHI, 110091 | gowisekart@gmail.com</p></div>