<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch complaints from other users with their names
$complaints = mysqli_query($conn, "
    SELECT c.*, u.full_name 
    FROM complaints c
    JOIN users u ON c.user_id = u.user_id
    WHERE c.user_id != $user_id
    ORDER BY c.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Community Dashboard</title>
<link rel="stylesheet" href="../new css/main.css">
<style>
/* Optional: highlight other users' complaints */

.status {
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 5px;
    color: white;
}
.status.pending { background-color: orange; }
.status.in_progress { background-color: blue; }
.status.resolved { background-color: green; }
.navbar glass-container ul{
    list-style: none;
    display: flex;
    gap:15px;
    margin:0;
    padding:0;
}
.navbar ul li a {
    text-decoration: none; 
    border-radius: 8px;
    color: #3d045eff;
    font-weight: bold;
    transition: 0.3s;
}
.navbar ul li a:hover {
    background-color: #3d045eff;
    padding: 5px 5px;
    color:white;
    transform: translateY(-2px); /* slight lift effect */
    box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* optional shadow */
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar glass-container">
    <div class="navbar-brand">
        <img src="../images/logo.png" alt="Logo" class="logo" style="width:100px;height:110px;">
        <h1>NeighborlyResolve</h1>
    </div>
    <ul>
        <li><a href="userhome.php">Add a Complaint</a></li>
        <li><a href="mycomplaints.php">My Complaints</a></li>
        <li><a href="communitydashboard.php">Community Dashboard</a></li>
        <li><a href="help.php">Help</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div style="margin-top:50px;">

<?php while($row = mysqli_fetch_assoc($complaints)): ?>
<div class="card other-user">
    <h3><?= htmlspecialchars($row['title']) ?></h3>
    <p><strong>Posted by:</strong> <?= htmlspecialchars($row['full_name']) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
    <p><strong>Severity:</strong> <?= htmlspecialchars($row['severity']) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($row['incident_date']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
    <p><strong>Status:</strong> 
        <span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span>
    </p>
    <p><strong>Remarks:</strong> <?= htmlspecialchars($row['remarks']) ?></p>
    <?php if(!empty($row['images'])): 
        foreach(explode(';',$row['images']) as $img) if($img) echo "<img src='$img'>"; 
    endif; ?>
</div>
<?php endwhile; ?>

</div>
</body>
</html>
