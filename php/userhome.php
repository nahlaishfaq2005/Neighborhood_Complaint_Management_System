<?php
session_start();
include 'config.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = $_POST['title'];
    $type        = $_POST['type'];
    $severity = isset($_POST['severity']) ? $_POST['severity'] : "";//if entered or not ?
    $description = $_POST['complaint'];
    $date        = $_POST['date'];
    $location    = $_POST['location'];

    // Handle image upload
    $imagePaths = "";
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        foreach ($_FILES['images']['name'] as $key => $name) {
            $tmpName = $_FILES['images']['tmp_name'][$key];
            $filePath = $uploadDir . time() . "_" . basename($name);
            if (move_uploaded_file($tmpName, $filePath)) {
                $imagePaths .= $filePath . ";";
            }
        }
    }

    // Logged-in user's ID
    $user_id = $_SESSION['user_id'];

    // Default status and remarks
    $status  = 'pending';
    $remarks = 'Waiting for remarks';

    // Insert complaint into DB
    $sql = "INSERT INTO complaints 
            (user_id, title, type, severity, description, incident_date, location, images, status, remarks)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $user_id, $title, $type, $severity, $description, $date, $location, $imagePaths, $status, $remarks);

    if ($stmt->execute()) {
        echo "<script>alert('Complaint submitted successfully!'); window.location.href='mycomplaints.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add a Complaint</title>
<link rel="stylesheet" href="../new css/main.css">
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: url('../images/background.jpg') no-repeat center center fixed;
    background-size: cover;
}
.navbar.glass-container ul{
    list-style: none;
    display: flex;
    gap:25px;
    margin-right:60px;
    padding:0;
}
.navbar {
    position: fixed;
    display: flex;
    top: 0;              
    left: 0;          
    width: 100%;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
    
}
.navbar.glass-container ul li a {
    text-decoration: none; 
    border-radius: 8px;
    color: #3d045eff;
    font-weight: bold;
    transition: 0.3s;
}
.navbar.glass-container ul li a:hover {
    background-color: #3d045eff;
    padding: 5px 5px;
    color:white;
    transform: translateY(-2px); /* slight lift effect */
    box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* optional shadow */
}
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 180px;
    padding-bottom: 50px;
    min-height: 100vh;
    box-sizing: border-box;
    
}
.form-box {
    width: 750px;
 
}
input, textarea, select {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    font-size: 16px;
    box-sizing: border-box;
}
input:focus, textarea:focus, select:focus {
    border-color: #8c02db;
    box-shadow: 0 0 5px #8c02db;
}
.radiobutton-group {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}
.radiobutton-item {
    display: flex;
    align-items: center;
    background-color: rgba(255,255,255,0.3);
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    cursor: pointer;
    transition: 0.3s;
}
.radiobutton-item input[type="radio"] {
    margin-right: 8px;
    accent-color: #8c02db;
    width: 18px;
    height: 18px;
}
.radiobutton-item:hover {
    background-color: rgba(140, 2, 219, 0.1);
    border-color: #8c02db;
}
button {
    width: 100%;
    background-color: hsl(272, 100%, 50%);
    color: white;
    padding: 15px;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background-color: #8c02db;
    transform: translateY(-2px);
}
@media(max-width: 650px){
    .form-box { width: 95%; padding: 30px 20px; }
    .checkbox-group { flex-direction: column; }
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

<!-- Complaint Form -->
<div class="container">
    <div class="form-box">
        <h2>Submit a Neighborhood Complaint</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- both text + file data. -->

            <label for="title">Complaint Title <span>*</span></label>
            <input type="text" id="title" name="title" placeholder="Enter a short title" required>+
            

            <label for="type">Complaint Type <span>*</span></label>
            <select id="type" name="type" required>
                <option value="">--Select--</option>
                <option value="noise">Noise</option>
                <option value="garbage">Garbage</option>
                <option value="safety">Safety</option>
                <option value="water">Water Supply</option>
                <option value="parking">Parking</option>
                <option value="streetlight">Street Light</option>
                <option value="road">Road / Infrastructure</option>
                <option value="electricity">Electricity</option>
                <option value="pollution">Pollution</option>
                <option value="pets">Pets / Animals</option>
                <option value="other">Other</option>
            </select>

            <label>Severity <span>*</span></label>
            <div class="radiobutton-group">
                <label class="radiobutton-item">
                    <input type="radio" id="low" name="severity" value="Low" required>
                    Low
                </label>

                <label class="radiobutton-item">
                    <input type="radio" id="medium" name="severity" value="Medium">
                    Medium
                </label>

                <label class="radiobutton-item">
                    <input type="radio" id="high" name="severity" value="High">
                    High
                </label>
            </div>


            <label for="complaint">Complaint Description <span>*</span></label>
            <textarea id="complaint" name="complaint" rows="5" placeholder="Describe your complaint" required></textarea>

            <label for="date">Date of Incident</label>
            <input type="date" id="date" name="date">

            <label for="location">Location / Neighborhood</label>
            <input type="text" id="location" name="location" placeholder="Enter location or neighborhood">

            <label for="images">Attach Images</label>
            <input type="file" id="images" name="images[]" multiple>

            <button type="submit">Submit Complaint</button>
        </form>
    </div>
</div>

</body>
</html>
