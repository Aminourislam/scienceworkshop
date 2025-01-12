<?php 
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT PANEL</title>
    <!-- Inline CSS for responsive green and black theme -->
    <style>
        /* Reset some default styles */
        body, h1, p, a {
            margin: 0;
            padding: 0;
        }
        /* Overall page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #00ff00; /* Green text */
            margin: 0;
            line-height: 1.6;
        }
        /* Header styling */
        header {
            background-color: #000;
            color: #00ff00;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-bottom: 2px solid #00ff00;
        }
        header h2 {
            font-size: 1.5em;
            cursor: pointer; /* Add cursor pointer for clickability */
        }
        /* Button styling for links */
        .btn {
            display: inline-block;
            text-decoration: none;
            background-color: #00ff00;
            color: #000;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn:hover {
            background-color: #000;
            color: #00ff00;
            border: 1px solid #00ff00;
        }
        /* Header Logout Button */
        .logout-btn {
            margin: 0;
            font-size: 0.9em;
            padding: 8px 15px;
        }
        /* Main content styling */
        .container {
            padding: 20px;
            width: 85%;
            max-width: 1000px;
            margin: 50px auto;
            background-color: #1e1e1e;
            border: 1px solid #00ff00;
            box-shadow: 0 0 10px #00ff00;
            border-radius: 10px;
            text-align: center;
        }
        h1 {
            font-size: 2em;
            color: #00ff00;
        }
        p {
            font-size: 1.1em;
            color: #00ff00;
        }
        /* Center button container */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container p {
            margin-bottom: 10px;
            font-size: 1em;
            color: #00ff00;
        }
        /* Responsive design */
        @media screen and (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }
            .container {
                width: 85%;
                margin: 20px auto;
                padding: 15px;
            }
            h1 {
                font-size: 1.5em;
            }
            p {
                font-size: 1em;
            }
            .btn {
                padding: 8px 15px;
                font-size: 0.9em;
            }
        }
        @media screen and (max-width: 480px) {
            header h2 {
                font-size: 1.2em;
            }
            h1 {
                font-size: 1.2em;
            }
            p {
                font-size: 0.9em;
            }
            .btn {
                padding: 6px 12px;
                font-size: 0.8em;
            }
        }
        /* Navigation Bar Styles */
        .nav {
            display: none; /* Hidden by default */
            flex-direction: column;
            background-color: #1e1e1e; /* Match container background */
            padding: 10px;
            transition: max-height 0.5s ease; /* Transition effect */
            overflow: hidden; /* Hide overflow */
            border-radius: 10px;
            border: 1px solid #00ff00; /* Match border color */
            box-shadow: 0 0 10px #00ff00; /* Match shadow */
        }
        .nav a {
            color: #00ff00; /* Match text color */
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            transition: background-color 0.3s;
            text-align: center;
            font-weight: 700;
        }
        .nav a:hover {
            background-color: #000; /* Darker background on hover */
            color: #00ff00; /* Match text color on hover */
            border: 1px solid #00ff00; /* Match border on hover */
        }
        /* Show the nav when active */
        .nav.active {
            display: flex; /* Show the nav */
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div>
            <h2 id="workshop-title">SCIENCE WORKSHOP</h2>
        </div>
        <!-- Logout Button -->
        <nav>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </nav>
    </header>
    <!-- Navigation Bar -->
    <div class="nav" id="nav-menu">
        <a href="https://hscall.github.io/ZIA-SIR/assignment.html">Assignments</a>
        <a href="spayment.php">Payments</a>
        <a href="profile.php">Edit Profile</a>
        <a href="pan.php?page=grades">Grades</a>
        <a href="pan.php?page=feedback">Feedback</a>
    </div>
    <!-- Main Content Section -->
    <div class="container">
        <h1>Welcome Back!</h1>
        <p><strong><?php echo htmlspecialchars($user_data['user_name']); ?></strong></p>
        <p>We're glad to see you here.</p>
    </div>
    <!-- Centered Paragraph and Button -->
    <div class="button-container">
        <p>FOR MORE INFORMATION ?</p>
        <a href="https://hscall.github.io/ZIA-SIR/" class="btn">Let's Go</a>
    </div><br>
    <script>
        // JavaScript to toggle the navigation menu
        document.getElementById('workshop-title').addEventListener('click', function() {
            const navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('active'); // Toggle the 'active' class
        });
    </script>
</body>
</html>
