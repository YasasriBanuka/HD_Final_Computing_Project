<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php"); // Include database connection
error_reporting(0); // Disable error reporting
session_start(); // Start session for user authentication

// Handle search query
$search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';

// Query to fetch user data from the database
$sql = "SELECT * FROM users";
if ($search) {
    $sql .= " WHERE username LIKE '%$search%'";
}
$sql .= " ORDER BY u_id DESC";

$query = mysqli_query($db, $sql);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>All Users</title>
    <!-- Link to CSS files -->
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

    <!-- Main wrapper -->
    <div id="main-wrapper">
        <!-- Header section -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <!-- Logo and brand link -->
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0"></ul>
                    <ul class="navbar-nav my-lg-0">
                        <!-- Notifications dropdown -->
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

        <?php
        include("stfsidenav.php");
        ?>

        <!-- Page wrapper -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">All Users</h4>
                                </div>
                                <br>
                                <div class="card-body">
                                    <!-- Search form -->
                                    <form method="GET" action="all_users.php">
                                        <div class="form-group">
                                            <label for="search">Search by Username:</label>
                                            <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a href="all_users.php" class="btn btn-inverse">Cancel</a>
                                    </form>
                                </div>
                                <div class="table-responsive m-t-20">
                                    <!-- Table displaying all users -->
                                    <table id="myTable" class="table table-bordered table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Username</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Reg-Date</th>
                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // Check if there are no users
                                                if (mysqli_num_rows($query) == 0) {
                                                    echo '<tr><td colspan="8"><center>No Users</center></td></tr>';
                                                } else {
                                                    // Display user data in table rows
                                                    while ($rows = mysqli_fetch_array($query)) {
                                                        echo '<tr>
                                                            <td>' . $rows['username'] . '</td>
                                                            <td>' . $rows['f_name'] . '</td>
                                                            <td>' . $rows['l_name'] . '</td>
                                                            <td>' . $rows['email'] . '</td>
                                                            <td>' . $rows['phone'] . '</td>
                                                            <td>' . $rows['address'] . '</td>
                                                            <td>' . $rows['date'] . '</td>
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
            <!-- Footer -->
            <footer class="footer"> © Fork'n Easy</footer>
        </div>
    </div>
    
    <!-- JS scripts -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
</body>
</html>
