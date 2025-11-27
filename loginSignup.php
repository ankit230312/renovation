<?php 
session_start();
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "u404352962_rapto");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["action"]) && $data["action"] === "google_signup") {

    $full_name   = $data["full_name"];
    $email       = $data["email"];
    $provider_id = $data["provider_id"];

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id, full_name, email FROM usersnew WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Existing user login
        $user = $result->fetch_assoc();

        // 🔥 SAVE SESSION VALUES
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["full_name"];
        $_SESSION["user_email"] = $user["email"];

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "full_name" => $user["full_name"]
        ]);
    } else {
        // Insert new Google user
        $stmt = $conn->prepare("INSERT INTO usersnew (full_name, email, provider, provider_id) VALUES (?, ?, 'google', ?)");
        $stmt->bind_param("sss", $full_name, $email, $provider_id);

        if ($stmt->execute()) {

            // NEW USER ID
            $new_id = $stmt->insert_id;

            // 🔥 SAVE SESSION VALUES
            $_SESSION["user_id"] = $new_id;
            $_SESSION["user_name"] = $full_name;
            $_SESSION["user_email"] = $email;

            echo json_encode([
                "status" => "success",
                "message" => "Account created successfully",
                "full_name" => $full_name
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
        }
    }
    exit;
}
?>
