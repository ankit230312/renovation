<?php


$orderId = $orderPrimaryId ?? 0;
if (!$orderId)
    die("Invalid Order");

// ----------------------
// FETCH ORDER


// ----------------------
$order = $conn->query("SELECT * FROM orders WHERE orderID=$orderId")->fetch_assoc();
$userId = $order['userID'];

// print_r($order); die;
// ----------------------
// FETCH USER (Customer)
// ----------------------
$user = $conn->query("SELECT * FROM usersnew WHERE id=$userId")->fetch_assoc();

// ----------------------
// FETCH ORDER ITEMS
// ----------------------
$items = $conn->query(query: "
    SELECT oi.*, p.product_name 
    FROM order_items oi
    JOIN products_item p ON oi.productID = p.productID
    WHERE oi.orderID = $orderId
");

// print_r($order);die;

$customerName = $user['full_name'];
$customerEmail = $user['email'];
$orderDate = date("d-m-Y", strtotime($order['added_on']));
$invoiceNo = "INV-" . str_pad($orderId, 5, "0", STR_PAD_LEFT);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice <?= $invoiceNo ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header {
            background: #f4b400;
            padding: 25px;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f4b400;
            padding: 10px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .label {
            background: #f4b400;
            padding: 6px;
            font-weight: bold;
        }

        .total {
            background: #f4b400;
            padding: 12px;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body style="margin:0; padding:0;">

    <div class="header">Contractor Invoice</div>

    <!-- TOP SECTION -->
    <table style="width: 100%; margin-top: 20px;">
        <tr>

            <!-- Bill From -->
            <td style="vertical-align: top; width: 33%;">
                <div class="label">Bill From:</div>
                <p style="margin:4px 0;">Splitfloor</p>
                <p style="margin:4px 0;">Mumbai</p>
                <p style="margin:4px 0;">contact@splitfloor.com</p>
            </td>

            <!-- Bill To -->
            <td style="vertical-align: top; width: 33%;">
                <div class="label">Bill To:</div>
                <p style="margin:4px 0;"><?= $customerName ?></p>
                <p style="margin:4px 0;"><?= $customerEmail ?></p>
                <p style="margin:4px 0;">Phone: <?= $order['contact_no'] ?></p>
                <p style="margin:4px 0;">Address: <?= $order['location'] ?></p>
            </td>

            <!-- Invoice Info -->
            <td style="vertical-align: top; text-align:right;">
                <p style="margin:4px 0;"><strong>Invoice No:</strong> <?= $invoiceNo ?></p>
                <p style="margin:4px 0;"><strong>Date:</strong> <?= $orderDate ?></p>
            </td>

        </tr>
    </table>

    <br><br>

    <!-- ITEMS TABLE -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <th style="text-align:left;">Description</th>
            <th style="text-align:center;">Qty</th>
            <th style="text-align:right;">Rate</th>
            <th style="text-align:right;">Amount</th>
        </tr>

        <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
                <td><?= $item['product_name'] ?></td>
                <td style="text-align:center;"><?= $item['qty'] ?></td>
                <td style="text-align:right;">
                    &#8377; <?= number_format($item['price'], 2) ?>
                </td>
                <td style="text-align:right;">
                    &#8377; <?= number_format($item['net_price'], 2) ?>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>

    <br><br>

    <?php
    $originalAmount = (float) $order['price'];
    $bookingAmount = (float) $order['total_amount'];
    $remainingAmount = (float) $order['remain_amount'];

    $gst = round($originalAmount * 0.18, 2);
    $grandTotal = round($originalAmount + $gst, 2);
    ?>

    <table style="width: 55%; float: right; border-collapse: collapse;">
        <tr>
            <td><strong>Original Amount:</strong></td>
            <td style="text-align:right;">
                &#8377; <?= number_format($originalAmount, 2) ?>
            </td>
        </tr>

        <tr>
            <td><strong>GST (18%):</strong></td>
            <td style="text-align:right;">
                &#8377; <?= number_format($gst, 2) ?>
            </td>
        </tr>

        <tr>
            <td><strong>Total Amount (Incl. GST):</strong></td>
            <td style="text-align:right;">
                &#8377; <?= number_format($grandTotal, 2) ?>
            </td>
        </tr>

        <tr>
            <td><strong>Booking Amount Paid:</strong></td>
            <td style="text-align:right;">
                &#8377; <?= number_format($bookingAmount, 2) ?>
            </td>
        </tr>

        <tr>
            <td><strong>Remaining Amount:</strong></td>
            <td style="text-align:right;">
                &#8377; <?= number_format($remainingAmount, 2) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:right;">
                <div class="total" style="margin-top:15px;">
                    Paid Now: &#8377;
                    <?= number_format($bookingAmount, 2) ?>
                </div>
            </td>
        </tr>
    </table>

    <br><br><br>

    <!-- Final Total -->


</body>


</html>