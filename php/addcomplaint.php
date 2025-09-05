<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add a Complaint</title>
<link rel="stylesheet" href="../new css/main.css">
<link rel="stylesheet" href="../css/userhome.css">
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: url('../images/background.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    /* Navbar */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: rgb(128, 19, 147);
        font-weight: bold;
        font-size: large;
        background-color: rgba(255,255,255,0.2);
        backdrop-filter: blur(5px);
        z-index: 1000;
    }

    .navbar ul {
        list-style: none;
        display: flex;
        gap: 30px;
        margin: 0;
        padding: 0;
    }

    .navbar ul li a {
        text-decoration: none;
        color: inherit;
    }

    .navbar ul li a:hover {
        color: #8c02db;
        transition: 0.3s;
    }

    /* Container */
    .container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 140px;
        min-height: 100vh;
        box-sizing: border-box;
    }

    /* Form Box */
    .form-box {
        background: rgba(255,255,255,0.45);
        backdrop-filter: blur(8px);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.35);
        padding: 40px 40px;
        width: 600px;
        max-width: 95%;
    }

    .form-box h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #000;
    }

    label {
        display: block;
        margin-top: 12px;
        font-weight: bold;
        color: black;
    }

    label span {
        color: red;
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

    /* Checkboxes */
    .checkbox-group {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        background-color: rgba(255,255,255,0.3);
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: 0.3s;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 8px;
        accent-color: #8c02db;
        width: 18px;
        height: 18px;
    }

    .checkbox-item:hover {
        background-color: rgba(140, 2, 219, 0.1);
        border-color: #8c02db;
    }

    /* Radio Buttons */
    .radio-group {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    .radio-item {
        display: flex;
        align-items: center;
        background-color: rgba(255,255,255,0.3);
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: 0.3s;
    }

    .radio-item input[type="radio"] {
        margin-right: 8px;
        accent-color: #8c02db;
        width: 18px;
        height: 18px;
    }

    .radio-item:hover {
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

    input[type=range] {
        width: 100%;
    }

    /* Responsive */
    @media(max-width: 650px){
        .form-box {
            width: 95%;
            padding: 30px 20px;
        }

        .checkbox-group, .radio-group {
            flex-direction: column;
        }
    }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <img src="../images/logo.png" alt="Logo" class="logo" style="width:100px;height:110px;">
    <ul>
        <li><a href="addcomplain.php">Add a Complaint</a></li>
        <li><a href="mycomplaints.php">My Complaints</a></li>
        <li><a href="communitydashboard.php">Community Dashboard</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Complaint Form -->
<div class="container">
    <div class="form-box">
        <h2>Submit a Neighborhood Complaint</h2>
        <form action="submitcomplaint.php" method="post" enctype="multipart/form-data">

            <!-- Complaint Type -->
            <label for="type">Complaint Type <span>*</span></label>
            <select id="type" name="type" required>
                <option value="">--Select--</option>
                <option value="noise">Noise</option>
                <option value="garbage">Garbage</option>
                <option value="safety">Safety</option>
                <option value="other">Other</option>
            </select>

            <!-- Severity Level -->
            <label>Severity Level</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="low" name="severity[]" value="Low">
                    <label for="low">Low</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="medium" name="severity[]" value="Medium">
                    <label for="medium">Medium</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="high" name="severity[]" value="High">
                    <label for="high">High</label>
                </div>
            </div>

            <!-- Urgency -->
            <label>Urgency</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="urgent" name="urgency" value="Urgent">
                    <label for="urgent">Urgent</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="normal" name="urgency" value="Normal">
                    <label for="normal">Normal</label>
                </div>
            </div>

            <!-- Complaint Description -->
            <label for="complaint">Complaint Description <span>*</span></label>
            <textarea id="complaint" name="complaint" rows="5" placeholder="Describe your complaint" required></textarea>

            <!-- Date of Incident -->
            <label for="date">Date of Incident</label>
            <input type="date" id="date" name="date">

            <!-- Location -->
            <label for="location">Location / Neighborhood</label>
            <input type="text" id="location" name="location" placeholder="Enter location or neighborhood">

            <!-- Priority Level -->
            <label for="priority">Priority Level</label>
            <input type="range" id="priority" name="priority" min="1" max="10" value="5">

            <!-- Attach Images -->
            <label for="images">Attach Images</label>
            <input type="file" id="images" name="images[]" multiple>

            <!-- Submit -->
            <button type="submit">Submit Complaint</button>
        </form>
    </div>
</div>

</body>
</html>
