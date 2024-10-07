<!DOCTYPE html>
<html lang="en">
<?php
// Include the database connection file
include("../connection/connect.php");
// Suppress error reporting
error_reporting(0);
// Start a new session or resume an existing session
session_start();
// Check if the admin login form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Define a SQL query to select the admin with the provided username and password
    $loginquery = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    // Execute the query
    $result = mysqli_query($db, $loginquery);
    // Fetch the result as an associative array
    $row = mysqli_fetch_array($result);
    // Check if a row was returned (i.e., the credentials are valid)
    if (is_array($row)) {
        // Store the admin ID in the session
        $_SESSION["adm_id"] = $row['adm_id'];
        // Display a success alert and redirect to the admin dashboard
        echo "<script>
                alert('Admin Login successful! Redirecting to the admin dashboard.');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        // Display an alert message if the credentials are invalid
        echo "<script>alert('Invalid Username or Password!');</script>";
    }
}

// Check if the staff login form has been submitted
if (isset($_POST['log'])) {
    // Retrieve username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Define a SQL query to select the staff member with the provided username and password
    $loginquery = "SELECT * FROM staff WHERE username='$username' AND password='$password'";
    
    // Execute the query
    $result = mysqli_query($db, $loginquery);
    
    // Fetch the result as an associative array
    $row = mysqli_fetch_array($result);
    
    // Check if a row was returned (i.e., the credentials are valid)
    if (is_array($row)) {
        // Store the staff ID in the session
        $_SESSION["stf_id"] = $row['stf_id'];
        // Display a success alert and redirect to the staff dashboard
        echo "<script>
                alert('Staff Login successful! Redirecting to the staff dashboard.');
                window.location.href = 'sdashboard.php';
              </script>";
    } else {
        // Display an alert message if the credentials are invalid
        echo "<script>alert('Invalid Username or Password!');</script>";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title>Admin and Staff Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/login.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            font-size: 30px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
        }

        .form {
            width: 300px;
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .thumbnail {
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .form input[type="text"],
        .form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 20px;
        }

        .form input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>

<body>
    <br><br>
    <div class="form-container">
        <div class="form">
            <div class="info">
                <h1>Admin Login</h1>
            </div>
            <div class="thumbnail"><img src="images/manager.png" alt="Admin Thumbnail"/></div>
            <form class="login-form" action="index.php" method="post">
                <input type="text" placeholder="Username" name="username" required />
                <input type="password" placeholder="Password" name="password" required />
                <input type="submit" name="submit" value="Login" />
            </form>
        </div>

        <div class="form">
            <div class="info">
                <h1>Staff Login</h1>
            </div>
            <div class="thumbnail"><img src="images/manager.png" alt="Staff Thumbnail"/></div>
            <form class="login-form" action="index.php" method="post">
                <input type="text" placeholder="Username" name="username" required />
                <input type="password" placeholder="Password" name="password" required />
                <input type="submit" name="log" value="Login" />
            </form>
        </div>
    </div>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='js/index.js'></script>
</body>

</html>
