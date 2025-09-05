<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if email exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
    $check->bind_param("ss", $email, $email);
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
  <style>
    body {
      font-family: Arial, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url("../images/background.jpg") no-repeat center center/cover;
    }

    .container {
      width: 360px;
      padding: 30px;
      border-radius: 15px;
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #560087ff;
      font-size: 22px;
      text-decoration: underline;
    }

    .input-field {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
      box-sizing: border-box;
}

    .input-field input {
      width: 94%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      outline: none;
      font-size: 15px;
    }

    .btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #fff;
      color: #4b2c91;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background: #f1f1f1;
    }

    .options {
      margin-top: 15px;
      font-size: 14px;
      color: #fff;
    }

    .options a {
      color: #fff;
      text-decoration: none;
      margin: 0 5px;
    }

    .options a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="../images/logo.png" alt="Neighborhood Complaint System" width="100" height="110">
    <h1 style="color: #4e01d3ff;">Neighborly Resolve</h1>
    <p style="color: #fff; margin-bottom: 20px;font-size: 18px;">
      Enter your registered email. 
      <br />We will reset your password.
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

