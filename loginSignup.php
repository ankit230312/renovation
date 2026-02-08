<?php 
session_start();
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "u404352962_rapto");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);



// ==================== GOOGLE SIGNUP ====================
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

// ==================== MANUAL SIGNUP ====================
if (isset($data["action"]) && $data["action"] === "manual_signup") {

    $full_name = trim($data["full_name"] ?? "");
    $email = trim($data["email"] ?? "");
    $password = $data["password"] ?? "";
    $confirm_password = $data["confirm_password"] ?? "";

    // Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(["status" => "error", "message" => "Password must be at least 6 characters"]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email address"]);
        exit;
    }

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM usersnew WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new manual user
    $stmt = $conn->prepare("INSERT INTO usersnew (full_name, email, password, provider) VALUES (?, ?, ?, 'manual')");
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);

    if ($stmt->execute()) {
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
    exit;
}

// ==================== MANUAL LOGIN ====================
if (isset($data["action"]) && $data["action"] === "manual_login") {

    $email = trim($data["email"] ?? "");
    $password = $data["password"] ?? "";

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        exit;
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, full_name, email, password, provider FROM usersnew WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
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
            echo json_encode(["status" => "error", "message" => "Invalid password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Email not found"]);
    }
    exit;
}
?>
