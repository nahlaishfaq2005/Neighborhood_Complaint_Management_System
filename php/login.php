<?php
session_start();
include 'config.php'; // Make sure this connects to your DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = isset($_POST['login']) ? $_POST['login'] : ''; // can be email or phone
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($login) || empty($password)) {
        echo "<script>alert('Please enter both email/phone and password.'); window.history.back();</script>";
        exit;
    }

    // Prepare query: check either email or phone
    $sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Login success: save session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['role'] = $user['role']; // save role in session

            // Redirect based on role
            if ($user['role'] === 'admin') {
                echo "<script>window.location.href='../adminhome.html';</script>";
            } else {
                echo "<script>window.location.href='userhome.php';</script>";
            }
            exit;
        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('No account found with this email/phone.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Neighborhood Complaint System - Login</title>
<style>
  /* Reset */
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url("../images/background2.jpg") no-repeat center center/cover;
  }

  .container {
    width: 360px;
    padding: 30px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    backdrop-filter: blur(10px);
    text-align: center;
  }

  .logo { margin-bottom: 15px; }
  .logo img { width: 100px; }

  h2 { margin-bottom: 20px; color: #fff; font-size: 24px; }

  .input-field { width: 100%; margin-bottom: 15px; }
  .input-field input {
    width: 100%;
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

  .btn:hover { background: #f1f1f1; }

  .options { margin-top: 15px; font-size: 14px; color: #fff; }
  .options a { color: #fff; text-decoration: none; margin: 0 5px; }
  .options a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
  <div class="logo">
    <img src="../images/logo.png" alt="Neighborhood Complaint System">
    <h1 style="color: #4e01d3ff;">Neighborly Resolve</h1>
  </div>
  <h2>Login</h2>
  <!-- Form submits to this same PHP -->
  <form action="login.php" method="POST">
    <div class="input-field">
      <input type="text" name="login" placeholder="Email or Phone" required>
    </div>
    <div class="input-field">
      <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" class="btn">Login</button>
  </form>
  <div class="options">
    <a href="forget.php">Forgot Password?</a> | <a href="signup.php">Sign Up</a>
  </div>
</div>
</body> 
</html>
