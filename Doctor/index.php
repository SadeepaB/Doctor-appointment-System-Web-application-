<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
        .status {
            max-width: 400px;
        }
    </style>
</head>
<body>

<!--Navbar-->

  <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #6295a2;">
    <div class="container">
        <a class="navbar-brand" href="index.html">
          <img src="../images/logo.png" alt="Logo" width="50" height="40">
        </a>
        <a class="navbar-brand" href="index.html">Edoca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ms-auto align-items-center">
              <li class="nav-item active">
                <a class="nav-link active" href="index.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">My Appointments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="doctors.php">My Patients</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my appointments.php">Settings</a>
              </li>
              
              <?php
                session_start(); // Start the session to access session variables

                // Check if the user is logged in by checking a session variable
                $isLoggedIn = isset($_SESSION['user_id']); // or any other condition to check login status

                if ($isLoggedIn) {
                    // Code to display if the user is logged in
                    echo '<li class="nav-item d-flex align-items-center">';
                    echo '    <a href="#"><img src="images/Profile.jpg" class="rounded-circle" alt="Profile Image" width="40" height="40"></a>';
                    echo '    <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>'; // Logout should link to a logout page
                    echo '</li>';
                } else {
                    // Code to display if the user is not logged in
                    echo '<li class="nav-item">';
                    echo '    <a class="nav-link" href="signup.php">';
                    echo '        <button class="btn btn-primary" style="background-color: #130FEA;">Signup</button>';
                    echo '    </a>';
                    echo '</li>';
                }
              ?>
            </ul>
        </div>
    </div>
  </nav>


  
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <div class="d-flex flex-column align-items-start">
          <span class="fs-4 mb-3"><strong>Doctor Profile</strong></span>
          <section class="doctor-profile text-center p-4  text-white rounded w-100" style="background-color:#6295a2;">
            <img src="../images/d-m-2.png" alt="Doctor Profile Picture" class="rounded-circle mb-3" style="width: 150px;">
            <h2>Dr. Sanjeewa Kodithuwakku</h2>
            <p>Specialized Cardiologist</p>
            <button class="btn btn-primary">Edit Profile</button>
          </section>
        </div>
      </div>
      <div class="col-md-6">
            <div class="d-flex flex-column align-items-start">
                <span class="fs-4 mb-3 "><strong>Status</strong></span>  
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4  text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>All Doctors</strong></p>
                            <p><strong>26</strong></p>
                            <i class="fa fa-user-md fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4  text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>All Patients</strong></p>
                            <p><strong>35</strong></p>
                            <i class="fa fa-wheelchair fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4  text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>New Appointments</strong></p>
                            <p><strong>26</strong></p>
                            <i class="fas fa-calendar-plus fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4  text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>All Appointments</strong></p>
                            <p><strong>26</strong></p>
                            <i class="fas fa-calendar-check fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
     
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="mt-5"></div>
<div class="container">
  <div class="text-center">
    <span class="fs-4 mb-3"><strong>My Appointments</strong></span>
  </div>
</div>

<div class="mt-5"></div> <!-- Add a margin-top to create a gap -->

<div class="bd-example">
  <table class="table table-striped table-hover" style="padding-left: 20px; padding-right: 20px;">
      <thead>
    <tr>
      <th scope="col">Patient Name</th>
      <th scope="col">Appointment Number</th>
      <th scope="col">Date</th>
      <th scope="col">Time</th>
      <th scope="col">Event</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Geethaka Kalhara</td>
      <td>01</td>
      <td>2024/07/30</td>
      <td>18.00PM</td>
      <td><input class="btn btn-primary" type="reset" value="Cancel"></td>
    </tr>
    <tr>
      <td>Sadeepa Bandara</td>
      <td>02</td>
      <td>2024/07/31</td>
      <td>18.30PM</td>
      <td><input class="btn btn-primary" type="reset" value="Cancel"></td>
    </tr>
    <tr>
      <td>Udula Abishek</td>
      <td>03</td>
      <td>2024/07/31</td>
      <td>10.00AM</td>
      <td><input class="btn btn-primary" type="reset" value="Cancel"></td>
    </tr>
    <tr>
      <th scope="row"><span style="font-weight: normal;">Thisara Kavinda</span></th>
      <td>04</td>
      <td>2024/07/31</td>
      <td>13.30PM</td>
      <td><input class="btn btn-primary" type="reset" value="Cancel"></td>
    </tr>
    <tr>
    <th scope="row"><span style="font-weight: normal;">Lasitha Prasad</span></th>
      <td>05</td>
      <td>2024/07/31</td>
      <td>16.00PM</td>
      <td><input class="btn btn-primary" type="reset" value="Cancel"></td>
    </tr>
  </tbody>

  </table>
</div>



  <!-- Include the footer -->
  <?php include('footer.php'); ?>

  <script src="js/bootstrap.min.js"></script>
</body>
</html>