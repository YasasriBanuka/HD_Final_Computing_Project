<!DOCTYPE html>
<html lang="en">
<?php
    // Include the database connection file
    include("../connection/connect.php");
    
    // Disable error reporting (not recommended for production)
    error_reporting(0);
    
    // Start a new session or resume an existing session
    session_start();
    
    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Check if any required fields are empty
        if (
            empty($_POST['c_name']) || empty($_POST['res_name']) || 
            $_POST['email'] == '' || $_POST['phone'] == '' || 
            $_POST['url'] == '' || $_POST['o_hr'] == '' || 
            $_POST['c_hr'] == '' || $_POST['o_days'] == '' || 
            $_POST['address'] == ''
        ) {
            // Show error message if fields are empty
            $error = '
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>All fields must be filled!</strong>
            </div>';
        } else {
            // Get the file details
            $fname = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $fsize = $_FILES['file']['size'];
            $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
            $fnew = uniqid() . '.' . $extension;
            
            // Define the path to store the uploaded file
            $store = "Res_img/" . basename($fnew);
            
            // Check if the file extension is allowed
            if (in_array($extension, ['jpg', 'png', 'gif'])) {
                // Check if the file size is within the allowed limit
                if ($fsize >= 1000000) {
                    // Show error message if the file size exceeds 1MB
                    $error = '
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Max image size is 1024kb!</strong> Try a different image.
                    </div>';
                } else {
                    // Prepare SQL query to insert form data into the database
                    $res_name = $_POST['res_name'];
                    $sql = "
                        INSERT INTO restaurant (
                            c_id, title, email, phone, url, o_hr, c_hr, o_days, address, image
                        ) VALUES (
                            '{$_POST['c_name']}', '$res_name', '{$_POST['email']}', 
                            '{$_POST['phone']}', '{$_POST['url']}', '{$_POST['o_hr']}', 
                            '{$_POST['c_hr']}', '{$_POST['o_days']}', '{$_POST['address']}', '$fnew'
                        )
                    ";
                    
                    // Execute the SQL query
                    mysqli_query($db, $sql);
                    
                    // Move the uploaded file to the designated directory
                    move_uploaded_file($temp, $store);
                    
                    // JavaScript success alert
                    echo '<script type="text/javascript">';
                    echo 'alert("New Restaurant Added Successfully!");';
                    echo 'window.location.href = "dashboard.php";'; // Optionally redirect to the dashboard
                    echo '</script>';
                }
            } elseif ($extension == '') {
                // Show error message if no image is selected
                $error = '
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Select an image!</strong>
                </div>';
            } else {
                // Show error message if the file extension is not allowed
                $error = '
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Invalid extension!</strong> Only PNG, JPG, and GIF are accepted.
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
    <title>Add Restaurant</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="../images/adicon.png"alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                    </ul>
                    <ul class="navbar-nav my-lg-0"></ul>
                        <li class="nav-item dropdown">
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all
                                                notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/user-icn.png"
                                    alt="user" class="profile-pic" /></a>
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
        <div class="page-wrapper">
            <div class="container-fluid">
                <?php echo $error;
                echo $success; ?>
                <div class="col-lg-12">
                    <div class="card card-outline-primary">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Restaurant</h4>
                        </div>
                        <div class="card-body">
                            <form action='' method='post' enctype="multipart/form-data">
                                <div class="form-body">
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Restaurant Name</label>
                                                <input type="text" name="res_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Bussiness E-mail</label>
                                                <input type="text" name="email"
                                                    class="form-control form-control-danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone </label>
                                                <input type="text" name="phone" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Website URL</label>
                                                <input type="text" name="url" class="form-control form-control-danger">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Open Hours</label>
                                                <select name="o_hr" class="form-control custom-select"
                                                    data-placeholder="Choose a Category">
                                                    <option>--Select your Hours--</option>
                                                    <option value="6am">6am</option>
                                                    <option value="7am">7am</option>
                                                    <option value="8am">8am</option>
                                                    <option value="9am">9am</option>
                                                    <option value="10am">10am</option>
                                                    <option value="11am">11am</option>
                                                    <option value="12pm">12pm</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Close Hours</label>
                                                <select name="c_hr" class="form-control custom-select"
                                                    data-placeholder="Choose a Category">
                                                    <option>--Select your Hours--</option>
                                                    <option value="3pm">3pm</option>
                                                    <option value="4pm">4pm</option>
                                                    <option value="5pm">5pm</option>
                                                    <option value="6pm">6pm</option>
                                                    <option value="7pm">7pm</option>
                                                    <option value="8pm">8pm</option>
                                                    <option value="9pm">9pm</option>
                                                    <option value="10pm">10pm</option>
                                                    <option value="11pm">11pm</option>
                                                    <option value="12am">12am</option>
                                                    <option value="1am">1am</option>
                                                    <option value="2am">2am</option>
                                                    <option value="3am">3am</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Open Days</label>
                                                <select name="o_days" class="form-control custom-select"
                                                    data-placeholder="Choose a Category" tabindex="1">
                                                    <option>--Select your Days--</option>
                                                    <option value="Mon-Tue">Mon-Tue</option>
                                                    <option value="Mon-Wed">Mon-Wed</option>
                                                    <option value="Mon-Thu">Mon-Thu</option>
                                                    <option value="Mon-Fri">Mon-Fri</option>
                                                    <option value="Mon-Sat">Mon-Sat</option>
                                                    <option value="24hr-x7">24hr-x7</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="file" id="lastName"
                                                    class="form-control form-control-danger" placeholder="12n">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Select Location</label>
                                                <select name="c_name" class="form-control custom-select"
                                                    data-placeholder="Choose a Location" tabindex="1">
                                                    <option>--Select Location--</option>
                                                    <?php $ssql = "select * from res_category";
                                                    $res = mysqli_query($db, $ssql);
                                                    while ($row = mysqli_fetch_array($res)) {
                                                        echo ' <option value="' . $row['c_id'] . '">' . $row['c_name'] . '</option>';
                                                        ;
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="box-title m-t-40">Restaurant Address</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="form-group">

                                                <textarea name="address" type="text" style="height:100px;"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" name="submit" class="btn btn-primary" value="Save">
                            <a href="add_restaurant.php" class="btn btn-inverse">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="footer">@Fork'n Easy | Crated by HD CSE CMU B06 | GROUP D</footer>
        </div>
    </div>
    </div>
    </div>
    <!-- jQuery library for JavaScript -->
<script src="js/lib/jquery/jquery.min.js"></script>

<!-- Popper.js for managing poppers in Bootstrap -->
<script src="js/lib/bootstrap/js/popper.min.js"></script>

<!-- Bootstrap JavaScript for Bootstrap components functionality -->
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>

<!-- jQuery Slimscroll for custom scrollbars -->
<script src="js/jquery.slimscroll.js"></script>

<!-- Sidebarmenu for sidebar menu functionality -->
<script src="js/sidebarmenu.js"></script>

<!-- Sticky-kit for making elements stick on scroll -->
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

<!-- Custom JavaScript for custom functionalities -->
<script src="js/custom.min.js"></script>
</body>

</html>