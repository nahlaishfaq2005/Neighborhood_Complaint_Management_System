<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NeighborlyResolve - Home</title>
<link rel="stylesheet" href="../new css/main.css">  
<style>
/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

body {
    background: url("../images/background.jpg") no-repeat center center fixed;
    background-size: cover;
    color: #3f2241;
}


/* Navbar */
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
.navbar.glass-container ul{
    list-style: none;
    display: flex;
    gap:40px;
    margin-right:50px;
    padding:0;
}
.navbar.glass-container ul a {
    text-decoration: none; 
    border-radius: 8px;
    color: #3d045eff;
    font-weight: bold;
    transition: 0.3s;
}
.navbar.glass-container ul a:hover {
    background-color: #3d045eff;
    padding: 5px 5px;
    color:white;
    transform: translateY(-2px); 
    box-shadow: 0 4px 8px rgba(0,0,0,0.2); 
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 18px; 
}

.navbar-brand h1 {
    font-size: 1.8rem;
    color: #000000ff;
    margin: 0;
}

/* Main Section */
.main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 100vh;
    padding: 50px 20px;
    margin-top: 50px;
    margin-bottom: 50px;
    border:none;
    border-radius: 0px;
}

.main .heading h1 {
    font-size: 60px;
    margin-top:70px;
    font-weight: bold;
    margin-bottom: 20px;
    padding: 30px 40px;
    background: rgba(255,255,255,0.4);
    border-radius: 15px;
}

.main p {
    font-size: 20px;
    max-width: 600px;
    margin: 30px auto;
}

/* Button */
.main nav a {
    background-color: #801fa7;
    text-decoration: none;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
    display: inline-block;
    
}

.main nav a:hover {
    background-color: #3d045eff;
    transform: scale(1.1);
}

/* Features Section */
.features {
    text-align: center;
    padding: 50px 20px;
    margin: 20px auto 0 auto;
    background: rgba(128,31,167,0.2);
    border-radius: 15px;
    width: 90%;
    max-width: 1200px;
}

/* Heading inside features */
.features .content {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 30px;
}

.features .content h2 {
    color: #ffffffff;
    font-size: 46px;
    margin-top: 70px;
    margin-bottom: 70px;
}

.features .content p {
    color: #000;
    font-size: 20px;
    line-height: 1.6;
}

/* Feature Boxes */
.features .features-box ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    list-style: none;
    padding: 0;
}

.features .features-box li {
    background-color: #c8afeb;
    border-radius: 15px;
    padding: 25px 30px;
    font-size: 22px;
    font-weight: 600;
    text-align: center;
    transition: 0.3s;
    min-width: 220px;
    max-width: 280px;
    
    margin-bottom: 50px;
}

.features .features-box li:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(128, 31, 167, 0.3);
}

/* CTA Bar */
.cta-bar {
    text-align: center;
    padding: 40px 80px 100px 80px; ;
    margin-top: 50px;
    border-radius: 15px 15px 0 0;
    background: rgba(255, 255, 255, 0.2);
    margin-bottom: 50px;
}

.cta-bar h2 {
    font-size: 32px;
    margin-bottom: 50px;
}

.cta-bar p {
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto 20px;
    line-height: 1.5;
}

.cta-bar .cta-button {
    padding: 12px 25px;
    background: linear-gradient(135deg,#764b86,#2e0e38);
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}

.cta-bar .cta-button:hover {
    background: linear-gradient(135deg,#846091,#332338);
    transform: scale(1.08);
}

/* Footer */
footer {
    background-color: #2e0e38;
    color: #fff;
    text-align: center;
    padding: 15px 0;
    font-weight: 600;
    border-top: 1px solid #764b86;
}

/* Responsive adjustments */
@media(max-width:768px){
    .main .heading h1 {
        font-size: 40px;
        padding: 20px 25px;
    }
    .features .content h2 {
        font-size: 28px;
    }
    .features .features-box li {
        min-width: 180px;
        font-size: 18px;
    }
    .cta-bar h2 {
        font-size: 26px;
    }
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar glass-container">
    <div class="navbar-brand">
        <img src="../images/handshake.png" alt="Logo" style="width:150px;height:150px;">
        <h1>NeighborlyResolve</h1>
    </div>
    <ul>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
        <a href="help.php">Help</a>
    </ul>
</nav>

<!-- Main Section -->
<section class="main glass-container">
    <div class="heading">
        <h1>Transform Your Neighborhood</h1>
    </div>
    <p>
        The most effective way to report, track, and resolve community issues. 
        Join thousands of residents making their neighborhoods better, one report at a time.
    </p>
    <nav>
        <a href="../php/login.php">Report an Issue</a>
    </nav>
</section>

<!-- Features Section -->
<section class="features glass-container">
    <div class="content">
        <h2>Why Communities Choose <i><span style="color: #4f046cff; font-size: 50px;">NeighborlyResolve </span></i>?</h2>
        <p>Built with residents in mind, designed for real results</p>
    </div>
    <div class="features-box">
        <ul>
            <li>Report issues easily</li>
            <li>Track progress</li>
            <li>Connect with neighbors</li>
        </ul>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-bar glass-container">
    <h2>Ready to Make a Difference?</h2>
    <p>Join thousands of neighbors who are actively improving their communities. Your voice matters, and together we can create positive change.</p>
    <a href="../php/signup.php" class="cta-button">Join Now</a>
</section>

<!-- Footer -->
<footer>
    <p>Neighborhood Complaint Management System | Group Project</p>
</footer>

</body>
</html>
