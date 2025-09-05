<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone = $_POST["phone"];

    // Check match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if email exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
    $check->bind_param("ss", $email, $phone);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $update->bind_param("ss", $hashedPassword, $email);

        if ($update->execute()) {
            echo "<script>
                    alert('Password updated successfully!');
                    setTimeout(function(){ window.location.href = 'login.php'; }, 1500);
                  </script>";
        } else {
            echo "<script>alert('Error updating password.');</script>";
        }
    } else {
        echo "<script>alert('Email not found!');</script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../new css/main.css">
  <link rel="stylesheet" href="../new css/login.css">
</head>
<body>
  <div class="container">
    <img src="../images/logo.png" alt="Neighborhood Complaint System" width="100" height="110">
    <h1 style="color: #4e01d3ff;">Neighborly Resolve</h1>
    <p style="color: #fff; margin-bottom: 20px;font-size: 15px;">
    Enter your registered email to reset your password.
    </p>
    <form action="forget.php" method="post">
      <div class="input-field">
      <input type="email" name="email" placeholder="Enter your Email" required><br><br>
      <input type="password" name="password" placeholder="Enter New Password" required><br><br>
      <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br><br>
      <button class='btn'type="submit">Reset Password</button>
    </div>
    <div class="options">
      <a href="login.php">Back to Login</a>
    </div>
  </div>
</body>
</html>

