<?php
session_start();
include("connection.php");
include("functions.php"); 

// Check if user is logged in as admin
// Check if the user is logged in
$user_data = check_login($con);

// Query for Total Registered Students
$total_users_query = "SELECT COUNT(*) AS total FROM users";
$total_users_result = mysqli_query($con, $total_users_query);
$total_users = mysqli_fetch_assoc($total_users_result)['total'];



// Queries for Class Counts
$class_11_query = "SELECT COUNT(*) AS class_11 FROM users WHERE class = 11";
$class_11_result = mysqli_query($con, $class_11_query);
$class_11_count = mysqli_fetch_assoc($class_11_result)['class_11'];

$class_12_query = "SELECT COUNT(*) AS class_12 FROM users WHERE class = 12";
$class_12_result = mysqli_query($con, $class_12_query);
$class_12_count = mysqli_fetch_assoc($class_12_result)['class_12'];

// Fetch all students in Class 11
$class_11_students_query = "SELECT * FROM users WHERE class = 11";
$class_11_students_result = mysqli_query($con, $class_11_students_query);

// Fetch all students in Class 12
$class_12_students_query = "SELECT * FROM users WHERE class = 12";
$class_12_students_result = mysqli_query($con, $class_12_students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
	<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f8ff; /* Light sky blue background */
        color: #333; /* Dark text for better readability */
        margin: 0;
        padding: 20px;
    }

    /* Header styling */
    header {
        background-color: #f0f8ff;
        color: #00ff00;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        border-bottom: 2px solid #000;
    }

    header h2 {
        font-size: 1.5em;
    }

    h1 {
        text-align: center;
        color: #007bff; /* Sky blue color for the main heading */
    }

    h2 {
        color: #007bff; /* Sky blue color for subheadings */
        border-bottom: 2px solid #007bff; /* Sky blue border */
        padding-bottom: 10px;
    }

    .statistics {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .stat-box {
        background-color: #ffffff; /* White background for stats */
        border: 1px solid #007bff; /* Sky blue border */
        border-radius: 5px;
        padding: 20px;
        margin: 10px;
        flex: 1 1 200px; /* Responsive flex item */
        text-align: center; /* Center text */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #007bff; /* Sky blue border */
    }

    th {
        background-color: #e7f3ff; /* Light sky blue background for header */
    }

    tr:nth-child(even) {
        background-color: #f9f9f9; /* Light gray for even rows */
    }

    a {
        color: #007bff; /* Sky blue links */
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #007bff; /* Sky blue border for buttons */
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    a:hover {
        background-color: #007bff; /* Sky blue background on hover */
        color: #fff; /* White text on hover */
    }


/* Navigation Bar Styles */
        .nav {
            display: none; /* Hidden by default */
            flex-direction: column;
            background-color: #000; /* Sky blue background */
            padding: 10px;
            transition: max-height 0.5s ease; /* Transition effect */
            overflow: hidden; /* Hide overflow */
	    border-radius: 10px;
        }

        .nav a {
            color: white; /* White text */
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            transition: background-color 0.3s;
	    text-align: center;
	    font-weight: 700;
        }

        .nav a:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* Show the nav when active */
        .nav.active {
            display: flex; /* Show the nav */
        }






    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .statistics {
            flex-direction: column; /* Stack vertically on small screens */
            align-items: center; /* Center items */
        }

        header {
            flex-direction: column;
            text-align: center;
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

        table {
            font-size: 0.9em; /* Slightly smaller font for tables */
        }

        th, td {
            padding: 8px; /* Adjust padding for smaller screens */
        }
    }

    @media (max-width: 480px) {
        header h2 {
            font-size: 1.2em; /* Smaller font size for header on very small screens */
        }

        .stat-box {
            padding: 15px; /* Less padding for smaller screens */
        }

        h1 {
            font-size: 1.3em; /* Smaller font size for main heading */
        }

        h2 {
            font-size: 1.2em; /* Smaller font size for subheadings */
        }

        a {
            padding: 4px 8px; /* Smaller button padding */
        }
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
        <a href="index.php">Payment</a>
        <a href="pan.php?page=result">Result</a>
        <a href="pan.php?page=attendance">Attendance</a>
        <a href="pan.php?page=grades">Grades</a>
        <a href="pan.php?page=feedback">Feedback</a>
    </div>






    <h1>Admin Panel</h1>
    <div class="statistics">
        <div class="stat-box">
            <h2>Students in website</h2>
            <p><?php echo $total_users; ?></p>
        </div>
        <div class="stat-box">
            <h2>Students in Class 11</h2>
            <p><?php echo $class_11_count; ?></p>
        </div>
        <div class="stat-box">
            <h2>Students in Class 12</h2>
            <p><?php echo $class_12_count; ?></p>
        </div>
    </div>

    <h2>Students in Class 11</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>College Name</th>
            <th>Roll</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
        <?php while ($student = mysqli_fetch_assoc($class_11_students_result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($student['user_id']); ?></td>
            <td><?php echo htmlspecialchars($student['user_name']); ?></td>
            <td><?php echo htmlspecialchars($student['email']); ?></td>
            <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
            <td><?php echo htmlspecialchars($student['college']); ?></td>
            <td><?php echo htmlspecialchars($student['roll']); ?></td>
            <td><?php echo htmlspecialchars($student['gender']); ?></td>
            <td>
                <a href="edit_student.php?id=<?php echo $student['user_id']; ?>">Edit</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Students in Class 12</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>College Name</th>
            <th>Roll</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
        <?php while ($student = mysqli_fetch_assoc($class_12_students_result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($student['user_id']); ?></td>
            <td><?php echo htmlspecialchars($student['user_name']); ?></td>
            <td><?php echo htmlspecialchars($student['email']); ?></td>
            <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
            <td><?php echo htmlspecialchars($student['college']); ?></td>
            <td><?php echo htmlspecialchars($student['roll']); ?></td>
            <td><?php echo htmlspecialchars($student['gender']); ?></td>
            <td>
                <a href="edit_student.php?id=<?php echo $student['user_id']; ?>">Edit</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <script>
        // JavaScript to toggle the navigation menu
        document.getElementById('workshop-title').addEventListener('click', function() {
            const navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('active'); // Toggle the 'active' class
        });
    </script>

</body>
</html>