<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get and trim form data
    $fullname = trim($_POST['fullname']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['confirm'];

    $today = new DateTime();
    $birthDate = new DateTime($dob);
    $age = $today->diff($birthDate)->y;

    // -----------------------
    // Full Name Validation
    // -----------------------
    if (empty($fullname)) {
        echo "<script>alert('Full name is required!'); window.history.back();</script>";//window.history.back(); "Go back to the previous page in the browsing history
    }
    if (!preg_match("/^[a-zA-Z ]+$/", $fullname)) {//regex pattern.
        echo "<script>alert('Full name can only contain letters and spaces!'); window.history.back();</script>";
        exit;
    }

    // -----------------------
    // Address Validation
    // -----------------------
    if (empty($address)) {
        echo "<script>alert('Address is required!'); window.history.back();</script>";
        exit;
    }
    if (strlen($address) < 5) {
        echo "<script>alert('Address is too short!'); window.history.back();</script>";
        exit;
    }

    // -----------------------
    // Phone Validation
    // -----------------------
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "<script>alert('Phone must be exactly 10 digits!'); window.history.back();</script>";
        exit;
    }

    // -----------------------
    // DOB / Age Validation
    // -----------------------
    if ($birthDate > $today) {
        echo "<script>alert('Birthday cannot be in the future!'); window.history.back();</script>";
        exit;
    }
    if ($age < 18) {
        echo "<script>alert('You must be at least 18 years old!'); window.history.back();</script>";
        exit;
    }
    if ($age > 120) {
        echo "<script>alert('Please enter a realistic birthday!'); window.history.back();</script>";
        exit;
    }
    $year = (int)$birthDate->format("Y");
    if ($year < 1900) {
        echo "<script>alert('Please enter a realistic year of birth!'); window.history.back();</script>";
        exit;
    }

    // -----------------------
    // Email Validation
    // -----------------------
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.history.back();</script>";
        exit;
    }

    // -----------------------
    // Password Validation (simplified)
    // -----------------------
    if (strlen($password) < 3) {
        echo "<script>alert('Password must be at least 3 characters!'); window.history.back();</script>";
        exit;
    }
    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // -----------------------
    // Check for existing email or phone
    // -----------------------
    $checkQuery = "SELECT * FROM users WHERE email=? OR phone=?";
    //??  this prevents SQL injection

    $checkstmt = $conn->prepare($checkQuery);
    $checkstmt->bind_param("ss", $email, $phone);
    $checkstmt->execute();
    $result = $checkstmt->get_result();
    if ($result->num_rows > 0) {  //result no of rows ->
        echo "<script>alert('Email or Phone already registered!'); window.history.back();</script>";
        $checkstmt->close();    
        $conn->close();     
        exit;
    }
    $checkstmt->close();

    // -----------------------
    // Hash Password and Insert
    // -----------------------
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //strongest available algorithm in PHP
    $role = 'user';

    $sql = "INSERT INTO users (full_name, address, phone, dob, email, password, role)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertstmt = $conn->prepare($sql);
    $insertstmt->bind_param("sssssss", $fullname, $address, $phone, $dob, $email, $hashedPassword, $role);

    if ($insertstmt->execute()) {
        echo "<script>alert('Signup successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $insertstmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup Page</title>
<link rel="stylesheet" href="../new css/main.css">  
<link rel="stylesheet" href="../new css/signup.css"> 
</head>
<body>
<div class="container">

    <!-- Left side -->
    <div class="left-side glass-container glass-padding">
        <div>
            <img src="../images/logo.png" alt="Logo" class="logo">
            <h1 style="color: #4e01d3ff;">Neighborly Resolve</h1>
            <p class="tagline">Connecting neighbors, sharing updates, building trust.</p>
            <div class="illustration">
                <img src="../images/handshake.png" alt="Community Illustration">
            </div>
        </div>
    </div>

    <!-- Right side -->
    <div class="right-side">
        <div class="form-box glass-container glass-padding">
            <h2>Signup</h2>
            <form id="signupForm" action="signup.php" method="POST">

                <label for="fullname">Full Name <span>*</span></label>
                <input type="text" id="fullname" name="fullname" required placeholder="Enter your full name">
                <span class="error"></span>

                <label for="address">Address <span>*</span></label>
                <input type="text" id="address" name="address" required placeholder="Enter your address">
                <span class="error"></span>

                <label for="phone">Phone Number <span>*</span></label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="07XXXXXXXX" required>
                <span class="error"></span>

                <label for="email">Email <span>*</span></label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                <span class="error"></span>

                <label for="dob">Birthday <span>*</span></label>
                <input type="date" id="dob" name="dob" required>
                <span class="error"></span>

                <label for="password">Password <span>*</span></label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
                <span class="error"></span>

                <label for="confirm">Confirm Password <span>*</span></label>
                <input type="password" id="confirm" name="confirm" required placeholder="Confirm your password">
                <span class="error"></span>
                <br>
                <button type="submit">Signup</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

</div>
<script src="../js/signup.js"></script>
</body>
</html>
