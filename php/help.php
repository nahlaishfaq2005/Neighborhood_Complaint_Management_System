<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Help Center - Neighborhood Management System</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        line-height: 1.6;
        background: url("../images/background.jpg") no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        color: #333;
    }

    /* Solid white container */
    .white-container {
        background: #fff; /* solid white */
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(0,0,0,0.2);
        padding: 50px 40px;
        max-width: 700px;
        width: 90%;
        margin: 60px auto;
        position: relative;
    }

    .help-heading {
        font-size: 2.5rem;
        font-weight: bold;
        color: #801fa7;
        text-align: center;
        margin-bottom: 40px;
    }

    /* Vertical timeline line */
    .timeline {
        position: absolute;
        left: 40px;
        top: 50px;   /* start below heading */
        bottom: 50px; /* leave space at bottom */
        width: 4px;
        background: #801fa7;
        border-radius: 2px;
    }

    /* Timeline item */
    .timeline-item {
        position: relative;
        margin: 50px 0 50px 80px; /* offset for line & circle */
    }

    .timeline-item h2 {
        position: relative;
        color: #801fa7;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    /* Circle on the line */
    .timeline-item::before {
        content: "";
        position: absolute;
        left: -95px; /* exactly on the vertical line */
        top: 0;
        width: 30px;
        height: 30px;
        background: #912fed;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }

    .timeline-item ul {
        list-style: disc;
        margin-top: 10px;
        padding-left: 20px;
    }

    .timeline-item ul li {
        margin-bottom: 10px;
        color: #2c1230;
        font-size: 1rem;
    }
</style>
</head>
<body>

<div class="white-container">
    <div class="help-heading">How can we help?</div>

    <!-- Vertical line -->
    <div class="timeline"></div>

    <!-- Timeline items -->
    <div class="timeline-item">
        <h2>How to Signup</h2>
        <ul>
            <li>Go to the <b>Home page</b> of the system.</li>
            <li>Click on the <b>Signup</b> at the top right corner.</li>
            <li>Fill in the required details.</li>
            <li>Click <b>Signup</b> to create your account.</li>
        </ul>
    </div>

    <div class="timeline-item">
        <h2>How to Login</h2>
        <ul>
            <li>If you already have an account, you can login using your credentials.</li>
            <li>Click on the <b>Login</b> at the top right corner.</li>
            <li>Enter your username and password.</li>
            <li>Click <b>Login</b> to access your account.</li>
        </ul>
    </div>

    <div class="timeline-item">
        <h2>How to Submit a Complaint</h2>
        <ul>
            <li>Login to your account.</li>
            <li>Navigate to the <b>Add a Complaint</b> page.</li>
            <li>Fill in the complaint details.</li>
            <li>Click <b>Submit Complaint</b> to send your complaint.</li>
        </ul>
    </div>

    
        <div class="timeline-item">
        <h2>How to View Your Complaints</h2>
        <ul>
            <li>Login to your account.</li>
            <li>Go to <b>My Complaints</b>page.</li>
            <li>You can see the list of all complaints you have submitted.</li>
        </ul>
    </div>
    <div class="timeline-item">
    <h2>How to Edit or Delete Your Complaint</h2>
    <ul>
        <li>Login to your account.</li>
        <li>Go to the <b>My Complaints</b> page.</li>
        <li>You will see <b>Edit</b> and <b>Delete</b> buttons under to each complaint.</li>
        <li>To edit a complaint: click <b>Edit</b>, update the details, and click <b>Update</b> to save changes.</li>
        <li>To delete a complaint: click <b>Delete</b> and confirm the deletion when prompted.</li>
    </ul>
    </div>
    <div class="timeline-item">
    <h2>View Other Users' Complaints</h2>
    <ul>
        <li>Login to your account.</li>
        <li>Go to the <b>Community Dashboard</b> page.</li>
        <li>You will see a list of complaints submitted by other users.</li>
        <li>This helps you stay informed about issues in your neighborhood.</li>
    </ul>
    </div>
</div>


</body>
</html>
