<?php 
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    // Sanitize user inputs
    $user_name = mysqli_real_escape_string($con, $user_name);
    $password = mysqli_real_escape_string($con, $password);

    // Ensure phone_number is numeric and exactly 11 digits long, and the field is not empty
    if (!empty($phone_number) && is_numeric($phone_number) && strlen($phone_number) == 11) {
        $phone_number = (int) $phone_number; // Cast to integer
    } else {
		echo "<h3 style='color:red; padding-top:10%; font-size:20px; text-align:center;'>YOUR PHONE NUMBER IS INCORRECT</h3><br>
				<div style=' text-align:center; font-size:20px;'><a href='signup.php'> Enter correct Phone number</a></div>";
		exit;
    }

    // Check that user_name, password, and phone_number are not empty and phone number is valid
    if (!empty($user_name) && !empty($password) && !empty($phone_number) && !is_numeric($user_name)) {
        
        // Generate a random user ID
        $user_id = random_num(6);

        // Use prepared statements to prevent SQL injection
        $query = "INSERT INTO users (user_id, user_name, password, phone_number) VALUES (?, ?, ?, ?)";
        
        // Prepare the statement
        if ($stmt = mysqli_prepare($con, $query)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssss", $user_id, $user_name, $password, $phone_number);
            
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                die;
            } else {
                echo "Error: Could not execute the query.";
            }
            
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Could not prepare the query.";
        }

    } else {
        echo "Please enter valid information!";
    }
}
?>




<!doctype html>

<html lang="en"> 

 <head> 

  <meta charset="UTF-8"> 

  <title>SCIENCE WORKSHOP || SIGN IN</title> 

  <link rel="stylesheet" href="style.css"> 

 </head> 

 <body> <!-- partial:index.partial.html --> 

  <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 

   <div class="signin"> 

    <div class="content"> 

     <h2>Sign Up</h2>
	 

     <form  class="form" method="post"> 

      <div class="inputBox"> 

       <input type="text" name="user_name" required> <i>Username</i> 

      </div> 

      <div class="inputBox"> 

       <input type="password" name="password" required> <i>Password</i> 

      </div> 

      <div class="inputBox"> 

       <input type="number" name="phone_number" required> <i>Phone number</i>

      </div>

      <div class="links"> <a href="#">Forgot Password</a> <a href="login.php">Login</a> 

      </div> 

      <div class="inputBox"> 

       <input type="submit" value="Sign up"> 

      </div> 

     </form> 


    </div> 

   </div> 

  </section> <!-- partial --> 

 </body>

</html>





