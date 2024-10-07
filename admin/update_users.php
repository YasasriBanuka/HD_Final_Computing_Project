<!DOCTYPE html>
<html lang="en">

<?php
// Start session and include database connection
session_start();
error_reporting(0);
include("../connection/connect.php");

// Handle form submission
if (isset($_POST['submit'])) {
    // Validate form inputs
    if (empty($_POST['uname']) || empty($_POST['fname']) || empty($_POST['lname']) ||
        empty($_POST['email']) || empty($_POST['password']) || empty($_POST['phone'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>All fields are required!</strong>
        </div>';
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Invalid email!</strong>
            </div>';
        } elseif (strlen($_POST['password']) < 6) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Password must be at least 6 characters long!</strong>
            </div>';
        } elseif (strlen($_POST['phone']) < 10) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Invalid phone number!</strong>
            </div>';
        } else {
            // Hash the password before updating the database
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $mql = "UPDATE users SET username='$_POST[uname]', f_name='$_POST[fname]', l_name='$_POST[lname]', email='$_POST[email]', phone='$_POST[phone]', password='$hashed_password' WHERE u_id='$_GET[user_upd]'";
            mysqli_query($db, $mql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>User Updated!</strong>
            </div>';
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Update Users</title>
    <!-- Stylesheets -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header">
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    
    <div id="main-wrapper">
        <!-- Header -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- Add any additional navigation items here -->
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <!-- Notifications Dropdown -->
                        <li class="nav-item dropdown">
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- User Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Page Wrapper -->
        <div class="page-wrapper" style="height:1200px;">

            <div class="container-fluid">
                <div class="row">
                    <div class="container-fluid">
                        <?php
                        // Display error and success messages
                        echo $error;
                        echo $success;
                        ?>

                        <!-- User Update Form -->

                        <br>
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Update My Profile</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Fetch user data for the update form
                                    $ssql = "SELECT * FROM users WHERE u_id='$_GET[user_upd]'";
                                    $res = mysqli_query($db, $ssql);
                                    $newrow = mysqli_fetch_array($res);
                                    ?>
                                    <form action='' method='post'>
                                        <div class="form-body">
                                            <hr>
                                            <div class="row p-t-20">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Username</label>
                                                        <input type="text" name="uname" class="form-control" value="<?php echo $newrow['username']; ?>" placeholder="username">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group has-danger">
                                                        <label class="control-label">First Name</label>
                                                        <input type="text" name="fname" class="form-control form-control-danger" value="<?php echo $newrow['f_name']; ?>" placeholder=" ">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Last Name</label>
                                                        <input type="text" name="lname" class="form-control" value="<?php echo $newrow['l_name']; ?>" placeholder=" ">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input type="text" name="email" class="form-control" value="<?php echo $newrow['email']; ?>" placeholder=" ">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Password</label>
                                                        <input type="password" name="password" class="form-control" value="" placeholder="Enter new password">
                                                        <small>Leave blank if you don't want to change the password</small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Phone</label>
                                                        <input type="text" name="phone" class="form-control" value="<?php echo $newrow['phone']; ?>" placeholder="Phone">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" name="submit" class="btn btn-success"> <i class="fa fa-check"></i>Update Profile</button>
                                            <a href="indexs.php"class="btn btn-inverse">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer"> ©2024 All rights reserved. Developed by HD computing and Software Engineering GROUP D </footer>
    </div>

    <!-- Scripts -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
</body>

</html>
