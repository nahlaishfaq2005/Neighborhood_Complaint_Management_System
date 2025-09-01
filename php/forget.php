<?php
// forget.php

// Database connection
$conn = new mysqli("localhost", "root", "", "your_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check password match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Check if email exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update new password (hashed for security)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $update->bind_param("ss", $hashedPassword, $email);
        if ($update->execute()) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Email not found!";
    }
}
$conn->close();
?>
