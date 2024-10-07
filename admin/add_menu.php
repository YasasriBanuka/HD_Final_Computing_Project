<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Dish</title>
    <!-- Add your CSS links here, e.g., Bootstrap or custom styles -->
</head>
<body>
<?php
// Include the database connection file
include("../connection/connect.php");

// Disable error reporting
error_reporting(0);

// Start the session
session_start();

$error = ''; // Initialize error variable
$success = ''; // Initialize success variable

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Validate if required fields are filled
    if (empty($_POST['d_name']) || empty($_POST['about']) || empty($_POST['price']) || empty($_POST['res_name'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields must be filled!</strong>
                  </div>';
    } else {
        // Handle the file upload
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION)); // Get the file extension
        $fnew = uniqid() . '.' . $extension;  // Generate a unique file name
        $store = "Res_img/dishes/" . $fnew;  // File path to store the image

        // Check if the uploaded file has a valid extension (jpg, png, gif)
        if (in_array($extension, ['jpg', 'png', 'gif'])) {
            // Check if the file size is less than 1MB (1024kb)
            if ($fsize < 1000000) {
                // Insert the dish data into the database
                $sql = "INSERT INTO dishes (rs_id, title, slogan, price, img) 
                        VALUES ('" . mysqli_real_escape_string($db, $_POST['res_name']) . "', '" . mysqli_real_escape_string($db, $_POST['d_name']) . "', '" . mysqli_real_escape_string($db, $_POST['about']) . "', '" . mysqli_real_escape_string($db, $_POST['price']) . "', '$fnew')";
                
                if (mysqli_query($db, $sql)) {
                    move_uploaded_file($temp, $store);
                    // Display a JavaScript success message
                    echo '<script type="text/javascript">
                            alert("New food added successfully!");
                            window.location.href = "all_menu.php";  // Optional: Redirect to another page after alert
                          </script>';
                } else {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error adding dish: ' . mysqli_error($db) . '</strong>
                              </div>';
                }
            } else {
                // Display an error message if file size exceeds 1MB
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Max Image Size is 1024kb! Try a different image.</strong>
                          </div>';
            }
        } else {
            // Display an error message if the file extension is not valid
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Invalid extension! Only png, jpg, gif are accepted.</strong>
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
    <title>Add Menu</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header">
  
    <!-- Preloader for the page -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
  
    <div id="main-wrapper">
      
        <!-- Top Navigation Bar -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- Placeholder for additional items -->
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <!-- User Profile and Notification Dropdowns -->
                        <li class="nav-item dropdown">
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> 
                                            <strong>Check all notifications</strong> 
                                            <i class="fa fa-angle-right"></i> 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="images/bookingSystem/user-icn.png" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
     
        <?php
        include("sidenav.php");
        ?>
      
        <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Display success or error messages -->
                <?php echo $error; echo $success; ?>
                
                <div class="col-lg-12">
                    <div class="card card-outline-primary">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Menu</h4>
                        </div>
                        <div class="card-body">
                            <!-- Form to add a new dish -->
                            <form action='' method='post'  enctype="multipart/form-data">
                                <div class="form-body">
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Dish Name</label>
                                                <input type="text" name="d_name" class="form-control" placeholder="Enter new Food Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Food Description</label>
                                                <input type="text" name="about" class="form-control" placeholder="Add Food Description">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Price </label>
                                                <input type="text" name="price" class="form-control" placeholder="Rs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="file" id="lastName" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Select Restaurant</label>
                                                <select name="res_name" class="form-control custom-select" data-placeholder="Choose a Category">
                                                    <option>--Select Restaurant--</option>
                                                    <!-- Fetch and display all restaurants from the database -->
                                                    <?php 
                                                        $ssql = "select * from restaurant";
                                                        $res = mysqli_query($db, $ssql); 
                                                        while($row = mysqli_fetch_array($res))  
                                                        {
                                                            echo' <option value="'.$row['rs_id'].'">'.$row['title'].'</option>';
                                                        }  
                                                    ?> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" name="submit" class="btn btn-success" value="Save"> 
                                    <a href="dashboard.php" class="btn btn-inverse">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include required JS scripts -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>

</body>
</html>
