<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if email or phone exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
    $check->bind_param("ss", $identifier, $identifier);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE users SET password=? WHERE email=? OR phone=?");
        $update->bind_param("sss", $hashedPassword, $identifier, $identifier);
        $update->execute();

        echo "<script>
                alert('If your account exists, your password has been reset.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('If your account exists, your password has been reset.');
                window.location.href = 'login.php';
              </script>";
    }
    $check->close();
    $update->close();
    $conn->close();
}
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
      Enter your registered email or phone to reset your password.
    </p>
    <form action="forget.php" method="post">
      <div class="input-field">
        <input type="text" name="identifier" placeholder="Enter your Email or Phone No" required><br><br>
        <input type="password" name="password" placeholder="Enter New Password" required><br><br>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br><br>
        <button class='btn' type="submit">Reset Password</button>
      </div>
      <div class="options">
        <a href="login.php">Back to Login</a>
      </div>
    </form>
  </div>
</body>
</html>

