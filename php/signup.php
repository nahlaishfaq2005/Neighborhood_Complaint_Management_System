<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm']; // corrected name

    // Check if passwords match
    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if email or phone already exists
    $checkQuery = "SELECT * FROM users WHERE email=? OR phone=?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Email or Phone already registered!');</script>";
        exit;
    }

    // Optional: hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (full_name, address, phone, dob, email, password)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fullname, $address, $phone, $dob, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful!'); window.location.href='../php/login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
