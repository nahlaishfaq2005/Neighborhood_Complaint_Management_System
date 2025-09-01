<?php
// forget.php
$conn = new mysqli("localhost", "root", "", "your_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $update->bind_param("ss", $hashedPassword, $email);

        if ($update->execute()) {
            echo "<script>
                    alert('Password updated successfully!');
                    setTimeout(function(){ window.location.href = 'login.html'; }, 1500);
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
