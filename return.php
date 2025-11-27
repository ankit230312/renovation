<?php

include("common/db.php");
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

        // (1) Get values from session that you stored earlier
        $od = $_SESSION['order_details'];



        $cart = $_SESSION['cart']; // cart items array

        $customerName = $od['name'];
        $contactNo    = $od['mobile'];
        $address      = $od['address'];
        $city         = $od['city'];
        $zip          = $od['zip'];
        $userId       = $od['user_id'];
        $orderAmount  = $od['amount'];
        $email = $od['email'];

        // print_r($od);die;

        date_default_timezone_set("Asia/Kolkata");
        $now = date("Y-m-d H:i:s");

        // (2) INSERT into orders table
        $sqlOrder = "INSERT INTO orders 
        (cityID, userID, vendorID, customer_name, contact_no, house_no, apartment, landmark, location, latitude, longitude, address_type, agentID, coupon_code, type, coupon_discount, delivery_charges, order_amount, total_amount, cashback_amount, payment_method, instruction, delivery_date, delivery_slot, status, rate_status, rate_value, order_from, added_on, updated_on) 
        VALUES 
        (2, '$userId', 2, '$customerName', '$contactNo', '', '', '', '$address', '', '', 'home', 0, '', NULL, 0, 0, '$orderAmount', '$orderAmount', 0, 'online', '', NOW(), '', 'PLACED', 'N', 0, 'WEB', '$now', '$now')";
        // print_r($sqlOrder);die;
        if ($conn->query($sqlOrder) === TRUE) {

            $orderPrimaryId = $conn->insert_id;  // this orderID for linking items

            // (3) Insert each cart item into order_items table
            foreach ($cart as $item) {

                $productId = $item['productId'];
                $qty       = 1;
                $price     = $item['price'];
                $netPrice  = $item['area'] * $item['price'];

                $sqlItem = "INSERT INTO order_items 
                (orderID, productID, variantID, qty, price, net_price, status, added_on, updated_on) 
                VALUES 
                ('$orderPrimaryId', '$productId', 0, '$qty', '$price', '$netPrice', 'PLACED', '$now', '$now')";

                $conn->query($sqlItem);
            }


            // unset($_SESSION['cart']);
            // unset($_SESSION['single_cart_product']);
            // unset($_SESSION['order_details']);

            // $invoiceUrl = "http://localhost/splitfloor/generate_invoice_pdf.php?order_id=" . $orderPrimaryId;
            // file_get_contents($invoiceUrl);

            include("generate_invoice_pdf.php");
            // die();

            header("Location: payment_success.php?order_id=" . $orderPrimaryId);
            exit;
        } else {
            echo "Database Error: " . $conn->error;
        }
    } else {
        echo "<p>Payment not completed. Current status: {$result['order_status']}</p>";
    }
} else {
    echo "<p>Error fetching payment status.</p>";
    error_log("Missing order_id in response: " . print_r($result, true));
}
