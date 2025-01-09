<?php
session_start();
include("connection.php");
include("functions.php");

// Fetch student data
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($con, $_GET['id']);
    $query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        echo "No user found!";
        exit;
    }
}

// Handle form submission for updating student details
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['update'])) {
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
            header("Location: admin.php?message=Student updated successfully");
            exit;
        } else {
            $error_message = "Error updating student: " . mysqli_error($con);
        }
    }

    // Handle student deletion
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM users WHERE user_id = '$user_id'";
        if (mysqli_query($con, $query)) {
            header("Location: admin.php?message=Student deleted successfully");
            exit;
        } else {
            $error_message = "Error deleting student: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff; /* Light sky blue background */
    color: #333; /* Dark text color */
    padding: 20px;
    margin: 0;
}

.container {
    max-width: 600px;
    margin: auto;
    background: #ffffff; /* White background for the form */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #007bff; /* Sky blue color for the heading */
}

label {
    display: block;
    margin: 10px 0 5px;
    width: 600px; /* Set width of label text */
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #007bff; /* Sky blue border */
    border-radius: 5px;
    background-color: #f0f8ff; /* Light sky blue background for inputs */
    color: #333; /* Dark text color */
    box-sizing: border-box; /* Ensures padding is included in width */
    height: 40px; /* Set a consistent height for all input fields */
}

button {
    background-color: #007bff; /* Sky blue button */
    color: #ffffff; /* White text */
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    margin-top: 10px;
    width: 100%; /* Full width for buttons */
}

button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

.go-back {
    display: inline-block;
    background-color: #ff7c30; /* Orange color for the Go Back button */
    color: white; /* White text */
    padding: 10px;
    border-radius: 4px;
    text-align: center;
    text-decoration: none;
	box-sizing: border-box;
    width: 100%; /* Full width for the Go Back button */
    margin-top: 10px; /* Space above the button */
    cursor: pointer; /* Pointer cursor on hover */
    text-align: center; /* Center text */
}

.go-back:hover {
    background-color: #e66a24; /* Darker orange on hover */
}

.message {
    text-align: center;
    margin: 10px 0;
}

.error {
    color: #ff4040; /* Red color for error messages */
}

@media (max-width: 768px) {
    .container {
        padding: 15px; /* Less padding on smaller screens */
    }
    button {
        font-size: 0.9rem; /* Smaller button text on smaller screens */
    }
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>
        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_data['user_id']); ?>">
            <label for="user_name">Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user_data['user_name']); ?>" required>
            
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user_data['phone_number']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($user_data['gender'] == "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if ($user_data['gender'] == "Female") echo "selected"; ?>>Female</option>
            </select>
            
            <label for="college">College Name:</label>
            <input type="text" id="college" name="college" value="<?php echo htmlspecialchars($user_data['college']); ?>" required>
            
            <label for="class">Class:</label>
            <input type="number" id="class" name="class" value="<?php echo htmlspecialchars($user_data['class']); ?>" required>
            
            <label for="roll">Roll:</label>
            <input type="number" id="roll" name="roll" value="<?php echo htmlspecialchars($user_data['roll']); ?>" required>
            
            <button type="submit" name="update">Update Student</button>
            <br><br>
			<a href="admin.php" class="go-back">Go Back</a>
            <br><br>
            <button type="submit" name="delete" style="background-color: #dc3545;">Delete Student</button>
        </form>
    </div>
</body>
</html>