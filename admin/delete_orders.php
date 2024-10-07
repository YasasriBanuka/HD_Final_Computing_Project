<?php
// Include the database connection file
include("../connection/connect.php");
// Suppress error reporting
error_reporting(0);

// Start a new session or resume an existing session
session_start();

// Execute a SQL query to delete a restaurant entry with the specified restaurant ID
// The restaurant ID is obtained from the URL parameter 'user_orders'

mysqli_query($db,"DELETE FROM users_orders WHERE o_id = '".$_GET['order_del']."'");

// Redirect to the 'all_orders.php' page after the deletion
header("location:all_orders.php");  

?>
