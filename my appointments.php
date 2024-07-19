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
              <li class="nav-item active">
                <a class="nav-link active" href="my appointments.php">My Appointments</a>
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
</body>
</html>