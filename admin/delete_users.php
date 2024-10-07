
<?php
// Include the database connection file
include("../connection/connect.php");

// Suppress error reporting
error_reporting(0);

// Start a new session or resume an existing session
session_start();

// Execute a SQL query to delete a user with the specified user ID
// The user ID is obtained from the URL parameter 'user_del'
mysqli_query($db, "DELETE FROM users WHERE u_id = '".$_GET['user_del']."'");

// Redirect to the 'all_users.php' page after the deletion
header("location:all_users.php");  

?>
