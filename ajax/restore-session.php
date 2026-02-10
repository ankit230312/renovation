<?php
require "../common/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'])) {
    echo json_encode(["status" => "fail"]);
    exit;
}

$email = $data['email'];


$stmt = $conn->prepare("SELECT id, full_name, email FROM usersnew WHERE email=? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {



    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name']  = $user['full_name'];

    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "fail"]);
}
