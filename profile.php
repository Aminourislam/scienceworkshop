<?php
session_start();
include("functions.php");
include("connection.php"); // Your database connection file

// Check if the user is logged in
$user_data = check_login($con);

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $user_data['user_id'];
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $college = mysqli_real_escape_string($con, $_POST['college']);
    $class = (int)$_POST['class'];
    $roll = (int)$_POST['roll'];

    // Update query
    $query = "UPDATE users SET 
                user_name = '$user_name',
                phone_number = '$phone_number',
                email = '$email',
                gender = '$gender',
		college = '$college',
                class = '$class',
                roll = '$roll'
              WHERE user_id = '$user_id'";

    if (mysqli_query($con, $query)) {
        $success_message = "Profile updated successfully!";
        $user_data = check_login($con); // Reload updated data
    } else {
        $error_message = "Error updating profile: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #000; /* Black background */
            color: #fff; /* White text for readability */
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 30px auto;
            background: #111; /* Dark container background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5); /* Green glow effect */
        }

        h1 {
            text-align: center;
            color: #00ff00; /* Bright green title */
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #00ff00; /* Green labels */
        }

        input, select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #00ff00; /* Green border */
            border-radius: 5px;
            background-color: #000; /* Black input background */
            color: #fff; /* White input text */
            font-size: 1rem;
        }

        input:focus, select:focus {
            outline: 1px solid #00ff00; /* Green focus outline */
        }

        button {
            background-color: #00ff00; /* Green button background */
            color: #000; /* Black text */
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #00cc00; /* Slightly darker green on hover */
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
        }

        .success {
            color: #00ff00;
        }

        .error {
            color: #ff4040;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>

        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- User Profile Form -->
        <form method="POST" action="">
            <label for="user_name">Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user_data['user_name']); ?>" readonly required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user_data['phone_number']); ?>" readonly required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" disabled>
                <option value="Male" <?php if ($user_data['gender'] == "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if ($user_data['gender'] == "Female") echo "selected"; ?>>Female</option>
            </select>
            <label for="college">College Name:</label>
            <input type="text" id="college" name="college" value="<?php echo htmlspecialchars($user_data['college']); ?>" readonly required>

            <label for="class">Class:</label>
            <input type="number" id="class" name="class" value="<?php echo htmlspecialchars($user_data['class']); ?>" readonly required>
                
            <label for="roll">Roll:</label>
            <input type="number" id="roll" name="roll" value="<?php echo htmlspecialchars($user_data['roll']); ?>" readonly required>
              
            <!-- Update Profile Button -->
            <button type="button" onclick="enableEdit()">Update Profile</button>

            <!-- Save Changes Button (Initially hidden) -->
            <button type="submit" style="display: none;" id="saveButton">Save Changes</button>
        </form>
        <div style="text-align: center; margin-top: 20px;">
            <button type="button" onclick="goBack()">Go Back</button>
        </div>
    </div>

    <script>
        function enableEdit() {
            // Enable input fields for editing
            document.getElementById("user_name").removeAttribute("readonly");
            document.getElementById("phone_number").removeAttribute("readonly");
            document.getElementById("email").removeAttribute("readonly");
            document.getElementById("gender").removeAttribute("disabled");
            document.getElementById("college").removeAttribute("readonly");
            document.getElementById("class").removeAttribute("readonly");
            document.getElementById("roll").removeAttribute("readonly");

            // Show the save button
            document.getElementById("saveButton").style.display = "inline-block";

            // Hide the update button
            document.querySelector("button[type='button']").style.display = "none";
        }

        function goBack() {
            window.history.back(); // Go to the previous page
        }
    </script>
</body>
</html>
