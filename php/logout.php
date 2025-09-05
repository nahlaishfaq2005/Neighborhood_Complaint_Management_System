<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout</title>
<link rel="stylesheet" href="../new css/main.css"> <!-- Link to external CSS -->
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .button {
    text-align: center;
    width: 100%;
    }
    .button a{
        display: inline-block;
        padding: 12px 30px;
        background-color: hsla(272, 100%, 40%, 1.00);
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 8px;
        margin-top: 20px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
</style>
</head>
<body>
<div class="container">
    <div class="form-box glass-container">
        <div class="logo-title">
        <img src="../images/logo.png" alt="Neighborhood Complaint System" width="100" height="110">
        <h1 style="color: #4e01d3ff;">Neighborly Resolve</h1>
    </div>
    <h2 style="color: #000000ff;">You have been logged out!</h2>
    <p>Click below to go back to login page:</p>  
    <div class="button">
        <a href="login.php">Login Again</a>
    </div>
</div>

</body>
</html>
