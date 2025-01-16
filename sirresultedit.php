<?php 
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in as admin
$user_data = check_login($con);

$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $roll = $con->real_escape_string($_POST['roll']);
    $class = $con->real_escape_string($_POST['class']);

    $query = $con->prepare("SELECT * FROM users WHERE roll=? AND class=?");
    $query->bind_param('ii', $roll, $class);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $user_id = $con->real_escape_string($_POST['user_id']);
    $exam_name = $con->real_escape_string($_POST['exam_name']);
    $mcq_mark = (int)$con->real_escape_string($_POST['mcq_mark']);
    $written_mark = (int)$con->real_escape_string($_POST['written_mark']);

    // Server-side validation
    if ($mcq_mark <= 25 && $written_mark <= 50) {
        $total_mark = $mcq_mark + $written_mark;

        $query = $con->prepare("UPDATE users SET examname=?, mcq_mark=?, written_mark=?, total_mark=? WHERE user_id=?");
        $query->bind_param('siiii', $exam_name, $mcq_mark, $written_mark, $total_mark, $user_id);
        $query->execute();

        $success_message = "Result updated successfully!";
    } else {
        $success_message = "Invalid input: MCQ marks must be <= 25 and Written marks must be <= 50.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light sky blue background */
            color: #333; /* Dark text color */
            padding: 20px;
            margin: 0;
            font-size: 18px; /* Base font size */
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff; /* White background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff; /* Sky blue color for the heading */
            font-size: 24px; /* Heading font size */
        }

        .success-message {
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text */
            padding: 10px;
            border: 1px solid #c3e6cb; /* Green border */
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 12px; /* Input padding */
            margin-bottom: 12px; /* Margin for inputs */
            border: 1px solid #007bff; /* Sky blue border */
            border-radius: 5px;
            background-color: #f0f8ff; /* Light sky blue background for inputs */
            color: #333; /* Dark text color */
            box-sizing: border-box; /* Ensures padding is included in width */
            font-size: 16px; /* Input font size */
            height: auto; /* Remove fixed height */
        }

        button {
            background-color: #007bff; /* Sky blue button */
            color: #ffffff; /* White text */
            padding: 12px; /* Button padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px; /* Button font size */
            margin-top: 12px; /* Margin for buttons */
            width: 100%; /* 100% width of input fields */
            text-align: center; /* Center text */
            display: block; /* Ensure it's a block element */
            text-decoration: none; /* Remove underline */
            margin-left: auto; /* Center button */
            margin-right: auto; /* Center button */
        }

        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .go-back {
            background-color: #007bff; /* Sky blue button */
            color: #ffffff; /* White text */
            padding: 12px; /* Button padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px; /* Button font size */
            margin-top: 20px; /* Margin for buttons */
            width: 95%; /* 95% width of input fields */
            text-align: center; /* Center text */
            display: block; /* Ensure it's a block element */
            text-decoration: none; /* Remove underline */
            margin-left: auto; /* Center button */
            margin-right: auto; /* Center button */
        }

        .go-back:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .student-info {
            border-bottom: 1px solid #007bff; /* Sky blue border */
            padding-bottom: 12px; /* Add padding to the bottom */
            margin-bottom: 12px; /* Add margin to the bottom */
        }

        @media (max-width: 1024px) {
            .form-container {
                padding: 15px; /* Adjust padding */
            }
            button, .go-back {
                font-size: 16px; /* Adjust font size */
            }
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 10px; /* Adjust padding for tablets */
            }
            button, .go-back {
                font-size: 14px; /* Adjust font size for tablets */
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 8px; /* Adjust padding for mobile */
            }
            button, .go-back {
                font-size: 12px; /* Adjust font size for mobile */
            }
        }
    </style>
    <script>
        function validateForm() {
            const mcqMark = document.querySelector('input[name="mcq_mark"]').value;
            const writtenMark = document.querySelector('input[name="written_mark"]').value;
            if (mcqMark > 25 || writtenMark > 50) {
                alert("Invalid input: MCQ marks must be <= 25 and Written marks must be <= 50.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="form-container">
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <h2>Search Student</h2>
        <form action="" method="post">
            <input type="number" name="roll" placeholder="Roll" required>
            <select name="class" required>
                <option value="" disabled selected>Select Class</option>
                <option value="11">Class 11</option>
                <option value="12">Class 12</option>
            </select>
            <button type="submit" name="search">Search</button>
        </form>
    </div><br>

    <?php if (isset($user)): ?>
    <div class="form-container">
        <h2>Edit Student Result</h2>
        <div class="student-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['user_name']); ?></p>
            <p><strong>Roll:</strong> <?php echo htmlspecialchars($user['roll']); ?></p>
            <p><strong>College:</strong> <?php echo htmlspecialchars($user['college']); ?></p>
        </div>
        <form action="" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <select name="exam_name" required>
                <option value="" disabled selected>Select Exam</option>
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    echo "<option value='Exam $i'>Exam $i</option>";
                }
                ?>
            </select>
            <input type="number" name="mcq_mark" placeholder="MCQ Mark" value="<?php echo $user['mcq_mark']; ?>" max="25" required>
            <input type="number" name="written_mark" placeholder="Written Mark" value="<?php echo $user['written_mark']; ?>" max="50" required>
            <button type="submit" name="update">Update Result</button>
        </form>
    </div>
    <?php endif; ?>

    <a href="admin.php" class="go-back">Go Back</a>
</body>
</html>