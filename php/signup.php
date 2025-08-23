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
    $checkQuery = "SELECT * FROM users WHERE email='$email' OR phone='$phone'";
    $result = $conn->query($checkQuery);
    if ($result->num_rows > 0) {
        echo "<script>alert('Email or Phone already registered!'); window.history.back();</script>";
        exit;
    }

    // Optional: hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (full_name, address, phone, dob, email, password)
            VALUES ('$fullname', '$address', '$phone', '$dob', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Signup successful!'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
