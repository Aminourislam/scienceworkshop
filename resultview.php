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
    <style type="text/css">
        body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.table-container, .search-container, .result-table {
    color: #00ff00;
    margin: 1.6vw auto;
    width: 90%;
    max-width: 1000px;
    text-align: center;
    background-color: #1e1e1e;
    border: 1px solid #00ff00;
    box-shadow: 0 0 10px #00ff00;
    border-radius: 10px;
    padding: 1vw;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 2vw;
    box-sizing: border-box;
}

table {
    width: 100%;
    margin: 0 auto;
    border-collapse: collapse;
}

th, td {
    padding: 1vw;
    border: 1px solid #00ff00;
    color: #00ff00;
    word-wrap: break-word;
}

th {
    background-color: #121212;
}

.search-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.search-container input {
    margin: 1vw;
    padding: 1vw;
    border: 1px solid #00ff00;
    background-color: #121212;
    color: #00ff00;
    border-radius: 5px;
    width: 100%;
    max-width: 500px;
    font-size: 1.8vw;
    box-sizing: border-box;
}

.search-container button {
    padding: 1vw 2vw;
    border: none;
    background-color: #00ff00;
    color: #121212;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.8vw;
}

.search-container button:hover {
    background-color: #121212;
    color: #00ff00;
    border: 1px solid #00ff00;
}

/* Responsive design */
@media (max-width: 768px) {
    .table-container, .search-container, .result-table {
        width: 95%;
        padding: 10px;
        font-size: 3vw;
    }
    th, td {
        padding: 8px;
    }
    .search-container input {
        width: 100%;
        max-width: none;
        font-size: 2.8vw;
    }
    .search-container button {
        padding: 8px 16px;
        font-size: 2.7vw;
    }
}

@media (max-width: 480px) {
    .table-container, .search-container, .result-table {
        width: 100%;
        padding: 5px;
        font-size: 3vw;
    }
    th, td {
        padding: 6px;
    }
    .search-container input {
        padding: 8px;
        font-size: 2.8vw;
    }
    .search-container button {
        padding: 7px 14px;
        font-size: 2.7vw;
    }
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
                $query = $con->prepare("SELECT user_name, roll, total_number FROM users ORDER BY total_number DESC LIMIT 10");
                $query->execute();
                $result = $query->get_result();

                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['user_name']}</td><td>{$row['roll']}</td><td>{$row['total_number']}</td></tr>"; 
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="search-container">
        <h2>Search Your Result</h2>
        <form action="" method="post">
            <input type="text" name="user_name" placeholder="Name" required>
            <input type="number" name="roll" placeholder="Roll" required>
            <input type="text" name="exam" placeholder="Exam Name" required>
            <button type="submit">Search</button>
        </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $con->real_escape_string($_POST['user_name']);
        $roll = $con->real_escape_string($_POST['roll']);
        $exam = $con->real_escape_string($_POST['exam']);

        $query = $con->prepare("SELECT user_name, roll, college, class, mcq_mark, written_mark, total_mark FROM users WHERE user_name=? AND roll=? AND exam=?");
        $query->bind_param('sis', $name, $roll, $exam);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="result-table">';
            echo '<h2>Your Result</h2>';
            echo '<table>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td><b>Name</b></td><td>{$row['user_name']}</td></tr>";
                echo "<tr><td><b>Roll</b></td><td>{$row['roll']}</td></tr>";
                echo "<tr><td><b>College</b></td><td>{$row['college']}</td></tr>";
                echo "<tr><td><b>Class</b></td><td>{$row['class']}</td></tr>";
                echo "<tr><td><b>MCQ Mark</b></td><td>{$row['mcq_mark']}</td></tr>";
                echo "<tr><td><b>Written Mark</b></td><td>{$row['written_mark']}</td></tr>";
                echo "<tr><td><b>Total Mark</b></td><td>{$row['total_mark']}</td></tr>";
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p style="text-align: center; color: #00ff00;">No results found.</p>';
        }
    }
    ?>
</body>
</html>