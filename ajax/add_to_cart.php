<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['product_id'])) {
    // Single product add
    $productId = $_POST['product_id'];

    $_SESSION['single_cart_product'] = $productId;

    echo json_encode(['success' => true]);
} else {
    // Multiple product add
    $data = json_decode($_POST['product_id_cart'], true);


// echo "<pre>";print_r($data);die;
    if (!is_array($data)) {
        echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
        exit;
    }

    if (isset($data['id'])) {
        $data = [$data];
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $products = [];

    foreach ($data as $item) {
        $products[] = [
            "id"        => $item['id'] ?? "",
            "name"      => $item['name'] ?? "",
            "price"     => $item['price'] ?? "0",
            "area"      => $item['area'] ?? "0",
            "productId" => $item['productId'] ?? ""
        ];
    }




    // push into numeric array
    $_SESSION['cart'] = $products;


    // unset($_SESSION['cart']);



    echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
}
