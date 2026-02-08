<?php include("common/db.php"); 
require 'cashfree_config.php';

// PRINTING POST FOR DEBUG
// print_r($_POST);
// die;

// Fetch POST values
$orderAmount    = isset($_POST['order_amount']) ? floatval($_POST['order_amount']) : 0;
$orderTotal     = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$orderRemaining   = isset($_POST['remaining_amount']) ? floatval($_POST['remaining_amount']) : 0;
$customerId     = isset($_POST['userId']) ? $_POST['userId'] : "GUEST_" . time();
$customerEmail  = isset($_POST['email']) ? $_POST['email'] : "noemail@example.com";
$customerPhone  = isset($_POST['mobile']) ? $_POST['mobile'] : "0000000000";
$customerName   = isset($_POST['name']) ? $_POST['name'] : "Unknown";
$customerCity   = isset($_POST['city']) ? $_POST['city'] : "";
$customerZip    = isset($_POST['zip']) ? $_POST['zip'] : "";
$customerAddr   = isset($_POST['address']) ? $_POST['address'] : "";


$_SESSION['order_details'] = [
    'name'    => $customerName,
    'email'   => $customerEmail,
    'mobile'  => $customerPhone,
    'address' => $customerAddr,
    'city'    => $customerCity,
    'zip'     => $customerZip,
    'user_id' => $customerId,
    'amount'  => $orderAmount,
    "total"   => $orderTotal,
    "remaining" => $orderRemaining
];

if ($orderAmount <= 0) {
    die("Invalid order amount.");
}

// Cashfree URL
$url = "https://sandbox.cashfree.com/pg/orders";

$orderId = "ORDER_" . time();

// Prepare order payload
$orderData = [
    "order_id"       => $orderId,
    "order_amount"   => $orderAmount,
    "order_currency" => "INR",

    "customer_details" => [
        "customer_id"    => $customerId,
        "customer_name"  => $customerName,
        "customer_email" => $customerEmail,
        "customer_phone" => $customerPhone,
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

if (isset($result['payment_session_id'])) {
    header("Location: cashfree_ui.php?session_id=" . urlencode($result['payment_session_id']));
    exit;
} else {
    echo "<pre>Error creating order: ";
    print_r($result);
    echo "</pre>";
}
