<?php
session_start();
require 'cashfree_config.php';

$orderId = $_GET['order_id'] ?? '';

if (!$orderId) {
    die("Invalid return response");
}

$url = CF_BASE_URL . "/orders/" . $orderId;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "x-client-id: " . CF_APP_ID,
    "x-client-secret: " . CF_SECRET_KEY,
    "x-api-version: 2023-08-01"   
]);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// Debug raw response
// echo "<pre>"; print_r($_SESSION); echo "</pre>";die;

// If success, display in HTML
if (isset($result['order_id'])) {
    echo "<h2>Payment Status</h2>";
    echo "Order ID: " . htmlspecialchars($result['order_id']) . "<br>";
    echo "Status: " . htmlspecialchars($result['order_status']) . "<br>";
    echo "Amount: " . htmlspecialchars($result['order_amount']) . "<br>";
   
    unset($_SESSION['cart']);  unset($_SESSION['single_cart_product']);  
    header("Location: payment_success.php");
} else {
    echo "<p>Error fetching payment status.</p>";
}
