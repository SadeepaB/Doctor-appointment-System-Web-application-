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
      <!-- <div class="col-md-6">
            <div class="d-flex flex-column align-items-start">
                <span class="fs-4 mb-3">Status</span>
                <section class="status d-flex flex-wrap">
                    <div class="status-item text-center p-4 bg-info text-white rounded m-2 status-item-width">
                        <p>All Doctors</p>
                        <p>26</p>
                        <i class="bi bi-person-badge display-4"></i>
                    </div>
                    <div class="status-item text-center p-4 bg-info text-white rounded m-2 status-item-width">
                        <p>All Patients</p>
                        <p>35</p>
                        <i class="bi bi-wheelchair display-4"></i>
                    </div>
                    <div class="status-item text-center p-4 bg-info text-white rounded m-2 status-item-width">
                        <p>New Appointments</p>
                        <p>26</p>
                        <i class="bi bi-check2-circle display-4"></i>
                    </div>
                    <div class="status-item text-center p-4 bg-info text-white rounded m-2 status-item-width">
                        <p>All Appointments</p>
                        <p>26</p>
                        <i class="bi bi-journal-text display-4"></i>
                    </div>
                </section>
            </div>
        </div> -->
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!--
 <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-12 col-xl-4">

        <div class="card" style="border-radius: 15px;">
          <div class="card-body text-center">
            <div class="mt-3 mb-4">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp"
                class="rounded-circle img-fluid" style="width: 100px;" />
            </div>
            <h4 class="mb-2">Dr. Sanjeewa Kodithuwakku</h4>
            <p class="text-muted mb-4">Specialized Cardiologist <span class="mx-2"></span> 
            <
            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded btn-lg">
              Edit Profile
            </button>
            
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
              

  <main class="d-flex justify-content-between">
  <span class="fs-4">Doctor Profile</span><span class="mx-2">

            <section class="doctor-profile text-center p-4 bg-info text-white rounded">
                <img src="doctor-profile.jpg" alt="Doctor Profile Picture" class="rounded-circle mb-3" style="width: 150px;">
                <h2>Dr. Sanjeewa Kodithuwakku</h2>
                <p>Specialized Cardiologist</p>
                <button class="btn btn-primary">Edit Profile</button>
            </section>
            <span class="fs-4">Status</span><span class="mx-2">

            <section class="status d-flex flex-wrap justify-content-around w-50" >
                <div class="status-item text-center p-4 bg-info text-white rounded m-2">
                    <p>All Doctors</p>
                    <p>26</p>
                    <i class="bi bi-person-badge display-4"></i>
                </div>
                <div class="status-item text-center p-4 bg-info text-white rounded m-2">
                    <p>All Patients</p>
                    <p>35</p>
                    <i class="bi bi-wheelchair display-4"></i>
                </div>
                <div class="status-item text-center p-4 bg-info text-white rounded m-2">
                    <p>New Appointments</p>
                    <p>26</p>
                    <i class="bi bi-check2-circle display-4"></i>
                </div>
                <div class="status-item text-center p-4 bg-info text-white rounded m-2">
                    <p>All Appointments</p>
                    <p>26</p>
                    <i class="bi bi-journal-text display-4"></i>
                </div>
            </section>
        </main>       -->
  <!-- Include the footer -->
  <?php include('footer.php'); ?>

  <script src="js/bootstrap.min.js"></script>
</body>
</html>