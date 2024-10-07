<!DOCTYPE html>
<html lang="en">

<?php
include("../connection/connect.php"); // Include the database connection file
error_reporting(0); // Disable error reporting
session_start(); // Start a session

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if required fields are empty
    if (empty($_POST['d_name']) || empty($_POST['about']) || $_POST['price'] == '' || $_POST['res_name'] == '') {    
        echo '<script>
            alert("All fields must be filled!");
        </script>';                        
    } else {
        $fname = $_FILES['file']['name']; // Get the file name
        $temp = $_FILES['file']['tmp_name']; // Get the temporary file path
        $fsize = $_FILES['file']['size']; // Get the file size
        $extension = explode('.', $fname); // Get the file extension
        $extension = strtolower(end($extension));  
        $fnew = uniqid() . '.' . $extension; // Create a unique file name
        $store = "Res_img/dishes/" . basename($fnew); // Define the storage path
        
        // Check if the file extension is valid
        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {         
            // Check if the file size is within the limit
            if ($fsize >= 1000000) {
                echo '<script>
                    alert("Max Image Size is 1024KB! Try a different image.");
                </script>';
            } else {
                // Update the dish information in the database
                $sql = "UPDATE dishes SET rs_id='$_POST[res_name]', title='$_POST[d_name]', slogan='$_POST[about]', price='$_POST[price]', img='$fnew' WHERE d_id='$_GET[menu_upd]'";
                if (mysqli_query($db, $sql)) {
                    move_uploaded_file($temp, $store); // Move the uploaded file to the storage path
                    echo '<script>
                        alert("Food Details Updated Successfully!");
                        window.location.href = "all_menu.php"; // Optional: redirect to another page after success
                    </script>';
                } else {
                    echo '<script>
                        alert("Unsuccess to Food update record. Please try again.");
                    </script>';
                }
            }
        } else {
            echo '<script>
                alert("Invalid file type! Only jpg, png, and gif are allowed.");
            </script>';
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
    <title>Update Menu</title>
    <!-- Bootstrap CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Helper CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header">
 
    <div class="preloader">
        <!-- Preloader animation -->
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>

    <div id="main-wrapper">
    
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <!-- Navbar brand -->
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- Additional navbar items -->
                    </ul>
                 
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <!-- User profile dropdown -->
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

        <?php include("sidenav.php"); // Include the sidebar ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <?php echo $error; // Display error messages
                echo $success; // Display success messages
                ?>        
                <div class="col-lg-12">
                    <div class="card card-outline-primary">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Menu to Restaurant</h4>
                        </div>
                        <div class="card-body">
                            <!-- Form to update menu item -->
                            <form action='' method='post' enctype="multipart/form-data">
                                <div class="form-body">
                                    <?php 
                                    // Fetch the current dish details
                                    $qml ="SELECT * FROM dishes WHERE d_id='$_GET[menu_upd]'";
                                    $rest = mysqli_query($db, $qml); 
                                    $roww = mysqli_fetch_array($rest);
                                    ?>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Food Name</label>
                                                <input type="text" name="d_name" value="<?php echo $roww['title']; ?>" class="form-control" placeholder="Enter Food name">
                                            </div>
                                        </div>
                                
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Description</label>
                                                <input type="text" name="about" value="<?php echo $roww['slogan']; ?>" class="form-control form-control-danger" placeholder="Food Description">
                                            </div>
                                        </div>
                             
                                    </div>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Price</label>
                                                <input type="text" name="price" value="<?php echo $roww['price']; ?>" class="form-control" placeholder="Rs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="file" id="lastName" class="form-control form-control-danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Select Restaurant</label>
                                                <select name="res_name" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                                    <option>--Select Restaurant--</option>
                                                    <?php 
                                                    // Fetch restaurant categories
                                                    $ssql ="SELECT * FROM restaurant";
                                                    $res = mysqli_query($db, $ssql); 
                                                    while($row = mysqli_fetch_array($res)) {
                                                        echo '<option value="'.$row['rs_id'].'">'.$row['title'].'</option>';
                                                    }
                                                    ?> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Save"> 
                                    <a href="all_menu.php" class="btn btn-inverse">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <footer class="footer">© Fork'n Easy</footer>
                
            </div>
        </div>
    </div>

    <!-- JavaScript and libraries -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
</body>
</html>
