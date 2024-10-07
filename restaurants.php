<!DOCTYPE html>
<html lang="en">
<?php
// Include database connection file
include("connection/connect.php");

// Suppress error reporting
error_reporting(0);

// Start a new session or resume the existing session
session_start();
?>

<head>
    <!-- Character encoding for the document -->
    <meta charset="utf-8">
    <!-- Compatibility with Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Viewport settings for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Meta description and author -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon for the site -->
    <link rel="icon" href="#">
    <title>Restaurants</title>
    <!-- Link to CSS files for styling -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Header section with navigation -->
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <!-- Toggle button for mobile view -->
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <!-- Brand logo -->
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="admin/images/logo.png" alt=""> </a>
                <!-- Navigation links -->
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <!-- Home link -->
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <!-- Restaurants link -->
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a> </li>

                        <?php
                        // Conditional links based on user session
                        if (empty($_SESSION["user_id"])) {
                            // If not logged in, show login and registration links
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
                              <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                        } else {
                            // If logged in, show user orders and logout links
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page content wrapper -->
    <div class="page-wrapper">
        <!-- Navigation links for ordering process -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="#">Choose Restaurant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your favorite food</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>
                </ul>
            </div>
        </div>

        <!-- Hero image section -->
        <div class="inner-page-hero bg-image" data-image-src="images/img/pimg.jpg">
            <div class="container"> </div>
        </div>

        <!-- Results display area -->
        <div class="result-show">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>

        <!-- Restaurants page section -->
        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <!-- Placeholder for potential filters or additional content -->
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                    </div>

                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
                        <div class="bg-gray restaurant-entry">
                            <div class="row">
                                <?php
                                // Query to fetch restaurant details from the database
                                $ress = mysqli_query($db, "select * from restaurant");
                                while ($rows = mysqli_fetch_array($ress)) {
                                    // Display each restaurant entry
                                    echo ' <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
                                                            <div class="entry-logo">
                                                                <a class="img-fluid" href="dishes.php?res_id=' . $rows['rs_id'] . '" >
                                                                 <img src="admin/Res_img/' . $rows['image'] . '" alt="Food logo"></a>
                                                            </div>
                                                            <!-- end:Logo -->
                                                            <div class="entry-dscr">
                                                                <h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . 
                                                                '</a></h5> <span>' . $rows['address'] . '</span>
                                                                
                                                            </div>
                                                            <!-- end:Entry description -->
                                                        </div>
                                                        
                                                         <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
                                                                <div class="right-content bg-white">
                                                                    <div class="right-review">
                                                                        
                                                                        <a href="dishes.php?res_id=' . $rows['rs_id'] .
                                                                         '" class="btn btn-purple">View Menu</a> </div>
                                                                </div>
                                                                <!-- end:right info -->
                                                            </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer section -->
    <footer class="footer">
        <div class="container">
            <div class="bottom-footer">
                <div class="row">
                    <!-- Payment options section -->
                    <div class="col-xs-12 col-sm-3 payment-options color-gray">
                        <h5>Payment Options</h5>
                        <ul>
                            <li>
                                <a href="#"> <img src="images/visa.png" alt="Paypal"> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="images/cash.png" alt="Maestro"> </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Address and contact information -->
                    <div class="col-xs-12 col-sm-4 address color-gray">
                        <h5>Address</h5>
                        <p>No 234, Main street, Galle Fort, Sri Lanka.</p>
                        <h5>Phone: 091-1524865</h5>
                    </div>
                    <!-- Additional information section -->
                    <div class="col-xs-12 col-sm-5 additional-info color-gray">
                        <h5>© Fork'n Easy</h5>
                        <p>Our restaurants strive to become our customers’ favorite places to eat.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script files -->
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
