<!DOCTYPE html>
<html lang="en">
<?php

session_start();
error_reporting(0);
include("connection/connect.php");

//Include necessary classes for email sending
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

//Import necessary classes from PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

if (isset($_POST['submit'])) {
    if (
        empty($_POST['firstname']) ||
        empty($_POST['lastname']) ||
        empty($_POST['email']) ||
        empty($_POST['phone']) ||
        empty($_POST['username']) ||
        empty($_POST['password']) ||
        empty($_POST['cpassword'])
    ) {
        $message = "All fields must be Required!";
        echo "<script>alert('$message');</script>";
    } else {

        // Check if username and email already exist
        $check_username = mysqli_query($db, "SELECT username FROM users WHERE username = '" . mysqli_real_escape_string($db, $_POST['username']) . "' ");
        $check_email = mysqli_query($db, "SELECT email FROM users WHERE email = '" . mysqli_real_escape_string($db, $_POST['email']) . "' ");

        // Validate form data
        if ($_POST['password'] != $_POST['cpassword']) {
            echo "<script>alert('Passwords do not match');</script>";
        } elseif (strlen($_POST['password']) < 6) {
            echo "<script>alert('Password length should be greater than 5');</script>";
        } elseif (strlen($_POST['phone']) < 10) {
            echo "<script>alert('Invalid phone number!');</script>";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email address! Please type a valid email.');</script>";
        } elseif (mysqli_num_rows($check_username) > 0) {
            echo "<script>alert('Username Already exists!');</script>";
        } elseif (mysqli_num_rows($check_email) > 0) {
            echo "<script>alert('Email Already exists!');</script>";
        } else {

            // Insert user into the database
            $mql = "INSERT INTO users(username, f_name, l_name, email, phone, password, address) 
                    VALUES('" . mysqli_real_escape_string($db, $_POST['username']) . "', 
                           '" . mysqli_real_escape_string($db, $_POST['firstname']) . "', 
                           '" . mysqli_real_escape_string($db, $_POST['lastname']) . "', 
                           '" . mysqli_real_escape_string($db, $_POST['email']) . "', 
                           '" . mysqli_real_escape_string($db, $_POST['phone']) . "', 
                           '" . mysqli_real_escape_string($db, $_POST['password']) . "', 
                           '" . mysqli_real_escape_string($db, $_POST['address']) . "')";
            $result  =  mysqli_query($db, $mql);

            if ($result) {
                try {
                    // Initialize PHPMailer object
                    $mail = new PHPMailer;

                    // SMTP Configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'banukadias5@gmail.com';
                    $mail->Password = 'cfplxzwulnpywmwa';  // Be careful with hardcoding passwords in production environments
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom('banukadias5@gmail.com', 'The Fork"n Easy');
                    $mail->addReplyTo('banukadias5@gmail.com', 'The Fork"n Easy');

                    // Recipient email address
                    $mail->addAddress($_POST['email']);

                    // Email content
                    $mail->isHTML(true);
                    $mail->Subject = 'Fork"n Easy Success Message';
                    $bodyContent = '<h2>Dear ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ',</h2>';
                    $bodyContent .= '<p>Your registration has been completed. Thank you for choosing us!</p>';
                    $mail->Body = $bodyContent;

                    // Send email and handle success or failure
                    if (!$mail->send()) {
                        echo 'Verification code sending failed. Error: ' . $mail->ErrorInfo;
                    } else {
                        echo "<script>alert('Registration successful!');</script>";
                    }
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                }

                header("refresh:0.1;url=login.php");
                exit();
            } else {
                echo "<script>alert('User Registration Unsuccessful!');</script>";
            }
        }
    }
}
?>



<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="icon" href="#">
   <title>Registration</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="css/font-awesome.min.css" rel="stylesheet">
   <link href="css/animsition.min.css" rel="stylesheet">
   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">
</head>

<body>
   <div style=" background-image: url('images/img/pimg.jpg');">
      <header id="header" class="header-scroll top-header headrom">
         <nav class="navbar navbar-dark">
            <div class="container">
               <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                  data-target="#mainNavbarCollapse">&#9776;</button>
               <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="admin/images/logo.png" alt=""> </a>
               <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                  <ul class="nav navbar-nav">
                     <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
                              class="sr-only">(current)</span></a> </li>
                     <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
                              class="sr-only"></span></a> </li>

                     <?php
                     if (empty($_SESSION["user_id"])) {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                     } else {


                        echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                     }

                     ?>

                  </ul>
               </div>
            </div>
         </nav>
      </header>
      <div class="page-wrapper">

         <div class="container">
            <ul>


            </ul>
         </div>

         <section class="contact-page inner-page">
            <div class="container ">
               <div class="row ">
                  <div class="col-md-12">
                     <div class="widget">
                        <div class="widget-body">

                           <form action="" method="post">
                              <div class="row">
                                 <div class="form-group col-sm-12">
                                    <label for="exampleInputusername">User-Name</label>
                                    <input class="form-control" type="text" name="username" id="example-text-input">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="exampleInputFirstname">First Name</label>
                                    <input class="form-control" type="text" name="firstname" id="example-text-input">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="exampleInputLastName">Last Name</label>
                                    <input class="form-control" type="text" name="lastname" id="example-text-input-2">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="exampleInputEmail1">Email Address</label>
                                    <input type="text" class="form-control" name="email" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="exampleInputNumber">Phone number</label>
                                    <input class="form-control" type="text" name="phone" id="example-tel-input-3">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" name="password"
                                       id="exampleInputPassword1">
                                 </div>
                                 <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">Confirm password</label>
                                    <input type="password" class="form-control" name="cpassword"
                                       id="exampleInputPassword2">
                                 </div>
                                 <div class="form-group col-sm-12">
                                    <label for="exampleTextarea">Delivery Address</label>
                                    <textarea class="form-control" id="exampleTextarea" name="address"
                                       rows="3"></textarea>
                                 </div>

                              </div>

                              <div class="row">
                                 <div class="col-sm-4">
                                    <p> <input type="submit" value="Register" name="submit" class="btn theme-btn"> </p>
                                 </div>
                              </div>
                           </form>

                        </div>

                     </div>

                  </div>

               </div>
            </div>
         </section>


         <footer class="footer">
            <div class="container">

               <div class="row bottom-footer">
                  <div class="container">
                     <div class="row">
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
                        <div class="col-xs-12 col-sm-4 address color-gray">
                           <h5>Address</h5>
                           <p>No 234, Main street, Galle Fort, Sri Lanka.</p>
                           <h5>Phone: 091-1524865</a></h5>
                        </div>
                        <div class="col-xs-12 col-sm-5 additional-info color-gray">
                           <h5>© Fork'n Easy</h5>
                           <p>Our restaurants strive to become our customers’ favorite places to eat.</p>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </footer>

      </div>

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