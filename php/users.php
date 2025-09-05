<?php
session_start();
include 'config.php';

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// DELETE a user (only role = 'user')
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    
    // Check the user's role first
    $check = mysqli_query($conn, "SELECT role FROM users WHERE user_id = $delete_id");
    $user = mysqli_fetch_assoc($check);
    
    if ($user && $user['role'] == 'user') {
        mysqli_query($conn, "DELETE FROM users WHERE user_id = $delete_id");
    }
    
    header("Location: users.php");
    exit;
}

// Fetch all users
$users = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users</title>
<link rel="stylesheet" href="../new css/main.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar glass-container">
    <img src="../images/logo.png" alt="Logo" class="logo" style="width:100px;height:110px;">
    <ul>
        <li><a href="adminhome.php">Admin Dashboard</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div style="margin-top:140px;">

<h2 style="text-align:center; margin-bottom:20px;">All Users</h2>

<?php while($row = mysqli_fetch_assoc($users)): ?>
<div class="card">
    <p><strong>Name:</strong> <?= htmlspecialchars($row['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($row['dob']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($row['role']) ?></p>

    <div class="actions">
        <?php if($row['role'] != 'admin'): // Only delete users ?>
        <a href="users.php?delete=<?= $row['user_id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        <?php endif; ?>
    </div>
</div>
<?php endwhile; ?>

</div>
</body>
</html>
