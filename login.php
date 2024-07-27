<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

    if (!empty($email) && !empty($password)) {
        // Function to verify password and set session
        function verify_and_set_session($result, $password, $password_hashed = true) {
            global $user; // Make $user available in the global scope
            $user = mysqli_fetch_assoc($result);
            $password_valid =password_verify($password, $user['password']);
            if ($password_valid) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                return true;
            }
            return false;
        }

        // Check in users table
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            if (verify_and_set_session($result, $password)) {
                // Redirect to the user logged-in page
                header("Location: index.php");
                exit();
            } else {
                echo "<script type='text/javascript'>alert('Incorrect password');</script>";
            }
        } else {
            // Check in doctor table
            $query = "SELECT * FROM doctor WHERE email='$email' LIMIT 1";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                if (verify_and_set_session($result, $password, false)) {
                    // Set additional session variables for doctors
                    $_SESSION['doctor_id'] = $user['id'];
                    $_SESSION['doctor_name'] = $user['name'];
                    // Redirect to the doctor logged-in page
                    header("Location: Doctor/index.php");
                    exit();
                } else {
                    echo "<script type='text/javascript'>alert('Incorrect password');</script>";
                }
            } else {
                // Check in admin table
                $query = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    if (verify_and_set_session($result, $password, false)) {
                        // Set additional session variables for admin
                        $_SESSION['admin_id'] = $user['admin_id'];
                        $_SESSION['admin_name'] = $user['name'];
                        // Redirect to the admin logged-in page
                        header("Location: Admin/index.php");
                        exit();
                    } else {
                        echo "<script type='text/javascript'>alert('Incorrect password');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Email not registered');</script>";
                }
            }
        }
    } else {
        echo "<script type='text/javascript'>alert('Please fill in both fields');</script>";
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
  <nav class="navbar navbar-expand-lg sticky-top py-1" style="background-color: #6295a2;">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="Logo" width="50" height="40">
        </a>
        <a class="navbar-brand" href="index.php">Edoca</a>
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

<!--Login-->
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-xl-6 col-md-6 mb-2">
      <img class="img-fluid rounded mx-auto d-block" loading="lazy" src="images/Login.jpg">
    </div>
    <div class="col-xl-6 col-md-6">
      <form action="#" method="POST">
        <div class="form-container p-5 rounded-3" style="background-color: #6295a2;">
          <div class="text-center mb-4">
            <p class="h4 form-header fw-bolder ">Welcome!</p>
            <p class="text-light">Login with your details to continue</p>
          </div>
          <div class="form-group pt-4">
            <label class="text-white">E-mail</label>
            <input type="email" id="email" class="form-control mt-2" name="Email" placeholder="Enter your e-mail">
          </div>
          <div class="form-group pt-4">
            <label class="text-white">Password</label>
            <input type="password" class="form-control mt-2" name="Password" placeholder="Enter your password">
          </div>
          <div class="text-center pt-4">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <p class="text-center pt-4">Don't have an Account? <a href="signup.php" class="text-decoration-none text-light">Sign Up</a></p>
        </div>
      </form>
    </div>
  </div>
</div>


  <!-- Include the footer -->
  <?php include('footer.php'); ?>

  <script src="js/bootstrap.min.js"></script>
</body>
</html>