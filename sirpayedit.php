<?php
session_start();
// Include the database connection file
include("connection.php");
include("functions.php");

// Check if user is logged in as admin
$user_data = check_login($con);

// Handle search form submission
$search_results = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $roll = $_POST['roll'];
    $class = $_POST['class'];

    // Query to find users by roll and class
    $search_query = "SELECT * FROM users WHERE roll='$roll' AND class='$class'";
    $search_results = mysqli_query($con, $search_query);
}

// Handle form submission for updating payment statuses
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $status1 = $_POST['status1'];
    $status2 = $_POST['status2'];
    $status3 = $_POST['status3'];
    $status4 = $_POST['status4'];
    $status5 = $_POST['status5'];
    $status6 = $_POST['status6'];

    // Update payment statuses in the database
    $query = "UPDATE users SET status1='$status1', status2='$status2', status3='$status3', status4='$status4', status5='$status5', status6='$status6' WHERE user_id='$user_id'";
    mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            background-color: #f0f8ff;
            color: #333;
            height: 40px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 10px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Find User by Roll and Class</h1>
        <form method="POST">
            <div class="form-group">
                <label for="roll">Roll:</label>
                <input type="number" id="roll" name="roll" required>
            </div>
            <div class="form-group">
                <label for="class">Class:</label>
                <select id="class" name="class" required>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="search">Search</button>
            </div>
        </form>

        <?php if ($search_results && mysqli_num_rows($search_results) > 0): ?>
            <h1>Edit Payment Status</h1>
            <?php while ($user = mysqli_fetch_assoc($search_results)): ?>
                <form method="POST">
                    <div class="form-group">
                        <label>User Name: <?php echo htmlspecialchars($user['user_name']); ?></label>
                    </div>
                    <div class="form-group">
                        <label>Roll: <?php echo htmlspecialchars($user['roll']); ?></label>
                    </div>
                    <div class="form-group">
                        <label>College: <?php echo htmlspecialchars($user['college']); ?></label>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                    <div class="form-group">
                        <label for="status1">1st Payment:</label>
                        <select id="status1" name="status1">
                            <option value="Paid" <?php if($user['status1'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if($user['status1'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status2">2nd Payment:</label>
                        <select id="status2" name="status2">
                            <option value="Paid" <?php if($user['status2'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if($user['status2'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status3">3rd Payment:</label>
                        <select id="status3" name="status3">
                            <option value="Paid" <?php if($user['status3'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if($user['status3'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status4">4th Payment:</label>
                        <select id="status4" name="status4">
                            <option value="Paid" <?php if($user['status4'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if($user['status4'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status5">5th Payment:</label>
                        <select id="status5" name="status5">
                            <option value="Paid" <?php if($user['status5'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if($user['status5'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status6">6th Payment:</label>
                        <select id="status6" name="status6">
                            <option value="Paid" <?php if($user['status6'] == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if($user['status6'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update">Update Payment Status</button>
                    </div>
                </form>
            <?php endwhile; ?>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])): ?>
            <p>No results found for the given roll and class.</p>
        <?php endif; ?>
        <div class="back-button">
            <a href="admin.php">Go Back</a>
        </div>
    </div>
</body>
</html>