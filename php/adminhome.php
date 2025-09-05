<?php
session_start();
include 'config.php';

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// DELETE a complaint
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM complaints WHERE complaint_id = $delete_id");
    header("Location: adminhome.php");
    exit;
}

// EDIT a complaint (admin can edit only status & remarks)
$editData = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "
        SELECT c.*, u.full_name 
        FROM complaints c 
        JOIN users u ON c.user_id = u.user_id 
        WHERE c.complaint_id = $edit_id
    ");
    $editData = mysqli_fetch_assoc($result);
}

// Handle edit form submission
if (isset($_POST['update'])) {
    $id = intval($_POST['complaint_id']);
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    mysqli_query($conn, "UPDATE complaints 
        SET status='$status', remarks='$remarks' 
        WHERE complaint_id=$id");

    header("Location: adminhome.php");
    exit;
}

// Fetch all complaints except the one being edited
$where_edit = $editData ? "WHERE c.complaint_id != ".$editData['complaint_id'] : "";
$complaints = mysqli_query($conn, "
    SELECT c.*, u.full_name 
    FROM complaints c 
    JOIN users u ON c.user_id = u.user_id 
    $where_edit
    ORDER BY c.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../new css/main.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar glass-container">
    <div class="navbar-brand">
        <img src="../images/logo.png" alt="Logo" class="logo" style="width:100px;height:110px;">
        <h1>NeighborlyResolve</h1>
    </div>
    <ul>
        <li><a href="adminhome.php">Community Dashboard</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div style="margin-top:50px;">

<!-- Edit Form -->
<?php if($editData): ?>
<div class="card">
    <h3>Edit Complaint</h3>
    <form method="post">
        <input type="hidden" name="complaint_id" value="<?= $editData['complaint_id'] ?>">

        <p><strong>Title:</strong> <?= htmlspecialchars($editData['title']) ?></p>
        <p><strong>User:</strong> <?= htmlspecialchars($editData['full_name']) ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($editData['type']) ?></p>
        <p><strong>Severity:</strong> <?= htmlspecialchars($editData['severity']) ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($editData['description'])) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($editData['incident_date']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($editData['location']) ?></p>

        <label>Status:</label>
        <select name="status" required>
            <?php
            $statuses = ['pending','in_progress','resolved'];
            foreach($statuses as $s) {
                $sel = $editData['status']==$s ? 'selected' : '';
                echo "<option value='$s' $sel>$s</option>";
            }
            ?>
        </select>

        <label>Remarks:</label>
        <textarea name="remarks"><?= htmlspecialchars($editData['remarks']) ?></textarea>

        <button type="submit" name="update">Update</button>
    </form>
</div>
<?php endif; ?>

<!-- All Complaints -->
<?php while($row = mysqli_fetch_assoc($complaints)): ?>
<div class="card">
    <h3><?= htmlspecialchars($row['title']) ?></h3>
    <p><strong>Posted by:</strong> <?= htmlspecialchars($row['full_name']) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
    <p><strong>Severity:</strong> <?= htmlspecialchars($row['severity']) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($row['incident_date']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
    <p><strong>Status:</strong> 
        <span class="status <?= $row['status'] ?>"><?= ucfirst(str_replace('_',' ',$row['status'])) ?></span>
    </p>
    <p><strong>Remarks:</strong> <?= htmlspecialchars($row['remarks']) ?></p>

    <?php if(!empty($row['images'])): 
        $imgs = explode(';',$row['images']);
        foreach($imgs as $img) if($img) echo "<img src='$img'>";
    endif; ?>

    <div class="actions">
        <a href="adminhome.php?edit=<?= $row['complaint_id'] ?>">Edit</a>
        <a href="adminhome.php?delete=<?= $row['complaint_id'] ?>" onclick="return confirm('Delete this complaint?')">Delete</a>
    </div>
</div>
<?php endwhile; ?>

</div>
</body>
</html>
