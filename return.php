<?php
session_start();
require 'cashfree_config.php';

$orderId = $_GET['order_id'] ?? '';

if (!$orderId) {
    die("Invalid return response");
}

$url = CF_BASE_URL . "/orders/" . $orderId;

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "x-client-id: " . CF_APP_ID,
    "x-client-secret: " . CF_SECRET_KEY,
    "x-api-version: 2023-08-01"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// 1️⃣ Handle cURL failure
if ($response === false) {
    error_log("Cashfree API Error: " . $curlError);
    die("Unable to connect to payment gateway. Please try again later.");
}

// 2️⃣ Decode JSON safely
$result = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("Invalid JSON from Cashfree: " . $response);
    die("Unexpected response from payment gateway.");
}

// 3️⃣ Handle HTTP error codes
if ($httpCode < 200 || $httpCode >= 300) {
    error_log("Cashfree returned HTTP $httpCode: " . print_r($result, true));
    die("Payment verification failed. Please contact support.");
}

// 4️⃣ Success — show result
// echo "<pre>";
// print_r($result);die;
if (isset($result['order_id'])) {
    echo "<h2>Payment Status</h2>";
    echo "Order ID: " . htmlspecialchars($result['order_id']) . "<br>";
    echo "Status: " . htmlspecialchars($result['order_status']) . "<br>";
    echo "Amount: " . htmlspecialchars($result['order_amount']) . "<br>";

    // If payment is successful, clear cart
    if ($result['order_status'] === 'PAID') {
        unset($_SESSION['cart']);
        unset($_SESSION['single_cart_product']);
        header("Location: payment_success.php");
        exit;
    } else {
        echo "<p>Payment not completed. Current status: {$result['order_status']}</p>";
    }
} else {
    echo "<p>Error fetching payment status.</p>";
    error_log("Missing order_id in response: " . print_r($result, true));
}
