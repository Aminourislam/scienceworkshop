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
    <title>Exam Results</title>
    <style>
        /* Add your CSS styling here */
        .table-container {
            color: #00ff00;
            margin: 20px auto;
            width: 80%;
            max-width: 1000px;
            text-align: center;
            background-color: #1e1e1e;
            border: 1px solid #00ff00;
            box-shadow: 0 0 10px #00ff00;
            border-radius: 10px;
        }
        .table-container table {
            width: 95%;
            align-self: center;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            padding: 12px;
            border: 1px solid #00ff00;
            color: #00ff00;
        }
        .table-container th {
            background-color: #121212;
        }
        .search-container {
            margin: 20px auto;
            width: 80%;
            max-width: 1000px;
            text-align: center;
            background-color: #1e1e1e;
            border: 1px solid #00ff00;
            box-shadow: 0 0 10px #00ff00;
            border-radius: 10px;
            padding: 20px;
        }
        .search-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .search-container input {
            margin: 10px;
            padding: 10px;
            border: 1px solid #00ff00;
            background-color: #121212;
            color: #00ff00;
            border-radius: 5px;
        }
        .search-container button {
            padding: 10px 20px;
            border: none;
            background-color: #00ff00;
            color: #121212;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #121212;
            color: #00ff00;
            border: 1px solid #00ff00;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Top Rankers</h2>
        <table>
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>ROLL</th>
                    <th>TOTAL NUMBER</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch rankers data and display in the table
                $query = "SELECT name, roll, total_number FROM rankers ORDER BY total_number DESC LIMIT 10";
                $result = mysqli_query($con, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['name']}</td><td>{$row['roll']}</td><td>{$row['total_number']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="search-container">
        <h2>Search Your Result</h2>
        <form action="search_result.php" method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="roll" placeholder="Roll" required>
            <input type="text" name="exam" placeholder="Exam Name" required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>
