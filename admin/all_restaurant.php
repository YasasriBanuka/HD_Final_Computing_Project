<!DOCTYPE html>
<html lang="en">

<?php
// Include the database connection file
include("../connection/connect.php");
// Suppress error reporting
error_reporting(0);
// Start a new session or resume an existing session
session_start();

// Initialize search variable
$search_location = isset($_POST['search_location']) ? $_POST['search_location'] : '';

// SQL query to fetch restaurant details with location filter
$sql = "SELECT * FROM restaurant";
if (!empty($search_location)) {
    $search_location = mysqli_real_escape_string($db, $search_location);
    $sql .= " WHERE address LIKE '%$search_location%'";
}
$sql .= " ORDER BY rs_id DESC";
$query = mysqli_query($db, $sql);
?>

<head>
    <!-- Meta tags for character set, browser compatibility, and viewport settings -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Favicon icon for the website -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    
    <!-- Page title -->
    <title>All Restaurants</title>
    
    <!-- CSS files for styling -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader for loading animation -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
   
    <!-- Main wrapper for the page -->
    <div id="main-wrapper">
        <!-- Header section -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <!-- Logo image -->
                        <span><img src="../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- Empty navbar items (if needed) -->
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <!-- Notifications dropdown -->
                        <li class="nav-item dropdown">
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);">
                                            <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <!-- User profile dropdown -->
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
  
        <!-- Left sidebar -->
        <?php
        include("sidenav.php");
        ?>

        <!-- Page content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main card for displaying restaurants -->
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">All Restaurant</h4>
                                </div>
                                <!-- Search form -->
                                 <br>
                                 <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="search_location">Search by Location:</label>
                                        <input type="text" id="search_location" name="search_location" class="form-control" 
                                               value="<?php echo htmlspecialchars($search_location); ?>"> <!-- Corrected value handling -->
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="all_restaurant.php" class="btn btn-inverse">Cancel</a>
                                </form>
                                <div class="table-responsive m-t-40">
                                    <!-- Table displaying restaurant data -->
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Location</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Url</th>
                                                <th>Open Hrs</th>
                                                <th>Close Hrs</th>
                                                <th>Open Days</th>
                                                <th>Address</th>
                                                <th>Image</th>
                                                <th>Date</th>
                                                <th>Action</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Check if there are no restaurants
                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="12"><center>No Restaurants</center></td>';
                                            } else {
                                                // Fetch and display each restaurant
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    // Query to get category name
                                                    $mql = "SELECT * FROM res_category WHERE c_id='" . $rows['c_id'] . "'";
                                                    $res = mysqli_query($db, $mql);
                                                    $row = mysqli_fetch_array($res);
                                                    
                                                    echo '<tr>
                                                        <td>' . $row['c_name'] . '</td>
                                                        <td>' . $rows['title'] . '</td>
                                                        <td>' . $rows['email'] . '</td>
                                                        <td>' . $rows['phone'] . '</td>
                                                        <td>' . $rows['url'] . '</td>
                                                        <td>' . $rows['o_hr'] . '</td>
                                                        <td>' . $rows['c_hr'] . '</td>
                                                        <td>' . $rows['o_days'] . '</td>
                                                        <td>' . $rows['address'] . '</td>
                                                        <td>
                                                            <div class="col-md-3 col-lg-8 m-b-10">
                                                                <center><img src="Res_img/' . $rows['image'] . '" class="img-responsive radius" style="min-width:150px;min-height:100px;"/></center>
                                                            </div>
                                                        </td>
                                                        <td>' . $rows['date'] . '</td>
                                                        <td>
                                                            <a href="delete_restaurant.php?res_del=' . $rows['rs_id'] . '" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">
                                                                <i class="fa fa-trash-o" style="font-size:16px"></i>
                                                            </a>
                                                            <a href="update_restaurant.php?res_upd=' . $rows['rs_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
            <!-- Footer section -->
            <footer class="footer">© Fork'n Easy</footer>
        </div>
    </div>
   
    <!-- JavaScript files for functionality -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>
