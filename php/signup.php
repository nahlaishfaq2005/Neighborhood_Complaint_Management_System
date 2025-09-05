<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

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
    $checkstmt = $conn->prepare($checkQuery);
    $checkstmt->bind_param("ss", $email, $phone);
    $checkstmt->execute();
    $result = $checkstmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Email or Phone already registered!');</script>";
        $checkstmt->close();    
        $conn->close();     
        exit;
    }
    $checkstmt->close();

    // Optional: hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (full_name, address, phone, dob, email, password)
            VALUES (?, ?, ?, ?, ?, ?)";
    $insertstmt = $conn->prepare($sql);
    $insertstmt->bind_param("ssssss", $fullname, $address, $phone, $dob, $email, $hashedPassword);

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
            <div >
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
                <h2 style="color: #4e01d3ff;text-decoration: underline;">Signup</h2>
                <form id="signupForm" action="signup.php" method="POST">

                    <label for="fullname">Full Name <span>*</span></label>
                    <input type="text" id="fullname" name="fullname" required placeholder="Enter your full name">

                    <label for="address">Address <span>*</span></label>
                    <input type="text" id="address" name="address" required placeholder="Enter your address">

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

                    <button type="submit">Signup</button>
                </form>
                <p>Already have an account? <a href="login.php"> | Login</a></p>
            </div>
        </div>

    </div>

    <script src="../js/signup.js"></script>
</body>
</html>
