<?php
session_start();
include("connection.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['First_Name'];
    $last_name = $_POST['Last_Name'];
    $address = $_POST['Address'];
    $nic = $_POST['NIC'];
    $dob = $_POST['DOB'];
    $email = $_POST['Email'];
    $mobile_number = $_POST['Mobile_Number'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['Confirm_Password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script type='text/javascript'>alert('Passwords do not match');</script>";
    } else {
        // Check if email is unique
        $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($con, $email_check_query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script type='text/javascript'>alert('Email is already registered');</script>";
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (first_name, last_name, address, nic, dob, email, mobile_number, password) VALUES ('$first_name', '$last_name', '$address', '$nic', '$dob', '$email', '$mobile_number', '$hashed_password')";
            
            if (mysqli_query($con, $query)) {
                $_SESSION['registered'] = true;
                header("Location: login.php");
                exit();
            } else {
                echo "<script type='text/javascript'>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootsrap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #6295a2;">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="Logo" width="50" height="40">
        </a>
        <a class="navbar-brand" href="index.html">Edoca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ms-auto align-items-center">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="doctors.php">Doctors</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my appointments.php">My Appointments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact us.php">Contact Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="signup.php"><button class="btn btn-primary" style="background-color: #130FEA; ">Signup</button></a>
              </li>
            </ul>
        </div>
    </div>
  </nav>

<!--Signup-->
<div class="container mt-5">
  <form method="POST" action="#">
      <div class="row justify-content-center">
          <div class="col-xl-6 col-md-6 mb-2">
              <div class="form-container p-3 rounded-3" style="background-color: #6295a2;">
                  <div class="text-center mb-4">
                      <p class="h4 form-header">Let's get started</p>
                      <p class="text-light">Add your personal details to continue</p>
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">Name</label>
                      <div class="row">
                          <div class="col">
                              <input type="text" class="form-control mt-2" placeholder="First Name" name="First_Name" required>
                          </div>
                          <div class="col">
                              <input type="text" class="form-control mt-2" placeholder="Last Name" name="Last_Name" required>
                          </div>
                      </div>
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">Address</label>
                      <input type="text" class="form-control mt-2" placeholder="Enter your address" name="Address">
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">NIC</label>
                      <input type="text" class="form-control mt-2" placeholder="Enter your NIC" name="NIC">
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">Date of Birth</label>
                      <input type="date" class="form-control mt-2" placeholder="MM/DD/YYYY" name="DOB">
                  </div>
                  <div class="text-center pt-5">
                      <button type="submit" class="btn btn-light">Next</button>
                      <p></p>
                  </div>
              </div>
          </div>
          <div class="col-xl-6 col-md-6">
              <div class="form-container p-3 rounded-3" style="background-color: #6295a2;">
                  <div class="text-center mb-4">
                      <p class="h4 form-header">Let's get started</p>
                      <p class="text-light">Add your personal details to continue</p>
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">E-mail</label>
                      <input type="email" id="email" class="form-control mt-2" placeholder="Enter your e-mail" name="Email" required>
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">Mobile Number</label>
                      <input type="text" class="form-control mt-2" placeholder="Enter your mobile number" name="Mobile Number">
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">Create Password</label>
                      <input type="password" class="form-control mt-2" placeholder="Enter your password" name="Password" required>
                  </div>
                  <div class="form-group pt-3">
                      <label class="text-white">Confirm Password</label>
                      <input type="password" class="form-control mt-2" placeholder="Re-enter your password" name="Confirm_Password" required>
                  </div>
                  <div class="text-center pt-4">
                      <button type="submit" class="btn btn-primary">Sign Up</button>
                      <p class="mt-3 mb-0">Already have an account? <a href="login.php" class="text-decoration-none text-light">Log in</a></p>
                  </div>
              </div>
          </div>
      </div>
  </form>
</div>

    
<!--Footer-->

<footer class="text-center text-lg-start pt-sm-1 mt-5" style="background-color: #6295a2; color: white;">

  <section class="">
    <div class="container text-center text-md-start mt-1">
      <div class="row mt-3">
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto">
          <h6 class="fw-bold mb-3">
            <img src="images/logo.png" width="50" height="40">Edoca
          </h6>
          <p class="mb-1">+94 11 123 4567</p>
          <p class="mb-1">edoca@gmail.com</p>
          <p class="mb-1">100/2 Passara road, Badulla</p>
        </div>

        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
          <h6 class="fw-bold mb-3">Others</h6>
          <p class="mb-1">Terms and Conditions</p>
          <p class="mb-1">FAQ</p>
          <p class="mb-1">Feedback</p>
          <p class="mb-1">Privacy Policy</p>
        </div>

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0">
          <h6 class="text-uppercase fw-bold mb-3">About</h6>
          <p class="mb-1"><a href="about.php" class="text-reset text-decoration-none">About Us</a></p>
          <p class="mb-1"><a href="contact us.php" class="text-reset text-decoration-none">Contact Us</a></p>
          <p class="mb-1"><a href="doctors.php" class="text-reset text-decoration-none">Our Doctors</a></p>
          <p class="mb-1"><a href="about.php" class="text-reset text-decoration-none">The Company</a></p>
        </div>
      </div>
    </div>
  </section>
  <section class="d-flex justify-content-center justify-content-lg-between p-4 pt-0 border-bottom">
    <div class="container">
      <hr>
      <div class="d-flex justify-content-between align-items-center">
        <p class="text-start mb-0">2024 All Rights Reserved</p>
        <div class="social-icons">
          <a href="#" class="me-4 text-reset"><i class="fab fa-facebook"></i></a>
          <a href="#" class="me-4 text-reset"><i class="fab fa-twitter"></i></a>
          <a href="#" class="me-4 text-reset"><i class="fab fa-google"></i></a>
          <a href="#" class="me-4 text-reset"><i class="fab fa-instagram"></i></a>
          <a href="#" class="me-4 text-reset"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="me-4 text-reset"><i class="fab fa-github"></i></a>
        </div>
      </div>
    </div>
  </section>
</footer>

  <script src="js/bootstrap.min.js"></script>
  <script>
    function focusEmail() {
      document.getElementById('email').focus();
    }
  </script>
</body>
</html>