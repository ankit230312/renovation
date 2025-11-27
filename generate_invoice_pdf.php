<?php
require 'dompdf/autoload.inc.php';
require 'vendor/autoload.php'; // PHPMailer

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// include "common/db.php";

// -------------------------
// 1) Get order_id
// -------------------------
$orderId = $orderPrimaryId ?? 0;
if (!$orderId) die("Invalid order ID");

// -------------------------
// 2) LOAD DYNAMIC HTML
// -------------------------
ob_start();
include "invoice.php";
$html = ob_get_clean();

// -------------------------
// 3) GENERATE PDF
// -------------------------
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();

$pdfOutput = $dompdf->output();

$invoicePath = "invoices/invoice_$orderId.pdf";
file_put_contents($invoicePath, $pdfOutput);

// -------------------------
// 4) FETCH USER EMAIL
// -------------------------
$order = $conn->query("SELECT * FROM orders WHERE orderID=$orderId")->fetch_assoc();
$userId = $order['userID'];
$user = $conn->query("SELECT * FROM usersnew WHERE id=$userId")->fetch_assoc();

$customerEmail = $user['email'];
$customerName = $user['full_name'] ?? $order['customer_name'];

// -------------------------
// 5) SEND EMAIL (PHPMailer)
// -------------------------

$mail = new PHPMailer(true);

try {

    // SMTP CONFIGURATION
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // YOUR GMAIL + APP PASSWORD
    $mail->Username = "ankit00mourya@gmail.com";
    $mail->Password = "viwtowjdduarlymw";

    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    // SENDER
    $mail->setFrom("ankit00mourya@gmail.com", "SplitFloor");

    // RECEIVER
    $mail->addAddress($customerEmail, $customerName);

    // ATTACHMENT
    $mail->addAttachment($invoicePath);

    // CONTENT
    $mail->isHTML(true);
    $mail->Subject = "Your Invoice - SplitFloor";
    $mail->Body = "
        Dear $customerName,<br><br>
        Thank you for your order. Please find your invoice attached.<br><br>
        Regards,<br>
        Team SplitFloor
    ";

    // SEND
    $mail->send();
    echo "Invoice generated & email sent successfully!";

} catch (Exception $e) {
    echo "Mail Error: " . $mail->ErrorInfo;
}

// Clear cart session
unset($_SESSION['cart']);
unset($_SESSION['single_cart_product']);
unset($_SESSION['order_details']);

?>
