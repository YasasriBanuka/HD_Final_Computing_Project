<!DOCTYPE html>
<html lang="en">

<?php
include("../connection/connect.php"); // Include the database connection
error_reporting(0); // Suppress error reporting
session_start(); // Start a new session or resume the existing one
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>View Order</title>
    <!-- CSS Stylesheets -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JavaScript for Popup Window -->
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;

        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top);
        }
    </script>
</head>

<body class="fix-header fix-sidebar">

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
                    <!-- Logo and Branding -->
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src= "../images/adicon.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <!-- Navbar Left (Empty) -->
                    <ul class="navbar-nav mr-auto mt-md-0"></ul>
                    <!-- Navbar Right -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Notifications Dropdown -->
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
                        <!-- User Profile Dropdown -->
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

        <!-- Sidebar Navigation -->
        <?php include("stfsidenav.php"); ?>

        <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12">
                            <!-- Order Details Card -->
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">View Order</h4>
                                </div>
                                <div class="table-responsive m-t-20">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <tbody>
                                            <?php
                                            // Fetch order details based on provided order ID
                                            $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON 
                                            users.u_id = users_orders.u_id WHERE o_id = '" . $_GET['user_upd'] . "'";
                                            $query = mysqli_query($db, $sql);
                                            $rows = mysqli_fetch_array($query);
                                            ?>
                                            <!-- Display Order Details -->
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td style="text-align: center;"><?php echo $rows['username']; ?></td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-primary" onClick="popUpWindow('order_update.php?form_id=<?php echo htmlentities($rows['o_id']); ?>');" title="Update order">
                                                        Update Order Status
                                                    </button>
                                                </td>
                                            </tr>

                                            <td><strong>Title:</strong></td>
                                                <td style="text-align: center;"><?php echo $rows['title']; ?></td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-primary" onClick="popUpWindow('userprofile.php?newform_id=<?php echo htmlentities($rows['o_id']); ?>');" title="View user details">
                                                        View User Details
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Quantity:</strong></td>
                                                <td style="text-align: center;"><?php echo $rows['quantity']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Price:</strong></td>
                                                <td style="text-align: center;">Rs.<?php echo $rows['price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Address:</strong></td>
                                                <td style="text-align: center;"><?php echo $rows['address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Date:</strong></td>
                                                <td style="text-align: center;"><?php echo $rows['date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <?php 
                                                // Display order status button based on current status
                                                $status = $rows['status'];
                                                if ($status == "" || $status == "NULL") { ?>
                                                    <td style="text-align: center;"><button type="button" class="btn btn-info">
                                                        <span class="fa fa-bars" aria-hidden="true"></span> Dispatch</button></td>
                                                <?php } 
                                                if ($status == "in process") { ?>
                                                    <td style="text-align: center;"><button type="button" class="btn btn-warning">
                                                        <span class="fa fa-cog fa-spin" aria-hidden="true"></span> On a Way!</button></td>
                                                <?php }
                                                if ($status == "closed") { ?>
                                                    <td style="text-align: center;"><button type="button" class="btn btn-primary">
                                                        <span class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button></td>
                                                <?php } 
                                                if ($status == "rejected") { ?>
                                                    <td style="text-align: center;"><button type="button" class="btn btn-danger">
                                                        <i class="fa fa-close"></i> Cancelled</button></td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">© fork'n Easy</footer>
        </div>
    </div>

    <!-- JavaScript Libraries -->
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
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>
