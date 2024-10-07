<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

// Redirect to login page if user_id is not set in session
if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
} else {
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>My Orders</title>
    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
            /* Radial gradients for various browsers */
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

        /* Media queries for responsive design */
        @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            /* Add responsive styles here if needed */
        }


        .spinner {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php">
                    <img class="img-rounded" src="admin/images/logo.png" alt="">
                </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a></li>
                        <li class="nav-item"><a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a></li>
                        <?php
                        // Display login/register or order/logout links based on session status
                        if (empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a></li>
                                  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a></li>';
                        } else {
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a></li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="page-wrapper">
        <div class="inner-page-hero bg-image" data-image-src="images/img/pimg.jpg">
            <div class="container"></div>
        </div>
        <div class="result-show">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bg-gray">
                            <div class="row">
                            <table class="table table-bordered table-hover">
                            <thead style="background: #404040; color: white;">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Track Map</th> <!-- New column for tracking -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch and display user orders
                                $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='" . $_SESSION['user_id'] . "'");
                                if (mysqli_num_rows($query_res) == 0) {
                                    echo '<tr><td colspan="7"><center>You have no orders placed yet.</center></td></tr>'; // Updated colspan
                                } else {
                                    while ($row = mysqli_fetch_array($query_res)) {
                                        ?>
                                        <tr>
                                            <td data-column="Item"><?php echo htmlspecialchars($row['title']); ?></td>
                                            <td data-column="Quantity"><?php echo htmlspecialchars($row['quantity']); ?></td>
                                            <td data-column="Price">Rs. <?php echo htmlspecialchars($row['price']); ?></td>
                                            <td data-column="Status">
                                                <?php
                                                $status = htmlspecialchars($row['status']);
                                                switch ($status) {
                                                    case "":
                                                    case "NULL":
                                                        echo '<button type="button" class="btn btn-info"><span class="fa fa-bars" aria-hidden="true"></span> Dispatch</button>';
                                                        break;
                                                    case "in process":
                                                        echo '<button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> On The Way!</button>';
                                                        break;
                                                    case "closed":
                                                        echo '<button type="button" class="btn btn-success"><span class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button>';
                                                        break;
                                                    case "rejected":
                                                        echo '<button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button>';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td data-column="Date"><?php echo htmlspecialchars($row['date']); ?></td>
                                            <td data-column="Action">
                                                <a href="delete_orders.php?order_del=<?php echo htmlspecialchars($row['o_id']); ?>"
                                                onclick="return confirm('Are you sure you want to cancel your order?');"
                                                class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">
                                                    <i class="fa fa-trash-o" style="font-size:16px"></i>
                                                </a>
                                            </td>
                                            <td data-column="Track Map" style="text-align: center; display: flex; justify-content: center;">
                                            <?php if ($status != 'rejected') { ?>
                                            <!-- Show Track Map button only if the order is not rejected -->
                                            <div id="tracking-container-<?php echo htmlspecialchars($row['o_id']); ?>" style="position: relative;">
                                                <button class="btn btn-primary" 
                                                        onclick="showTrackingAnimation('<?php echo htmlspecialchars($row['o_id']); ?>')">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i> Track Order
                                                </button>
                                                <!-- Animation Spinner (initially hidden) -->
                                                <div id="tracking-animation-<?php echo htmlspecialchars($row['o_id']); ?>" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <div class="spinner"></div>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                                <span>Your order is canceled</span>
                                            <?php } ?>
                                        </td>

                                        <!-- Add CSS for spinner animation -->
                                        <style>
                                            .spinner {
                                                border: 4px solid rgba(0, 0, 0, 0.1);
                                                width: 24px;
                                                height: 24px;
                                                border-radius: 50%;
                                                border-left-color: #000;
                                                animation: spin 1s linear infinite;
                                            }

                                            @keyframes spin {
                                                to { transform: rotate(360deg); }
                                            }
                                        </style>

                                        <!-- Add JavaScript function for showing animation -->
                                        <script>
                                            function showTrackingAnimation(orderId) {
                                                // Get the tracking animation element
                                                var trackingAnimation = document.getElementById('tracking-animation-' + orderId);
                                                trackingAnimation.style.display = 'block';  // Show the spinner

                                                // Simulate tracking animation (hide the spinner after a delay)
                                                setTimeout(function() {
                                                    trackingAnimation.style.display = 'none';  // Hide the spinner after delay
                                                    alert('Tracking complete for Order ID: ' + orderId);  // Simulate a tracking completion message
                                                }, 2000); // 2-second delay for demonstration
                                            }
                                        </script>
                                    </tr>
                                        <?php
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
        </section>
        
        <footer class="footer">
            <div class="row bottom-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 payment-options color-gray">
                            <h5>Payment Options</h5>
                            <ul>
                                <li><a href="#"><img src="images/visa.png" alt="Visa"></a></li>
                                <li><a href="#"><img src="images/mastercard.png" alt="Mastercard"></a></li>
                                <li><a href="#"><img src="images/cash.png" alt="Cash"></a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4 address color-gray">
                            <h5>Address</h5>
                            <p>No 234, Main Street, Galle Fort, Sri Lanka.</p>
                            <h5>Phone: 091-1524865</h5>
                        </div>
                        <div class="col-xs-12 col-sm-5 additional-info color-gray">
                            <h5>© Fork'n Easy</h5>
                            <p>Our restaurants strive to become our customers’ favorite places to eat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>


</body>
</html>
<?php
}
?>
