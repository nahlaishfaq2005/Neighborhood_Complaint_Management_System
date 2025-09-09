<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM complaints WHERE complaint_id=$delete_id AND user_id=$user_id");
    header("Location: mycomplaints.php");
    exit;
}

$editData = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM complaints WHERE complaint_id=$edit_id AND user_id=$user_id");
    $editData = mysqli_fetch_assoc($result);
}


if (isset($_POST['update'])) {
    $id = intval($_POST['complaint_id']);
    $title = $_POST['title'];
    $type = $_POST['type'];
    $severity = $_POST['severity'];
    $description = $_POST['description'];
    $date = $_POST['incident_date'];
    $location = $_POST['location'];

    
    $images = $editData['images'];
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        foreach ($_FILES['images']['name'] as $k => $name) {
            $tmp = $_FILES['images']['tmp_name'][$k];
            $filePath = $uploadDir . time() . "_" . basename($name);
            move_uploaded_file($tmp, $filePath);
            $images .= $filePath . ";";
        }
    }

    mysqli_query($conn, "UPDATE complaints 
        SET title='$title', type='$type', severity='$severity', description='$description', 
            incident_date='$date', location='$location', images='$images' 
        WHERE complaint_id=$id AND user_id=$user_id");

    header("Location: mycomplaints.php");
    exit;
}


$complaints = mysqli_query($conn, "SELECT * FROM complaints WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Complaints</title>
<link rel="stylesheet" href="../new css/main.css">
</head>
<body>


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
<?php if($editData): ?>
<div class="card">
    <div class="form-box">
        <h2>Edit Complaint</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="complaint_id" value="<?= $editData['complaint_id'] ?>">
            
            <label for="title">Complaint Title <span>*</span></label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($editData['title']) ?>" required>

            <label for="type">Complaint Type <span>*</span></label>
            <select id="type" name="type" required>
                <?php 
                $types = ['noise','garbage','safety','water','parking','streetlight','road','electricity','pollution','pets','other'];
                foreach($types as $t){
                    $selected = $editData['type']==$t ? 'selected' : '';
                    echo "<option value='$t' $selected>$t</option>";
                }
                ?>
            </select>

            <label>Severity <span>*</span></label>
            <div class="radiobutton-group">
                <?php
                $severities = ['Low','Medium','High'];
                foreach($severities as $s){
                    $checked = ($editData['severity']==$s) ? 'checked' : '';
                    echo '<label class="radiobutton-item">
                            <input type="radio" name="severity" value="'.$s.'" '.$checked.' required>
                            '.$s.'
                          </label>';
                }
                ?>
            </div>

            <label for="description">Complaint Description <span>*</span></label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($editData['description']) ?></textarea>

            <label for="incident_date">Date of Incident</label>
            <input type="date" id="incident_date" name="incident_date" value="<?= $editData['incident_date'] ?>">

            <label for="location">Location / Neighborhood</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($editData['location']) ?>">

            <label for="images">Attach Images</label>
            <input type="file" id="images" name="images[]" multiple>
            <?php
            if(!empty($editData['images'])){
                $imgs = explode(';', $editData['images']);
                foreach($imgs as $img){
                    if($img) echo "<img src='$img' style='width:80px;height:80px;margin:5px;'>";
                }
            }
            ?>

            <button type="submit" name="update">Update Complaint</button>
        </form>
    </div>
</div>
<?php endif; ?>



<?php while($row = mysqli_fetch_assoc($complaints)): ?>
<div class="card">
    <h3><?= htmlspecialchars($row['title']) ?></h3>
    <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
    <p><strong>Severity:</strong> <?= htmlspecialchars($row['severity']) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($row['incident_date']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
    <p><strong>Status:</strong> 
        <span class="status <?= htmlspecialchars($row['status']) ?>">
            <?= ucfirst(str_replace('_', ' ', $row['status'])) ?>
        </span>
    </p>

    <?php if(!empty($row['images'])): 
        $imgs = explode(';',$row['images']); ?>
        <?php foreach($imgs as $img) if($img) echo "<img src='$img'>"; ?>
    <?php endif; ?>

    <div class="actions">
        <a href="mycomplaints.php?edit=<?= $row['complaint_id'] ?>">Edit</a>
        <a href="mycomplaints.php?delete=<?= $row['complaint_id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </div>
</div>
<?php endwhile; ?>

</div>
</body>
</html>
