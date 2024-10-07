<!DOCTYPE html>
<html lang="en">
<?php
// Include the connection to the database
include("../connection/connect.php");
error_reporting(0);
session_start();

// Handle form submission to add a new category
if (isset($_POST['submit'])) {
    // Check if the category name field is empty
    if (empty($_POST['c_name'])) {
        // Display an error message if the field is empty
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                     <strong>Field Required!</strong>
                  </div>';
    } else {
        // Check if the category already exists
        $check_cat = mysqli_query($db, "SELECT c_name FROM res_category WHERE c_name = '" . $_POST['c_name'] . "'");

        if (mysqli_num_rows($check_cat) > 0) {
            // Display an error message if the category already exists
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span></button>
                         <strong>Category already exists!</strong>
                      </div>';
        } else {
            // Insert the new category into the database
            $mql = "INSERT INTO res_category(c_name) VALUES('" . $_POST['c_name'] . "')";
            mysqli_query($db, $mql);
            // Display a success message
            $success = '<div class="alert alert-success alert-dismissible fade show">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span></button>
                         New Category Added Successfully.</br>
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
    <title>Add New Restaurant Locations</title>
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

        <!-- Top navigation bar -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0"></ul>
                    <ul class="navbar-nav my-lg-0">
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

        <!-- Page wrapper -->
        <div class="page-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="container-fluid">
                        <!-- Display error or success messages -->
                        <?php
                        echo $error;
                        echo $success;
                        ?>
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Add New Restaurant Location</h4>
                                </div>
                                <!-- Form to add a new category -->
                                <form action='' method='post'>
                                    <div class="form-body">
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Restaurant Location</label>
                                                    <input type="text" name="c_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-primary" value="Save">
                                        <a href="add_category.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Search Locations </h4>

                                <!-- Search form to filter Location -->
                                <form action="" method="POST" class="form-inline">
                                    <input type="text" name="search" class="form-control mr-2" placeholder="Search by Location name" required>
                                    <button type="submit" name="search_btn" class="btn btn-primary">Search</button>
                                </form>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-hover table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Restaurant Location </th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                    // Check if search is performed
                                    if (isset($_POST['search_btn'])) {
                                     $search = $_POST['search'];
                                     // Query to search location by name
                                     $sql = "SELECT * FROM res_category WHERE c_name LIKE '%$search%' ORDER BY c_id DESC";
                                    } else {
                                 // Default query to fetch all categories
                                    $sql = "SELECT * FROM res_category ORDER BY c_id DESC";
                                    }

                                     $query = mysqli_query($db, $sql);

                                 if (!mysqli_num_rows($query) > 0) {
                                      echo '<td colspan="7"><center>No Categories-Data!</center></td>';
                                    } else {
                                        // Display each  location in the table
                                        while ($rows = mysqli_fetch_array($query)) {
                                                echo '<tr><td>' . $rows['c_id'] . '</td>
                                                <td>' . $rows['c_name'] . '</td>
                                                <td>' . $rows['date'] . '</td>
                                        <td><a href="delete_category.php?cat_del=' . $rows['c_id'] . '" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
                                        <a href="update_category.php?cat_upd=' . $rows['c_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                     </td></tr>';
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
    </div>
</div>
<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/sidebarmenu.js"></script>
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="js/custom.min.js"></script>
</body>

</html>
