<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
</head>
<body>
    <h2>You are logged out.</h2>
    <a href="login.php">Go to Login</a>
</body>
</html>
