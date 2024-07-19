<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!--Navbar-->

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
              <li class="nav-item active">
                <a class="nav-link active" href="index.php">Home</a>
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

<!--Image slider--> 

    <div id="carouselExampleIndicators" class="carousel slide carousel-fade container" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
          <img src="images/Doctors 1.jpg" class="d-block w-100" alt="D1">
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="images/Doctors 2.jpg" class="d-block w-100" alt="D2">
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="images/Doctors 3.jpg" class="d-block w-100" alt="D3">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>


<!--Doctor Search Form-->

    <div class="container mb-4 rounded-3 text-center p-4 bg-light">
    <form class="row g-3">
      <div class="col-md-3">
        <label for="doctors" class="form-label">Doctor Name</label>
        <input class="form-control" type="text" id="doctor-name" list="doctor-list" placeholder="Search Doctor Name">
      </div>
      <div class="col-md-3">
        <label for="Specializations" class="form-label">Specialization</label>
        <input class="form-control" type="text" id="specialization" list="specialization-list" placeholder="Search specialization">
      </div>
      <div class="col-md-3">
        <label for="hospitals" class="form-label">Hospital</label>
        <input class="form-control" type="text" id="hospital" list="hospital-list" placeholder="Search Hospital">
      </div>
      <div class="col-md-3">
        <label for="date" class="form-label">Date</label>
        <input class="form-control" type="date" id="date">
      </div>
      <div class="col-12 pt-3">
        <button type="submit" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Search</button>
      </div>
    </form>
    </div>

<!--Doctor Searched Details--> 

    <div class="container mb-4 text-center">
      <div class="row g-4">
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
          <div class="card h-100 bg-light">
              <img src="images/d1.png" class="card-img-top rounded-circle" alt="...">
              <div class="card-body">
                  <h5 class="card-title">Dr. Jayaruwan Bandara</h5>
                  <p class="card-text">Dermatologists</p>
                  <p class="card-text">Lanka Hospital Colombo</p>
                  <a href="#" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Channel Now</a>
              </div>
          </div>
      </div>
          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
              <div class="card h-100 bg-light">
                  <img src="images/d2.png" class="card-img-top rounded-circle" alt="...">
                  <div class="card-body">
                      <h5 class="card-title">Dr. Jayaruwan Bandara</h5>
                      <p class="card-text">Dermatologists</p>
                      <p class="card-text">Lanka Hospital Colombo</p>
                      <a href="#" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Channel Now</a>
                  </div>
              </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 bg-light">
                <img src="images/d3.png" class="card-img-top rounded-circle" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Dr. Jayaruwan Bandara</h5>
                    <p class="card-text">Dermatologists</p>
                    <p class="card-text">The Central Hospital Col.10</p>
                    <a href="#" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Channel Now</a>
                </div>
            </div>
        </div>
          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 bg-light">
                <img src="images/d4.png" class="card-img-top rounded-circle" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Dr. Shamali Perera</h5>
                    <p class="card-text">Dermatologists</p>
                    <p class="card-text">Lanka Hospital Colombo</p>
                    <a href="#" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Channel Now</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
          <div class="card h-100 bg-light">
              <img src="images/d5.png" class="card-img-top rounded-circle" alt="...">
              <div class="card-body">
                  <h5 class="card-title">Dr. Waruni Hettiarachchi</h5>
                  <p class="card-text">Dermatologists</p>
                  <p class="card-text">Nawaloka Hospital Colombo 02</p>
                  <a href="#" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Channel Now</a>
              </div>
          </div>
      </div>
      </div>
  </div>

<!--Wellness and Health Tips-->

  <div class="container mb-4">
    <h3 class="text-center mb-4">Wellness and Health Tips</h3>
    <div class="row g-4">
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="ratio ratio-16x9 rounded-3">
          <iframe src="https://www.youtube.com/embed/zdjWnvbaUZo" title="YouTube video" class="rounded-3" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="ratio ratio-16x9 rounded-3">
          <iframe src="https://www.youtube.com/embed/Cg_GW7yhq20" title="YouTube video" class="rounded-3" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="ratio ratio-16x9 rounded-3">
          <iframe src="https://www.youtube.com/embed/6ajmuRg2o3Q" title="YouTube video" class="rounded-3" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>

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