<?php

// Include the database connection file
include("../connection/connect.php");

// Disable error reporting for security
error_reporting(0);

// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (strlen($_SESSION['user_id']) == 0) {
    header('location:../login.php');
} else {
    // Check if the form is submitted
    if (isset($_POST['update'])) {
        // Retrieve form data
        $form_id = $_GET['form_id'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        // Insert remark into the database
        $query = mysqli_query($db, "INSERT INTO remark(frm_id, status, remark) VALUES ('$form_id', '$status', '$remark')");
        
        // Update order status in the database
        $sql = mysqli_query($db, "UPDATE users_orders SET status='$status' WHERE o_id='$form_id'");

        // Display a success message
        echo "<script>alert('Form details updated successfully');</script>";
    }
?>

<script language="javascript" type="text/javascript">
    // Function to close the current window
    function f2() {
        window.close();
    }

    // Function to print the current window content
    function f3() {
        window.print();
    }
</script>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>User Profile</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        .indent-small {
            margin-left: 5px;
        }
        .form-group.internal {
            margin-bottom: 0;
        }
        .dialog-panel {
            margin: 10px;
        }
        .datepicker-dropdown {
            z-index: 200 !important;
        }
        .panel-body {
            background: #e5e5e5;
            background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
            background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
            font: 600 15px "Open Sans", Arial, sans-serif;
        }
        label.control-label {
            font-weight: 600;
            color: #777;
        }
        table { 
            width: 650px; 
            border-collapse: collapse; 
            margin: auto;
            margin-top: 50px;
        }
        tr:nth-of-type(odd) { 
            background: #eee; 
        }
        th { 
            background: #004684; 
            color: white; 
            font-weight: bold; 
        }
        td, th { 
            padding: 10px; 
            border: 1px solid #ccc; 
            text-align: left; 
            font-size: 14px;
        }
    </style>
</head>

<body>

<div style="margin-left:50px;">
    <form name="updateticket" id="updatecomplaint" method="post"> 
        <table border ="0" cellspacing="0" cellpadding="0">
            <?php 
            // Retrieve order details based on form_id
            $ret1 = mysqli_query($db, "SELECT * FROM users_orders WHERE o_id='" . $_GET['newform_id'] . "'");
            $ro = mysqli_fetch_array($ret1);
            
            // Retrieve user details based on user_id from the order
            $ret2 = mysqli_query($db, "SELECT * FROM users WHERE u_id='" . $ro['u_id'] . "'");
            while ($row = mysqli_fetch_array($ret2)) {
            ?>
                <tr>
                    <td colspan="2"><b><?php echo $row['f_name']; ?>'s profile</b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr height="50">
                    <td><b>Reg Date:</b></td>
                    <td><?php echo htmlentities($row['date']); ?></td>
                </tr>
                <tr height="50">
                    <td><b>First Name:</b></td>
                    <td><?php echo htmlentities($row['f_name']); ?></td>
                </tr>
                <tr height="50">
                    <td><b>Last Name:</b></td>
                    <td><?php echo htmlentities($row['l_name']); ?></td>
                </tr>
                <tr height="50">
                    <td><b>User Email:</b></td>
                    <td><?php echo htmlentities($row['email']); ?></td>
                </tr>
                <tr height="50">
                    <td><b>User Phone:</b></td>
                    <td><?php echo htmlentities($row['phone']); ?></td>
                </tr>
                <tr height="50">
                    <td><b>Status:</b></td>
                    <td><?php
                        // Display status based on user status value
                        if ($row['status'] == 1) {
                            echo "<div class='btn btn-primary'>Active</div>";
                        } else {
                            echo "<div class='btn btn-danger'>Block</div>";
                        }
                    ?></td>
                </tr>
                <tr>
                    <td colspan="2">   
                        <input name="Submit2" type="submit" class="btn btn-danger" value="Close this window" onClick="return f2();" style="cursor: pointer;" />
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>

</body>
</html>

<?php } ?>
