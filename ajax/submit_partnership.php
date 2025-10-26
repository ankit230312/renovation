<?php
header('Content-Type: application/json');

include "../common/db.php";



if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}


// echo json_encode($_POST);
// die;

$fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$profession = mysqli_real_escape_string($conn, $_POST['profession']);
$experience = mysqli_real_escape_string($conn, $_POST['experience']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

// Validation
if (empty($fullName) || empty($email) || empty($phone) || empty($profession) || empty($experience) || empty($location)) {
    echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
    exit;
}

// Insert query
$query = "INSERT INTO partnership_requests (full_name, email, phone, profession, experience, location, message)
          VALUES ('$fullName', '$email', '$phone', '$profession', '$experience', '$location', '$message')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success", "message" => "Thank you! We'll contact you within 24 hours."]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
}
?>
