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
<body class="d-flex flex-column min-vh-100">
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
              <li class="nav-item active">
                <a class="nav-link active" href="about.php">About</a>
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

<!--About-->

<section class="py-3 py-md-5">
  <div class="container">
    <img class="img-fluid rounded w-100" src="images/About Us.png" alt="about us">
    <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
      <div class="col-12 col-lg-6 col-xl-5">
        <img class="img-fluid rounded mx-auto d-block" loading="lazy" src="images/About image.jpg" alt="About 1">
      </div>
      <div class="col-12 col-lg-6 col-xl-7">
        <div class="row justify-content-xl-center">
          <div class="col-12 col-xl-11">
            <h1 class="mb-4 mt-5 text-center" style="color: #6295a2;">Who Are We?</h1>
            <p class="lead fs-4 text-secondary mb-4">We transform doctor appointments with technology, ensuring exceptional care and efficiency.</p>
            <p class="mb-5 jus">Welcome to Edoca! We are here to make scheduling your medical appointments as easy and convenient as possible. Our user-friendly platform
              allows you to quickly find and book appointments with doctors based on their name, specialization, or hospital. Say goodbye to long waiting times and booking hassles.
              With just a few clicks, you can manage all your appointments in one place. We're dedicated to improving your healthcare experience by providing a reliable and efficient
              online service that puts you in control. Join us and discover a simpler way to take care of your health.</p>              
          </div>
        </div>
      </div>
      <div class="row gy-4 gy-md-0 gx-xxl-5X ">
        <div class="col-12 col-md-6">
          <div class="d-flex">
            <div class="me-4 text-primary">
              <i class="fa-regular fa-calendar-check fa-2x"></i>
            </div>
            <div>
              <h2 class="h4 mb-3" style="color: #6295a2;">Channel Doctors</h2> 
            </div>
          </div>
          <p class="text-secondary mb-2">We created a seamless digital platform to connect patients with doctors effortlessly.</p>
        </div>
        <div class="col-12 col-md-6">
          <div class="d-flex">
            <div class="me-4 text-primary">
              <i class="fa-solid fa-id-card fa-2x"></i>
            </div>
            <div>
              <h2 class="h4 mb-3" style="color: #6295a2;">Contact Us</h2>
            </div>
          </div>
          <p class="text-secondary mb-2">We believe in enhancing healthcare through innovative and user-friendly solutions.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!--Footer-->

<footer class="text-center text-lg-start pt-sm-1" style="background-color: #6295a2; color: white;">

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