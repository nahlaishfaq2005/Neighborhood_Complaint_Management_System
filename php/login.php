<?php
session_start(); 
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($login) || empty($password)) {
        echo "<script>alert('Please enter both email/phone and password.'); window.history.back();</script>";
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        

        
        if (password_verify($password, $user['password'])) {
            
           $_SESSION['user_id'] = $user['user_id']; 
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['role'] = $user['role']; 
            if ($user['role'] === 'admin') {
                echo "<script>window.location.href='adminhome.php';</script>";
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
<title>Login</title>
<link rel="stylesheet" href="../new css/login.css">
</head>
<body>
<div class="container">
  <div class="logo" style="margin-top: 50px;">
    <img src="../images/logo.png" alt="Neighborhood Complaint System" width="100" height="110">
    <h1 style="color: #4e01d3ff;margin-top: 70px;">Neighborly Resolve</h1>
  </div>
  <h2 style="text-decoration: underline;">Login</h2>
  

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
