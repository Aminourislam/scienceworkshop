<?php
session_start();
// Include the database connection file
include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Fetch payment statuses from the database
$query = "SELECT status1, status2, status3, status4, status5, status6 FROM users LIMIT 1"; // Replaced table name with 'users'
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Assign the fetched values to variables
    $status1 = $row['status1'] ?? 'N/A'; // Use 'N/A' if the value is null
    $status2 = $row['status2'] ?? 'N/A';
    $status3 = $row['status3'] ?? 'N/A';
    $status4 = $row['status4'] ?? 'N/A';
    $status5 = $row['status5'] ?? 'N/A';
    $status6 = $row['status6'] ?? 'N/A';
} else {
    // Handle query error
    echo "Error fetching payment statuses: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #000000; /* Set background to dark */
            color: #00ff00; /* Set text color to green */
            box-sizing: border-box;
        }

        .payment-box {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            width: 100%;
            height: 100vh;
            background-color: #000000; /* Darker background for payment box */
            padding: 20px;
            box-sizing: border-box;
        }

        .payment-box-item {
            display: flex; /* Set display to flex */
            flex-direction: column; /* Stack children vertically */
            justify-content: center; /* Center items vertically */
            align-items: center; /* Center items horizontally */
            width: 200px;
            height: 200px;
            background-color: #1e1e1e; /* Dark background for items */
            border-radius: 10px;
            border: 1px solid #00ff00; /* Add border to items */
            box-shadow: 0 0 10px #00ff00;
            margin: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            color: #00ff00; /* Text color */
        }
        .payment-box-item h1, .payment-box-item h3 {
            background-color: #1e1e1e; /* Green background */
            color: #00ff00; /* Black text */
            padding: 5px 5px; /* Padding for button effect */
            border: 1px solid #00ff00;
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 0 10px #00ff00;
            cursor: pointer; /* Change cursor to pointer */
            text-align: center; /* Center text */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition */
        }

        .payment-box-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 255, 0, 0.2);
            background-color: #00ff00; /* Change background on hover */
            color: #000; /* Change text color on hover */
        }

        .payment-box-item h1 {
            font-size: 20px;
            text-align: center;
            margin: 0;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .back-button button {
            background-color: #00ff00; /* Green button background */
            color: #000; /* Black text */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button button:hover {
            background-color: #00cc00; /* Slightly darker green on hover */
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .payment-box {
                flex-direction: column;
                align-items: center;
                height: auto; /* Allow height to adjust based on content */
            }

            .payment-box-item {
                width: 90%; /* Make items take up more width on smaller screens */
                max-width: 300px; /* Limit max width */
            }
        }

        @media (max-width: 480px) {
            .payment-box-item h1 {
                font-size: 18px; /* Adjust font size for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="payment-box">
        <div class="payment-box-item">
            <h1>1st Payment</h1>
            <h3><?php echo htmlspecialchars($status1); ?></h3>
        </div>
        <div class="payment-box-item">
            <h1>2nd Payment</h1>
            <h3><?php echo htmlspecialchars($status2); ?></h3>
        </div>
        <div class="payment-box-item">
            <h1>3rd Payment</h1>
            <h3><?php echo htmlspecialchars($status3); ?></h3>
        </div>
        <div class="payment-box-item">
            <h1>4th Payment</h1>
            <h3><?php echo htmlspecialchars($status4); ?></h3>
        </div>
        <div class="payment-box-item">
            <h1>5th Payment</h1>
            <h3><?php echo htmlspecialchars($status5); ?></h3>
        </div>
        <div class="payment-box-item">
            <h1>6th Payment</h1>
            <h3><?php echo htmlspecialchars($status6); ?></h3>
        </div>
    </div>
    <div class="back-button">
        <button onclick="goBack()">Go Back</button>
    </div><br><br>
    <script>
        function goBack() {
            window.location.href = "index.php"; // Change to your desired back page
        }
    </script>
</body>
</html>