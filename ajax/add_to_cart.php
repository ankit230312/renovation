<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['product_id'])) {



	$productId =  $_POST['product_id'];


	$_SESSION['single_cart_product'] = $productId;
	echo json_encode(['success' => true]);
} else {
	$data = json_decode($_POST['product_id_cart'], true);

	
	if (!is_array($data)) {
		echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
		exit;
	}

	$_SESSION['cart'] = $data;

	echo json_encode(['success' => true]);
}
