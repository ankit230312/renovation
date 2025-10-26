<?php
require 'cashfree_config.php';

// Create Order Endpoint

$orderAmount = isset($_POST['order_amount']) ? floatval($_POST['order_amount']) : 0;

if ($orderAmount <= 0) {
    die("Invalid order amount.");
}
$url = "https://sandbox.cashfree.com/pg/orders";

$orderId = "ORDER_" . time();
$orderData = [
    "order_id"       => $orderId,
    "order_amount"   => $orderAmount,
    "order_currency" => "INR",
    "customer_details" => [
        "customer_id"    => "CUST_101",
        "customer_email" => "customer@example.com",
        "customer_phone" => "9876543210"
    ],
    "order_meta" => [
        "return_url" => "http://localhost/splitfloor/return.php?order_id={order_id}",
        "notify_url" => "http://localhost/splitfloor/webhook.php"
    ]
];

$payload = json_encode($orderData);

// cURL Request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "x-client-id: " . CF_APP_ID,
    "x-client-secret: " . CF_SECRET_KEY,
    "x-api-version: 2023-08-01"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);
echo "<pre>";
if(isset($result['payment_session_id'])){
    // Redirect user to Cashfree Checkout
    $sessionId = $result['payment_session_id'];
   header("Location: cashfree_ui.php?session_id=" . urlencode($result['payment_session_id']));

    exit;
} else {
    echo "<pre>Error creating order: ";
    print_r($result);
    echo "</pre>";
}
